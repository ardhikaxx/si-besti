<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sleep_test_id')->constrained('sleep_tests')->onDelete('cascade');
            $table->enum('day_type', ['first', 'last']);
            $table->date('test_date');
            
            // Data kuesioner
            $table->time('bedtime')->nullable(); // Q1
            $table->integer('time_to_sleep')->nullable(); // Q2 (menit)
            $table->time('wakeup_time')->nullable(); // Q3
            $table->float('sleep_duration')->nullable(); // Q4 (jam)
            
            // Q5: Gangguan tidur
            $table->json('sleep_disturbances')->nullable();
            
            // Q6: Penggunaan obat
            $table->integer('medication_use')->nullable();
            
            // Q7: Kantuk siang hari
            $table->integer('daytime_sleepiness')->nullable();
            
            // Q8: Antusiasme
            $table->integer('enthusiasm')->nullable();
            
            // Q9: Kepuasan tidur
            $table->integer('sleep_satisfaction')->nullable();
            
            // Skor komponen PSQI
            $table->integer('component_1')->nullable(); // Kualitas tidur subyektif
            $table->integer('component_2')->nullable(); // Latensi tidur
            $table->integer('component_3')->nullable(); // Durasi tidur
            $table->integer('component_4')->nullable(); // Efisiensi tidur
            $table->integer('component_5')->nullable(); // Gangguan tidur
            $table->integer('component_6')->nullable(); // Penggunaan obat
            $table->integer('component_7')->nullable(); // Disfungsi siang hari
            
            // Total skor
            $table->integer('total_score')->nullable();
            
            // Status
            $table->boolean('is_confirmed')->default(false);
            $table->boolean('filled_by_admin')->default(false);
            $table->timestamp('confirmed_at')->nullable();
            
            $table->timestamps();
            
            // Unique constraint
            $table->unique(['sleep_test_id', 'day_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_tests');
    }
};