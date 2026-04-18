<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranKunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

// Import untuk Email
use App\Mail\KunjunganApproved;
use Illuminate\Support\Facades\Mail;

class PendaftaranKunjunganController extends Controller
{
    public function frontendIndex(Request $request) {
        $tanggalDipilih = $request->get('date', date('Y-m-d'));
        $carbonDate = Carbon::parse($tanggalDipilih);
        $today = Carbon::today()->format('Y-m-d');
        $bookedSessions = PendaftaranKunjungan::where('tanggal_kunjungan', $tanggalDipilih)->where('status', 'approved')->get()->keyBy('sesi');
        $allBookings = PendaftaranKunjungan::where('status', 'approved')->whereMonth('tanggal_kunjungan', $carbonDate->month)->whereYear('tanggal_kunjungan', $carbonDate->year)->get()->groupBy('tanggal_kunjungan');
        return view('kunjungan', compact('tanggalDipilih', 'carbonDate', 'bookedSessions', 'allBookings', 'today'));
    }

    public function index() {
        $list_pendaftaran = PendaftaranKunjungan::latest()->get();
        return view('admin.kunjungan.pendaftaran', compact('list_pendaftaran'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_pemohon' => 'required',
            'instansi' => 'required',
            'no_wa' => 'required',
            'email' => 'required|email',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'sesi' => 'required',
        ]);

        PendaftaranKunjungan::create([
            'nama_pemohon' => $request->nama_pemohon,
            'instansi' => $request->instansi,
            'email' => $request->email,
            'no_wa' => $request->no_wa,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'sesi' => $request->sesi,
            'keperluan' => $request->keperluan,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Reservasi berhasil dikirim!');
    }

    private function formatNomor($nomor) {
        $nomor = preg_replace('/\D/', '', $nomor); 
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }
        return $nomor;
    }

    public function approve($id) {
        $data = PendaftaranKunjungan::findOrFail($id);
        
        // 1. LOGIKA WHATSAPP (Fonnte)
        $token = '3Pzf4Ebz7ZYyxt2aQbyL'; 
        $nomorTujuan = $this->formatNomor($data->no_wa);
        $pesan = "Halo *{$data->nama_pemohon}*,\n\nReservasi kunjungan instansi *{$data->instansi}* pada tanggal *{$data->tanggal_kunjungan}* telah *DISETUJUI*. 🌱\n\nSampai jumpa di Gubuk Sayur!";

        $response = Http::withoutVerifying()
            ->asForm()
            ->withHeaders(['Authorization' => $token])
            ->post('https://api.fonnte.com/send', [
                'target' => $nomorTujuan,
                'message' => $pesan,
            ]);

        // Cek Respon Fonnte Berhasil
        if ($response->successful() && $response->json('status') == true) {
            
            // Update Status di Database
            $data->update(['status' => 'approved']);

            // 2. LOGIKA EMAIL (Hanya dikirim jika WA berhasil dan email tersedia)
            if ($data->email) {
                try {
                    Mail::to($data->email)->send(new KunjunganApproved($data));
                } catch (\Exception $e) {
                    // Jika email gagal, tetap approve tapi beri peringatan log
                    \Log::error("Gagal kirim email ke {$data->email}: " . $e->getMessage());
                }
            }

            return back()->with('success', 'Pendaftaran Disetujui, WA & Email Terkirim!');
        }

        return back()->with('error', 'Gagal kirim WA: ' . ($response->json('reason') ?? 'Koneksi API Bermasalah'));
    }

    public function reject($id) {
        $data = PendaftaranKunjungan::findOrFail($id);
        
        $token = '3Pzf4Ebz7ZYyxt2aQbyL';
        $nomorTujuan = $this->formatNomor($data->no_wa);
        $pesan = "Halo *{$data->nama_pemohon}*,\n\nMohon maaf, reservasi kunjungan Anda pada tanggal *{$data->tanggal_kunjungan}* *BELUM BISA KAMI SETUJUI*.";

        Http::withoutVerifying()
            ->asForm()
            ->withHeaders(['Authorization' => $token])
            ->post('https://api.fonnte.com/send', [
                'target' => $nomorTujuan,
                'message' => $pesan,
            ]);

        $data->update(['status' => 'rejected']);
        return back()->with('success', 'Pendaftaran Ditolak & WA Pemberitahuan Terkirim.');
    }

    public function destroy($id) {
        PendaftaranKunjungan::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus!');
    }
}