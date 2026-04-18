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
        Schema::create('kontak_pesans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('alamat')->nullable(); // Alamat boleh kosong (nullable)
            $table->string('email');
            $table->string('no_hp');
            $table->text('pesan');
            $table->boolean('is_read')->default(false); // Default: belum dibaca admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontak_pesans');
    }
};