<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('pengguna.home');
        }
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string',
            'pin' => 'required|digits:4'
        ], [
            'fullname.required' => 'Nama lengkap harus diisi',
            'pin.required' => 'PIN harus diisi',
            'pin.digits' => 'PIN harus 4 digit angka'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Cari pengguna
        $pengguna = Pengguna::where('nama_lengkap', $request->fullname)->first();

        if (!$pengguna) {
            return back()->withErrors([
                'login_error' => 'Nama lengkap tidak ditemukan.'
            ])->withInput();
        }

        // Cek PIN
        if (!Hash::check($request->pin, $pengguna->pin)) {
            return back()->withErrors([
                'login_error' => 'PIN salah.'
            ])->withInput();
        }

        Auth::login($pengguna, true);

        // Simpan ke session (opsional)
        Session::put('pengguna', $pengguna);
        Session::put('user_id', $pengguna->id);

        return redirect()->route('pengguna.home')
            ->with('success', 'Login berhasil! Selamat datang ' . $pengguna->nama_lengkap);
    }

    /**
     * Show registration form
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('pengguna.dashboard');
        }
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        Log::info('Registration attempt', $request->all());

        // Validate input
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255|min:3',
            'phone' => 'required|string|regex:/^08[1-9][0-9]{7,}$/|unique:penggunas,nomor_telepon',
            'pin' => 'required|digits:4',
            'confirm_pin' => 'required|same:pin',
            'umur' => 'required|integer|min:15|max:50',
            'jenis_kelamin' => 'required|in:P',
            'pekerjaan' => 'required|string|max:255',
            'pendidikan_terakhir' => 'required|in:SD,SMP,SMA/SMK,D3,S1,S2,S3',
            'alamat' => 'required|string|min:10',
            'usia_kehamilan' => 'nullable|integer|min:1|max:42',
            'hamil_anak_ke' => 'nullable|integer|min:1',
            'jumlah_anak' => 'nullable|integer|min:0',
            'terms' => 'required|accepted'
        ], [
            'fullname.required' => 'Nama lengkap harus diisi',
            'fullname.min' => 'Nama minimal 3 karakter',
            'phone.required' => 'Nomor telepon harus diisi',
            'phone.regex' => 'Format nomor telepon tidak valid. Contoh: 081234567890',
            'phone.unique' => 'Nomor telepon sudah terdaftar',
            'pin.required' => 'PIN harus diisi',
            'pin.digits' => 'PIN harus 4 digit angka',
            'confirm_pin.required' => 'Konfirmasi PIN harus diisi',
            'confirm_pin.same' => 'Konfirmasi PIN tidak cocok',
            'umur.required' => 'Umur harus diisi',
            'umur.min' => 'Umur minimal 15 tahun',
            'umur.max' => 'Umur maksimal 50 tahun',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'pekerjaan.required' => 'Pekerjaan harus diisi',
            'pendidikan_terakhir.required' => 'Pendidikan terakhir harus dipilih',
            'alamat.required' => 'Alamat harus diisi',
            'alamat.min' => 'Alamat minimal 10 karakter',
            'usia_kehamilan.min' => 'Usia kehamilan minimal 1 minggu',
            'usia_kehamilan.max' => 'Usia kehamilan maksimal 42 minggu',
            'hamil_anak_ke.min' => 'Hamil anak ke minimal 1',
            'jumlah_anak.min' => 'Jumlah anak minimal 0',
            'terms.required' => 'Anda harus menyetujui syarat dan ketentuan',
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan'
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed:', $validator->errors()->toArray());
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Create new user with hashed PIN
            $pengguna = Pengguna::create([
                'nama_lengkap' => $request->fullname,
                'nomor_telepon' => $request->phone,
                'pin' => Hash::make($request->pin),
                'umur' => $request->umur,
                'jenis_kelamin' => $request->jenis_kelamin,
                'pekerjaan' => $request->pekerjaan,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'alamat' => $request->alamat,
                'usia_kehamilan' => $request->usia_kehamilan,
                'hamil_anak_ke' => $request->hamil_anak_ke,
                'jumlah_anak' => $request->jumlah_anak ?? 0
            ]);

            Log::info('User created:', ['id' => $pengguna->id]);

            // Log in the user automatically after registration
            Auth::login($pengguna);
            Session::put('pengguna', $pengguna);
            Session::put('user_id', $pengguna->id);

            return redirect()->route('pengguna.home')->with('success', 'Registrasi berhasil! Selamat datang ' . $pengguna->nama_lengkap);

        } catch (\Exception $e) {
            Log::error('Registration error:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])->withInput();
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $userId = Auth::guard('web')->id();

        Auth::guard('web')->logout();

        if ($userId) {
            DB::table('penggunas')
                ->where('id', $userId)
                ->update(['remember_token' => null]);
        }

        $request->session()->regenerateToken();
        $request->session()->forget(['pengguna', 'user_id']);

        return redirect()->route('login')
            ->with('success', 'Logout berhasil.');
    }
}