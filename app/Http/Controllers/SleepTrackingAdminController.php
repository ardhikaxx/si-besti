<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\SleepTracking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SleepTrackingAdminController extends Controller
{
    /**
     * Display a listing of sleep tracking data for all users
     */
    public function index()
    {
        // Get all users with sleep tracking data
        $users = Pengguna::withCount('sleepTrackings')
            ->with(['sleepTrackings' => function($query) {
                $query->latest()->take(5); // Get latest 5 sleep records
            }])
            ->whereHas('sleepTrackings')
            ->get();

        // Prepare data for view
        $dataUsers = [];
        foreach ($users as $user) {
            $dataUsers[] = [
                'id' => $user->id,
                'nama_lengkap' => $user->nama_lengkap,
                'nomor_telepon' => $user->nomor_telepon,
                'umur' => $user->umur,
                'jenis_kelamin' => $user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                'usia_kehamilan' => $user->usia_kehamilan ? $user->usia_kehamilan . ' minggu' : '-',
                'hamil_anak_ke' => $user->hamil_anak_ke ?: '-',
                'jumlah_anak' => $user->jumlah_anak,
                'alamat' => $user->alamat,
                'total_sleep_records' => $user->sleep_trackings_count,
                'latest_sleep' => $user->sleepTrackings->first() ? [
                    'tanggal' => $user->sleepTrackings->first()->tanggal_tidur,
                    'durasi' => $user->sleepTrackings->first()->formatted_duration,
                    'waktu_tidur' => $user->sleepTrackings->first()->formatted_sleep_time,
                    'waktu_bangun' => $user->sleepTrackings->first()->formatted_wake_time,
                    'waktu_tidur_kembali' => $user->sleepTrackings->first()->waktu_tidur_kembali
                ] : null
            ];
        }

        return view('admins.sleep-tracking.index', compact('dataUsers'));
    }

    /**
     * Get sleep tracking statistics
     */
    public function getStatistics()
    {
        $totalUsers = Pengguna::whereHas('sleepTrackings')->count();
        $totalRecords = SleepTracking::count();
        
        // Calculate average sleep duration
        $avgDuration = SleepTracking::avg('durasi_tidur');
        
        // Calculate average wake back time
        $avgWakeBackTime = SleepTracking::whereNotNull('waktu_tidur_kembali')
            ->where('waktu_tidur_kembali', '>', 0)
            ->avg('waktu_tidur_kembali');
        
        // Get today's records
        $todayRecords = SleepTracking::whereDate('tanggal_tidur', Carbon::today())->count();
        
        return response()->json([
            'success' => true,
            'data' => [
                'total_users' => $totalUsers,
                'total_records' => $totalRecords,
                'avg_duration' => $avgDuration ? round($avgDuration, 2) : 0,
                'avg_wake_back_time' => $avgWakeBackTime ? round($avgWakeBackTime, 1) : 0,
                'today_records' => $todayRecords
            ]
        ]);
    }

    /**
     * Get sleep tracking details for a specific user
     */
    public function getUserSleepDetails($id)
    {
        try {
            $user = Pengguna::with('sleepTrackings')->findOrFail($id);
            
            // Get sleep tracking data for chart
            $sleepData = $user->sleepTrackings()
                ->orderBy('tanggal_tidur', 'desc')
                ->take(30) // Last 30 records for chart
                ->get()
                ->map(function($record) {
                    return [
                        'id' => $record->id,
                        'tanggal' => Carbon::parse($record->tanggal_tidur)->format('d M'),
                        'tanggal_full' => $record->formatted_date,
                        'waktu_tidur' => $record->formatted_sleep_time,
                        'waktu_bangun' => $record->formatted_wake_time,
                        'durasi' => (float) $record->durasi_tidur,
                        'durasi_formatted' => $record->formatted_duration,
                        'jumlah_kebangunan' => $record->jumlah_kebangunan,
                        'waktu_tidur_kembali' => $record->waktu_tidur_kembali,
                        'waktu_tidur_kembali_formatted' => $record->waktu_tidur_kembali ? 
                            $record->waktu_tidur_kembali . ' menit' : '-',
                        'alasan_kebangun' => $record->alasan_kebangun,
                        'catatan_lain' => $record->catatan_lain,
                        'has_wake_back_time' => $record->hasWakeBackTime()
                    ];
                })
                ->reverse()
                ->values(); // Reset array keys

            // Calculate statistics
            $totalRecords = $user->sleepTrackings()->count();
            $avgDuration = $user->sleepTrackings()->avg('durasi_tidur');
            $minDuration = $user->sleepTrackings()->min('durasi_tidur');
            $maxDuration = $user->sleepTrackings()->max('durasi_tidur');
            
            // Calculate wake back time statistics
            $wakeBackStats = $this->calculateWakeBackStatistics($user->id);
            
            // Get sleep distribution by time of day
            $sleepByTime = [
                'early' => $user->sleepTrackings()
                    ->whereTime('waktu_tidur', '<', '22:00:00')
                    ->count(),
                'normal' => $user->sleepTrackings()
                    ->whereTime('waktu_tidur', '>=', '22:00:00')
                    ->whereTime('waktu_tidur', '<=', '23:59:59')
                    ->count(),
                'late' => $user->sleepTrackings()
                    ->whereTime('waktu_tidur', '>=', '00:00:00')
                    ->whereTime('waktu_tidur', '<', '02:00:00')
                    ->count()
            ];

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'nama_lengkap' => $user->nama_lengkap,
                        'nomor_telepon' => $user->nomor_telepon,
                        'umur' => $user->umur,
                        'jenis_kelamin' => $user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                        'usia_kehamilan' => $user->usia_kehamilan,
                        'hamil_anak_ke' => $user->hamil_anak_ke,
                        'jumlah_anak' => $user->jumlah_anak,
                        'alamat' => $user->alamat
                    ],
                    'sleep_data' => $sleepData,
                    'statistics' => [
                        'total_records' => $totalRecords,
                        'avg_duration' => $avgDuration ? round($avgDuration, 2) : 0,
                        'avg_duration_formatted' => $this->formatDuration($avgDuration),
                        'min_duration' => $minDuration ? round($minDuration, 2) : 0,
                        'min_duration_formatted' => $this->formatDuration($minDuration),
                        'max_duration' => $maxDuration ? round($maxDuration, 2) : 0,
                        'max_duration_formatted' => $this->formatDuration($maxDuration),
                        'sleep_by_time' => $sleepByTime,
                        'wake_back_stats' => $wakeBackStats
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Calculate wake back time statistics
     */
    private function calculateWakeBackStatistics($userId)
    {
        $sleepTrackings = SleepTracking::where('pengguna_id', $userId)->get();
        
        $recordsWithWakeBack = $sleepTrackings->filter(function($tracking) {
            return $tracking->waktu_tidur_kembali !== null && $tracking->waktu_tidur_kembali > 0;
        });
        
        $totalWithWakeBack = $recordsWithWakeBack->count();
        $avgWakeBackTime = $recordsWithWakeBack->avg('waktu_tidur_kembali');
        $maxWakeBackTime = $recordsWithWakeBack->max('waktu_tidur_kembali');
        $minWakeBackTime = $recordsWithWakeBack->min('waktu_tidur_kembali');
        
        // Categorize wake back times
        $quickReturn = $recordsWithWakeBack->filter(function($tracking) {
            return $tracking->waktu_tidur_kembali <= 15;
        })->count();
        
        $moderateReturn = $recordsWithWakeBack->filter(function($tracking) {
            return $tracking->waktu_tidur_kembali > 15 && $tracking->waktu_tidur_kembali <= 30;
        })->count();
        
        $longReturn = $recordsWithWakeBack->filter(function($tracking) {
            return $tracking->waktu_tidur_kembali > 30;
        })->count();
        
        return [
            'total_with_wake_back' => $totalWithWakeBack,
            'percentage' => $sleepTrackings->count() > 0 ? 
                round(($totalWithWakeBack / $sleepTrackings->count()) * 100, 1) : 0,
            'avg_wake_back_time' => $avgWakeBackTime ? round($avgWakeBackTime, 1) : 0,
            'max_wake_back_time' => $maxWakeBackTime,
            'min_wake_back_time' => $minWakeBackTime,
            'quick_return' => $quickReturn,
            'moderate_return' => $moderateReturn,
            'long_return' => $longReturn,
            'quick_return_percentage' => $totalWithWakeBack > 0 ? 
                round(($quickReturn / $totalWithWakeBack) * 100, 1) : 0,
            'moderate_return_percentage' => $totalWithWakeBack > 0 ? 
                round(($moderateReturn / $totalWithWakeBack) * 100, 1) : 0,
            'long_return_percentage' => $totalWithWakeBack > 0 ? 
                round(($longReturn / $totalWithWakeBack) * 100, 1) : 0
        ];
    }

    /**
     * Format duration in hours to readable format
     */
    private function formatDuration($hours)
    {
        if (!$hours) return '-';
        
        $hours = (float) $hours;
        $hourPart = floor($hours);
        $minutePart = round(($hours - $hourPart) * 60);
        
        if ($hourPart > 0 && $minutePart > 0) {
            return "{$hourPart} jam {$minutePart} menit";
        } elseif ($hourPart > 0) {
            return "{$hourPart} jam";
        } else {
            return "{$minutePart} menit";
        }
    }
}