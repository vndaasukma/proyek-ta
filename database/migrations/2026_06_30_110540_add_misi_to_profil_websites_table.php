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
        Schema::table('profil_websites', function (Blueprint $table) {
            if (!Schema::hasColumn('profil_websites', 'misi_1')) {
                $table->text('misi_1')->nullable()->after('visi_deskripsi');
            }
            if (!Schema::hasColumn('profil_websites', 'misi_2')) {
                $table->text('misi_2')->nullable()->after('misi_1');
            }
            if (!Schema::hasColumn('profil_websites', 'misi_3')) {
                $table->text('misi_3')->nullable()->after('misi_2');
            }
            if (!Schema::hasColumn('profil_websites', 'misi_4')) {
                $table->text('misi_4')->nullable()->after('misi_3');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profil_websites', function (Blueprint $table) {
            foreach (['misi_1', 'misi_2', 'misi_3', 'misi_4'] as $col) {
                if (Schema::hasColumn('profil_websites', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};