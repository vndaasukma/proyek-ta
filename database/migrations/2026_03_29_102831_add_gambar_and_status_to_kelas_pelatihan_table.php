<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas_pelatihan', function (Blueprint $table) {
            // Cek jika kolom 'gambar' BELUM ada, maka buatkan
            if (!Schema::hasColumn('kelas_pelatihan', 'gambar')) {
                $table->string('gambar')->nullable()->after('kuota');
            }

            // Cek jika kolom 'status' BELUM ada, maka buatkan
            if (!Schema::hasColumn('kelas_pelatihan', 'status')) {
                $table->enum('status', ['open', 'closed'])->default('open')->after('gambar');
            }
        });
    }

    public function down(): void
    {
        Schema::table('kelas_pelatihan', function (Blueprint $table) {
            $table->dropColumn(['gambar', 'status']);
        });
    }
};