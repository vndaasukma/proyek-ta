<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @author Vinda Ambitha Sukma
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
            // PENGAMAN: Cek dulu sebelum menambahkan kolom order_id
            if (!Schema::hasColumn('pendaftaran_pelatihan', 'order_id')) {
                $table->string('order_id')->unique()->after('id'); // ID unik untuk Midtrans
            }
            
            // PENGAMAN: Cek dulu sebelum menambahkan kolom total_harga
            if (!Schema::hasColumn('pendaftaran_pelatihan', 'total_harga')) {
                $table->integer('total_harga')->after('order_id'); // Harga yang harus dibayar
            }
            
            // PENGAMAN: Cek dulu sebelum menambahkan kolom snap_token
            if (!Schema::hasColumn('pendaftaran_pelatihan', 'snap_token')) {
                $table->string('snap_token')->nullable()->after('status_pendaftaran'); // Token popup
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
            // PENGAMAN: Hapus kolom HANYA jika kolom tersebut memang ada
            if (Schema::hasColumn('pendaftaran_pelatihan', 'order_id')) {
                $table->dropColumn('order_id');
            }
            if (Schema::hasColumn('pendaftaran_pelatihan', 'total_harga')) {
                $table->dropColumn('total_harga');
            }
            if (Schema::hasColumn('pendaftaran_pelatihan', 'snap_token')) {
                $table->dropColumn('snap_token');
            }
        });
    }
};