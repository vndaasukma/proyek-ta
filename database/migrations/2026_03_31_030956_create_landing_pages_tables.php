<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // 1. Cek & Buat Tabel Images (Hero, Produk, Galeri)
        if (!Schema::hasTable('images')) {
            Schema::create('images', function (Blueprint $table) {
                $table->id();
                $table->string('image_path');
                $table->string('type'); // hero, product, gallery
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 2. Cek & Buat Tabel Settings
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->string('key')->primary();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }

        // 3. Cek & Buat Tabel Fasilitas
        if (!Schema::hasTable('fasilitas')) {
            Schema::create('fasilitas', function (Blueprint $table) {
                $table->id();
                $table->string('nama_fasilitas');
                $table->text('deskripsi');
                $table->string('gambar');
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('images');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('fasilitas');
    }
};