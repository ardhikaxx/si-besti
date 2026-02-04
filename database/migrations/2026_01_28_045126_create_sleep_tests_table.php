<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sleep_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('penggunas')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_score_before')->nullable();
            $table->integer('total_score_after')->nullable();
            $table->enum('status', ['ongoing', 'completed', 'abandoned', 'waiting_admin'])->default('ongoing');
            $table->enum('current_test', ['first', 'last'])->default('first');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sleep_tests');
    }
};