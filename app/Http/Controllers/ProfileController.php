<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display the profile page.
     */
    public function index()
    {
        $pengguna = Auth::user();
        return view('pengguna.profile.index', compact('pengguna'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $pengguna = Auth::user();

        // Validasi data yang diinput
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'sometimes|required|string|max:255',
            'nomor_telepon' => 'sometimes|required|string|max:15|unique:penggunas,nomor_telepon,' . $pengguna->id,
            'umur' => 'sometimes|required|integer|min:1|max:120',
            'jenis_kelamin' => 'sometimes|required|in:L,P',
            'alamat' => 'sometimes|required|string',
            'usia_kehamilan' => 'nullable|integer|min:1|max:45',
            'hamil_anak_ke' => 'nullable|integer|min:1',
            'jumlah_anak' => 'nullable|integer|min:0',
            'pin' => 'nullable|string|min:6|max:6',
            'confirm_pin' => 'required_with:pin|same:pin',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi',
            'nomor_telepon.unique' => 'Nomor telepon sudah terdaftar',
            'umur.required' => 'Umur wajib diisi',
            'umur.integer' => 'Umur harus berupa angka',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'alamat.required' => 'Alamat wajib diisi',
            'pin.min' => 'PIN harus 6 digit',
            'pin.max' => 'PIN harus 6 digit',
            'confirm_pin.same' => 'Konfirmasi PIN tidak cocok',
            'confirm_pin.required_with' => 'Konfirmasi PIN wajib diisi jika mengubah PIN',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Prepare data for update
            $updateData = [];

            // Check each field and add to updateData if present in request
            $fields = [
                'nama_lengkap',
                'nomor_telepon',
                'umur',
                'jenis_kelamin',
                'alamat',
                'usia_kehamilan',
                'hamil_anak_ke',
                'jumlah_anak'
            ];

            foreach ($fields as $field) {
                if ($request->has($field) && $request->$field !== null) {
                    $updateData[$field] = $request->$field;
                }
            }

            // Handle PIN update
            if ($request->filled('pin')) {
                $updateData['pin'] = Hash::make($request->pin);
            }

            // Update the user
            $pengguna->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui!',
                'data' => $pengguna->refresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui profil',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}