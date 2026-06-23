<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            // Tambahkan kolom jika belum ada
            if (!Schema::hasColumn('trainings', 'image')) {
                $table->string('image')->nullable()->after('title');
            }
            if (!Schema::hasColumn('trainings', 'tanggal_pelatihan')) {
                $table->date('tanggal_pelatihan')->nullable()->after('image');
            }
            if (!Schema::hasColumn('trainings', 'terisi')) {
                $table->integer('terisi')->default(0)->after('quota');
            }
        });
    }

    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn(['image', 'tanggal_pelatihan', 'terisi']);
        });
    }
};