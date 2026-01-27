<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class MurottalController extends Controller
{
    /**
     * Display Ar-Rahman surah only
     */
    public function index(Request $request)
    {
        try {
            // Fetch only Ar-Rahman surah (nomor 55)
            $response = Http::get('https://quran-api.santrikoding.com/api/surah/55');
            
            if ($response->successful()) {
                $surah = $response->json();
                
                // Get authenticated user
                $user = Auth::user();
                
                return view('pengguna.murottal.index', compact('surah', 'user'));
            } else {
                return back()->with('error', 'Gagal mengambil data Surah Ar-Rahman');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display Ar-Rahman surah detail
     */
    public function show()
    {
        try {
            // Fetch Ar-Rahman surah detail from API
            $response = Http::get("https://quran-api.santrikoding.com/api/surah/55");
            
            if ($response->successful()) {
                $surah = $response->json();
                
                // Get authenticated user
                $user = Auth::user();
                
                return view('pengguna.murottal.show', compact('surah', 'user'));
            } else {
                return back()->with('error', 'Surah Ar-Rahman tidak ditemukan');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}