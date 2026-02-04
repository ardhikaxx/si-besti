<?php
namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\SleepTest;
use App\Models\DailyTest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HasilTestAdminController extends Controller
{
    public function index()
    {
        $penggunas = Pengguna::with(['sleepTests' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->whereHas('sleepTests')->get();

        $penggunas->each(function ($pengguna) {
            $pengguna->total_tests = $pengguna->sleepTests->count();
            $pengguna->completed_tests = $pengguna->sleepTests->where('status', 'completed')->count();
            $pengguna->waiting_admin = $pengguna->sleepTests->filter(function ($test) {
                $status = $test->getTestStatus();
                return in_array($status['status'], ['waiting_admin', 'waiting_admin_last']);
            })->count();
        });

        return view('admins.hasil-test.index', compact('penggunas'));
    }

    public function show($id)
    {
        $pengguna = Pengguna::with(['sleepTests' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('admins.hasil-test.detail', compact('pengguna'));
    }

    public function create($testId, $type = null)
    {
        $sleepTest = SleepTest::with(['pengguna', 'firstTest', 'lastTest'])->findOrFail($testId);
        
        // Jika type tidak ditentukan, cari yang perlu diisi admin
        if (!$type) {
            if ($sleepTest->firstTest && !$sleepTest->firstTest->filled_by_admin) {
                $type = 'first';
            } elseif ($sleepTest->lastTest && !$sleepTest->lastTest->filled_by_admin) {
                $type = 'last';
            } else {
                $type = 'first';
            }
        }

        $dailyTest = $type == 'first' ? $sleepTest->firstTest : $sleepTest->lastTest;

        return view('admins.hasil-test.test-admin', compact('sleepTest', 'type', 'dailyTest'));
    }

    public function store(Request $request, $testId, $type)
    {
        $request->validate([
            'bedtime' => 'required|date_format:H:i',
            'time_to_sleep' => 'required|integer|min:0|max:300',
            'wakeup_time' => 'required|date_format:H:i',
            'sleep_duration' => 'required|numeric|min:0|max:24',
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

        $sleepTest = SleepTest::findOrFail($testId);
        $test = $type == 'first' ? $sleepTest->firstTest : $sleepTest->lastTest;

        if (!$test) {
            return back()->with('error', 'Test tidak ditemukan.');
        }

        // Siapkan data gangguan tidur
        $disturbances = [];
        foreach (range('a', 'j') as $letter) {
            $disturbances[$letter] = $request->input("sleep_disturbances.{$letter}", 0);
        }

        // Update data bagian admin
        $adminData = [
            'bedtime' => $request->bedtime,
            'time_to_sleep' => $request->time_to_sleep,
            'wakeup_time' => $request->wakeup_time,
            'sleep_duration' => $request->sleep_duration,
            'sleep_disturbances' => $disturbances,
            'filled_by_admin' => true
        ];

        $test->update($adminData);

        // Hitung skor lengkap
        $test->calculateScores()->save();

        // Jika ini test terakhir dan sudah selesai, hitung skor akhir
        if ($type == 'last' && $sleepTest->firstTest && $sleepTest->firstTest->filled_by_admin) {
            $sleepTest->calculateFinalScores();
        }

        return redirect()->route('admin.test-quality.detail', $sleepTest->pengguna_id)
            ->with('success', 'Bagian admin untuk test ' . ($type == 'first' ? 'pertama' : 'terakhir') . ' berhasil disimpan!');
    }

    public function showTest($testId)
    {
        $sleepTest = SleepTest::with(['pengguna', 'firstTest', 'lastTest'])->findOrFail($testId);
        
        return view('admins.hasil-test.test-detail', compact('sleepTest'));
    }

    public function confirmTest($testId, $type)
    {
        $sleepTest = SleepTest::findOrFail($testId);
        $test = $type == 'first' ? $sleepTest->firstTest : $sleepTest->lastTest;

        if (!$test) {
            return back()->with('error', 'Test tidak ditemukan.');
        }

        $test->update([
            'is_confirmed' => true,
            'confirmed_at' => now()
        ]);

        // Jika kedua test sudah dikonfirmasi dan diisi admin, set completed
        if ($sleepTest->firstTest && $sleepTest->lastTest && 
            $sleepTest->firstTest->is_confirmed && $sleepTest->lastTest->is_confirmed &&
            $sleepTest->firstTest->filled_by_admin && $sleepTest->lastTest->filled_by_admin) {
            
            $sleepTest->update([
                'total_score_before' => $sleepTest->firstTest->total_score,
                'total_score_after' => $sleepTest->lastTest->total_score,
                'status' => 'completed'
            ]);
        }

        return back()->with('success', 'Test ' . ($type == 'first' ? 'pertama' : 'terakhir') . ' berhasil dikonfirmasi!');
    }
}