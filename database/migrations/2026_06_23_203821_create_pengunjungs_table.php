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
    Schema::create('pengunjungs', function (Blueprint $table) {
        $table->id();
        $table->string('ip_address');
        $table->date('tanggal');
        $table->integer('hits')->default(1); // Menghitung berapa kali IP tsb buka web di hari itu
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengunjungs');
    }
};
