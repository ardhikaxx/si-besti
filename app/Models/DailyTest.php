<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DailyTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'sleep_test_id',
        'day_type',
        'test_date',
        'bedtime',
        'time_to_sleep',
        'wakeup_time',
        'sleep_duration',
        'sleep_disturbances',
        'medication_use',
        'daytime_sleepiness',
        'enthusiasm',
        'sleep_satisfaction',
        'component_1',
        'component_2',
        'component_3',
        'component_4',
        'component_5',
        'component_6',
        'component_7',
        'total_score',
        'is_confirmed',
        'filled_by_admin',
        'confirmed_at'
    ];

    protected $casts = [
        'test_date' => 'date',
        'sleep_disturbances' => 'array',
        'is_confirmed' => 'boolean',
        'filled_by_admin' => 'boolean',
        'confirmed_at' => 'datetime'
    ];

    public function sleepTest()
    {
        return $this->belongsTo(SleepTest::class);
    }

    public function calculateScores()
    {
        // Component 1: Kualitas Tidur Subyektif (Q9)
        $this->component_1 = $this->sleep_satisfaction;

        // Component 2: Latensi Tidur
        $this->calculateLatencyScore();

        // Component 3: Durasi Tidur (Q4)
        $this->calculateDurationScore();

        // Component 4: Efisiensi Tidur
        $this->calculateEfficiencyScore();

        // Component 5: Gangguan Tidur (Q5)
        $this->calculateDisturbanceScore();

        // Component 6: Penggunaan Obat (Q6)
        $this->calculateMedicationScore();

        // Component 7: Disfungsi Siang Hari (Q7 + Q8)
        $this->calculateDaytimeDysfunctionScore();

        // Total Score
        $this->total_score =
            $this->component_1 +
            $this->component_2 +
            $this->component_3 +
            $this->component_4 +
            $this->component_5 +
            $this->component_6 +
            $this->component_7;

        return $this;
    }

    private function calculateLatencyScore()
    {
        // Skor dari Q2 (waktu untuk tertidur dalam menit)
        $q2_score = 0;
        if ($this->time_to_sleep <= 15) {
            $q2_score = 0;
        } elseif ($this->time_to_sleep <= 30) {
            $q2_score = 1;
        } elseif ($this->time_to_sleep <= 60) {
            $q2_score = 2;
        } else {
            $q2_score = 3;
        }

        // Skor dari Q5a (tidak bisa tidur dalam 30 menit)
        $disturbances = $this->sleep_disturbances ?? [];
        $q5a_value = $disturbances['a'] ?? 0;
        $q5a_score = $q5a_value; // 0-3 sesuai frekuensi

        // Total skor latensi
        $latency_total = $q2_score + $q5a_score;

        // Konversi ke skor komponen 2
        if ($latency_total == 0) {
            $this->component_2 = 0;
        } elseif ($latency_total <= 2) {
            $this->component_2 = 1;
        } elseif ($latency_total <= 4) {
            $this->component_2 = 2;
        } else {
            $this->component_2 = 3;
        }
    }

    private function calculateDurationScore()
    {
        if ($this->sleep_duration > 7) {
            $this->component_3 = 0;
        } elseif ($this->sleep_duration >= 6) {
            $this->component_3 = 1;
        } elseif ($this->sleep_duration >= 5) {
            $this->component_3 = 2;
        } else {
            $this->component_3 = 3;
        }
    }

    private function calculateEfficiencyScore()
    {
        if (!$this->bedtime || !$this->wakeup_time || !$this->sleep_duration) {
            $this->component_4 = 0;
            return;
        }

        // Hitung waktu di tempat tidur
        $bedtime = Carbon::parse($this->bedtime);
        $wakeup = Carbon::parse($this->wakeup_time);

        if ($wakeup->lessThan($bedtime)) {
            $wakeup->addDay();
        }

        $time_in_bed_hours = $wakeup->diffInMinutes($bedtime) / 60;

        // Durasi tidur dalam jam
        $actual_sleep_hours = $this->sleep_duration;

        // Hitung efisiensi
        if ($time_in_bed_hours > 0) {
            $efficiency = ($actual_sleep_hours / $time_in_bed_hours) * 100;

            if ($efficiency > 85) {
                $this->component_4 = 0;
            } elseif ($efficiency >= 75) {
                $this->component_4 = 1;
            } elseif ($efficiency >= 65) {
                $this->component_4 = 2;
            } else {
                $this->component_4 = 3;
            }
        } else {
            $this->component_4 = 0;
        }
    }

    private function calculateDisturbanceScore()
    {
        $disturbances = $this->sleep_disturbances ?? [];

        // Item Q5b sampai Q5j
        $items = ['b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'];
        $disturbance_score = 0;

        foreach ($items as $item) {
            $frequency = $disturbances[$item] ?? 0;
            $disturbance_score += $frequency; // Nilai 0-3
        }

        if ($disturbance_score == 0) {
            $this->component_5 = 0;
        } elseif ($disturbance_score <= 9) {
            $this->component_5 = 1;
        } elseif ($disturbance_score <= 18) {
            $this->component_5 = 2;
        } else {
            $this->component_5 = 3;
        }
    }

    private function calculateMedicationScore()
    {
        $this->component_6 = $this->medication_use;
    }

    private function calculateDaytimeDysfunctionScore()
    {
        // Q7: Kantuk siang hari (0-3)
        $q7_score = $this->daytime_sleepiness;

        // Q8: Antusiasme (0-3)
        $q8_score = $this->enthusiasm;

        // Total skor disfungsi siang hari
        $daytime_total = $q7_score + $q8_score;

        if ($daytime_total == 0) {
            $this->component_7 = 0;
        } elseif ($daytime_total <= 2) {
            $this->component_7 = 1;
        } elseif ($daytime_total <= 4) {
            $this->component_7 = 2;
        } else {
            $this->component_7 = 3;
        }
    }

    public function getQualityLevel()
    {
        if ($this->total_score === null) {
            return 'Belum dihitung';
        }

        return $this->total_score <= 5 ? 'Baik' : 'Buruk';
    }

    public function getQualityColor()
    {
        if ($this->total_score === null) {
            return 'secondary';
        }

        return $this->total_score <= 5 ? 'success' : 'danger';
    }

    public function isAdminFilled()
    {
        // Cek apakah bagian admin (Q1-Q5) sudah diisi
        return $this->bedtime && $this->time_to_sleep && $this->wakeup_time &&
            $this->sleep_duration && $this->sleep_disturbances;
    }
}