<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->string('nama_penyelenggara')->nullable()->after('ttd_pelatih');
            $table->string('ttd_penyelenggara')->nullable()->after('nama_penyelenggara');
            $table->string('nama_ketua')->nullable()->after('ttd_penyelenggara');
            $table->string('ttd_ketua')->nullable()->after('nama_ketua');
        });
    }

    public function down()
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn(['nama_penyelenggara', 'ttd_penyelenggara', 'nama_ketua', 'ttd_ketua']);
        });
    }
};