<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locked_dates', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique(); // Mengunci satu tanggal penuh
            $table->string('keterangan')->nullable(); // Alasan dikunci (misal: "Libur Hari Raya")
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locked_dates');
    }
};