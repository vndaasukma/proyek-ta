<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Models\KelasPelatihan;
use App\Models\Image;
use App\Models\KontakPesan;

// Import Controllers (Frontend)
use App\Http\Controllers\PendaftaranPelatihanController;
use App\Http\Controllers\Auth\LoginController;

// Import Controllers (Admin)
use App\Http\Controllers\Admin\KelasPelatihanController;
use App\Http\Controllers\Admin\KemitraanController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\KontakPesanController;
use App\Http\Controllers\Admin\PendaftaranKunjunganController;
use App\Http\Controllers\Admin\PendaftaranPelatihanController as AdminPendaftaranPelatihan;

/* --- FRONTEND --- */

Route::get('/', function () {
    $list_pelatihan = KelasPelatihan::where('status', 'open')->take(3)->get();
    $images = Image::where('type', 'product')->get();
    return view('beranda', compact('list_pelatihan', 'images'));
})->name('beranda');

Route::get('/pelatihan', function () {
    $list_pelatihan = KelasPelatihan::where('status', 'open')->get();
    return view('pelatihan', compact('list_pelatihan'));
})->name('pelatihan');

// name('pelatihan.daftar') agar link pendaftaran aman
Route::get('/pelatihan/daftar/{id}', function ($id) {
    $pelatihan = KelasPelatihan::findOrFail($id);
    return view('pendaftaran.create', compact('pelatihan')); 
})->name('pelatihan.daftar');

Route::post('/pelatihan/daftar', [PendaftaranPelatihanController::class, 'store'])->name('pelatihan.store');

Route::get('/sukses-daftar', function () {
    return view('sukses-daftar');
})->name('sukses.daftar');

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

/* --- ADMIN --- */
Route::prefix('admin')->middleware(['auth'])->group(function () {
    
    // 1. Dashboard
    Route::get('/dashboard', function () {
        $total = KelasPelatihan::count();
        $open = KelasPelatihan::where('status', 'open')->count();
        $closed = KelasPelatihan::where('status', 'closed')->count(); 
        $total_pesan = KontakPesan::count(); 
        $pesan_terbaru = KontakPesan::latest()->take(5)->get();
        return view('admin.dashboard', compact('total', 'open', 'closed', 'total_pesan', 'pesan_terbaru'));
    })->name('admin.dashboard');

    // 2. Kelas Pelatihan
    Route::resource('kelas-pelatihan', KelasPelatihanController::class);
    Route::get('/kelas-pelatihan/{id}/cetak', [KelasPelatihanController::class, 'cetak'])->name('kelas-pelatihan.cetak');

    // 3. Pendaftaran Pelatihan
    Route::resource('pendaftaran-pelatihan', AdminPendaftaranPelatihan::class);
    Route::patch('/pendaftaran/{id}/approve', [AdminPendaftaranPelatihan::class, 'approve'])->name('admin.approve');
    Route::patch('/pendaftaran/{id}/tolak', [AdminPendaftaranPelatihan::class, 'tolak'])->name('admin.tolak');
    
    // --- UNTUK TOMBOL BATALKAN ---
    Route::patch('/pendaftaran/{id}/batalkan', [AdminPendaftaranPelatihan::class, 'batalkan'])->name('admin.batalkan');
    
    // 4. Kunjungan
    Route::get('/pendaftaran-kunjungan', [PendaftaranKunjunganController::class, 'index'])->name('admin.kunjungan.pendaftaran');
    Route::post('/pendaftaran-kunjungan/{id}/approve', [PendaftaranKunjunganController::class, 'approve'])->name('admin.kunjungan.approve');
    Route::delete('/pendaftaran-kunjungan/{id}', [PendaftaranKunjunganController::class, 'destroy'])->name('admin.kunjungan.destroy');

    // 5. Kemitraan
    Route::resource('kemitraan', KemitraanController::class)->names(['index' => 'admin.kemitraan.index']);
    Route::get('/kemitraan/{id}/approve', [KemitraanController::class, 'approve'])->name('admin.kemitraan.approve');
    Route::get('/kemitraan/{id}/reject', [KemitraanController::class, 'reject'])->name('admin.kemitraan.reject');
    Route::get('/kemitraan/{id}/cetak', [KemitraanController::class, 'cetak'])->name('admin.kemitraan.cetak');

    // 6. Pesan Masuk
    Route::get('/pesan', [KontakPesanController::class, 'index'])->name('admin.pesan.index');
    Route::delete('/pesan/{id}', [KontakPesanController::class, 'destroy'])->name('admin.pesan.destroy');
    
    // 7. Setting
    Route::get('/setting', [SettingController::class, 'index'])->name('admin.setting.index');
});

/* --- JALUR DARURAT --- */
Route::get('/cek-vinda/{id}', [PendaftaranKunjunganController::class, 'approve']);

/* --- CALLBACK MIDTRANS --- */
Route::post('/api/midtrans-callback', [App\Http\Controllers\PendaftaranPelatihanController::class, 'notification']);