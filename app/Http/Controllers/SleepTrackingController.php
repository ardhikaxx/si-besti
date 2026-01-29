<?php

namespace App\Http\Controllers;

use App\Models\SleepTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SleepTrackingController extends Controller
{
    /**
     * Display a listing of the sleep tracking records.
     */
    public function index()
    {
        $pengguna = Auth::user();
        $sleepTrackings = SleepTracking::where('pengguna_id', $pengguna->id)
            ->orderBy('tanggal_tidur', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pengguna.sleep-tracking.index', compact('sleepTrackings'));
    }

    /**
     * Store a newly created sleep tracking record.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_tidur' => 'required|date',
            'waktu_tidur' => 'required|date_format:H:i',
            'waktu_bangun' => 'required|date_format:H:i',
            'jumlah_kebangunan' => 'required|integer|min:0',
            'alasan_kebangunan' => 'nullable|string|max:500',
            'catatan_lain' => 'nullable|string|max:1000',
        ]);

        // Validasi waktu bangun harus setelah waktu tidur
        if (strtotime($request->waktu_bangun) <= strtotime($request->waktu_tidur)) {
            // Jika waktu bangun <= waktu tidur, anggap melewati tengah malam
            // Tidak ada error, sistem akan menangani perhitungan durasi
        }

        try {
            $pengguna = Auth::user();
            
            // Cek apakah sudah ada data untuk tanggal yang sama
            $existingData = SleepTracking::where('pengguna_id', $pengguna->id)
                ->where('tanggal_tidur', $request->tanggal_tidur)
                ->first();
            
            if ($existingData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah mencatat tidur untuk tanggal ini. Silakan edit data yang sudah ada.'
                ], 422);
            }

            $sleepTracking = new SleepTracking();
            $sleepTracking->pengguna_id = $pengguna->id;
            $sleepTracking->tanggal_tidur = $request->tanggal_tidur;
            $sleepTracking->waktu_tidur = $request->waktu_tidur;
            $sleepTracking->waktu_bangun = $request->waktu_bangun;
            $sleepTracking->jumlah_kebangunan = $request->jumlah_kebangunan;
            $sleepTracking->alasan_kebangunan = $request->alasan_kebangunan;
            $sleepTracking->catatan_lain = $request->catatan_lain;
            
            // Hitung durasi tidur dalam jam
            $sleepTracking->calculateDuration();
            
            $sleepTracking->save();

            return response()->json([
                'success' => true,
                'message' => 'Catatan tidur berhasil disimpan!',
                'data' => $sleepTracking
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the specified sleep tracking record.
     */
    public function show($id)
    {
        $pengguna = Auth::user();
        $sleepTracking = SleepTracking::where('pengguna_id', $pengguna->id)
            ->where('id', $id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $sleepTracking
        ]);
    }

    /**
     * Update the specified sleep tracking record.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_tidur' => 'required|date',
            'waktu_tidur' => 'required|date_format:H:i',
            'waktu_bangun' => 'required|date_format:H:i',
            'jumlah_kebangunan' => 'required|integer|min:0',
            'alasan_kebangunan' => 'nullable|string|max:500',
            'catatan_lain' => 'nullable|string|max:1000',
        ]);

        // Validasi waktu bangun harus setelah waktu tidur
        if (strtotime($request->waktu_bangun) <= strtotime($request->waktu_tidur)) {
            // Jika waktu bangun <= waktu tidur, anggap melewati tengah malam
            // Tidak ada error, sistem akan menangani perhitungan durasi
        }

        try {
            $pengguna = Auth::user();
            
            $sleepTracking = SleepTracking::where('pengguna_id', $pengguna->id)
                ->where('id', $id)
                ->firstOrFail();

            // Cek apakah ada data lain dengan tanggal yang sama (kecuali data ini sendiri)
            $existingData = SleepTracking::where('pengguna_id', $pengguna->id)
                ->where('tanggal_tidur', $request->tanggal_tidur)
                ->where('id', '!=', $id)
                ->first();
            
            if ($existingData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sudah ada catatan tidur untuk tanggal ini.'
                ], 422);
            }

            $sleepTracking->tanggal_tidur = $request->tanggal_tidur;
            $sleepTracking->waktu_tidur = $request->waktu_tidur;
            $sleepTracking->waktu_bangun = $request->waktu_bangun;
            $sleepTracking->jumlah_kebangunan = $request->jumlah_kebangunan;
            $sleepTracking->alasan_kebangunan = $request->alasan_kebangunan;
            $sleepTracking->catatan_lain = $request->catatan_lain;
            
            // Hitung durasi tidur dalam jam
            $sleepTracking->calculateDuration();
            
            $sleepTracking->save();

            return response()->json([
                'success' => true,
                'message' => 'Catatan tidur berhasil diperbarui!',
                'data' => $sleepTracking
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified sleep tracking record.
     */
    public function destroy($id)
    {
        try {
            $pengguna = Auth::user();
            
            $sleepTracking = SleepTracking::where('pengguna_id', $pengguna->id)
                ->where('id', $id)
                ->firstOrFail();

            $sleepTracking->delete();

            return response()->json([
                'success' => true,
                'message' => 'Catatan tidur berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics for sleep tracking
     */
    public function getStatistics()
    {
        $pengguna = Auth::user();
        
        $totalRecords = SleepTracking::where('pengguna_id', $pengguna->id)->count();
        $averageDuration = SleepTracking::where('pengguna_id', $pengguna->id)->avg('durasi_tidur');
        $averageWakeups = SleepTracking::where('pengguna_id', $pengguna->id)->avg('jumlah_kebangunan');
        $latestRecord = SleepTracking::where('pengguna_id', $pengguna->id)
            ->orderBy('tanggal_tidur', 'desc')
            ->first();

        // Format average duration
        $formattedAvgDuration = '0 jam';
        if ($averageDuration) {
            $hours = floor($averageDuration);
            $minutes = round(($averageDuration - $hours) * 60);
            $formattedAvgDuration = "{$hours} jam";
            if ($minutes > 0) {
                $formattedAvgDuration .= " {$minutes} menit";
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'total_records' => $totalRecords,
                'average_duration' => $averageDuration ? round($averageDuration, 2) : 0,
                'formatted_average_duration' => $formattedAvgDuration,
                'average_wakeups' => $averageWakeups ? round($averageWakeups, 1) : 0,
                'latest_record' => $latestRecord
            ]
        ]);
    }
}