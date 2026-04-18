<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranPelatihan;
use Midtrans\Snap;
use Midtrans\Config;

class PendaftaranPelatihanController extends Controller
{
    /**
     * Fungsi untuk menyimpan pendaftaran dan generate Snap Token
     */
    public function store(Request $request)
    {
        $orderId = 'PLT-' . time();

        // 1. Simpan data awal ke database
        $pendaftaran = PendaftaranPelatihan::create([
            'order_id'          => $orderId,
            'nama'              => $request->nama,
            'email'             => $request->email,
            'no_hp'             => $request->no_hp,
            'pelatihan_id'      => $request->pelatihan_id,
            'total_harga'       => $request->total_harga,
            'tanggal_daftar'    => now(),
            'status_pendaftaran' => 'pending',
            'status_pembayaran'  => 'pending',
            'snap_token'        => null,
        ]);

        // 2. Konfigurasi Midtrans menggunakan file .env
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int)$pendaftaran->total_harga,
            ],
            'customer_details' => [
                'first_name' => $pendaftaran->nama,
                'email'      => $pendaftaran->email,
                'phone'      => $pendaftaran->no_hp,
            ],
            // Opsional: Tambahkan URL redirect setelah bayar
            // 'callbacks' => [
            //     'finish' => route('sukses.daftar'),
            // ]
        ];

        try {
            // 3. Ambil Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);
            
            // Simpan token ke database
            $pendaftaran->update(['snap_token' => $snapToken]);

            // 4. Lempar ke halaman pembayaran
            return view('payment', compact('snapToken', 'pendaftaran'));

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Fungsi Notification (Webhook) untuk menerima kabar dari Midtrans
     */
    public function notification(Request $request)
    {
        // Mengambil data JSON yang dikirim Midtrans
        $payload = $request->getContent();
        $notification = json_decode($payload);

        if (!$notification) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // Cari data pendaftaran berdasarkan order_id
        $pendaftaran = PendaftaranPelatihan::where('order_id', $notification->order_id)->first();

        if ($pendaftaran) {
            $status = $notification->transaction_status;

            if ($status == 'settlement' || $status == 'capture') {
                // Update status jadi Success jika pembayaran berhasil
                $pendaftaran->update([
                    'status_pembayaran'  => 'Success',
                    'status_pendaftaran' => 'Success'
                ]);
            } elseif ($status == 'pending') {
                // Tetap Pending
                $pendaftaran->update([
                    'status_pembayaran' => 'Pending'
                ]);
            } elseif ($status == 'deny' || $status == 'expire' || $status == 'cancel') {
                // Update status jadi Failed jika gagal/batal
                $pendaftaran->update([
                    'status_pembayaran'  => 'Failed',
                    'status_pendaftaran' => 'Failed'
                ]);
            }

            return response()->json(['status' => 'ok', 'message' => 'Notification processed']);
        }

        return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
    }
}