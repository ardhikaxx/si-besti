<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DataIbuController extends Controller
{
    /**
     * Display a listing of the pengguna (ibu hamil).
     */
    public function index()
    {
        // Ambil semua pengguna dengan filter jenis kelamin perempuan
        $ibu = Pengguna::where('jenis_kelamin', 'P')
            ->orderBy('created_at', 'desc')
            ->get();

        // Format data untuk response
        $dataIbu = $ibu->map(function ($item) {
            return [
                'id' => $item->id,
                'nama_lengkap' => $item->nama_lengkap,
                'status' => $item->remember_token ? 'online' : 'offline',
                'umur' => $item->umur,
                'usia_kehamilan' => $item->usia_kehamilan ? $item->usia_kehamilan . ' minggu' : 'Tidak tersedia',
                'hamil_anak_ke' => $item->hamil_anak_ke ?? 'Tidak tersedia',
                'nomor_telepon' => $item->nomor_telepon,
                'alamat' => $item->alamat,
                'jumlah_anak' => $item->jumlah_anak,
                'jenis_kelamin' => $item->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-laki',
                'created_at' => $item->created_at->format('d M Y'),
                'updated_at' => $item->updated_at->format('d M Y'),
            ];
        });

        return view('admins.data-ibu.index', compact('dataIbu'));
    }

    /**
     * Get detail data ibu by ID.
     */
    public function getDetail($id)
    {
        try {
            $ibu = Pengguna::findOrFail($id);

            $data = [
                'id' => $ibu->id,
                'nama_lengkap' => $ibu->nama_lengkap,
                'nomor_telepon' => $ibu->nomor_telepon,
                'umur' => $ibu->umur . ' tahun',
                'jenis_kelamin' => $ibu->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-laki',
                'alamat' => $ibu->alamat,
                'usia_kehamilan' => $ibu->usia_kehamilan ? $ibu->usia_kehamilan . ' minggu' : 'Tidak tersedia',
                'hamil_anak_ke' => $ibu->hamil_anak_ke ?? 'Tidak tersedia',
                'jumlah_anak' => $ibu->jumlah_anak ?? 0,
                'status' => $ibu->remember_token ? 'Online' : 'Offline',
                'status_badge' => $ibu->remember_token ? 'success' : 'secondary',
                'created_at' => $ibu->created_at->format('d M Y H:i'),
                'updated_at' => $ibu->updated_at->format('d M Y H:i'),
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update status online/offline.
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $ibu = Pengguna::findOrFail($id);

            $status = $request->status;
            if ($status == 'online') {
                // Generate token baru untuk status online
                $ibu->remember_token = bin2hex(random_bytes(32));
            } else {
                // Hapus token untuk status offline
                $ibu->remember_token = null;
            }

            $ibu->save();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui',
                'status' => $status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status'
            ], 500);
        }
    }

    /**
     * Delete data ibu.
     */
    public function destroy($id)
    {
        try {
            $ibu = Pengguna::findOrFail($id);
            $nama = $ibu->nama_lengkap;
            $ibu->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data ibu ' . $nama . ' berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data'
            ], 500);
        }
    }

    /**
     * Get statistics data.
     */
    public function getStatistics()
    {
        $totalIbu = Pengguna::where('jenis_kelamin', 'P')->count();
        $onlineIbu = Pengguna::where('jenis_kelamin', 'P')
            ->whereNotNull('remember_token')
            ->count();
        $trimester1 = Pengguna::where('jenis_kelamin', 'P')
            ->whereBetween('usia_kehamilan', [0, 12])
            ->count();
        $trimester2 = Pengguna::where('jenis_kelamin', 'P')
            ->whereBetween('usia_kehamilan', [13, 27])
            ->count();
        $trimester3 = Pengguna::where('jenis_kelamin', 'P')
            ->where('usia_kehamilan', '>=', 28)
            ->count();

        return response()->json([
            'total' => $totalIbu,
            'online' => $onlineIbu,
            'offline' => $totalIbu - $onlineIbu,
            'trimester1' => $trimester1,
            'trimester2' => $trimester2,
            'trimester3' => $trimester3
        ]);
    }
}