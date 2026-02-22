<?php

namespace App\Http\Controllers;

use App\Models\SleepTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SleepTrackingController extends Controller
{
    /**
     * Display a listing of the sleep tracking records.
     */
    public function index()
    {
        try {
            $pengguna = Auth::user();
            $sleepTrackings = SleepTracking::where('pengguna_id', $pengguna->id)
                ->orderBy('tanggal_tidur', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            
            return view('pengguna.sleep-tracking.index', compact('sleepTrackings'));
        } catch (\Exception $e) {
            Log::error('Error loading sleep tracking index: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat data');
        }
    }

    /**
     * Store a newly created sleep tracking record.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'tanggal_tidur' => 'required|date',
                'durasi_di_tempat_tidur' => 'required|integer|min:1|max:180',
                'waktu_tidur' => 'required|date_format:H:i',
                'waktu_bangun' => 'required|date_format:H:i',
                'jumlah_kebangunan' => 'required|integer|min:0',
                'waktu_tidur_kembali' => 'nullable|integer|min:1|max:120',
                'alasan_kebangun' => 'required|string|max:500',
                'catatan_lain' => 'nullable|string|max:1000',
            ]);

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
            $sleepTracking->durasi_di_tempat_tidur = $request->durasi_di_tempat_tidur;
            $sleepTracking->waktu_tidur = $request->waktu_tidur;
            $sleepTracking->waktu_bangun = $request->waktu_bangun;
            $sleepTracking->jumlah_kebangunan = $request->jumlah_kebangunan;
            
            // Set waktu tidur kembali hanya jika jumlah kebangunan > 0
            if ($request->jumlah_kebangunan > 0 && $request->filled('waktu_tidur_kembali')) {
                $sleepTracking->waktu_tidur_kembali = $request->waktu_tidur_kembali;
            } else {
                $sleepTracking->waktu_tidur_kembali = null;
            }
            
            $sleepTracking->alasan_kebangun = $request->alasan_kebangun;
            $sleepTracking->catatan_lain = $request->catatan_lain;
            
            // Hitung durasi tidur dalam jam
            $sleepTracking->calculateDuration();
            
            $sleepTracking->save();

            return response()->json([
                'success' => true,
                'message' => 'Catatan tidur berhasil disimpan!',
                'data' => $sleepTracking
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error storing sleep tracking: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data'
            ], 500);
        }
    }

    /**
     * Show the specified sleep tracking record.
     */
    public function show($id)
    {
        try {
            $pengguna = Auth::user();
            $sleepTracking = SleepTracking::where('pengguna_id', $pengguna->id)
                ->where('id', $id)
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $sleepTracking
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error showing sleep tracking: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat data'
            ], 500);
        }
    }

    /**
     * Update the specified sleep tracking record.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'tanggal_tidur' => 'required|date',
                'durasi_di_tempat_tidur' => 'required|integer|min:1|max:180',
                'waktu_tidur' => 'required|date_format:H:i',
                'waktu_bangun' => 'required|date_format:H:i',
                'jumlah_kebangunan' => 'required|integer|min:0',
                'waktu_tidur_kembali' => 'nullable|integer|min:1|max:120',
                'alasan_kebangun' => 'required|string|max:500',
                'catatan_lain' => 'nullable|string|max:1000',
            ]);

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
            $sleepTracking->durasi_di_tempat_tidur = $request->durasi_di_tempat_tidur;
            $sleepTracking->waktu_tidur = $request->waktu_tidur;
            $sleepTracking->waktu_bangun = $request->waktu_bangun;
            $sleepTracking->jumlah_kebangunan = $request->jumlah_kebangunan;
            
            // Set waktu tidur kembali hanya jika jumlah kebangunan > 0
            if ($request->jumlah_kebangunan > 0 && $request->filled('waktu_tidur_kembali')) {
                $sleepTracking->waktu_tidur_kembali = $request->waktu_tidur_kembali;
            } else {
                $sleepTracking->waktu_tidur_kembali = null;
            }
            
            $sleepTracking->alasan_kebangun = $request->alasan_kebangun;
            $sleepTracking->catatan_lain = $request->catatan_lain;
            
            // Hitung durasi tidur dalam jam
            $sleepTracking->calculateDuration();
            
            $sleepTracking->save();

            return response()->json([
                'success' => true,
                'message' => 'Catatan tidur berhasil diperbarui!',
                'data' => $sleepTracking
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error updating sleep tracking: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data'
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
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting sleep tracking: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data'
            ], 500);
        }
    }

    /**
     * Get statistics for sleep tracking
     */
    public function getStatistics()
    {
        try {
            $pengguna = Auth::user();
            
            if (!$pengguna) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak terautentikasi'
                ], 401);
            }
            
            $totalRecords = SleepTracking::where('pengguna_id', $pengguna->id)->count();
            $averageDuration = SleepTracking::where('pengguna_id', $pengguna->id)->avg('durasi_tidur');
            $averageWakeups = SleepTracking::where('pengguna_id', $pengguna->id)->avg('jumlah_kebangunan');
            
            // Rata-rata waktu tidur kembali (hitung dari data yang memiliki nilai)
            $averageWakeBackTime = SleepTracking::where('pengguna_id', $pengguna->id)
                ->whereNotNull('waktu_tidur_kembali')
                ->where('waktu_tidur_kembali', '>', 0)
                ->avg('waktu_tidur_kembali');
            
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
                    'average_wake_back_time' => $averageWakeBackTime ? round($averageWakeBackTime, 1) : 0,
                    'latest_record' => $latestRecord
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting sleep statistics: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat statistik',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}