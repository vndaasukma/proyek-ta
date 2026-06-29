<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranPelatihan;
use App\Models\KelasPelatihan;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoicePelatihan;
use Illuminate\Support\Facades\Log;

/**
 * @author Vinda Ambitha Sukma
 */
class PendaftaranPelatihanController extends Controller
{
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

    public function suksesDaftar(Request $request)
    {
        $orderId = $request->query('order_id');
        Log::info("MIDTRANS REDIRECT: Memasuki halaman sukses-daftar. Order ID: " . $orderId);

        if ($orderId) {
            // Wajib memanggil with('pelatihan.jadwal') agar relasi siap dibaca di dalam email
            $pendaftaran = PendaftaranPelatihan::with('pelatihan.jadwal')->where('order_id', $orderId)->first();

            if ($pendaftaran) {
                // Gunakan strtolower agar kebal dari kesalahan huruf besar/kecil di database
                if (strtolower($pendaftaran->status_pembayaran) !== 'success') {
                    
                    $pendaftaran->update([
                        'status_pembayaran'  => 'Success',
                        'status_pendaftaran' => 'Success'
                    ]);

                    KelasPelatihan::where('id', $pendaftaran->pelatihan_id)->increment('terisi');
                    
                    Log::info("MEMULAI KIRIM EMAIL INVOICE KE: " . $pendaftaran->email);
                    
                    try {
                        Mail::to($pendaftaran->email)->send(new InvoicePelatihan($pendaftaran));
                        Log::info("STATUS EMAIL: BERHASIL DIKIRIM!");
                    } catch (\Exception $e) {
                        Log::error("CRASH KIRIM EMAIL INVOICE: " . $e->getMessage());
                    }
                } else {
                    Log::info("STATUS SUDAH LUNAS. (Email kemungkinan sudah dikirim oleh Webhook).");
                }
            }
        }

        return view('sukses-daftar');
    }

    public function notification(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        if (!$notification) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        Log::info("WEBHOOK MIDTRANS MASUK. Order ID: " . $notification->order_id);
        
        $pendaftaran = PendaftaranPelatihan::with('pelatihan.jadwal')->where('order_id', $notification->order_id)->first();

        if ($pendaftaran) {
            $status = $notification->transaction_status;

            if ($status == 'settlement' || $status == 'capture') {
                if (strtolower($pendaftaran->status_pembayaran) !== 'success') {
                    $pendaftaran->update([
                        'status_pembayaran'  => 'Success',
                        'status_pendaftaran' => 'Success'
                    ]);
                    
                    KelasPelatihan::where('id', $pendaftaran->pelatihan_id)->increment('terisi');

                    Log::info("WEBHOOK MEMULAI KIRIM EMAIL INVOICE KE: " . $pendaftaran->email);
                    try {
                        Mail::to($pendaftaran->email)->send(new InvoicePelatihan($pendaftaran));
                        Log::info("WEBHOOK STATUS EMAIL: BERHASIL DIKIRIM!");
                    } catch (\Exception $e) {
                        Log::error("WEBHOOK CRASH KIRIM EMAIL: " . $e->getMessage());
                    }
                }
            } elseif ($status == 'deny' || $status == 'expire' || $status == 'cancel') {
                if (strtolower($pendaftaran->status_pembayaran) == 'success') {
                    KelasPelatihan::where('id', $pendaftaran->pelatihan_id)->decrement('terisi');
                }
                $pendaftaran->update([
                    'status_pembayaran'  => 'Failed',
                    'status_pendaftaran' => 'Failed'
                ]);
            }

            return response()->json(['status' => 'ok'], 200);
        }

        return response()->json(['status' => 'error'], 404);
    }
}