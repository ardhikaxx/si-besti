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
        Schema::table('penggunas', function (Blueprint $table) {
            $table->string('pekerjaan')->nullable()->after('jenis_kelamin');
            $table->string('pendidikan_terakhir')->nullable()->after('pekerjaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penggunas', function (Blueprint $table) {
            $table->dropColumn(['pekerjaan', 'pendidikan_terakhir']);
        });
    }
};
