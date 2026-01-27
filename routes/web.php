<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Register routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('pengguna.dashboard');
    Route::get('/sleep-tracking', function () {
        return view('pengguna.sleep-tracking.index');
    })->name('pengguna.sleep-tracking');
    Route::get('/quality-test', function () {
        return view('pengguna.quality-test.index');
    })->name('pengguna.quality-test');
    Route::get('/murottal', function () {
        return view('pengguna.murottal.index');
    })->name('pengguna.murottal');
    Route::get('/profile', function () {
        return view('pengguna.profile.index');
    })->name('pengguna.profile');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});