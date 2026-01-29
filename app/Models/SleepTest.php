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

        // Hanya bisa di hari pertama atau hari setelahnya jika belum diisi
        $today = now();
        $testStartDate = Carbon::parse($this->start_date);
        
        if ($today->lt($testStartDate)) {
            return false; // Belum waktunya
        }

        $firstTest = $this->firstTest;
        
        // Jika belum ada test pertama, bisa diisi
        if (!$firstTest) {
            return true;
        }

        // Jika sudah ada tapi belum dikonfirmasi, bisa diedit
        return !$firstTest->is_confirmed;
    }

    public function canTakeLastTest()
    {
        if ($this->status !== 'ongoing') {
            return false;
        }

        // Pastikan test pertama sudah selesai
        $firstTest = $this->firstTest;
        if (!$firstTest || !$firstTest->is_confirmed) {
            return false;
        }

        // Cek apakah sudah hari ke-7 atau setelahnya
        $today = now();
        $lastTestDate = Carbon::parse($this->end_date); // Hari ke-7
        
        // Bisa mengambil test terakhir jika:
        // 1. Sudah mencapai hari ke-7 atau setelahnya
        // 2. Belum ada test terakhir atau belum dikonfirmasi
        if ($today->gte($lastTestDate)) {
            $lastTest = $this->lastTest;
            if (!$lastTest) {
                return true;
            }
            return !$lastTest->is_confirmed;
        }

        return false;
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
                'day_type' => $i == 1 ? 'first' : ($i == 7 ? 'last' : null),
                'is_available' => $this->isTestDateAvailable($i, $date)
            ];
        }
        
        return $dates;
    }

    private function isTestDateAvailable($dayNumber, $date)
    {
        $today = now();
        
        if ($dayNumber == 1) {
            // Test pertama: tersedia mulai hari pertama
            return $today->gte($date);
        } elseif ($dayNumber == 7) {
            // Test terakhir: tersedia mulai hari ke-7
            // dan test pertama harus sudah selesai
            $firstTest = $this->firstTest;
            $firstTestCompleted = $firstTest && $firstTest->is_confirmed;
            
            return $today->gte($date) && $firstTestCompleted;
        }
        
        return false;
    }

    public function getCurrentTestInfo()
    {
        $firstTest = $this->firstTest;
        $lastTest = $this->lastTest;
        
        if (!$firstTest) {
            return [
                'status' => 'first_pending',
                'message' => 'Test pertama belum diisi',
                'next_test_date' => $this->start_date
            ];
        }
        
        if ($firstTest && !$firstTest->is_confirmed) {
            return [
                'status' => 'first_unconfirmed',
                'message' => 'Test pertama belum dikonfirmasi',
                'next_test_date' => $this->start_date
            ];
        }
        
        if ($firstTest && $firstTest->is_confirmed && (!$lastTest || !$lastTest->is_confirmed)) {
            $today = now();
            $lastTestDate = Carbon::parse($this->end_date);
            
            if ($today->lt($lastTestDate)) {
                $daysLeft = $today->diffInDays($lastTestDate);
                return [
                    'status' => 'waiting_for_last',
                    'message' => 'Menunggu test terakhir (hari ke-7)',
                    'next_test_date' => $this->end_date,
                    'days_left' => $daysLeft
                ];
            } else {
                return [
                    'status' => 'last_available',
                    'message' => 'Test terakhir tersedia',
                    'next_test_date' => $this->end_date
                ];
            }
        }
        
        if ($lastTest && $lastTest->is_confirmed) {
            return [
                'status' => 'completed',
                'message' => 'Test selesai',
                'next_test_date' => null
            ];
        }
        
        return [
            'status' => 'unknown',
            'message' => 'Status tidak diketahui',
            'next_test_date' => null
        ];
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

    public function getProgressPercentage()
    {
        $firstTest = $this->firstTest;
        $lastTest = $this->lastTest;
        
        if (!$firstTest) {
            return 0;
        }
        
        if ($firstTest && !$firstTest->is_confirmed) {
            return 25;
        }
        
        if ($firstTest && $firstTest->is_confirmed) {
            if (!$lastTest) {
                return 50;
            }
            
            if ($lastTest && !$lastTest->is_confirmed) {
                return 75;
            }
            
            if ($lastTest && $lastTest->is_confirmed) {
                return 100;
            }
        }
        
        return 0;
    }
}