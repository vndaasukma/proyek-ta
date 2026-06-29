<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPelatihan;
use App\Models\KelasPelatihan;
use App\Models\Pengunjung; // Ditambahkan agar data pengunjung bisa dipanggil
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use PDF;

/**
 * @author Vinda Ambitha Sukma
 */
class PendaftaranPelatihanController extends Controller
{
    /**
     * Menampilkan data pendaftaran pelatihan
     */
    public function index()
    {
        $pendaftaran = PendaftaranPelatihan::with('pelatihan')->latest()->get();
        $list_kelas = KelasPelatihan::all();
        
        return view('admin.pendaftaran.index', compact('pendaftaran', 'list_kelas'));
    }

    public function approve($id)
    {
        PendaftaranPelatihan::findOrFail($id)->update(['status_pendaftaran' => 'Success']);
        return back()->with('success', 'Pendaftaran berhasil disetujui!');
    }

    public function tolak($id)
    {
        PendaftaranPelatihan::findOrFail($id)->update(['status_pendaftaran' => 'Gagal']);
        return back()->with('success', 'Pendaftaran berhasil ditolak.');
    }

    public function batalkan($id)
    {
        PendaftaranPelatihan::findOrFail($id)->update(['status_pendaftaran' => 'Pending']);
        return back()->with('success', 'Status pendaftaran dikembalikan ke Pending.');
    }

    /**
     * Preview Sertifikat Berbentuk PDF Stream (SUDAH SINKRON 100% DENGAN BLADE)
     */
    public function previewSertifikat($id)
    {
        $item = PendaftaranPelatihan::with('pelatihan.pengaturanSertifikat')->findOrFail($id);
        $pelatihan = $item->pelatihan;
        $sertifikat = $pelatihan ? $pelatihan->pengaturanSertifikat : null;

        if (!$pelatihan) {
            return back()->with('error', 'Data kelas pelatihan tidak ditemukan.');
        }

        $convertImageToBase64 = function($storagePath, $defaultPublicPath = null) {
            if ($storagePath && Storage::disk('public')->exists($storagePath)) {
                $file = Storage::disk('public')->get($storagePath);
                $mime = Storage::disk('public')->mimeType($storagePath);
                return 'data:' . $mime . ';base64,' . base64_encode($file);
            }
            if ($defaultPublicPath && file_exists(public_path($defaultPublicPath))) {
                $file = file_get_contents(public_path($defaultPublicPath));
                $mime = mime_content_type(public_path($defaultPublicPath));
                return 'data:' . $mime . ';base64,' . base64_encode($file);
            }
            return null;
        };

        // Konversi Gambar ke Base64 (Opsional - Jika Kosong, Tampilan Tetap Rapi)
        $template_url          = $convertImageToBase64($sertifikat?->template_sertifikat, 'assets/img/sertifikat-default.png');
        $img_ttd_pelatih       = $convertImageToBase64($sertifikat?->ttd_pelatih);
        $img_ttd_penyelenggara = $convertImageToBase64($sertifikat?->ttd_penyelenggara);
        $img_ttd_ketua         = $convertImageToBase64($sertifikat?->ttd_ketua);
        
        // Pemetaan Variabel Dinamis - Mengambil Nilai Asli Inputan Form Database Kustom
        $nama_pelatih       = $sertifikat?->nama_pelatih ?? $pelatihan->nama_pelatih ?? 'Instruktur / Pelatih';
        $nama_penyelenggara = $sertifikat?->nama_penyelenggara ?? 'P4S Gubuk Sayur';
        $nama_ketua         = $sertifikat?->nama_ketua ?? 'Supratna S.Pt';

        $pdf = \PDF::loadView('admin.pendaftaran.sertifikat_pdf', compact(
            'item', 
            'template_url', 
            'img_ttd_pelatih', 
            'img_ttd_penyelenggara', 
            'img_ttd_ketua', 
            'nama_pelatih', 
            'nama_penyelenggara', 
            'nama_ketua'
        ))->setPaper('a4', 'landscape');

        return $pdf->stream('Sertifikat-' . $item->nama . '.pdf');
    }

