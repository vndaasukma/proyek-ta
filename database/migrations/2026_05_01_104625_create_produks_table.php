<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 🟢 PERBAIKAN: Hapus fisik tabel lama di database jika terdeteksi sudah ada
        Schema::dropIfExists('produks');

        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->string('type')->default('product');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};