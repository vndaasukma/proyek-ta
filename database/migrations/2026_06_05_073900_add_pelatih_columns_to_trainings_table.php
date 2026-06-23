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
        Schema::table('trainings', function (Blueprint $table) {
            // Menambahkan kolom nama_pelatih dan ttd_pelatih setelah kolom status
            $table->string('nama_pelatih')->nullable()->after('status');
            $table->string('ttd_pelatih')->nullable()->after('nama_pelatih');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn(['nama_pelatih', 'ttd_pelatih']);
        });
    }
};