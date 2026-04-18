<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Tabel untuk Gambar (Hero, Produk, Galeri)
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->string('type'); // hero, product, gallery
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel untuk Teks Dinamis
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('images');
        Schema::dropIfExists('settings');
    }
};