<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranPelatihan;
use App\Models\KelasPelatihan;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoicePelatihan;

/**
 * @author Vinda Ambitha Sukma
 */
class PendaftaranPelatihanController extends Controller
{
    /**
     * Fungsi untuk menyimpan pendaftaran dan generate Snap Token
     */
    public function store(Request $request)
    {
        $orderId = 'PLT-' . time();

        $pendaftaran = PendaftaranPelatihan::create([
            'order_id'           => $orderId,
            'nama'               => $request->nama,
            'email'              => $request->email,
            'no_hp'              => $request->no_hp,
            'pelatihan_id'       => $request->pelatihan_id,
            'total_harga'        => $request->total_harga,
            'tanggal_daftar'     => now(),
            'status_pendaftaran' => 'pending',
            'status_pembayaran'  => 'pending',
            'snap_token'         => null,
        ]);

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
            'callbacks' => [
                'finish' => route('sukses.daftar')
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $pendaftaran->update(['snap_token' => $snapToken]);

            return view('payment', compact('snapToken', 'pendaftaran'));

        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * JALUR KILAT BROWSER: Mengubah status otomatis pasca-pembayaran sukses
     */
    public function suksesDaftar(Request $request)
    {
        $orderId = $request->query('order_id');

        if ($orderId) {
            $pendaftaran = PendaftaranPelatihan::where('order_id', $orderId)->first();

            if ($pendaftaran && $pendaftaran->status_pembayaran !== 'Success') {
                $pendaftaran->update([
                    'status_pembayaran'  => 'Success',
                    'status_pendaftaran' => 'Success'
                ]);

                KelasPelatihan::where('id', $pendaftaran->pelatihan_id)->increment('terisi');

                // Kirim email invoice aman (Anti-Crash)
                try {
                    Mail::to($pendaftaran->email)->send(new InvoicePelatihan($pendaftaran));
                } catch (\Throwable $e) {
                    \Log::error('Email invoice via Browser gagal: ' . $e->getMessage());
                }
            }
        }

        return view('sukses-daftar');
    }

    /**
     * Webhook Notification: Menangkap sinyal sukses dari Midtrans
     */
    public function notification(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        if (!$notification) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $pendaftaran = PendaftaranPelatihan::where('order_id', $notification->order_id)->first();

        if ($pendaftaran) {
            $status = $notification->transaction_status;

            if ($status == 'settlement' || $status == 'capture') {
                if ($pendaftaran->status_pembayaran !== 'Success') {
                    $pendaftaran->update([
                        'status_pembayaran'  => 'Success',
                        'status_pendaftaran' => 'Success'
                    ]);
                    
                    KelasPelatihan::where('id', $pendaftaran->pelatihan_id)->increment('terisi');

                    // Kirim email invoice backup aman (Anti-Crash)
                    try {
                        Mail::to($pendaftaran->email)->send(new InvoicePelatihan($pendaftaran));
                    } catch (\Throwable $e) {
                        \Log::error('Email invoice via Webhook gagal: ' . $e->getMessage());
                    }
                }
            } elseif ($status == 'deny' || $status == 'expire' || $status == 'cancel') {
                if ($pendaftaran->status_pembayaran == 'Success') {
                    KelasPelatihan::where('id', $pendaftaran->pelatihan_id)->decrement('terisi');
                }
                $pendaftaran->update([
                    'status_pembayaran'  => 'Failed',
                    'status_pendaftaran' => 'Failed'
                ]);
            }

            // PENTING: Selalu beri respon 200 OK ke Midtrans agar tidak dikirimi email error lagi
            return response()->json(['status' => 'ok'], 200);
        }

        return response()->json(['status' => 'error'], 404);
    }
}