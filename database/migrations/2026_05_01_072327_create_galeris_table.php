<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @author
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // PENGAMAN: Cek dulu apakah tabel galeris sudah ada
        if (!Schema::hasTable('galeris')) {
            Schema::create('galeris', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->string('gambar');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeris');
    }
};