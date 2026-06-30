<?php

/**
 * Konfigurasi Routing Web
 * @author Vinda Ambitha Sukma
 */

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Models\KelasPelatihan;
use App\Models\Produk;
use App\Models\KontakPesan;
use App\Models\Pengunjung;

// Import Controllers (Frontend)
use App\Http\Controllers\PendaftaranPelatihanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\GoogleController;

// Import Controllers (Admin)
use App\Http\Controllers\Admin\KelasPelatihanController;
use App\Http\Controllers\Admin\KemitraanController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\KontakPesanController;
use App\Http\Controllers\Admin\PendaftaranKunjunganController;
use App\Http\Controllers\Admin\PendaftaranPelatihanController as AdminPendaftaranPelatihan;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\PelatihController;
use App\Http\Controllers\Admin\ProfilWebsiteController;
use App\Http\Controllers\Admin\JadwalPelatihanController;
use App\Http\Controllers\Admin\SertifikatPelatihanController; // Ditambahkan

/* --- FRONTEND --- */

// Halaman Beranda Utama
Route::get('/', function () {
    $kelas_open = \App\Models\KelasPelatihan::where('status', 'open')->get();

    foreach ($kelas_open as $kelas) {
        $harus_tutup = false;
        if ($kelas->tanggal_exp_pelatihan && now()->startOfDay()->gt(\Carbon\Carbon::parse($kelas->tanggal_exp_pelatihan))) {
            $harus_tutup = true;
        }
        if (!$harus_tutup) {
            $jumlah_pendaftar = \App\Models\PendaftaranPelatihan::where('pelatihan_id', $kelas->id)
                ->whereIn('status_pembayaran', ['Success', 'pending'])
                ->count();
            if ($jumlah_pendaftar >= $kelas->kuota) {
                $harus_tutup = true;
            }
        }
        if ($harus_tutup) {
            $kelas->update(['status' => 'closed']);
        }
    }

    $list_pelatihan = \App\Models\KelasPelatihan::where('status', 'open')->take(3)->get();
    $images = \App\Models\Produk::where('type', 'product')->get();
    
    return view('beranda', compact('list_pelatihan', 'images'));
})->name('beranda');

// Halaman Detail Artikel Kegiatan
Route::get('/galeri/{id}', function ($id) {
    $artikel = \App\Models\Galeri::findOrFail($id);
    $rekomendasi = \App\Models\Galeri::where('id', '!=', $id)->latest()->take(3)->get();
    return view('galeri-detail', compact('artikel', 'rekomendasi'));
})->name('galeri.detail');

// Halaman Daftar Semua Pelatihan
Route::get('/pelatihan', function () {
    $kelas_open = \App\Models\KelasPelatihan::where('status', 'open')->get();
    foreach ($kelas_open as $kelas) {
        $harus_tutup = false;
        if ($kelas->tanggal_exp_pelatihan && now()->startOfDay()->gt(\Carbon\Carbon::parse($kelas->tanggal_exp_pelatihan))) {
            $harus_tutup = true;
        }
        if (!$harus_tutup) {
            $jumlah_pendaftar = \App\Models\PendaftaranPelatihan::where('pelatihan_id', $kelas->id)
                ->whereIn('status_pembayaran', ['Success', 'pending'])
                ->count();
            if ($jumlah_pendaftar >= $kelas->kuota) {
                $harus_tutup = true;
            }
        }
        if ($harus_tutup) {
            $kelas->update(['status' => 'closed']);
        }
    }
    $list_pelatihan = KelasPelatihan::where('status', 'open')->get();
    return view('pelatihan', compact('list_pelatihan'));
})->name('pelatihan');

Route::get('/pelatihan/detail/{id}', function ($id) {
    $pelatihan = KelasPelatihan::findOrFail($id);
    return view('detail-pelatihan', compact('pelatihan'));
})->name('pelatihan.detail');

Route::get('/pelatihan/daftar/{id}', function ($id) {
    $pelatihan = KelasPelatihan::findOrFail($id);
    return view('pendaftaran.create', compact('pelatihan')); 
})->name('pelatihan.daftar');

