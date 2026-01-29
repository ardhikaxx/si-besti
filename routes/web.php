<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SleepTrackingController;
use App\Http\Controllers\QualityTestController;
use App\Http\Controllers\MurottalController;

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

    // Sleep Tracking Routes
    Route::prefix('sleep-tracking')->name('pengguna.sleep-tracking.')->group(function () {
        Route::get('/', [SleepTrackingController::class, 'index'])->name('index');
        Route::get('/statistics', [SleepTrackingController::class, 'getStatistics'])->name('statistics');
        Route::post('/', [SleepTrackingController::class, 'store'])->name('store');
        Route::get('/{id}', [SleepTrackingController::class, 'show'])->name('show');
        Route::put('/{id}', [SleepTrackingController::class, 'update'])->name('update');
        Route::delete('/{id}', [SleepTrackingController::class, 'destroy'])->name('destroy');
    });

    // Quality Test Routes
    Route::prefix('quality-test')->name('pengguna.quality-test.')->group(function () {
        Route::get('/', [QualityTestController::class, 'index'])->name('index');
        Route::get('/{type}', [QualityTestController::class, 'showTestPage'])->name('show'); // type: first atau last
        Route::post('/{type}', [QualityTestController::class, 'storeTest'])->name('store');
        Route::get('/{type}/edit', [QualityTestController::class, 'editTest'])->name('edit');
        Route::post('/confirm/{type}', [QualityTestController::class, 'confirmTest'])->name('confirm');
        Route::post('/start-new', [QualityTestController::class, 'startNewTest'])->name('start-new');
        Route::get('/result/{test}', [QualityTestController::class, 'viewResult'])->name('result');
    });

    // Murottal routes using controller
    // Route::get('/murottal', [MurottalController::class, 'index'])->name('pengguna.murottal');
    // Route::get('/murottal/{id}', [MurottalController::class, 'show'])->name('pengguna.murottal.show');

    // Murottal routes using controller
    Route::get('/murottal', [MurottalController::class, 'index'])->name('pengguna.murottal');
    Route::get('/murottal/show', [MurottalController::class, 'show'])->name('pengguna.murottal.show');

    Route::get('/profile', function () {
        return view('pengguna.profile.index');
    })->name('pengguna.profile');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});