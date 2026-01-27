<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Debug: log request
        Log::info('Login attempt', $request->all());

        // Validate input
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

        // Find user by nama_lengkap
        $pengguna = Pengguna::where('nama_lengkap', $request->fullname)->first();

        Log::info('User found:', $pengguna ? ['id' => $pengguna->id, 'name' => $pengguna->nama_lengkap] : ['message' => 'User not found']);

        // Check if user exists
        if (!$pengguna) {
            return back()->withErrors([
                'login_error' => 'Nama lengkap tidak ditemukan.'
            ])->withInput();
        }

        // Check PIN
        $pinMatch = Hash::check($request->pin, $pengguna->pin);
        Log::info('PIN match:', ['input' => $request->pin, 'stored' => $pengguna->pin, 'match' => $pinMatch]);

        if (!$pinMatch) {
            return back()->withErrors([
                'login_error' => 'PIN salah.'
            ])->withInput();
        }

        // Log in the user
        Auth::login($pengguna);

        // Store user data in session
        Session::put('pengguna', $pengguna);
        Session::put('user_id', $pengguna->id);

        Log::info('Login successful:', ['user_id' => $pengguna->id]);

        // Redirect to dashboard
        return redirect()->route('dashboard')->with('success', 'Login berhasil! Selamat datang ' . $pengguna->nama_lengkap);
    }

    /**
     * Show registration form
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
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
            'jenis_kelamin' => 'required|in:L,P',
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

            return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang ' . $pengguna->nama_lengkap);

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
        $userId = Auth::id();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('Logout successful:', ['user_id' => $userId]);

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Show dashboard
     */
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $pengguna = Auth::user();
        return view('pengguna.dashboard.index', compact('pengguna'));
    }
}