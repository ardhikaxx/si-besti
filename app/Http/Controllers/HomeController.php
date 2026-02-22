<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SleepTest;
use App\Models\SleepTracking;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $pengguna = Auth::user();
        
        // Data untuk grafik Test Kualitas Tidur
        $qualityTestData = $this->getQualityTestData($pengguna->id);
        
        // Data untuk grafik Sleep Tracking
        $sleepTrackingData = $this->getSleepTrackingData($pengguna->id);
        
        return view('pengguna.dashboard.index', compact('pengguna', 'qualityTestData', 'sleepTrackingData'));
    }
    
    private function getQualityTestData($penggunaId)
    {
        // Ambil semua test yang sudah completed
        $completedTests = SleepTest::where('pengguna_id', $penggunaId)
            ->where('status', 'completed')
            ->with(['firstTest', 'lastTest'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Jika tidak ada test completed, ambil test ongoing terakhir
        if ($completedTests->isEmpty()) {
            $latestTest = SleepTest::where('pengguna_id', $penggunaId)
                ->where('status', 'ongoing')
                ->with(['firstTest', 'lastTest'])
                ->latest()
                ->first();
            
            if (!$latestTest || !$latestTest->firstTest) {
                return null;
            }
            
            // Cek apakah first test sudah dikonfirmasi
            if (!$latestTest->firstTest->is_confirmed) {
                return null;
            }
            
            $data = [
                'type' => 'single', // single test (ongoing)
                'first_date' => Carbon::parse($latestTest->firstTest->test_date)->format('d M Y'),
                'first_score' => $latestTest->firstTest->total_score,
                'first_quality' => $latestTest->firstTest->total_score <= 5 ? 'Baik' : 'Buruk',
                'status' => $latestTest->status,
                'has_last_test' => false,
                'last_score' => null,
                'last_quality' => null,
                'last_date' => null,
            ];
            
            // Cek apakah ada last test dan sudah dikonfirmasi
            if ($latestTest->lastTest && $latestTest->lastTest->is_confirmed) {
                $data['has_last_test'] = true;
                $data['last_date'] = Carbon::parse($latestTest->lastTest->test_date)->format('d M Y');
                $data['last_score'] = $latestTest->lastTest->total_score;
                $data['last_quality'] = $latestTest->lastTest->total_score <= 5 ? 'Baik' : 'Buruk';
            }
            
            return $data;
        }
        
        // Jika ada test completed, siapkan data untuk grafik semua tes
        $labels = [];
        $scoresBefore = [];
        $scoresAfter = [];
        
        foreach ($completedTests as $index => $test) {
            $labels[] = 'Test #' . ($index + 1);
            $scoresBefore[] = $test->total_score_before ?? 0;
            $scoresAfter[] = $test->total_score_after ?? 0;
        }
        
        return [
            'type' => 'multiple', // multiple tests (completed)
            'labels' => $labels,
            'scores_before' => $scoresBefore,
            'scores_after' => $scoresAfter,
            'total_tests' => $completedTests->count(),
        ];
    }
    
    private function getSleepTrackingData($penggunaId)
    {
        // Ambil data 7 hari terakhir
        $sevenDaysAgo = Carbon::now()->subDays(6)->startOfDay();
        
        $trackings = SleepTracking::where('pengguna_id', $penggunaId)
            ->where('tanggal_tidur', '>=', $sevenDaysAgo)
            ->orderBy('tanggal_tidur', 'asc')
            ->get();
        
        if ($trackings->isEmpty()) {
            return null;
        }
        
        $dates = [];
        $durations = [];
        
        foreach ($trackings as $tracking) {
            $dates[] = Carbon::parse($tracking->tanggal_tidur)->format('d M');
            $durations[] = (float) $tracking->durasi_tidur;
        }
        
        return [
            'dates' => $dates,
            'durations' => $durations,
        ];
    }
}