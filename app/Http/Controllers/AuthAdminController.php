<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthAdminController extends Controller
{
    public function showLoginForm()
    {
        // Clear any existing admin session
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.profile');
        }

        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.login')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.profile'))
                ->with('success', 'Login berhasil! Selamat datang di dashboard admin.')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Login Berhasil!',
                    'text' => 'Selamat datang kembali di sistem admin SI-BESTI.'
                ]);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->except('password'))
            ->with('error', 'Login gagal. Periksa kembali email dan password.')
            ->with('swal', [
                'icon' => 'error',
                'title' => 'Login Gagal!',
                'text' => 'Email atau password yang Anda masukkan salah.'
            ]);
    }

    public function logout(Request $request)
    {
        $authAdmin = Auth::guard('admin')->user();

        if ($authAdmin) {
            // AMBIL MODEL ASLI
            $admin = Admin::find($authAdmin->id);

            if ($admin) {
                $admin->remember_token = null;
                $admin->save();
            }
        }

        Auth::guard('admin')->logout();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Anda telah berhasil logout.');
    }



    public function profile()
    {
        $admin = Admin::findOrFail(Auth::guard('admin')->id());
        return view('admins.profile.index', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Admin::findOrFail(Auth::guard('admin')->id());

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20|unique:admins,nomor_telepon,' . $admin->id,
            'email' => 'required|email|unique:admins,email,' . $admin->id,
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.profile')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal memperbarui profil. Periksa kembali data yang dimasukkan.')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Update Gagal!',
                    'text' => 'Terdapat kesalahan dalam pengisian formulir.'
                ]);
        }

        try {
            $admin->update([
                'nama_lengkap' => $request->nama_lengkap,
                'nomor_telepon' => $request->nomor_telepon,
                'email' => $request->email,
            ]);

            return redirect()->route('admin.profile')
                ->with('success', 'Profil berhasil diperbarui.')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Update Berhasil!',
                    'text' => 'Profil Anda telah berhasil diperbarui.'
                ]);

        } catch (\Exception $e) {
            return redirect()->route('admin.profile')
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Update Gagal!',
                    'text' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ]);
        }
    }

    public function updatePasswordModal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password baru minimal 8 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $admin = Admin::findOrFail(Auth::guard('admin')->id());

        if (!Hash::check($request->current_password, $admin->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password saat ini salah',
                'errors' => ['current_password' => ['Password saat ini salah']]
            ], 422);
        }

        try {
            $admin->update([
                'password' => Hash::make($request->new_password),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diperbarui',
                'swal' => [
                    'icon' => 'success',
                    'title' => 'Berhasil!',
                    'text' => 'Password Anda telah berhasil diperbarui.'
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem',
                'errors' => ['system' => ['Terjadi kesalahan: ' . $e->getMessage()]]
            ], 500);
        }
    }
}