Route::post('/pelatihan/daftar', [PendaftaranPelatihanController::class, 'store'])->name('pelatihan.store');
Route::get('/sukses-daftar', [PendaftaranPelatihanController::class, 'suksesDaftar'])->name('sukses.daftar');
Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');

/* --- KUNJUNGAN & LAINNYA --- */
Route::get('/kunjungan', [PendaftaranKunjunganController::class, 'frontendIndex'])->name('kunjungan');
Route::post('/daftar-kunjungan', [PendaftaranKunjunganController::class, 'store'])->name('kunjungan.store');
Route::get('/kemitraan', fn () => view('kemitraan'))->name('kemitraan');
Route::post('/kemitraan/store', [KemitraanController::class, 'storeFront'])->name('kemitraan.store');
Route::get('/hubungi-kami', fn () => view('hubungi-kami'))->name('hubungi-kami');
Route::post('/hubungi-kami/kirim', [KontakPesanController::class, 'store'])->name('kontak.store');

/* --- AUTH MANUALLY & SOCIALITE --- */
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

/* --- ADMIN PANEL --- */
Route::prefix('admin')->middleware(['auth'])->group(function () {
    
    // DASHBOARD PIMPINAN (MENGGUNAKAN FORMULA ROLLING 7 HARI TERAKHIR DINAMIS)
    Route::get('/dashboard', function () {
        $total = KelasPelatihan::count();
        $open = KelasPelatihan::where('status', 'open')->count();
        $closed = KelasPelatihan::where('status', 'closed')->count(); 
        $total_pesan = KontakPesan::count(); 
        $pesan_terbaru = KontakPesan::latest()->take(5)->get();
        $total_pendapatan = \App\Models\PendaftaranPelatihan::where('status_pembayaran', 'Success')->sum('total_harga');
        
        $query_bulanan = \App\Models\PendaftaranPelatihan::where('status_pembayaran', 'Success')
            ->selectRaw('MONTH(tanggal_daftar) as bulan, SUM(total_harga) as total')
            ->whereYear('tanggal_daftar', date('Y'))
            ->groupBy('bulan')->pluck('total', 'bulan')->toArray();
        $pendapatan_bulanan = [];
        for ($i = 1; $i <= 12; $i++) { $pendapatan_bulanan[] = $query_bulanan[$i] ?? 0; }

        $awalMinggu = now()->subDays(6)->startOfDay(); 
        $akhirMinggu = now()->endOfDay(); 

        $query_mingguan = \App\Models\PendaftaranPelatihan::where('status_pembayaran', 'Success')
            ->whereBetween('tanggal_daftar', [$awalMinggu, $akhirMinggu])
            ->selectRaw('DATE(tanggal_daftar) as tanggal, SUM(total_harga) as total')
            ->groupBy('tanggal')->pluck('total', 'tanggal')->toArray();

        $pendapatan_mingguan = [];
        $label_mingguan = [];
        
        $namaHariIndo = [
            'Monday'    => 'Senin', 
            'Tuesday'   => 'Selasa', 
            'Wednesday' => 'Rabu', 
            'Thursday'  => 'Kamis', 
            'Friday'    => 'Jumat', 
            'Saturday'  => 'Sabtu', 
            'Sunday'    => 'Minggu'
        ];

        for ($i = 6; $i >= 0; $i--) {
            $hariObj = now()->subDays($i);
            $tglKey = $hariObj->format('Y-m-d');
            
            $label_mingguan[] = $namaHariIndo[$hariObj->format('l')];
            $pendapatan_mingguan[] = $query_mingguan[$tglKey] ?? 0;
        }
        
        $total_minggu_ini = array_sum($pendapatan_mingguan);
        $pengunjung_hari_ini = Pengunjung::where('tanggal', now()->toDateString())->sum('hits') ?? 0;

        return view('admin.dashboard', compact(
            'total', 'open', 'closed', 'total_pesan', 'pesan_terbaru',
            'total_pendapatan', 'pendapatan_bulanan', 'pendapatan_mingguan', 'label_mingguan', 'total_minggu_ini',
            'pengunjung_hari_ini'
        ));
    })->name('admin.dashboard');

    // PELATIHAN & PELATIH
    Route::resource('kelas-pelatihan', KelasPelatihanController::class);
    Route::resource('pelatih', PelatihController::class)->names('admin.pelatih');
    Route::get('/kelas-pelatihan/{id}/cetak', [KelasPelatihanController::class, 'cetak'])->name('kelas-pelatihan.cetak');
    Route::resource('pendaftaran-pelatihan', AdminPendaftaranPelatihan::class);
    
    // JADWAL PELATIHAN
    Route::get('/jadwal-pelatihan', [JadwalPelatihanController::class, 'index'])->name('jadwal-pelatihan.index');
    Route::get('/jadwal-pelatihan/create/{kelas_id}', [JadwalPelatihanController::class, 'create'])->name('jadwal-pelatihan.create');
    Route::post('/jadwal-pelatihan/store', [JadwalPelatihanController::class, 'store'])->name('jadwal-pelatihan.store');
    Route::delete('/jadwal-pelatihan/{id}', [JadwalPelatihanController::class, 'destroy'])->name('jadwal-pelatihan.destroy');
    Route::post('/jadwal-pelatihan/blast/{kelas_id}', [JadwalPelatihanController::class, 'blastReminder'])->name('jadwal-pelatihan.blast');
    
    // SERTIFIKAT & BLAST
    Route::get('/pendaftaran-pelatihan/{id}/preview-sertifikat', [AdminPendaftaranPelatihan::class, 'previewSertifikat'])->name('admin.pendaftaran.preview_sertifikat');
    Route::post('/pendaftaran-pelatihan/{id}/blast-sertifikat', [AdminPendaftaranPelatihan::class, 'blastSertifikat'])->name('admin.pendaftaran.blast_sertifikat');
    Route::post('/pendaftaran-pelatihan/blast-massal-kelas', [AdminPendaftaranPelatihan::class, 'blastSertifikatMassal'])->name('admin.pendaftaran.blast_massal');
    Route::get('/blast-wa', [AdminPendaftaranPelatihan::class, 'blastView'])->name('admin.blast.view');
    Route::post('/blast-wa/send', [AdminPendaftaranPelatihan::class, 'blastSend'])->name('admin.blast.send');

    // MENU MANDIRI DATA KOMPONEN SERTIFIKAT PELATIHAN
    Route::get('/sertifikat-pelatihan', [SertifikatPelatihanController::class, 'index'])->name('admin.sertifikat.index');
    Route::get('/sertifikat-pelatihan/{kelas_id}/edit', [SertifikatPelatihanController::class, 'edit'])->name('admin.sertifikat.edit');
    Route::post('/sertifikat-pelatihan/{kelas_id}/update', [SertifikatPelatihanController::class, 'update'])->name('admin.sertifikat.update');
    
    // STATUS PELATIHAN
    Route::patch('/pendaftaran/{id}/approve', [AdminPendaftaranPelatihan::class, 'approve'])->name('admin.approve');
    Route::patch('/pendaftaran/{id}/tolak', [AdminPendaftaranPelatihan::class, 'tolak'])->name('admin.tolak');
    Route::patch('/pendaftaran/{id}/batalkan', [AdminPendaftaranPelatihan::class, 'batalkan'])->name('admin.batalkan');
    
    // LAPORAN PDF
    Route::get('/laporan/keuangan/pdf', [AdminPendaftaranPelatihan::class, 'cetakLaporanKeuangan'])->name('admin.laporan.keuangan');
    Route::get('/laporan/pengunjung/pdf', [AdminPendaftaranPelatihan::class, 'cetakLaporanPengunjung'])->name('admin.laporan.pengunjung');

    // KUNJUNGAN
    Route::get('/pendaftaran-kunjungan', [PendaftaranKunjunganController::class, 'index'])->name('admin.kunjungan.pendaftaran');
    Route::post('/pendaftaran-kunjungan/store-manual', [PendaftaranKunjunganController::class, 'storeManual'])->name('admin.kunjungan.store_manual');
    Route::post('/pendaftaran-kunjungan/{id}/approve', [PendaftaranKunjunganController::class, 'approve'])->name('admin.kunjungan.approve');
    Route::post('/pendaftaran-kunjungan/{id}/reject', [PendaftaranKunjunganController::class, 'reject'])->name('admin.kunjungan.reject');
    Route::delete('/pendaftaran-kunjungan/{id}', [PendaftaranKunjunganController::class, 'destroy'])->name('admin.kunjungan.destroy');
    Route::post('/pendaftaran-kunjungan/{id}/reschedule', [PendaftaranKunjunganController::class, 'reschedule'])->name('admin.kunjungan.reschedule');
    Route::post('/kunjungan/lock-date', [PendaftaranKunjunganController::class, 'lockDate'])->name('admin.kunjungan.lock');
    Route::delete('/kunjungan/unlock-date/{id}', [PendaftaranKunjunganController::class, 'unlockDate'])->name('admin.kunjungan.unlock');

    // KEMITRAAN (SINKRONISASI FILTER URL PERBAIKAN)
    Route::resource('kemitraan', KemitraanController::class)->names('admin.kemitraan');
    Route::get('/kemitraan/{id}/approve', [KemitraanController::class, 'approve'])->name('admin.kemitraan.approve');
    Route::get('/kemitraan/{id}/reject', [KemitraanController::class, 'reject'])->name('admin.kemitraan.reject');
    Route::get('/kemitraan/{id}/cetak', [KemitraanController::class, 'cetak'])->name('admin.kemitraan.cetak');
    Route::post('/kemitraan/{id}/kirim-surat', [KemitraanController::class, 'sendLetter'])->name('admin.kemitraan.kirim'); 

    // PESAN & SETTING
    Route::get('/pesan', [KontakPesanController::class, 'index'])->name('admin.pesan.index');
    Route::delete('/pesan/{id}', [KontakPesanController::class, 'destroy'])->name('admin.pesan.destroy');
    Route::get('/setting', [SettingController::class, 'index'])->name('admin.setting.index');

    // CMS (PROFIL WEBSITE, REVIEW, GALERI, PRODUK, FASILITAS)
    Route::get('/profil-website', [ProfilWebsiteController::class, 'index'])->name('profil-website.index');
    Route::put('/profil-website/update', [ProfilWebsiteController::class, 'update'])->name('profil-website.update');

    // FIXED TYPO: Menghilangkan simbol @ di depan Route
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('admin.reviews.index');
    Route::patch('/reviews/{id}/approve', [AdminReviewController::class, 'approve'])->name('admin.reviews.approve');
    Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('admin.reviews.destroy');

    // GALERI
    Route::get('/galeri', [GaleriController::class, 'index'])->name('admin.galeri.index');
    Route::post('/galeri', [GaleriController::class, 'store'])->name('admin.galeri.store');
    Route::put('/galeri/{id}', [GaleriController::class, 'update'])->name('admin.galeri.update');
    Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])->name('admin.galeri.destroy');

    // PRODUCT (PROSES UPDATE / PUT BERHASIL DISELARASKAN)
    Route::get('/product', [ProdukController::class, 'index'])->name('admin.product.index');
    Route::post('/product', [ProdukController::class, 'store'])->name('admin.product.store');
    // FIXED: Memperbaiki penamaan route destroy product agar selaras dengan folder view
    Route::delete('/product/{id}', [ProdukController::class, 'destroy'])->name('admin.product.destroy');
    // SISIPKAN BARIS BARU INI UNTUK UPDATE DATA:
    Route::put('/product/{id}', [ProdukController::class, 'update'])->name('admin.product.update');

    // FASILITAS
    Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('admin.fasilitas.index');
    Route::post('/fasilitas', [FasilitasController::class, 'store'])->name('admin.fasilitas.store');
    Route::delete('/fasilitas/{id}', [FasilitasController::class, 'destroy'])->name('admin.fasilitas.destroy');
});

// API & CALLBACK SYSTEM
Route::get('/cek-vinda/{id}', [PendaftaranKunjunganController::class, 'approve']);
Route::post('/api/midtrans-callback', [PendaftaranPelatihanController::class, 'notification']);