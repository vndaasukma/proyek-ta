<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendaftaranPelatihan;
use App\Models\KelasPelatihan; // 🟢 Tambahkan ini untuk membaca list kelas
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\SertifikatPelatihanMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

/**
 * @author Vinda Ambitha Sukma
 */
class PendaftaranPelatihanController extends Controller
{
    /**
     * Menampilkan data tabel pendaftaran
     */
    public function index()
    {
        $pendaftaran = PendaftaranPelatihan::with('pelatihan')->latest()->get();
        // 🟢 Ambil list seluruh kelas untuk pilihan modal blast massal
        $list_kelas = KelasPelatihan::all(); 
        
        return view('admin.pendaftaran.index', compact('pendaftaran', 'list_kelas'));
    }

    /**
     * Menampilkan Halaman Form Pembuat Blast WA
     */
    public function blastView()
    {
        $total_peserta = PendaftaranPelatihan::count();
        return view('admin.pendaftaran.blast', compact('total_peserta'));
    }

    /**
     * Memproses Pengiriman Blast WA via API Fonnte
     */
    public function blastSend(Request $request)
    {
        $request->validate([
            'pesan' => 'required|string',
        ]);

        $pendaftar = PendaftaranPelatihan::select('no_hp')->get();

        if ($pendaftar->isEmpty()) {
            return back()->with('error', 'Gagal mengirim blast, belum ada data peserta di database.');
        }

        $kumpulan_nomor = $pendaftar->pluck('no_hp')->map(function ($nomor) {
            $clean = preg_replace('/[^0-9]/', '', $nomor);
            if (substr($clean, 0, 1) === '0') {
                $clean = '62' . substr($clean, 1);
            }
            return $clean;
        })->implode(',');

        $tokenFonnte = env('FONNTE_TOKEN');

        try {
            $response = Http::withHeaders([
                'Authorization' => $tokenFonnte,
            ])->asForm()->post('https://api.fonnte.com/send', [
                'target' => $kumpulan_nomor,
                'message' => $request->pesan,
                'delay' => '2',
            ]);

            $result = $response->json();

            if (isset($result['status']) && $result['status'] == true) {
                return redirect()->route('pendaftaran-pelatihan.index')
                    ->with('success', 'Blast WA Berhasil! Pesan dalam proses pengiriman ke ' . $pendaftar->count() . ' peserta.');
            } else {
                return back()->with('error', 'Fonnte Error: ' . ($result['reason'] ?? 'Gagal mengirim pesan.'));
            }

        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Memproses Otomatis Pembuatan PDF Sertifikat dan Mengirimkannya ke Email Peserta (Tunggal)
     */
    public function blastSertifikat($id)
    {
        $peserta = PendaftaranPelatihan::with('pelatihan')->findOrFail($id);

        if (!$peserta->email) {
            return back()->with('error', 'Gagal memproses. Alamat email pendaftar tidak ditemukan.');
        }

        $namaPelatih = $peserta->pelatihan->nama_pelatih ?? 'Instruktur P4S';
        $fileTtdPelatih = $peserta->pelatihan->ttd_pelatih;

        $pathTtdKetua = public_path('assets/img/ttd_ketua.png');
        $base64Ketua = '';
        if (file_exists($pathTtdKetua)) {
            $base64Ketua = 'data:image/png;base64,' . base64_encode(file_get_contents($pathTtdKetua));
        }

        $base64Pelatih = '';
        if ($fileTtdPelatih) {
            $pathTtdPelatih = storage_path('app/public/' . $fileTtdPelatih);
            if (file_exists($pathTtdPelatih)) {
                $base64Pelatih = 'data:image/png;base64,' . base64_encode(file_get_contents($pathTtdPelatih));
            }
        }

        $nomorSertifikat = 'SERT/GBS/' . date('Y') . '/' . str_pad($peserta->id, 5, '0', STR_PAD_LEFT);

        $dataSertifikat = [
            'nama_peserta'     => $peserta->nama ?? $peserta->nama_pendaftar,
            'nama_pelatihan'   => $peserta->pelatihan->title ?? $peserta->pelatihan->nama_pelatihan,
            'tanggal'          => Carbon::parse($peserta->tanggal_daftar)->translatedFormat('d F Y'),
            'nomor_sertifikat' => $nomorSertifikat,
            'nama_ketua'       => 'H. Ahmad Sukma, S.P.',
            'nama_pelatih'     => $namaPelatih,
            'img_ttd_ketua'    => $base64Ketua,
            'img_ttd_pelatih'  => $base64Pelatih
        ];

        try {
            // 🛠️ PERBAIKAN: Folder dipindahkan ke admin.pendaftaran sesuai struktur aslimu
            $pdf = Pdf::loadView('admin.pendaftaran.sertifikat_pdf', $dataSertifikat)->setPaper('a4', 'landscape');
            $peserta->pdf_binary = $pdf->output();

            Mail::to($peserta->email)->send(new SertifikatPelatihanMail($peserta));

            return back()->with('success', 'Sertifikat resmi berhasil digenerate dan telah dikirimkan ke email ' . $peserta->email . '!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi gangguan sistem email: ' . $e->getMessage());
        }
    }

    /**
     * Melihat Tampilan Sertifikat Langsung di Browser (Stream PDF)
     */
    public function previewSertifikat($id)
    {
        $peserta = PendaftaranPelatihan::with('pelatihan')->findOrFail($id);

        $namaPelatih = $peserta->pelatihan->nama_pelatih ?? 'Instruktur P4S';
        $fileTtdPelatih = $peserta->pelatihan->ttd_pelatih;

        $pathTtdKetua = public_path('assets/img/ttd_ketua.png');
        $base64Ketua = '';
        if (file_exists($pathTtdKetua)) {
            $base64Ketua = 'data:image/png;base64,' . base64_encode(file_get_contents($pathTtdKetua));
        }

        $base64Pelatih = '';
        if ($fileTtdPelatih) {
            $pathTtdPelatih = storage_path('app/public/' . $fileTtdPelatih);
            if (file_exists($pathTtdPelatih)) {
                $base64Pelatih = 'data:image/png;base64,' . base64_encode(file_get_contents($pathTtdPelatih));
            }
        }

        $nomorSertifikat = 'SERT/GBS/' . date('Y') . '/' . str_pad($peserta->id, 5, '0', STR_PAD_LEFT);

        $dataSertifikat = [
            'nama_peserta'     => $peserta->nama ?? $peserta->nama_pendaftar,
            'nama_pelatihan'   => $peserta->pelatihan->title ?? $peserta->pelatihan->nama_pelatihan,
            'tanggal'          => Carbon::parse($peserta->tanggal_daftar)->translatedFormat('d F Y'),
            'nomor_sertifikat' => $nomorSertifikat,
            'nama_ketua'       => 'H. Ahmad Sukma, S.P.',
            'nama_pelatih'     => $namaPelatih,
            'img_ttd_ketua'    => $base64Ketua,
            'img_ttd_pelatih'  => $base64Pelatih
        ];

        // 🛠️ PERBAIKAN: Folder dipindahkan ke admin.pendaftaran sesuai struktur aslimu
        $pdf = Pdf::loadView('admin.pendaftaran.sertifikat_pdf', $dataSertifikat)->setPaper('a4', 'landscape');
               
        return $pdf->stream('Preview_Sertifikat_' . str_replace(' ', '_', $dataSertifikat['nama_peserta']) . '.pdf');
    }

    /**
     * 🚀 FITUR BARU MULTI-BLAST: Mengirimkan Semua Sertifikat Anggota Kelas Tertentu Sekali Klik
     */
    public function blastSertifikatMassal(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas_pelatihan,id'
        ]);

        // Ambil data target kelas
        $kelas = KelasPelatihan::findOrFail($request->kelas_id);

        // Cari semua peserta di kelas tersebut yang pembayarannya LUNAS (Success / settlement / capture)
        $kumpulanPeserta = PendaftaranPelatihan::with('pelatihan')
            ->whereHas('pelatihan', function($query) use ($request) {
                $query->where('id', $request->kelas_id);
            })
            ->whereIn('status_pembayaran', ['Success', 'success', 'settlement', 'capture'])
            ->get();

        if ($kumpulanPeserta->isEmpty()) {
            return back()->with('error', 'Gagal memproses. Tidak ditemukan peserta yang berstatus LUNAS pada kelas ' . ($kelas->title ?? $kelas->nama_pelatihan));
        }

        // Cache file TTD Ketua (Base64) di luar loop agar hemat memory RAM server
        $pathTtdKetua = public_path('assets/img/ttd_ketua.png');
        $base64Ketua = '';
        if (file_exists($pathTtdKetua)) {
            $base64Ketua = 'data:image/png;base64,' . base64_encode(file_get_contents($pathTtdKetua));
        }

        $counterSukses = 0;

        // Loop dan kirim berkas satu per satu secara sekuensial
        foreach ($kumpulanPeserta as $peserta) {
            if (!$peserta->email) continue;

            $namaPelatih = $peserta->pelatihan->nama_pelatih ?? 'Instruktur P4S';
            $fileTtdPelatih = $peserta->pelatihan->ttd_pelatih;

            $base64Pelatih = '';
            if ($fileTtdPelatih) {
                $pathTtdPelatih = storage_path('app/public/' . $fileTtdPelatih);
                if (file_exists($pathTtdPelatih)) {
                    $base64Pelatih = 'data:image/png;base64,' . base64_encode(file_get_contents($pathTtdPelatih));
                }
            }

            $nomorSertifikat = 'SERT/GBS/' . date('Y') . '/' . str_pad($peserta->id, 5, '0', STR_PAD_LEFT);

            $dataSertifikat = [
                'nama_peserta'     => $peserta->nama ?? $peserta->nama_pendaftar,
                'nama_pelatihan'   => $peserta->pelatihan->title ?? $peserta->pelatihan->nama_pelatihan,
                'tanggal'          => Carbon::parse($peserta->tanggal_daftar)->translatedFormat('d F Y'),
                'nomor_sertifikat' => $nomorSertifikat,
                'nama_ketua'       => 'H. Ahmad Sukma, S.P.',
                'nama_pelatih'     => $namaPelatih,
                'img_ttd_ketua'    => $base64Ketua,
                'img_ttd_pelatih'  => $base64Pelatih
            ];

            try {
                $pdf = Pdf::loadView('admin.pendaftaran.sertifikat_pdf', $dataSertifikat)->setPaper('a4', 'landscape');
                $peserta->pdf_binary = $pdf->output();

                Mail::to($peserta->email)->send(new SertifikatPelatihanMail($peserta));
                $counterSukses++;
            } catch (\Exception $e) {
                \Log::error('Gagal blast massal ID '.$peserta->id.': '.$e->getMessage());
            }
        }

        return back()->with('success', 'Berhasil melakukan koordinasi! Sebanyak ' . $counterSukses . ' berkas sertifikat resmi kelas ' . ($kelas->title ?? $kelas->nama_pelatihan) . ' berhasil dikirim massal ke email masing-masing.');
    }
}