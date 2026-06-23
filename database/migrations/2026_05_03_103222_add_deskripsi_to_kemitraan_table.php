<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kemitraan', function (Blueprint $table) {
            $table->text('deskripsi')->nullable()->after('no_wa');
        });
    }

    public function down()
    {
        Schema::table('kemitraan', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
        });
    }
};