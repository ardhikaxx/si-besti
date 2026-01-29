<?php
// app/Http/Controllers/QualityTestController.php

namespace App\Http\Controllers;

use App\Models\SleepTest;
use App\Models\DailyTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            
            if ($date['is_test_day']) {
                $test = $date['day_type'] == 'first' ? $firstTest : $lastTest;
                $hasTest = $test !== null;
                $isConfirmed = $hasTest && $test->is_confirmed;
                
                if ($date['day_type'] == 'first') {
                    $canTakeTest = $currentTest->canTakeFirstTest();
                } else {
                    $canTakeTest = $currentTest->canTakeLastTest();
                }
            }
            
            $weekDays[] = [
                'day_number' => $date['day'],
                'date' => $date['date']->format('Y-m-d'),
                'day_name' => $date['date']->translatedFormat('l'),
                'date_formatted' => $date['date']->format('d M'),
                'is_today' => $date['date']->isToday(),
                'is_past' => $date['date']->isPast(),
                'is_future' => $date['date']->isFuture(),
                'is_test_day' => $date['is_test_day'],
                'day_type' => $date['day_type'],
                'has_test' => $hasTest,
                'test' => $test,
                'can_take_test' => $canTakeTest,
                'is_confirmed' => $isConfirmed
            ];
        }

        return view('pengguna.quality-test.index', compact('currentTest', 'weekDays'));
    }

    private function createNewTest($pengguna)
    {
        $startDate = now();
        $endDate = now()->addDays(6);

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

        if ($type == 'first' && !$currentTest->canTakeFirstTest()) {
            return redirect()->route('pengguna.quality-test.index')
                ->with('error', 'Test pertama tidak dapat diakses saat ini.');
        }

        if ($type == 'last' && !$currentTest->canTakeLastTest()) {
            return redirect()->route('pengguna.quality-test.index')
                ->with('error', 'Test terakhir tidak dapat diakses saat ini.');
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

        // Validasi jenis test
        if ($type == 'first' && !$currentTest->canTakeFirstTest()) {
            return redirect()->route('pengguna.quality-test.index')
                ->with('error', 'Test pertama tidak dapat diakses saat ini.');
        }

        if ($type == 'last' && !$currentTest->canTakeLastTest()) {
            return redirect()->route('pengguna.quality-test.index')
                ->with('error', 'Test terakhir tidak dapat diakses saat ini.');
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

        return redirect()->route('pengguna.quality-test.index')
            ->with('success', 'Test ' . ($type == 'first' ? 'pertama' : 'terakhir') . ' berhasil disimpan!');
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

        // Update status test
        if ($type == 'first') {
            $currentTest->update(['current_test' => 'last']);
        } else {
            $currentTest->calculateFinalScores();
        }

        return redirect()->route('pengguna.quality-test.index')
            ->with('success', 'Test ' . ($type == 'first' ? 'pertama' : 'terakhir') . ' berhasil dikonfirmasi!');
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
            ->with('success', 'Test baru berhasil dimulai!');
    }

    public function viewResult($id)
    {
        $pengguna = Auth::user();
        
        $test = SleepTest::where('pengguna_id', $pengguna->id)
            ->with(['firstTest', 'lastTest'])
            ->findOrFail($id);

        return view('pengguna.quality-test.result', compact('test'));
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
        
        if (!$test || $test->is_confirmed) {
            return redirect()->route('pengguna.quality-test.index')
                ->with('error', 'Test tidak dapat diedit.');
        }

        return view('pengguna.quality-test.test-page', compact('currentTest', 'type', 'existingTest'));
    }
}