<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * * Fungsi ini akan dijalankan saat mengetik: php artisan migrate
     */
    public function up(): void
    {
        Schema::create('kemitraan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perwakilan');
            $table->string('nama_instansi');
            $table->string('no_wa');
            $table->string('proposal_path');
            
            // Status Kemitraan: default adalah 'pending' saat baru daftar
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->timestamps(); // Akan membuat kolom created_at & updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     * * Fungsi ini dijalankan melakukan rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('kemitraan');
    }
};