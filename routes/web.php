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

// Import Controllers (Frontend)
use App\Http\Controllers\PendaftaranPelatihanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReviewController;

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

/* --- FRONTEND --- */
Route::get('/', function () {
    $list_pelatihan = \App\Models\KelasPelatihan::where('status', 'open')->take(3)->get();
    $images = \App\Models\Produk::where('type', 'product')->get();
    
    return view('beranda', compact('list_pelatihan', 'images'));
})->name('beranda');

Route::get('/pelatihan', function () {
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

// PERBAIKAN: Dialihkan kembali ke Controller untuk memproses status otomatis pasca-pembayaran
Route::get('/sukses-daftar', [PendaftaranPelatihanController::class, 'suksesDaftar'])->name('sukses.daftar');

Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');

/* --- KUNJUNGAN & LAINNYA --- */
Route::get('/kunjungan', [PendaftaranKunjunganController::class, 'frontendIndex'])->name('kunjungan');
Route::post('/daftar-kunjungan', [PendaftaranKunjunganController::class, 'store'])->name('kunjungan.store');
Route::get('/kemitraan', fn () => view('kemitraan'))->name('kemitraan');
Route::post('/kemitraan/store', [KemitraanController::class, 'storeFront'])->name('kemitraan.store');
Route::get('/hubungi-kami', fn () => view('hubungi-kami'))->name('hubungi-kami');
Route::post('/hubungi-kami/kirim', [KontakPesanController::class, 'store'])->name('kontak.store');

/* --- AUTH --- */
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/* --- ADMIN PANEL --- */
Route::prefix('admin')->middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', function () {
        $total = KelasPelatihan::count();
        $open = KelasPelatihan::where('status', 'open')->count();
        $closed = KelasPelatihan::where('status', 'closed')->count(); 
        $total_pesan = KontakPesan::count(); 
        $pesan_terbaru = KontakPesan::latest()->take(5)->get();

        // 1. Total seluruh pendapatan pelatihan yang sukses dibayar
        $total_pendapatan = \App\Models\PendaftaranPelatihan::where('status_pembayaran', 'Success')->sum('total_harga');

        // 2. Mengelompokkan omzet berdasarkan bulan di tahun berjalan
        $query_bulanan = \App\Models\PendaftaranPelatihan::where('status_pembayaran', 'Success')
            ->selectRaw('MONTH(tanggal_daftar) as bulan, SUM(total_harga) as total')
            ->whereYear('tanggal_daftar', date('Y'))
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $pendapatan_bulanan = [];
        for ($i = 1; $i <= 12; $i++) {
            $pendapatan_bulanan[] = $query_bulanan[$i] ?? 0;
        }

        return view('admin.dashboard', compact(
            'total', 'open', 'closed', 'total_pesan', 'pesan_terbaru',
            'total_pendapatan', 'pendapatan_bulanan'
        ));
    })->name('admin.dashboard');

    Route::resource('kelas-pelatihan', KelasPelatihanController::class);
    Route::get('/kelas-pelatihan/{id}/cetak', [KelasPelatihanController::class, 'cetak'])->name('kelas-pelatihan.cetak');

    Route::resource('pendaftaran-pelatihan', AdminPendaftaranPelatihan::class);
    
    /* SEKSI BARU: RUNTIME PREVIEW & BLAST EMAIL SERTIFIKAT DIGITAL */
    Route::get('/pendaftaran-pelatihan/{id}/preview-sertifikat', [AdminPendaftaranPelatihan::class, 'previewSertifikat'])->name('admin.pendaftaran.preview_sertifikat');
    Route::post('/pendaftaran-pelatihan/{id}/blast-sertifikat', [AdminPendaftaranPelatihan::class, 'blastSertifikat'])->name('admin.pendaftaran.blast_sertifikat');
    Route::post('/pendaftaran-pelatihan/blast-massal-kelas', [AdminPendaftaranPelatihan::class, 'blastSertifikatMassal'])->name('admin.pendaftaran.blast_massal');

    /* --- FITUR BLAST WA --- */
    Route::get('/blast-wa', [AdminPendaftaranPelatihan::class, 'blastView'])->name('admin.blast.view');
    Route::post('/blast-wa/send', [AdminPendaftaranPelatihan::class, 'blastSend'])->name('admin.blast.send');
    
    Route::patch('/pendaftaran/{id}/approve', [AdminPendaftaranPelatihan::class, 'approve'])->name('admin.approve');
    Route::patch('/pendaftaran/{id}/tolak', [AdminPendaftaranPelatihan::class, 'tolak'])->name('admin.tolak');
    Route::patch('/pendaftaran/{id}/batalkan', [AdminPendaftaranPelatihan::class, 'batalkan'])->name('admin.batalkan');
    
    /* --- MANAGEMENT PENDAFTARAN KUNJUNGAN --- */
    Route::get('/pendaftaran-kunjungan', [PendaftaranKunjunganController::class, 'index'])->name('admin.kunjungan.pendaftaran');
    Route::post('/pendaftaran-kunjungan/store-manual', [PendaftaranKunjunganController::class, 'storeManual'])->name('admin.kunjungan.store_manual');
    Route::post('/pendaftaran-kunjungan/{id}/approve', [PendaftaranKunjunganController::class, 'approve'])->name('admin.kunjungan.approve');
    Route::post('/pendaftaran-kunjungan/{id}/reject', [PendaftaranKunjunganController::class, 'reject'])->name('admin.kunjungan.reject');
    Route::delete('/pendaftaran-kunjungan/{id}', [PendaftaranKunjunganController::class, 'destroy'])->name('admin.kunjungan.destroy');
    
    Route::post('/pendaftaran-kunjungan/{id}/reschedule', [PendaftaranKunjunganController::class, 'reschedule'])->name('admin.kunjungan.reschedule');
    Route::post('/kunjungan/lock-date', [PendaftaranKunjunganController::class, 'lockDate'])->name('admin.kunjungan.lock');
    Route::delete('/kunjungan/unlock-date/{id}', [PendaftaranKunjunganController::class, 'unlockDate'])->name('admin.kunjungan.unlock');

    Route::resource('kemitraan', KemitraanController::class)->names('admin.kemitraan');
    
    Route::get('/kemitraan/{id}/approve', [KemitraanController::class, 'approve'])->name('admin.kemitraan.approve');
    Route::get('/kemitraan/{id}/reject', [KemitraanController::class, 'reject'])->name('admin.kemitraan.reject');
    Route::get('/kemitraan/{id}/cetak', [KemitraanController::class, 'cetak'])->name('admin.kemitraan.cetak');

    Route::get('/pesan', [KontakPesanController::class, 'index'])->name('admin.pesan.index');
    Route::delete('/pesan/{id}', [KontakPesanController::class, 'destroy'])->name('admin.pesan.destroy');
    Route::get('/setting', [SettingController::class, 'index'])->name('admin.setting.index');

    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('admin.reviews.index');
    Route::patch('/reviews/{id}/approve', [AdminReviewController::class, 'approve'])->name('admin.reviews.approve');
    Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('admin.reviews.destroy');

    Route::get('/galeri', [GaleriController::class, 'index'])->name('admin.galeri.index');
    Route::post('/galeri', [GaleriController::class, 'store'])->name('admin.galeri.store');
    Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])->name('admin.galeri.destroy');

    Route::get('/product', [ProdukController::class, 'index'])->name('admin.product.index');
    Route::post('/product', [ProdukController::class, 'store'])->name('admin.product.store');
    Route::delete('/product/{id}', [ProdukController::class, 'destroy'])->name('admin.product.destroy');

    Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('admin.fasilitas.index');
    Route::post('/fasilitas', [FasilitasController::class, 'store'])->name('admin.fasilitas.store');
    Route::delete('/fasilitas/{id}', [FasilitasController::class, 'destroy'])->name('admin.fasilitas.destroy');

    Route::get('/tes-wa-vinda', function () {
        return response()->json([
            'status' => 'success',
            'message' => 'Notifikasi WhatsApp dinonaktifkan. Pengujian sistem berhasil.'
        ]);
    });
});

Route::get('/cek-vinda/{id}', [PendaftaranKunjunganController::class, 'approve']);
Route::post('/api/midtrans-callback', [PendaftaranPelatihanController::class, 'notification']);