    /**
     * Blast Sertifikat Tunggal Ke Email Peserta
     */
    public function blastSertifikat($id, $isMass = false)
    {
        $item = PendaftaranPelatihan::with('pelatihan.pengaturanSertifikat')->findOrFail($id);
        $pelatihan = $item->pelatihan;
        $sertifikat = $pelatihan ? $pelatihan->pengaturanSertifikat : null;

        if (!$pelatihan) {
            return $isMass ? false : back()->with('error', 'Data kelas pelatihan tidak ditemukan.');
        }

        $convertImageToBase64 = function($storagePath, $defaultPublicPath = null) {
            if ($storagePath && Storage::disk('public')->exists($storagePath)) {
                $file = Storage::disk('public')->get($storagePath);
                $mime = Storage::disk('public')->mimeType($storagePath);
                return 'data:' . $mime . ';base64,' . base64_encode($file);
            }
            if ($defaultPublicPath && file_exists(public_path($defaultPublicPath))) {
                $file = file_get_contents(public_path($defaultPublicPath));
                $mime = mime_content_type(public_path($defaultPublicPath));
                return 'data:' . $mime . ';base64,' . base64_encode($file);
            }
            return null;
        };

        $template_url          = $convertImageToBase64($sertifikat?->template_sertifikat, 'assets/img/sertifikat-default.png');
        $img_ttd_pelatih       = $convertImageToBase64($sertifikat?->ttd_pelatih);
        $img_ttd_penyelenggara = $convertImageToBase64($sertifikat?->ttd_penyelenggara);
        $img_ttd_ketua         = $convertImageToBase64($sertifikat?->ttd_ketua);
        
        $nama_pelatih       = $sertifikat?->nama_pelatih ?? $pelatihan->nama_pelatih ?? 'Instruktur';
        $nama_penyelenggara = $sertifikat?->nama_penyelenggara ?? 'P4S Gubuk Sayur';
        $nama_ketua         = $sertifikat?->nama_ketua ?? 'Supratna S.Pt';

        $pdf = \PDF::loadView('admin.pendaftaran.sertifikat_pdf', compact(
            'item', 
            'template_url', 
            'img_ttd_pelatih', 
            'img_ttd_penyelenggara', 
            'img_ttd_ketua', 
            'nama_pelatih', 
            'nama_penyelenggara', 
            'nama_ketua'
        ))->setPaper('a4', 'landscape');

        try {
            Mail::send('emails.sertifikat_notification', ['item' => $item], function($message) use ($item, $pdf) {
                $message->to($item->email)
                        ->subject('Sertifikat Kelulusan Pelatihan - P4S Gubuk Sayur')
                        ->attachData($pdf->output(), "Sertifikat-Kelulusan-" . $item->nama . ".pdf");
            });

            $item->update(['status_pendaftaran' => 'Success']);
            return $isMass ? true : back()->with('success', 'Sertifikat resmi berhasil diblast ke email ' . $item->email);
        } catch (\Exception $e) {
            return $isMass ? false : back()->with('error', 'Gagal mengirim email blast sertifikat: ' . $e->getMessage());
        }
    }

    /**
     * Blast Sertifikat Massal Seluruh Kelompok Peserta Kelas
     */
    public function blastSertifikatMassal(Request $request)
    {
        $request->validate(['kelas_id' => 'required']);
        
        $pendaftar = PendaftaranPelatihan::where('pelatihan_id', $request->kelas_id)
            ->whereIn('status_pembayaran', ['Success', 'settlement'])
            ->get();

        if ($pendaftar->isEmpty()) {
            return back()->with('error', 'Tidak ada data pendaftar dengan status pembayaran sukses di kelas ini.');
        }

        $berhasil = 0;
        foreach ($pendaftar as $peserta) {
            $proses = $this->blastSertifikat($peserta->id, true);
            if ($proses) { $berhasil++; }
        }

        return back()->with('success', $berhasil . ' Berkas sertifikat kelompok resmi berhasil diblast ke email masing-masing!');
    }

    /**
     * Menampilkan Form Blast WhatsApp Pengumuman
     */
    public function blastView() 
    {
        $list_pelatihan = KelasPelatihan::latest()->get();
        return view('admin.pendaftaran.blast', compact('list_pelatihan'));
    }

