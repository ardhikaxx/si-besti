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
        Schema::create('penggunas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nomor_telepon')->unique();
            $table->string('pin');
            $table->integer('umur');
            $table->enum('jenis_kelamin', ['P'])->default('P');
            $table->text('alamat');
            $table->integer('usia_kehamilan')->nullable();
            $table->integer('hamil_anak_ke')->nullable();
            $table->integer('jumlah_anak')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggunas');
    }
};