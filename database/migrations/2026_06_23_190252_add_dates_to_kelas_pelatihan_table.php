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
        Schema::table('kelas_pelatihan', function (Blueprint $table) {
            $table->date('tanggal_pelatihan')->nullable()->after('kuota');
            $table->date('batas_pendaftaran')->nullable()->after('tanggal_pelatihan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas_pelatihan', function (Blueprint $table) {
            $table->dropColumn(['tanggal_pelatihan', 'batas_pendaftaran']);
        });
    }
};