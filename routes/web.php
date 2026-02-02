<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SleepTrackingController;
use App\Http\Controllers\QualityTestController;
use App\Http\Controllers\MurottalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\DataIbuController;
use App\Http\Controllers\SleepTrackingAdminController;

Route::get('/', function () {
    return redirect()->route('login');
});


// ==================== ROUTES PENGGUNA ====================

// Login & Register (PUBLIC)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


// ==================== PROTECTED PENGGUNA ====================
Route::middleware(['pengguna'])->group(function () {

    Route::get('/dashboard', [HomeController::class, 'index'])
        ->name('pengguna.home');

    // ===== Sleep Tracking =====
    Route::prefix('sleep-tracking')->name('pengguna.sleep-tracking.')->group(function () {
        Route::get('/', [SleepTrackingController::class, 'index'])->name('index');
        Route::get('/statistics', [SleepTrackingController::class, 'getStatistics'])->name('statistics');
        Route::post('/', [SleepTrackingController::class, 'store'])->name('store');
        Route::get('/{id}', [SleepTrackingController::class, 'show'])->name('show');
        Route::put('/{id}', [SleepTrackingController::class, 'update'])->name('update');
        Route::delete('/{id}', [SleepTrackingController::class, 'destroy'])->name('destroy');
    });

    // ===== Quality Test =====
    Route::prefix('quality-test')->name('pengguna.quality-test.')->group(function () {
        Route::get('/', [QualityTestController::class, 'index'])->name('index');
        Route::get('/result', [QualityTestController::class, 'allResults'])->name('result');
        Route::get('/result/{test}', [QualityTestController::class, 'viewResult'])->name('result-detail');
        Route::get('/test/{type}', [QualityTestController::class, 'showTestPage'])->name('show');
        Route::post('/test/{type}', [QualityTestController::class, 'storeTest'])->name('store');
        Route::get('/test/{type}/edit', [QualityTestController::class, 'editTest'])->name('edit');
        Route::post('/confirm/{type}', [QualityTestController::class, 'confirmTest'])->name('confirm');
        Route::post('/start-new', [QualityTestController::class, 'startNewTest'])->name('start-new');
    });

    // ===== Murottal =====
    Route::get('/murottal', [MurottalController::class, 'index'])->name('pengguna.murottal');
    Route::get('/murottal/show', [MurottalController::class, 'show'])->name('pengguna.murottal.show');

    // ===== Profile =====
    Route::prefix('profile')->name('pengguna.profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
    });

    // ===== Logout Pengguna =====
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


// ==================== ROUTES ADMIN ====================
Route::prefix('admin')->group(function () {

    // Public admin
    Route::get('/login', [AuthAdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthAdminController::class, 'login'])->name('admin.login.post');

    // Protected admin
    Route::middleware(['admin'])->group(function () {

        Route::prefix('data-ibu')->group(function () {
            Route::get('/', [DataIbuController::class, 'index'])->name('admin.data-ibu');
            Route::get('/{id}/detail', [DataIbuController::class, 'getDetail'])->name('admin.data-ibu.detail');
            Route::post('/{id}/status', [DataIbuController::class, 'updateStatus'])->name('admin.data-ibu.status');
            Route::delete('/{id}', [DataIbuController::class, 'destroy'])->name('admin.data-ibu.destroy');
            Route::get('/statistics', [DataIbuController::class, 'getStatistics'])->name('admin.data-ibu.statistics');
        });

        Route::prefix('sleep-tracking')->group(function () {
            Route::get('/', [SleepTrackingAdminController::class, 'index'])->name('admin.sleep-tracking');
            Route::get('/statistics', [SleepTrackingAdminController::class, 'getStatistics'])->name('admin.sleep-tracking.statistics');
            Route::get('/{id}/details', [SleepTrackingAdminController::class, 'getUserSleepDetails'])->name('admin.sleep-tracking.details');
        });

        Route::get('/profile', [AuthAdminController::class, 'profile'])->name('admin.profile');
        Route::put('/profile/update', [AuthAdminController::class, 'updateProfile'])->name('admin.profile.update');
        Route::post('/profile/update-password-modal', [AuthAdminController::class, 'updatePasswordModal'])->name('admin.password.update.modal');

        Route::post('/logout', [AuthAdminController::class, 'logout'])->name('admin.logout');
    });
});
