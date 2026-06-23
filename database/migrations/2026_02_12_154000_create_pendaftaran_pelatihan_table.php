<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftaran_pelatihan', function (Blueprint $table) {
            $table->id();
            
            //  ID Transaksi (Penting untuk Midtrans)
            $table->string('order_id')->unique(); 

            //  Data Peserta
            $table->string('nama');
            $table->string('email');
            $table->string('no_hp');

            // Relasi ke Tabel Kelas Pelatihan
            $table->foreignId('pelatihan_id')
                  ->constrained('kelas_pelatihan')
                  ->cascadeOnDelete();

            // Detail Pembayaran
            $table->decimal('total_harga', 15, 2);
            $table->string('snap_token')->nullable();

            // Metadata & Status
            $table->timestamp('tanggal_daftar')->nullable();
            $table->enum('status_pendaftaran', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->enum('status_pembayaran', ['pending', 'success', 'failed', 'expired'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_pelatihan');
    }
};