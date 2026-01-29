<?php
// app/Models/SleepTest.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SleepTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengguna_id',
        'start_date',
        'end_date',
        'total_score_before',
        'total_score_after',
        'status',
        'current_test'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_confirmed' => 'boolean'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }

    public function dailyTests()
    {
        return $this->hasMany(DailyTest::class);
    }

    public function firstTest()
    {
        return $this->hasOne(DailyTest::class)->where('day_type', 'first');
    }

    public function lastTest()
    {
        return $this->hasOne(DailyTest::class)->where('day_type', 'last');
    }

    public function canTakeFirstTest()
    {
        if ($this->status !== 'ongoing') {
            return false;
        }

        if ($this->current_test !== 'first') {
            return false;
        }

        $firstTest = $this->firstTest;
        return !$firstTest || !$firstTest->is_confirmed;
    }

    public function canTakeLastTest()
    {
        if ($this->status !== 'ongoing') {
            return false;
        }

        if ($this->current_test !== 'last') {
            return false;
        }

        // Pastikan test pertama sudah selesai
        $firstTest = $this->firstTest;
        if (!$firstTest || !$firstTest->is_confirmed) {
            return false;
        }

        $lastTest = $this->lastTest;
        return !$lastTest || !$lastTest->is_confirmed;
    }

    public function getTestDates()
    {
        $dates = [];
        $startDate = Carbon::parse($this->start_date);
        
        for ($i = 1; $i <= 7; $i++) {
            $date = $startDate->copy()->addDays($i - 1);
            $dates[] = [
                'day' => $i,
                'date' => $date,
                'is_test_day' => $i == 1 || $i == 7,
                'day_type' => $i == 1 ? 'first' : ($i == 7 ? 'last' : null)
            ];
        }
        
        return $dates;
    }

    public function calculateFinalScores()
    {
        $firstTest = $this->firstTest;
        $lastTest = $this->lastTest;
        
        if ($firstTest && $lastTest && $firstTest->is_confirmed && $lastTest->is_confirmed) {
            $this->total_score_before = $firstTest->total_score;
            $this->total_score_after = $lastTest->total_score;
            $this->status = 'completed';
            $this->save();
        }
    }
}