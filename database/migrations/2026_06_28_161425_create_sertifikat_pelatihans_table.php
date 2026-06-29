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
        Schema::create('sertifikat_pelatihans', function (Blueprint $table) {
            $table->id();
            
            // Menghubungkan sertifikat ke tabel trainings (kelas_pelatihan)
            $table->foreignId('kelas_pelatihan_id')
                  ->constrained('trainings')
                  ->onDelete('cascade');
                  
            // Kolom input komponen tanda tangan & gambar template
            $table->string('nama_pelatih')->nullable();
            $table->string('ttd_pelatih')->nullable();
            $table->string('nama_penyelenggara')->nullable();
            $table->string('ttd_penyelenggara')->nullable();
            $table->string('nama_ketua')->nullable();
            $table->string('ttd_ketua')->nullable();
            $table->string('template_sertifikat')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat_pelatihans');
    }
};