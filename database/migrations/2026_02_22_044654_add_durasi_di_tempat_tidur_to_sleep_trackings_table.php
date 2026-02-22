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
        Schema::table('sleep_trackings', function (Blueprint $table) {
            $table->integer('durasi_di_tempat_tidur')->nullable()->after('tanggal_tidur')->comment('Durasi di tempat tidur sebelum tidur dalam menit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sleep_trackings', function (Blueprint $table) {
            $table->dropColumn('durasi_di_tempat_tidur');
        });
    }
};
