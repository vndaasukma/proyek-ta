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
        Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
            $table->string('order_id')->unique()->after('id'); // ID unik untuk Midtrans
            $table->integer('total_harga')->after('order_id'); // Harga yang harus dibayar
            $table->string('snap_token')->nullable()->after('status_pendaftaran'); // Token untuk memunculkan popup bayar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
            // hapus lagi kolomnya kalau migrasi di-rollback
            $table->dropColumn(['order_id', 'total_harga', 'snap_token']);
        });
    }
};