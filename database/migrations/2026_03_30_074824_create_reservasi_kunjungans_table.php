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
        Schema::create('reservasi_kunjungans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemohon');
            $table->string('instansi');
            $table->string('email');
            $table->string('no_wa');
            $table->date('tanggal_kunjungan');
            $table->integer('sesi'); // Nilai 1, 2, atau 3
            $table->text('keperluan')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi_kunjungans');
    }
};