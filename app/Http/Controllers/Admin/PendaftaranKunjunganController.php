<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranKunjungan;
use App\Models\LockedDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

// Import untuk Email
use App\Mail\KunjunganApproved;
use App\Mail\KunjunganRejected;
use Illuminate\Support\Facades\Mail;

/**
 * @author Vinda Ambitha Sukma
 */
class PendaftaranKunjunganController extends Controller
{
    /**
     * Menampilkan Form Pendaftaran Kunjungan di Halaman Depan (User)
     */
    public function frontendIndex(Request $request) {
        $tanggalDipilih = $request->get('date', date('Y-m-d'));
        $carbonDate = Carbon::parse($tanggalDipilih);
        $today = Carbon::today()->format('Y-m-d');
        
        $bookedSessions = PendaftaranKunjungan::where('tanggal_kunjungan', $tanggalDipilih)
                            ->where('status', 'approved')
                            ->get()
                            ->keyBy('sesi');

        $allBookings = PendaftaranKunjungan::where('status', 'approved')
                        ->whereMonth('tanggal_kunjungan', $carbonDate->month)
                        ->whereYear('tanggal_kunjungan', $carbonDate->year)
                        ->get()
                        ->groupBy('tanggal_kunjungan');

        // Mengambil seluruh array tanggal yang sedang digembok mandiri
        $lockedDates = LockedDate::pluck('date')->toArray();

        return view('kunjungan', compact('tanggalDipilih', 'carbonDate', 'bookedSessions', 'allBookings', 'today', 'lockedDates'));
    }

    /**
     * Menampilkan Table List Pendaftaran di Dashboard Admin
     */
    public function index() {
        // SINKRONISASI: Dikembalikan ke nama $list_pendaftaran agar sesuai dengan file Blade asli kamu
        $list_pendaftaran = PendaftaranKunjungan::latest()->get();
        $lockedDates = LockedDate::orderBy('date', 'asc')->get();

        return view('admin.kunjungan.pendaftaran', compact('list_pendaftaran', 'lockedDates'));
    }

    /**
     * Memproses Kiriman Form Pendaftaran dari User Luar (Halaman Depan)
     */
    public function store(Request $request) {
        $request->validate([
            'nama_pemohon'      => 'required',
            'instansi'          => 'required',
            'jumlah_pengunjung' => 'required|integer|min:1', 
            'no_wa'             => 'required',
            'email'             => 'required|email',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'sesi'              => 'required',
        ]);

        // Proteksi keamanan jika user mencoba mendaftar pada tanggal yang digembok
        $isLocked = LockedDate::where('date', $request->tanggal_kunjungan)->exists();
        if ($isLocked) {
            return back()->with('error', 'Maaf, tanggal kunjungan yang Anda pilih sudah ditutup penuh oleh admin. Silakan memilih alternatif tanggal lainnya.');
        }

        PendaftaranKunjungan::create([
            'nama_pemohon'      => $request->nama_pemohon,
            'instansi'          => $request->instansi,
            'jumlah_pengunjung' => $request->jumlah_pengunjung, 
            'email'             => $request->email,
            'no_wa'             => $request->no_wa,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'sesi'              => $request->sesi,
            'keperluan'         => $request->keperluan,
            'status'            => 'pending'
        ]);

        return back()->with('success', 'Pengajuan reservasi Anda telah kami terima. Tim Gubuk Sayur akan segera meninjau jadwal tersebut. Mohon tunggu konfirmasi resmi yang akan dikirimkan melalui pesan WhatsApp ke nomor Anda.');
    }

