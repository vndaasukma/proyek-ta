<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @author Vinda Ambitha Sukma
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            // 1. Tambahkan tanggal_pelatihan yang ternyata hilang
            if (!Schema::hasColumn('trainings', 'tanggal_pelatihan')) {
                $table->date('tanggal_pelatihan')->nullable();
            }
            
            // 2. Tambahkan kolom batas expired
            if (!Schema::hasColumn('trainings', 'tanggal_exp_pelatihan')) {
                $table->date('tanggal_exp_pelatihan')->nullable();
            }

            // 3. Tambahkan kolom S&K
            if (!Schema::hasColumn('trainings', 'ketentuan')) {
                $table->text('ketentuan')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn(['tanggal_pelatihan', 'tanggal_exp_pelatihan', 'ketentuan']);
        });
    }
};