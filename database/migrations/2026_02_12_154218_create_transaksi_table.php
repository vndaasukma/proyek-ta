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
    Schema::create('transaksi', function (Blueprint $table) {
        $table->id();

        // Relasi
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('pendaftaran_id')->constrained('pendaftaran_pelatihan')->cascadeOnDelete();

        // Data transaksi internal
        $table->string('kode_invoice')->unique();

        // Data Midtrans
        $table->string('order_id')->unique();
        $table->integer('gross_amount');
        $table->string('payment_type')->nullable();
        $table->string('transaction_status')->default('pending');
        $table->string('snap_token')->nullable();

        // Tanggal
        $table->timestamp('tanggal_transaksi')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