    /**
     * Helper Format Nomor WhatsApp Fonnte
     */
    private function formatNomor($nomor) {
        $nomor = preg_replace('/\D/', '', $nomor); 
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }
        return $nomor;
    }

    /**
     * Aksi Menyetujui Kunjungan (Kirim WA Fonnte + Kirim Email)
     */
    public function approve($id) {
        $data = PendaftaranKunjungan::findOrFail($id);
        
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

        if ($response->successful() && $response->json('status') == true) {
            $data->update(['status' => 'approved']);

            if ($data->email) {
                try {
                    Mail::to($data->email)->send(new KunjunganApproved($data));
                } catch (\Exception $e) {
                    \Log::error("Gagal kirim email ke {$data->email}: " . $e->getMessage());
                }
            }

            return back()->with('success', 'Pendaftaran Disetujui, WA & Email Terkirim!');
        }

        return back()->with('error', 'Gagal kirim WA: ' . ($response->json('reason') ?? 'Koneksi API Bermasalah'));
    }

    /**
     * Aksi Menolak Kunjungan (Update Status + Kirim WA Fonnte + Kirim Email)
     */
    public function reject($id) {
        $data = PendaftaranKunjungan::findOrFail($id);
        
        $data->update(['status' => 'rejected']);

        $tanggalBagus = \Carbon\Carbon::parse($data->tanggal_kunjungan)->translatedFormat('d F Y');

        $token = '3Pzf4Ebz7ZYyxt2aQbyL';
        $nomorTujuan = $this->formatNomor($data->no_wa);
        $pesan = "Halo *{$data->nama_pemohon}*,\n\nMohon maaf, reservasi kunjungan Anda dari instansi *{$data->instansi}* pada tanggal *{$tanggalBagus}* *BELUM BISA KAMI SETUJUI* saat ini. 🙏\n\nHal ini dikarenakan jadwal yang penuh atau kegiatan operasional lainnya. Silakan hubungi kami untuk mendiskusikan alternatif jadwal.\n\nSalam, *P4S Gubuk Sayur*";

        $response = Http::withoutVerifying()
            ->asForm()
            ->withHeaders(['Authorization' => $token])
            ->post('https://api.fonnte.com/send', [
                'target' => $nomorTujuan,
                'message' => $pesan,
            ]);

        if ($data->email) {
            try {
                Mail::to($data->email)->send(new KunjunganRejected($data));
            } catch (\Exception $e) {
                \Log::error("Gagal kirim email penolakan ke {$data->email}: " . $e->getMessage());
            }
        }

        if ($response->successful() && $response->json('status') == true) {
            return back()->with('success', 'Pendaftaran Ditolak, WA & Email Penolakan Berhasil Terkirim!');
        }

        return back()->with('success', 'Data berhasil Ditolak, TAPI pesan WA gagal terkirim (Nomor mungkin tidak valid).');
    }

    /**
     * Menghapus Data Pendaftaran Kunjungan
     */
    public function destroy($id) {
        PendaftaranKunjungan::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus!');
    }

    /**
     * Memproses Reschedule Jadwal Peserta Langsung oleh Admin via Modal
     */
    public function reschedule(Request $request, $id) {
        $data = PendaftaranKunjungan::findOrFail($id);

        // VALIDASI BACKEND 1: Jika tanggal kunjungan awal yang ingin diganti ternyata sudah lewat dari hari ini
        if (Carbon::parse($data->tanggal_kunjungan)->startOfDay()->lt(Carbon::today())) {
            return back()->with('error', 'Gagal! Jadwal kunjungan yang sudah terlewat tidak dapat di-reschedule kembali.');
        }

        // VALIDASI BACKEND 2: Memastikan input 'tanggal_baru' terisi, bertipe date, dan minimal hari ini/ke depan
        $request->validate([
            'tanggal_baru' => 'required|date|after_or_equal:today',
        ]);

        $isLocked = LockedDate::where('date', $request->tanggal_baru)->exists();
        if ($isLocked) {
            return back()->with('error', 'Gagal memindahkan jadwal. Tanggal baru yang Anda pilih sedang dalam status dikunci/gembok.');
        }

        $data->update([
            'tanggal_kunjungan' => $request->tanggal_baru 
        ]);

        return back()->with('success', 'Jadwal kunjungan ' . $data->instansi . ' berhasil di-reschedule ke tanggal ' . date('d-m-Y', strtotime($request->tanggal_baru)) . '.');
    }

    /**
     * Membuat Gembok/Kunci Tanggal Mandiri Lewat Dashboard Admin
     */
    public function lockDate(Request $request) {
        $request->validate([
            'date' => 'required|date|unique:locked_dates,date',
            'keterangan' => 'required|string|max:255'
        ], [
            'date.unique' => 'Tanggal ini sudah berada dalam daftar kunci gembok.'
        ]);

        LockedDate::create([
            'date' => $request->date,
            'keterangan' => $request->keterangan
        ]);

        return back()->with('success', 'Tanggal ' . date('d-m-Y', strtotime($request->date)) . ' berhasil dikunci mandiri dari sistem.');
    }

    /**
     * Membuka Kembali (Unlock) Gembok Tanggal yang Sebelumnya Dikunci
     */
    public function unlockDate($id) {
        $date = LockedDate::findOrFail($id);
        $date->delete();

        return back()->with('success', 'Gembok tanggal berhasil dibuka kembali. User sekarang bisa mengisi jadwal ini.');
    }

    /**
     * Memproses Pendaftaran Kunjungan Manual Langsung dari Dashboard Admin
     */
    public function storeManual(Request $request) {
        $request->validate([
            'nama_pemohon'      => 'required|string|max:255',
            'instansi'          => 'required|string|max:255',
            'jumlah_pengunjung' => 'required|integer|min:1', 
            'no_wa'             => 'required|string',
            'email'             => 'required|email',
            'tanggal_kunjungan' => 'required|date',
            'sesi'              => 'required',
        ]);

        PendaftaranKunjungan::create([
            'nama_pemohon'      => $request->nama_pemohon,
            'instansi'          => $request->instansi,
            'jumlah_pengunjung' => $request->jumlah_pengunjung, 
            'email'             => $request->email,
            'no_wa'             => $request->no_wa,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'sesi'              => $request->sesi,
            'keperluan'         => $request->keperluan ?? 'Input manual oleh admin',
            'status'            => 'approved' 
        ]);

        return back()->with('success', 'Data kunjungan berhasil didaftarkan langsung oleh admin dengan status Approved!');
    }
}