<?php
namespace App\Http\Controllers;

use App\Models\SleepTest;
use App\Models\DailyTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class QualityTestController extends Controller
{
    public function index()
    {
        $pengguna = Auth::user();

        // Cari test yang sedang berjalan
        $currentTest = SleepTest::where('pengguna_id', $pengguna->id)
            ->where('status', 'ongoing')
            ->first();

        if (!$currentTest) {
            // Buat test baru
            $currentTest = $this->createNewTest($pengguna);
        }

        // Ambil informasi status
        $testStatus = $currentTest->getTestStatus();

        // Ambil test pertama dan terakhir
        $firstTest = $currentTest->firstTest;
        $lastTest = $currentTest->lastTest;

        // Hitung progress
        $progress = $currentTest->getProgressPercentage();

        return view('pengguna.quality-test.index', compact(
            'currentTest',
            'firstTest',
            'lastTest',
            'testStatus',
            'progress'
        ));
    }

    private function createNewTest($pengguna)
    {
        $startDate = now();
        $endDate = now()->addDays(6); // Hari ke-7

        $test = SleepTest::create([
            'pengguna_id' => $pengguna->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'ongoing',
            'current_test' => 'first'
        ]);

        return $test;
    }

    public function showTestPage($type)
    {
        $pengguna = Auth::user();

        if (!in_array($type, ['first', 'last'])) {
            return redirect()->route('pengguna.quality-test.index')
                ->with('error', 'Jenis test tidak valid.');
        }

        $currentTest = SleepTest::where('pengguna_id', $pengguna->id)
            ->where('status', 'ongoing')
            ->firstOrFail();

        // Validasi apakah user bisa mengisi test
        if (!$currentTest->canUserTakeTest($type)) {
            return redirect()->route('pengguna.quality-test.index')
                ->with('error', 'Test tidak dapat diakses saat ini.');
        }

        // Cek apakah sudah ada data test
        $existingTest = $type == 'first' ? $currentTest->firstTest : $currentTest->lastTest;

        return view('pengguna.quality-test.test-page', compact(
            'currentTest',
            'type',
            'existingTest'
        ));
    }

    public function storeTest(Request $request, $type)
    {
        $pengguna = Auth::user();

        // Validasi input khusus user (hanya bagian 3-6)
        $request->validate([
            'medication_use' => 'required|integer|between:0,3',
            'daytime_sleepiness' => 'required|integer|between:0,3',
            'enthusiasm' => 'required|integer|between:0,3',
            'sleep_satisfaction' => 'required|integer|between:0,3',
        ]);

        $currentTest = SleepTest::where('pengguna_id', $pengguna->id)
            ->where('status', 'ongoing')
            ->firstOrFail();

        // Validasi akses
        if (!$currentTest->canUserTakeTest($type)) {
            return redirect()->route('pengguna.quality-test.index')
                ->with('error', 'Test tidak dapat diakses saat ini.');
        }

        // Siapkan data test (hanya bagian user)
        $testData = [
            'sleep_test_id' => $currentTest->id,
            'day_type' => $type,
            'test_date' => now(),
            'medication_use' => $request->medication_use,
            'daytime_sleepiness' => $request->daytime_sleepiness,
            'enthusiasm' => $request->enthusiasm,
            'sleep_satisfaction' => $request->sleep_satisfaction,
            'is_confirmed' => true, // User langsung konfirmasi
            'confirmed_at' => now()
        ];

        // Cek apakah sudah ada test
        $existingTest = $type == 'first' ? $currentTest->firstTest : $currentTest->lastTest;

        if ($existingTest) {
            $existingTest->update($testData);
            $test = $existingTest;
        } else {
            $test = DailyTest::create($testData);
        }

        // Update status sleep test
        if ($type == 'first') {
            $currentTest->update(['current_test' => 'first']);
        } else {
            $currentTest->update(['current_test' => 'last']);
        }

        return redirect()->route('pengguna.quality-test.index')
            ->with('success', 'Test berhasil disimpan! Sedang diproses oleh admin.');
    }

    public function allResults()
    {
        $pengguna = Auth::user();

        // Ambil semua test yang sudah completed
        $completedTests = SleepTest::where('pengguna_id', $pengguna->id)
            ->where('status', 'completed')
            ->with(['firstTest', 'lastTest'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pengguna.quality-test.results', compact('completedTests'));
    }

    public function viewResult($id)
    {
        $pengguna = Auth::user();

        $test = SleepTest::where('pengguna_id', $pengguna->id)
            ->with(['firstTest', 'lastTest'])
            ->findOrFail($id);

        // Pastikan test sudah selesai
        if ($test->status !== 'completed') {
            return redirect()->route('pengguna.quality-test.result')
                ->with('error', 'Test belum selesai.');
        }

        $firstTest = $test->firstTest;
        $lastTest = $test->lastTest;

        // Hitung improvement
        $scoreImprovement = $lastTest->total_score - $firstTest->total_score;
        $improvementPercentage = $firstTest->total_score > 0
            ? round(($scoreImprovement / $firstTest->total_score) * 100, 1)
            : 0;

        // Hitung perubahan untuk setiap komponen
        $componentChanges = [];
        for ($i = 1; $i <= 7; $i++) {
            $componentKey = "component_{$i}";
            $before = $firstTest->$componentKey ?? 0;
            $after = $lastTest->$componentKey ?? 0;

            $componentChanges[] = [
                'name' => $this->getComponentName($i),
                'before' => $before,
                'after' => $after,
                'change' => $after - $before,
                'improvement' => $before > 0
                    ? round((($after - $before) / $before) * 100, 1)
                    : 0
            ];
        }

        // Detail gangguan tidur
        $firstDisturbances = $this->parseDisturbances($firstTest->sleep_disturbances);
        $lastDisturbances = $this->parseDisturbances($lastTest->sleep_disturbances);

        // Hitung total gangguan
        $firstDisturbanceTotal = array_sum($firstDisturbances);
        $lastDisturbanceTotal = array_sum($lastDisturbances);
        $disturbanceChange = $lastDisturbanceTotal - $firstDisturbanceTotal;

        // Kumpulkan data untuk view
        $resultData = [
            'test' => $test,
            'firstTest' => $firstTest,
            'lastTest' => $lastTest,
            'scoreImprovement' => $scoreImprovement,
            'improvementPercentage' => $improvementPercentage,
            'componentChanges' => $componentChanges,
            'firstDisturbances' => $firstDisturbances,
            'lastDisturbances' => $lastDisturbances,
            'firstDisturbanceTotal' => $firstDisturbanceTotal,
            'lastDisturbanceTotal' => $lastDisturbanceTotal,
            'disturbanceChange' => $disturbanceChange,
            'disturbanceLabels' => $this->getDisturbanceLabels(),
            'sleepTimeImprovement' => $this->calculateTimeImprovement($firstTest, $lastTest),
            'overallQuality' => $this->getOverallQuality($scoreImprovement)
        ];

        return view('pengguna.quality-test.results-detail', $resultData);
    }

    // Helper method untuk parsing disturbances
    private function parseDisturbances($disturbances)
    {
        if (is_array($disturbances)) {
            return $disturbances;
        }

        if (is_string($disturbances)) {
            // Coba decode JSON
            $decoded = json_decode($disturbances, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }

            // Jika string biasa, coba parse sebagai array
            if (strpos($disturbances, 'a:') === 0) {
                $unserialized = @unserialize($disturbances);
                if ($unserialized !== false) {
                    return $unserialized;
                }
            }
        }

        // Default: array kosong dengan semua keys dari a-j
        $default = [];
        foreach (range('a', 'j') as $letter) {
            $default[$letter] = 0;
        }
        return $default;
    }

    // Method getComponentName
    private function getComponentName($number)
    {
        $components = [
            1 => 'Kualitas Tidur Subyektif',
            2 => 'Latensi Tidur',
            3 => 'Durasi Tidur',
            4 => 'Efisiensi Tidur',
            5 => 'Gangguan Tidur',
            6 => 'Penggunaan Obat',
            7 => 'Disfungsi Siang Hari'
        ];

        return $components[$number] ?? "Komponen {$number}";
    }

    // Method getDisturbanceLabels
    private function getDisturbanceLabels()
    {
        return [
            'a' => 'Tidak mampu tertidur selama 30 menit',
            'b' => 'Terbangun ditengah malam',
            'c' => 'Terbangun untuk ke kamar mandi',
            'd' => 'Sulit bernafas dengan baik',
            'e' => 'Batuk atau mengorok',
            'f' => 'Kedinginan di malam hari',
            'g' => 'Kepanasan di malam hari',
            'h' => 'Mimpi buruk',
            'i' => 'Terasa nyeri',
            'j' => 'Alasan lain'
        ];
    }

    // Method calculateTimeImprovement
    private function calculateTimeImprovement($firstTest, $lastTest)
    {
        return [
            'bedtime_change' => $this->calculateTimeDifference($firstTest->bedtime, $lastTest->bedtime),
            'time_to_sleep_change' => $lastTest->time_to_sleep - $firstTest->time_to_sleep,
            'wakeup_change' => $this->calculateTimeDifference($firstTest->wakeup_time, $lastTest->wakeup_time),
            'duration_change' => $lastTest->sleep_duration - $firstTest->sleep_duration,
            'efficiency_improvement' => $this->calculateEfficiencyImprovement($firstTest, $lastTest)
        ];
    }

    // Method calculateTimeDifference
    private function calculateTimeDifference($time1, $time2)
    {
        try {
            $time1 = Carbon::parse($time1);
            $time2 = Carbon::parse($time2);

            if ($time2->greaterThan($time1)) {
                $diff = $time1->diff($time2);
                $hours = $diff->h;
                $minutes = $diff->i;

                if ($hours > 0 && $minutes > 0) {
                    return "Lebih awal {$hours} jam {$minutes} menit";
                } elseif ($hours > 0) {
                    return "Lebih awal {$hours} jam";
                } else {
                    return "Lebih awal {$minutes} menit";
                }
            } else {
                $diff = $time2->diff($time1);
                $hours = $diff->h;
                $minutes = $diff->i;

                if ($hours > 0 && $minutes > 0) {
                    return "Lebih lambat {$hours} jam {$minutes} menit";
                } elseif ($hours > 0) {
                    return "Lebih lambat {$hours} jam";
                } else {
                    return "Lebih lambat {$minutes} menit";
                }
            }
        } catch (\Exception $e) {
            return "Tidak bisa dibandingkan";
        }
    }

    // Method calculateEfficiencyImprovement
    private function calculateEfficiencyImprovement($firstTest, $lastTest)
    {
        $firstEfficiency = $firstTest->component_4 ?? 0;
        $lastEfficiency = $lastTest->component_4 ?? 0;

        $improvement = $lastEfficiency - $firstEfficiency;

        if ($improvement < 0) {
            return "Meningkat " . abs($improvement) . " poin";
        } elseif ($improvement > 0) {
            return "Menurun " . $improvement . " poin";
        } else {
            return "Tidak berubah";
        }
    }

    // Method getOverallQuality
    private function getOverallQuality($scoreImprovement)
    {
        if ($scoreImprovement < -2) {
            return [
                'label' => 'Peningkatan Signifikan',
                'color' => 'success',
                'icon' => 'fa-trophy',
                'message' => 'Kualitas tidur Anda mengalami peningkatan yang sangat baik!'
            ];
        } elseif ($scoreImprovement < 0) {
            return [
                'label' => 'Peningkatan Sedang',
                'color' => 'primary',
                'icon' => 'fa-chart-line',
                'message' => 'Kualitas tidur Anda mengalami peningkatan.'
            ];
        } elseif ($scoreImprovement == 0) {
            return [
                'label' => 'Tidak Ada Perubahan',
                'color' => 'secondary',
                'icon' => 'fa-minus-circle',
                'message' => 'Kualitas tidur Anda tetap sama.'
            ];
        } else {
            return [
                'label' => 'Perlu Perhatian',
                'color' => 'warning',
                'icon' => 'fa-exclamation-triangle',
                'message' => 'Kualitas tidur Anda mengalami penurunan.'
            ];
        }
    }
}