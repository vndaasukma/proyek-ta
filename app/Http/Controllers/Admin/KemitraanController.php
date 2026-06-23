<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kemitraan;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class KemitraanController extends Controller
{
    public function index()
    {
        $kemitraan = Kemitraan::latest()->get();
        return view('admin.kemitraan.index', compact('kemitraan'));
    }

    public function storeFront(Request $request)
    {
        // PERBAIKAN: Menambahkan validasi email agar wajib diisi
        $request->validate([
            'nama_perwakilan' => 'required',
            'nama_instansi'   => 'required',
            'no_wa'           => 'required',
            'email'           => 'required|email', // <--- INI YANG KURANG SEBELUMNYA
            'deskripsi'       => 'required',
            'proposal'        => 'nullable|mimes:pdf,doc,docx|max:2048', 
        ]);

        $path = null;
        if ($request->hasFile('proposal')) {
            $file = $request->file('proposal');
            $path = $file->store('proposals', 'public');
        }

        // PERBAIKAN: Menyimpan email ke database
        Kemitraan::create([
            'nama_perwakilan' => $request->nama_perwakilan,
            'nama_instansi'   => $request->nama_instansi,
            'no_wa'           => $request->no_wa,
            'email'           => $request->email,  // <--- INI JUGA YANG KURANG SEBELUMNYA
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

        // 1. Format Nomor WA (Ubah 08 jadi 628)
        $noWa = preg_replace('/[^0-9]/', '', $k->no_wa);
        if (substr($noWa, 0, 1) == '0') {
            $noWa = '62' . substr($noWa, 1);
        }

        $pesan = "Halo Bapak/Ibu *{$k->nama_perwakilan}* dari *{$k->nama_instansi}*.\n\nSelamat! Pengajuan kerja sama / kemitraan Anda dengan *P4S Gubuk Sayur Lumajang* telah kami *SETUJUI*.\n\nSurat persetujuan resmi telah diterbitkan oleh sistem kami. Tim kami akan segera berkoordinasi lebih lanjut dengan Anda.\n\nTerima kasih atas antusiasme kerja samanya! 🥬✨";

        $notifStatus = "Kemitraan disetujui.";

        // 2. Kirim WA via Fonnte
        try {
            $response = Http::withoutVerifying()
                ->asForm()
                ->withHeaders(['Authorization' => '3Pzf4Ebz7ZYyxt2aQbyL']) // Token Vinda
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

        // 3. Kirim Email (Jika kolom email ada dan tidak kosong)
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

        // 1. Format Nomor WA (Ubah 08 jadi 628)
        $noWa = preg_replace('/[^0-9]/', '', $k->no_wa);
        if (substr($noWa, 0, 1) == '0') {
            $noWa = '62' . substr($noWa, 1);
        }

        $pesan = "Halo Bapak/Ibu *{$k->nama_perwakilan}* dari *{$k->nama_instansi}*.\n\nTerima kasih telah mengajukan proposal kemitraan kepada kami.\n\nNamun mohon maaf, setelah melalui tahap peninjauan, pengajuan kemitraan Anda *BELUM DAPAT KAMI SETUJUI* untuk saat ini dikarenakan penyesuaian jadwal dan kapasitas operasional P4S.\n\nSemoga kita dapat menjalin kerja sama di lain kesempatan. Sukses selalu untuk Anda! 🙏";

        $notifStatus = "Kemitraan ditolak.";

        // 2. Kirim WA via Fonnte
        try {
            $response = Http::withoutVerifying()
                ->asForm()
                ->withHeaders(['Authorization' => '3Pzf4Ebz7ZYyxt2aQbyL']) // Token Vinda
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

        // 3. Kirim Email
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