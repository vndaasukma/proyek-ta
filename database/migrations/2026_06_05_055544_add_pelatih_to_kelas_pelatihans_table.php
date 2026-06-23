<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas_pelatihans', function (Blueprint $table) {
            $table->string('nama_pelatih')->nullable()->after('status');
            $table->string('ttd_pelatih')->nullable()->after('nama_pelatih');
        });
    }

    public function down(): void
    {
        Schema::table('kelas_pelatihans', function (Blueprint $table) {
            $table->dropColumn(['nama_pelatih', 'ttd_pelatih']);
        });
    }
};