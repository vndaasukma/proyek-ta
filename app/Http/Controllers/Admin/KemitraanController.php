<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kemitraan;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

/**
 * @author Vinda Ambitha Sukma
 */
class KemitraanController extends Controller
{
    public function index()
    {
        $kemitraan = Kemitraan::latest()->get();
        return view('admin.kemitraan.index', compact('kemitraan'));
    }

    public function storeFront(Request $request)
    {
        $request->validate([
            'nama_perwakilan' => 'required',
            'nama_instansi'   => 'required',
            'no_wa'           => 'required',
            'email'           => 'required|email',
            'deskripsi'       => 'required',
            'proposal'        => 'nullable|mimes:pdf,doc,docx|max:2048', 
        ]);

        $path = null;
        if ($request->hasFile('proposal')) {
            $file = $request->file('proposal');
            $path = $file->store('proposals', 'public');
        }

        Kemitraan::create([
            'nama_perwakilan' => $request->nama_perwakilan,
            'nama_instansi'   => $request->nama_instansi,
            'no_wa'           => $request->no_wa,
            'email'           => $request->email,
            'deskripsi'       => $request->deskripsi,
            'proposal_path'   => $path,
            'status'          => 'pending',
        ]);

        return back()->with('success', 'Permohonan kemitraan berhasil dikirim! Tunggu kabar dari kami via WA dan Email.');
    }

    // =========================================================================
    // FUNGSI APPROVE (ACC)
    // =========================================================================
    public function approve($id)
    {
        $k = Kemitraan::findOrFail($id);
        $k->update(['status' => 'approved']);

        $noWa = preg_replace('/[^0-9]/', '', $k->no_wa);
        if (substr($noWa, 0, 1) == '0') {
            $noWa = '62' . substr($noWa, 1);
        }

        $pesan = "Halo Bapak/Ibu *{$k->nama_perwakilan}* dari *{$k->nama_instansi}*.\n\nSelamat! Pengajuan kerja sama / kemitraan Anda dengan *P4S Gubuk Sayur Lumajang* telah kami *SETUJUI*.\n\nSurat persetujuan resmi telah diterbitkan oleh sistem kami. Tim kami akan segera berkoordinasi lebih lanjut dengan Anda.\n\nTeria kasih atas antusiasme kerja samanya! 🥬✨";

        $notifStatus = "Kemitraan disetujui.";

        try {
            $response = Http::withoutVerifying()
                ->asForm()
                ->withHeaders(['Authorization' => '3Pzf4Ebz7ZYyxt2aQbyL'])
                ->post('https://api.fonnte.com/send', [
                    'target'  => $noWa,
                    'message' => $pesan,
                ]);
            
            if ($response->successful() && isset($response['status']) && $response['status'] == true) {
                $notifStatus .= " WA Terkirim.";
            } else {
                $notifStatus .= " (Gagal kirim WA: Cek Fonnte/Token).";
            }
        } catch (\Exception $e) {
            $notifStatus .= " (Error API Fonnte).";
        }

        if (!empty($k->email)) {
            try {
                Mail::raw($pesan, function ($message) use ($k) {
                    $message->to($k->email)
                            ->subject('Persetujuan Kemitraan - P4S Gubuk Sayur');
                });
                $notifStatus .= " Email Terkirim.";
            } catch (\Exception $e) {
                $notifStatus .= " (Gagal Email: Cek setting .env).";
            }
        }

        return back()->with('success', $notifStatus);
    }

    // =========================================================================
    // FUNGSI REJECT (TOLAK)
    // =========================================================================
    public function reject($id)
    {
        $k = Kemitraan::findOrFail($id);
        $k->update(['status' => 'rejected']);

        $noWa = preg_replace('/[^0-9]/', '', $k->no_wa);
        if (substr($noWa, 0, 1) == '0') {
            $noWa = '62' . substr($noWa, 1);
        }

        $pesan = "Halo Bapak/Ibu *{$k->nama_perwakilan}* dari *{$k->nama_instansi}*.\n\nTerima kasih telah mengajukan proposal kemitraan kepada kami.\n\nNamun mohon maaf, setelah melalui tahap peninjauan, pengajuan kemitraan Anda *BELUM DAPAT KAMI SETUJUI* untuk saat ini dikarenakan penyesuaian jadwal dan kapasitas operasional P4S.\n\nSemoga kita dapat menjalin kerja sama di lain kesempatan. Sukses selalu untuk Anda! 🙏";

        $notifStatus = "Kemitraan ditolak.";

        try {
            $response = Http::withoutVerifying()
                ->asForm()
                ->withHeaders(['Authorization' => '3Pzf4Ebz7ZYyxt2aQbyL'])
                ->post('https://api.fonnte.com/send', [
                    'target'  => $noWa,
                    'message' => $pesan,
                ]);
            
            if ($response->successful() && isset($response['status']) && $response['status'] == true) {
                $notifStatus .= " WA Terkirim.";
            } else {
                $notifStatus .= " (Gagal kirim WA: Cek Fonnte/Token).";
            }
        } catch (\Exception $e) {
            $notifStatus .= " (Error API Fonnte).";
        }

        if (!empty($k->email)) {
            try {
                Mail::raw($pesan, function ($message) use ($k) {
                    $message->to($k->email)
                            ->subject('Informasi Kemitraan - P4S Gubuk Sayur');
                });
                $notifStatus .= " Email Terkirim.";
            } catch (\Exception $e) {
                $notifStatus .= " (Gagal Email: Cek setting .env).";
            }
        }

        return back()->with('success', $notifStatus);
    }

