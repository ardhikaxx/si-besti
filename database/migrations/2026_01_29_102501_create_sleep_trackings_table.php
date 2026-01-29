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
        Schema::create('sleep_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('penggunas')->onDelete('cascade');
            $table->date('tanggal_tidur');
            $table->time('waktu_tidur');
            $table->time('waktu_bangun');
            $table->integer('jumlah_kebangunan')->default(0);
            $table->text('alasan_kebangunan')->nullable();
            $table->text('catatan_lain')->nullable();
            $table->decimal('durasi_tidur', 5, 2)->nullable()->comment('Dalam jam, contoh: 7.5 untuk 7 jam 30 menit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sleep_trackings');
    }
};