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

    // ========== FORGOT PASSWORD METHODS ==========
    public function forgotPassword(Request $request)
    {
        // Log untuk debugging
        Log::info('Forgot password request received', ['email' => $request->email]);

        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ], [
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email tidak valid',
            ]);

            if ($validator->fails()) {
                Log::warning('Forgot password validation failed', ['errors' => $validator->errors()]);

                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()->toArray()
                ], 422);
            }

            // Cek apakah email ada di database
            $admin = Admin::where('email', $request->email)->first();

            if (!$admin) {
                Log::warning('Forgot password - Email not found', ['email' => $request->email]);

                return response()->json([
                    'success' => false,
                    'message' => 'Email tidak terdaftar dalam sistem',
                    'errors' => ['email' => ['Email tidak terdaftar dalam sistem']]
                ], 404);
            }

            // Email ditemukan
            Log::info('Forgot password - Email found', ['email' => $request->email]);

            $redirectUrl = route('admin.reset.password.form', ['email' => $admin->email]);

            return response()->json([
                'success' => true,
                'message' => 'Email berhasil diverifikasi. Anda akan diarahkan ke halaman reset password.',
                'redirect_url' => $redirectUrl
            ], 200);

        } catch (\Exception $e) {
            Log::error('Forgot password exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
                'errors' => ['system' => ['Terjadi kesalahan sistem']]
            ], 500);
        }
    }

    public function showResetPasswordForm($email)
    {
        // Cek apakah email ada di database
        $admin = Admin::where('email', $email)->first();

        if (!$admin) {
            return redirect()->route('admin.login')
                ->with('error', 'Email tidak valid atau tidak terdaftar.')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Email Tidak Valid!',
                    'text' => 'Email yang dimasukkan tidak terdaftar dalam sistem.'
                ]);
        }

        return view('auth.reset-password', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar',
            'password.required' => 'Password baru harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi.')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Validasi Gagal!',
                    'text' => 'Harap periksa kembali data yang dimasukkan.'
                ]);
        }

        try {
            // Update password admin
            $admin = Admin::where('email', $request->email)->first();

            if (!$admin) {
                return redirect()->route('admin.login')
                    ->with('error', 'Email tidak ditemukan.')
                    ->with('swal', [
                        'icon' => 'error',
                        'title' => 'Email Tidak Ditemukan!',
                        'text' => 'Email yang dimasukkan tidak terdaftar dalam sistem.'
                    ]);
            }

            $admin->update([
                'password' => Hash::make($request->password),
            ]);

            Log::info('Password reset successful', ['email' => $request->email]);

            // Redirect ke halaman login dengan pesan sukses
            return redirect()->route('admin.login')
                ->with('success', 'Password berhasil direset! Silakan login dengan password baru Anda.')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Password Berhasil Direset!',
                    'text' => 'Password Anda telah berhasil diperbarui. Silakan login dengan password baru Anda.'
                ]);

        } catch (\Exception $e) {
            Log::error('Reset password error: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Reset Password Gagal!',
                    'text' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ]);
        }
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