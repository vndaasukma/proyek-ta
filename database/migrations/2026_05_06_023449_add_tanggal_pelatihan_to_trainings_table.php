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
    Schema::table('trainings', function (Blueprint $table) {
        // Menambah kolom tanggal tepat setelah judul
        $table->date('tanggal_pelatihan')->nullable()->after('title');
    });
}

public function down(): void
{
    Schema::table('trainings', function (Blueprint $table) {
        $table->dropColumn('tanggal_pelatihan');
    });
}
};
