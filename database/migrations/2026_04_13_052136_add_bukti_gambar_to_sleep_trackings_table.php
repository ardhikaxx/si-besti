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
            $table->string('bukti_gambar')->nullable()->after('catatan_lain')->comment('Path gambar bukti kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sleep_trackings', function (Blueprint $table) {
            $table->dropColumn('bukti_gambar');
        });
    }
};