    /**
     * Memproses Pengiriman Blast WhatsApp ke Nomor Peserta Status Lunas (Fonnte API Terintegrasi Nyata)
     */
    public function blastSend(Request $request) 
    { 
        $request->validate([
            'pelatihan_id' => 'required',
            'pesan' => 'required',
        ]);

        $target_peserta = PendaftaranPelatihan::where('pelatihan_id', $request->pelatihan_id)
            ->whereIn('status_pembayaran', ['Success', 'success', 'settlement', 'capture', 'Lunas', 'lunas'])
            ->get();

        if ($target_peserta->isEmpty()) {
            return back()->with('error', 'Gagal memproses blast! Tidak ditemukan data peserta dengan status pembayaran LUNAS di kelas pelatihan ini.');
        }

        $token_wa_gateway = "3Pzf4Ebz7ZYyxt2aQbyL"; 
        $berhasil_terkirim = 0;
        $pesan_gagal = null;

        foreach ($target_peserta as $peserta) {
            $nomor_raw = $peserta->no_hp ?? $peserta->no_wa ?? $peserta->telepon;

            if ($nomor_raw) {
                $nomor_tujuan = preg_replace('/[^0-9]/', '', $nomor_raw);
                if (strpos($nomor_tujuan, '0') === 0) {
                    $nomor_tujuan = '62' . substr($nomor_tujuan, 1);
                }

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.fonnte.com/send',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array(
                        'target' => $nomor_tujuan,
                        'message' => $request->pesan,
                        'countryCode' => '62',
                    ),
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_HTTPHEADER => array("Authorization: $token_wa_gateway"),
                ));

                $response = curl_exec($curl);
                curl_close($curl);

                $result = json_decode($response, true);
                if ($result && isset($result['status']) && $result['status'] == true) {
                    $berhasil_terkirim++;
                } else {
                    $pesan_gagal = $result['reason'] ?? 'Koneksi API Fonnte Ditolak / Kuota Habis';
                }
            }
        }

        if ($berhasil_terkirim === 0) {
            return back()->with('error', 'Gagal mengirim pesan Blast WA! Respon Server Fonnte: ' . ($pesan_gagal ?? 'Koneksi Terputus'));
        }

        return back()->with('success', 'Sistem P4S Gubuk Sayur berhasil menyebarkan pesan blast WhatsApp secara NYATA ke ' . $berhasil_terkirim . ' nomor peserta!');
    }

    // =========================================================================
    // REVISI SINKRON: CETAK LAPORAN FINANSIAL (MENGGUNAKAN NAMA FILE KEUANGAN_PDF)
    // =========================================================================
    public function cetakLaporanKeuangan() 
    { 
        $pemasukan = PendaftaranPelatihan::with('pelatihan')
            ->whereIn('status_pembayaran', ['Success', 'success', 'settlement', 'Lunas', 'lunas'])
            ->latest()
            ->get();

        $total_pendapatan = $pemasukan->sum('total_harga');
        
        $bulanIndo = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $tanggal_cetak = date('j') . ' ' . $bulanIndo[date('n')] . ' ' . date('Y');

        // FIXED: Memanggil admin.laporan.keuangan_pdf pas dengan nama berkas fisikmu
        $pdf = \PDF::loadView('admin.laporan.keuangan_pdf', compact('pemasukan', 'total_pendapatan', 'tanggal_cetak'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Keuangan_P4S_Gubuk_Sayur.pdf');
    }

    // =========================================================================
    // REVISI SINKRON: CETAK LAPORAN PENGUNJUNG (MENGGUNAKAN NAMA FILE PENGUNJUNG_PDF)
    // =========================================================================
    public function cetakLaporanPengunjung() 
    { 
        $pengunjung = Pengunjung::orderBy('tanggal', 'desc')->get();
        
        $bulanIndo = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $tanggal_cetak = date('j') . ' ' . $bulanIndo[date('n')] . ' ' . date('Y');

        // FIXED: Memanggil admin.laporan.pengunjung_pdf pas dengan nama berkas fisikmu
        $pdf = \PDF::loadView('admin.laporan.pengunjung_pdf', compact('pengunjung', 'tanggal_cetak'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Statistik_Pengunjung_P4S.pdf');
    }
}