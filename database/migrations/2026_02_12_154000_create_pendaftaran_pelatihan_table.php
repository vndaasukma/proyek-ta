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

        // 👤 Data pengunjung
        $table->string('nama');
        $table->string('email');
        $table->string('no_hp');

        // 🎓 Relasi pelatihan
        $table->foreignId('pelatihan_id')
              ->constrained('kelas_pelatihan')
              ->cascadeOnDelete();

        // 📅 Metadata
        $table->timestamp('tanggal_daftar')->nullable();
        $table->string('status_pendaftaran')->default('pending');

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
