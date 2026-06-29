<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwal_pelatihans', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel trainings (Model KelasPelatihan)
            $table->foreignId('kelas_pelatihan_id')->constrained('trainings')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('materi');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_pelatihans');
    }
};