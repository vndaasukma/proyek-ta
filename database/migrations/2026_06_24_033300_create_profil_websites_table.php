<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up()
    {
    Schema::create('profil_website', function (Blueprint $table) {
        $table->id();
        $table->string('judul')->nullable();
        $table->text('deskripsi')->nullable();
        $table->string('visi_judul')->nullable();
        $table->text('visi_deskripsi')->nullable();
        $table->string('edukasi_judul')->nullable();
        $table->text('edukasi_deskripsi')->nullable();
        $table->string('gambar')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_websites');
    }
};
