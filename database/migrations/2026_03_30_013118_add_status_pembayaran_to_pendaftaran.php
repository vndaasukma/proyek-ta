<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambah kolom.
     */
    public function up(): void
    {
        Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
            // cek dulu apakah kolomnya sudah ada (agar tidak error duplicate)
            if (!Schema::hasColumn('pendaftaran_pelatihan', 'status_pembayaran')) {
                $table->string('status_pembayaran')->default('pending')->after('no_hp');
            }
        });
    }

    /**
     * Batalkan migrasi (Hapus kolom jika rollback).
     */
    public function down(): void
    {
        Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
            $table->dropColumn('status_pembayaran');
        });
    }
};