<?php
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

    public function canUserTakeTest($type)
    {
        if ($this->status !== 'ongoing') {
            return false;
        }

        $today = now();
        
        if ($type == 'first') {
            $startDate = Carbon::parse($this->start_date);
            if ($today->lt($startDate)) {
                return false;
            }
            
            $firstTest = $this->firstTest;
            return !$firstTest || ($firstTest && !$firstTest->is_confirmed);
        } else {
            // Untuk test terakhir, cek apakah test pertama sudah dikonfirmasi admin
            $firstTest = $this->firstTest;
            if (!$firstTest || !$firstTest->is_confirmed) {
                return false;
            }
            
            $endDate = Carbon::parse($this->end_date);
            if ($today->lt($endDate)) {
                return false;
            }
            
            $lastTest = $this->lastTest;
            return !$lastTest || ($lastTest && !$lastTest->is_confirmed);
        }
    }

    public function canAdminFillTest($type)
    {
        $test = $type == 'first' ? $this->firstTest : $this->lastTest;
        
        // Admin bisa mengisi jika test ada tapi belum diisi bagian admin
        if ($test) {
            // Cek apakah bagian admin (Q1-Q5) sudah diisi
            return !$test->filled_by_admin && $test->is_confirmed;
        }
        
        return false;
    }

    public function getTestStatus()
    {
        $firstTest = $this->firstTest;
        $lastTest = $this->lastTest;
        
        if (!$firstTest) {
            return [
                'status' => 'waiting_user',
                'message' => 'Menunggu pengisian oleh pengguna',
                'color' => 'warning'
            ];
        }
        
        if ($firstTest && !$firstTest->is_confirmed) {
            return [
                'status' => 'waiting_user',
                'message' => 'Menunggu pengisian oleh pengguna',
                'color' => 'warning'
            ];
        }
        
        if ($firstTest && $firstTest->is_confirmed && !$firstTest->filled_by_admin) {
            return [
                'status' => 'waiting_admin',
                'message' => 'Sedang diproses admin',
                'color' => 'info'
            ];
        }
        
        if ($firstTest && $firstTest->filled_by_admin && (!$lastTest || !$lastTest->is_confirmed)) {
            return [
                'status' => 'waiting_user_last',
                'message' => 'Menunggu test terakhir oleh pengguna',
                'color' => 'warning'
            ];
        }
        
        if ($lastTest && $lastTest->is_confirmed && !$lastTest->filled_by_admin) {
            return [
                'status' => 'waiting_admin_last',
                'message' => 'Sedang diproses admin (test terakhir)',
                'color' => 'info'
            ];
        }
        
        if ($lastTest && $lastTest->filled_by_admin && $lastTest->is_confirmed) {
            return [
                'status' => 'completed',
                'message' => 'Test selesai',
                'color' => 'success'
            ];
        }
        
        return [
            'status' => 'unknown',
            'message' => 'Status tidak diketahui',
            'color' => 'secondary'
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
        
        if ($firstTest && $firstTest->is_confirmed && !$firstTest->filled_by_admin) {
            return 50;
        }
        
        if ($firstTest && $firstTest->filled_by_admin && (!$lastTest || !$lastTest->is_confirmed)) {
            return 75;
        }
        
        if ($lastTest && $lastTest->is_confirmed && !$lastTest->filled_by_admin) {
            return 90;
        }
        
        if ($lastTest && $lastTest->filled_by_admin && $lastTest->is_confirmed) {
            return 100;
        }
        
        return 0;
    }

    public function isTestAvailableForUser()
    {
        $firstTest = $this->firstTest;
        
        // Jika belum ada test pertama, user bisa mengisi
        if (!$firstTest) {
            return true;
        }
        
        // Jika test pertama sudah dikonfirmasi tapi belum diisi admin, user belum bisa mengisi test terakhir
        if ($firstTest->is_confirmed && !$firstTest->filled_by_admin) {
            return false;
        }
        
        // Jika test pertama sudah selesai (dikonfirmasi dan diisi admin), cek untuk test terakhir
        if ($firstTest->filled_by_admin) {
            $lastTest = $this->lastTest;
            
            // Jika belum ada test terakhir, user bisa mengisi
            if (!$lastTest) {
                return true;
            }
            
            // Jika test terakhir sudah dikonfirmasi, user tidak bisa mengisi lagi
            if ($lastTest->is_confirmed) {
                return false;
            }
        }
        
        return true;
    }
}