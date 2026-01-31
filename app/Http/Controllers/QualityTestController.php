<?php
// app/Http/Controllers/QualityTestController.php

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

        // Ambil informasi status saat ini
        $testInfo = $currentTest->getCurrentTestInfo();

        // Ambil test pertama dan terakhir
        $firstTest = $currentTest->firstTest;
        $lastTest = $currentTest->lastTest;

        // Hitung hari-hari dalam seminggu
        $dates = $currentTest->getTestDates();

        $weekDays = [];
        foreach ($dates as $date) {
            $test = null;
            $hasTest = false;
            $isConfirmed = false;
            $canTakeTest = false;
            $lockReason = null;

            if ($date['is_test_day']) {
                $test = $date['day_type'] == 'first' ? $firstTest : $lastTest;
                $hasTest = $test !== null;
                $isConfirmed = $hasTest && $test->is_confirmed;

                if ($date['day_type'] == 'first') {
                    $canTakeTest = $currentTest->canTakeFirstTest();
                } else {
                    $canTakeTest = $currentTest->canTakeLastTest();

                    // Jika test terakhir belum bisa diakses, beri alasan
                    if (!$canTakeTest && $date['is_test_day']) {
                        $today = now();
                        $testDate = Carbon::parse($date['date']);

                        if ($today->lt($testDate)) {
                            $daysLeft = $today->diffInDays($testDate);
                            $lockReason = "Test akan tersedia pada " . $testDate->format('d M Y') . " (hari ke-7)";
                        } elseif (!$firstTest || !$firstTest->is_confirmed) {
                            $lockReason = "Test pertama belum selesai";
                        }
                    }
                }
            }

            $weekDays[] = [
                'day_number' => $date['day'],
                'date' => $date['date']->format('Y-m-d'),
                'day_name' => $date['date']->translatedFormat('l'),
                'date_formatted' => $date['date']->format('d M Y'),
                'is_today' => $date['date']->isToday(),
                'is_past' => $date['date']->isPast(),
                'is_future' => $date['date']->isFuture(),
                'is_test_day' => $date['is_test_day'],
                'day_type' => $date['day_type'],
                'has_test' => $hasTest,
                'test' => $test,
                'can_take_test' => $canTakeTest,
                'is_confirmed' => $isConfirmed,
                'lock_reason' => $lockReason,
                'is_available' => $date['is_available']
            ];
        }

        return view('pengguna.quality-test.index', compact('currentTest', 'weekDays', 'testInfo'));
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

        if ($type == 'first') {
            if (!$currentTest->canTakeFirstTest()) {
                $today = now();
                $startDate = Carbon::parse($currentTest->start_date);

                if ($today->lt($startDate)) {
                    return redirect()->route('pengguna.quality-test.index')
                        ->with('error', 'Test pertama akan tersedia pada ' . $startDate->format('d M Y') . '.');
                }

                return redirect()->route('pengguna.quality-test.index')
                    ->with('error', 'Test pertama tidak dapat diakses saat ini.');
            }
        } else {
            if (!$currentTest->canTakeLastTest()) {
                $firstTest = $currentTest->firstTest;
                $endDate = Carbon::parse($currentTest->end_date);
                $today = now();

                if (!$firstTest || !$firstTest->is_confirmed) {
                    return redirect()->route('pengguna.quality-test.index')
                        ->with('error', 'Test pertama belum selesai. Silakan selesaikan test pertama terlebih dahulu.');
                }

                if ($today->lt($endDate)) {
                    $daysLeft = $today->diffInDays($endDate);
                    return redirect()->route('pengguna.quality-test.index')
                        ->with('error', 'Test terakhir akan tersedia pada ' . $endDate->format('d M Y') . ' (hari ke-7).');
                }

                return redirect()->route('pengguna.quality-test.index')
                    ->with('error', 'Test terakhir tidak dapat diakses saat ini.');
            }
        }

        // Cek apakah sudah ada data test
        $existingTest = $type == 'first' ? $currentTest->firstTest : $currentTest->lastTest;

        return view('pengguna.quality-test.test-page', compact('currentTest', 'type', 'existingTest'));
    }

    public function storeTest(Request $request, $type)
    {
        $pengguna = Auth::user();

        // Validasi input
        $request->validate([
            'bedtime' => 'required|date_format:H:i',
            'time_to_sleep' => 'required|integer|min:0|max:300',
            'wakeup_time' => 'required|date_format:H:i',
            'sleep_duration' => 'required|numeric|min:0|max:24',

            'sleep_satisfaction' => 'required|integer|between:0,3',
            'medication_use' => 'required|integer|between:0,3',
            'daytime_sleepiness' => 'required|integer|between:0,3',
            'enthusiasm' => 'required|integer|between:0,3',

            'sleep_disturbances.a' => 'required|integer|between:0,3',
            'sleep_disturbances.b' => 'required|integer|between:0,3',
            'sleep_disturbances.c' => 'required|integer|between:0,3',
            'sleep_disturbances.d' => 'required|integer|between:0,3',
            'sleep_disturbances.e' => 'required|integer|between:0,3',
            'sleep_disturbances.f' => 'required|integer|between:0,3',
            'sleep_disturbances.g' => 'required|integer|between:0,3',
            'sleep_disturbances.h' => 'required|integer|between:0,3',
            'sleep_disturbances.i' => 'required|integer|between:0,3',
            'sleep_disturbances.j' => 'required|integer|between:0,3',
        ]);

        $currentTest = SleepTest::where('pengguna_id', $pengguna->id)
            ->where('status', 'ongoing')
            ->firstOrFail();

        // Validasi akses berdasarkan jenis test
        if ($type == 'first') {
            if (!$currentTest->canTakeFirstTest()) {
                return redirect()->route('pengguna.quality-test.index')
                    ->with('error', 'Test pertama tidak dapat diakses saat ini.');
            }
        } else {
            if (!$currentTest->canTakeLastTest()) {
                return redirect()->route('pengguna.quality-test.index')
                    ->with('error', 'Test terakhir tidak dapat diakses saat ini.');
            }
        }

        // Siapkan data gangguan tidur
        $disturbances = [];
        foreach (range('a', 'j') as $letter) {
            $disturbances[$letter] = $request->input("sleep_disturbances.{$letter}", 0);
        }

        $testData = [
            'sleep_test_id' => $currentTest->id,
            'day_type' => $type,
            'test_date' => now(),
            'bedtime' => $request->bedtime,
            'time_to_sleep' => $request->time_to_sleep,
            'wakeup_time' => $request->wakeup_time,
            'sleep_duration' => $request->sleep_duration,
            'sleep_disturbances' => $disturbances,
            'medication_use' => $request->medication_use,
            'daytime_sleepiness' => $request->daytime_sleepiness,
            'enthusiasm' => $request->enthusiasm,
            'sleep_satisfaction' => $request->sleep_satisfaction,
            'is_confirmed' => false
        ];

        // Cek apakah sudah ada test
        $existingTest = $type == 'first' ? $currentTest->firstTest : $currentTest->lastTest;

        if ($existingTest) {
            $existingTest->update($testData);
            $test = $existingTest;
        } else {
            $test = DailyTest::create($testData);
        }

        // Hitung skor
        $test->calculateScores()->save();

        // Jika test pertama, update current_test
        if ($type == 'first') {
            $currentTest->update(['current_test' => 'first']);
        }

        $message = $type == 'first'
            ? 'Test pertama berhasil disimpan! Silakan konfirmasi untuk melanjutkan.'
            : 'Test terakhir berhasil disimpan! Silakan konfirmasi untuk melihat hasil.';

        return redirect()->route('pengguna.quality-test.index')
            ->with('success', $message);
    }

    public function confirmTest($type)
    {
        $pengguna = Auth::user();

        if (!in_array($type, ['first', 'last'])) {
            return redirect()->route('pengguna.quality-test.index')
                ->with('error', 'Jenis test tidak valid.');
        }

        $currentTest = SleepTest::where('pengguna_id', $pengguna->id)
            ->where('status', 'ongoing')
            ->firstOrFail();

        // Ambil test yang akan dikonfirmasi
        $test = $type == 'first' ? $currentTest->firstTest : $currentTest->lastTest;

        if (!$test) {
            return redirect()->route('pengguna.quality-test.index')
                ->with('error', 'Test belum diisi.');
        }

        // Konfirmasi test
        $test->update([
            'is_confirmed' => true,
            'confirmed_at' => now()
        ]);

        // Update status test - HAPUS baris yang mengupdate current_test ke 'waiting'
        // $currentTest->update(['current_test' => 'waiting']); // HAPUS BARIS INI

        if ($type == 'first') {
            // Update current_test menjadi 'last' atau biarkan 'first'
            // Tergantung kebutuhan logika Anda
            $currentTest->update(['current_test' => 'first']); // Atau 'last' jika sesuai

            $message = 'Test pertama berhasil dikonfirmasi! Test terakhir akan tersedia pada ' .
                Carbon::parse($currentTest->end_date)->format('d M Y') . ' (hari ke-7).';
        } else {
            $currentTest->calculateFinalScores();
            $message = 'Test terakhir berhasil dikonfirmasi! Hasil test sudah tersedia.';
        }

        return redirect()->route('pengguna.quality-test.index')
            ->with('success', $message);
    }

    public function startNewTest()
    {
        $pengguna = Auth::user();

        // Cek apakah ada test yang sedang berjalan
        $ongoingTest = SleepTest::where('pengguna_id', $pengguna->id)
            ->where('status', 'ongoing')
            ->first();

        if ($ongoingTest) {
            // Tandai sebagai abandoned
            $ongoingTest->update(['status' => 'abandoned']);
        }

        // Buat test baru
        $this->createNewTest($pengguna);

        return redirect()->route('pengguna.quality-test.index')
            ->with('success', 'Test baru berhasil dimulai! Silakan isi test pertama.');
    }

    public function editTest($type)
    {
        $pengguna = Auth::user();

        if (!in_array($type, ['first', 'last'])) {
            return redirect()->route('pengguna.quality-test.index')
                ->with('error', 'Jenis test tidak valid.');
        }

        $currentTest = SleepTest::where('pengguna_id', $pengguna->id)
            ->where('status', 'ongoing')
            ->firstOrFail();

        // Ambil test yang akan diedit
        $test = $type == 'first' ? $currentTest->firstTest : $currentTest->lastTest;

        if (!$test) {
            return redirect()->route('pengguna.quality-test.index')
                ->with('error', 'Test tidak ditemukan.');
        }

        if ($test->is_confirmed) {
            return redirect()->route('pengguna.quality-test.index')
                ->with('error', 'Test yang sudah dikonfirmasi tidak dapat diedit.');
        }

        // Validasi akses edit
        if ($type == 'first' && !$currentTest->canTakeFirstTest()) {
            return redirect()->route('pengguna.quality-test.index')
                ->with('error', 'Test pertama tidak dapat diedit saat ini.');
        }

        if ($type == 'last' && !$currentTest->canTakeLastTest()) {
            return redirect()->route('pengguna.quality-test.index')
                ->with('error', 'Test terakhir tidak dapat diedit saat ini.');
        }

        return view('pengguna.quality-test.test-page', [
            'currentTest' => $currentTest,
            'type' => $type,
            'existingTest' => $test
        ]);
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

        // Ambil test yang sedang ongoing tapi sudah ada kedua test
        $ongoingTest = SleepTest::where('pengguna_id', $pengguna->id)
            ->where('status', 'ongoing')
            ->with(['firstTest', 'lastTest'])
            ->first();

        $tests = $completedTests;

        // Jika ada ongoing test dengan kedua test sudah terisi, tambahkan ke list
        if ($ongoingTest && $ongoingTest->firstTest && $ongoingTest->lastTest) {
            $tests->prepend($ongoingTest);
        }

        return view('pengguna.quality-test.results', compact('tests'));
    }

    public function viewResult($id)
    {
        $pengguna = Auth::user();

        // Ambil test berdasarkan ID
        $test = SleepTest::where('pengguna_id', $pengguna->id)
            ->with(['firstTest', 'lastTest'])
            ->findOrFail($id);

        // Pastikan test sudah selesai atau memiliki kedua test
        if (!$test->firstTest || !$test->lastTest) {
            return redirect()->route('pengguna.quality-test.result')
                ->with('error', 'Test belum lengkap. Silakan selesaikan kedua test terlebih dahulu.');
        }

        // Hitung improvement dan detail scores
        $firstTest = $test->firstTest;
        $lastTest = $test->lastTest;

        // Pastikan total_score ada
        if ($firstTest->total_score === null || $lastTest->total_score === null) {
            return redirect()->route('pengguna.quality-test.result')
                ->with('error', 'Skor test belum dihitung. Silakan konfirmasi test terlebih dahulu.');
        }

        // Hitung perubahan skor
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

        // Detail gangguan tidur - FIXED: Handle array/string conversion
        $firstDisturbances = $this->parseDisturbances($firstTest->sleep_disturbances);
        $lastDisturbances = $this->parseDisturbances($lastTest->sleep_disturbances);

        // Debug logging jika diperlukan
        // Log::info('First disturbances:', $firstDisturbances);
        // Log::info('Last disturbances:', $lastDisturbances);

        // Hitung total gangguan untuk masing-masing test
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