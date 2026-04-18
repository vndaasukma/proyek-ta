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
    Schema::create('pendaftaran_kunjungan', function (Blueprint $table) {
        $table->id();
        $table->string('nama_instansi');
        $table->string('email');
        $table->string('whatsapp');
        $table->date('tanggal');
        $table->string('sesi'); // 08:00 / 11:00 / 14:00
        $table->string('status')->default('pending'); // pending / approved / rejected
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_kunjungan');
    }
};