    public function cetak($id)
    {
        $data = Kemitraan::findOrFail($id);

        if ($data->status != 'approved') {
            return back()->with('error', 'Hanya pengajuan yang sudah disetujui yang dapat dicetak.');
        }

        $pdf = Pdf::loadView('admin.pdf.surat_kemitraan', compact('data'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('Surat_Kemitraan_'.$data->id.'.pdf');
    }

    // =========================================================================
    // REVISI BARU: FUNGSI AUTOMATED BLAST KIRIM DIGITAL (PDF EMAIL + WA FONNTE)
    // =========================================================================
    public function sendLetter($id)
    {
        $data = Kemitraan::findOrFail($id);

        if (empty($data->email) || empty($data->no_wa)) {
            return back()->with('error', 'Gagal memproses pengiriman. Alamat email atau nomor WhatsApp pengaju tidak terdata.');
        }

        // 1. Generate PDF di memori RAM tanpa menyimpan file fisik lokal
        $pdf = Pdf::loadView('admin.pdf.surat_kemitraan', compact('data'))
                  ->setPaper('a4', 'portrait');

        // 2. Format Sanitasi Nomor HP Fonnte
        $noWa = preg_replace('/[^0-9]/', '', $data->no_wa);
        if (substr($noWa, 0, 1) == '0') {
            $noWa = '62' . substr($noWa, 1);
        }

        // 3. Bangun Format Kode Surat Online Berdasarkan Aturan Bulan Romawi & Padding ID
        $bulanRomawi = [1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'][date('n')];
        $idPadding = sprintf('%03d', $data->id);
        $noSuratFormat = "GS/OL/" . $idPadding . "/" . $bulanRomawi . "/" . date('Y');

        $notifStatus = "Pemrosesan Blast Digital Sukses.";

        // 4. Eksekusi Kirim Email Resmi dengan Lampiran PDF Mentah
        try {
            Mail::send([], [], function ($message) use ($data, $pdf) {
                $message->to($data->email)
                        ->subject('Surat Persetujuan Kemitraan Resmi - P4S Gubuk Sayur Lumajang')
                        ->html('
                            <p>Halo <strong>' . ($data->nama_perwakilan ?? 'Mitra') . '</strong>,</p>
                            <p>Selamat! Pengajuan dokumen administrasi kerja sama dari instansi <strong>' . $data->nama_instansi . '</strong> telah diverifikasi dan disetujui secara legal oleh P4S Gubuk Sayur.</p>
                            <p>Berikut kami lampirkan dokumen digital <strong>Surat Persetujuan Kemitraan Resmi</strong> dalam bentuk berkas PDF untuk diunduh.</p>
                            <br>
                            <p>Salam Hormat,</p>
                            <p><strong>Tim Administrasi P4S Gubuk Sayur Lumajang</strong></p>
                        ')
                        ->attachData($pdf->output(), 'Surat_Persetujuan_Kemitraan_OL.pdf', [
                            'mime' => 'application/pdf',
                        ]);
            });
            $notifStatus .= " PDF Email Terkirim.";
        } catch (\Exception $e) {
            $notifStatus .= " (Gagal Email: Cek konfigurasi mail .env).";
        }

        // 5. Eksekusi Kirim Notifikasi Konfirmasi Nomor Surat via WA Fonnte
        $pesanWA = "Halo Bapak/Ibu *{$data->nama_perwakilan}*,\n\nKami menginfokan bahwa dokumen Surat Persetujuan Kemitraan Resmi untuk *{$data->nama_instansi}* telah berhasil diterbitkan oleh sistem dengan Nomor Surat Resmi: *{$noSuratFormat}*. 🌱\n\nBerkas fisik PDF surat tersebut telah dikirimkan secara otomatis ke alamat email Anda (*{$data->email}*). Silakan melakukan pengecekan kotak masuk.\n\nTerima kasih atas kerja samanya!\n\nSalam,\n*P4S Gubuk Sayur Lumajang*";

        try {
            $response = Http::withoutVerifying()
                ->asForm()
                ->withHeaders(['Authorization' => '3Pzf4Ebz7ZYyxt2aQbyL'])
                ->post('https://api.fonnte.com/send', [
                    'target'  => $noWa,
                    'message' => $pesanWA,
                ]);

            if ($response->successful() && isset($response['status']) && $response['status'] == true) {
                $notifStatus .= " Notifikasi WA Terkirim.";
            } else {
                $notifStatus .= " (WA Tertolak Fonnte).";
            }
        } catch (\Exception $e) {
            $notifStatus .= " (Gagal API Gateway WA).";
        }

        return back()->with('success', $notifStatus);
    }

    public function destroy($id)
    {
        $k = Kemitraan::findOrFail($id);
        
        if ($k->proposal_path && Storage::disk('public')->exists($k->proposal_path)) {
            Storage::disk('public')->delete($k->proposal_path);
        }
        
        $k->delete();
        
        return back()->with('success', 'Data kemitraan dan proposal berhasil dihapus dari sistem!');
    }
}