<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
        
            if (!Schema::hasColumn('trainings', 'ttd_pelatih')) {
                $table->string('ttd_pelatih')->nullable()->after('nama_pelatih');
            }
            if (!Schema::hasColumn('trainings', 'template_sertifikat')) {
                $table->string('template_sertifikat')->nullable()->after('ttd_pelatih');
            }
        });
    }

    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn(['ttd_pelatih', 'template_sertifikat']);
        });
    }
};