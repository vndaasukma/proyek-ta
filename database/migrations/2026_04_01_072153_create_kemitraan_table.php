<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Laporan Pertanggungjawaban / Dokumentasi Sistem
 * @author 
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * Fungsi ini akan dijalankan saat mengetik: php artisan migrate
     */
    public function up(): void
    {
        // PENGAMAN: Cek dulu apakah tabel sudah ada di database. 
        // Jika sudah ada, lewati proses pembuatan agar tidak terjadi error "already exists".
        if (!Schema::hasTable('kemitraan')) {
            Schema::create('kemitraan', function (Blueprint $table) {
                $table->id();
                $table->string('nama_perwakilan');
                $table->string('nama_instansi');
                $table->string('no_wa');
                $table->text('deskripsi');
                $table->string('proposal_path')->nullable();
                
                // Status Kemitraan: default adalah 'pending' saat baru daftar
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     * Fungsi ini dijalankan saat melakukan rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('kemitraan');
    }
};