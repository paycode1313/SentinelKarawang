<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IncentiveController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\Admin\ActivityController as AdminActivityController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
// routes/web.php
use App\Http\Controllers\NotificationController;

Route::middleware(['auth'])->group(function () {
    // ... rute lainnya
    Route::get('/notifications', [NotificationController::class, 'index'])
         ->name('notifications.index');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Halaman Utama
Route::get('/', function () {
    return view('welcome');
});
// routes/web.php
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

/// Password Reset Routes
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

// Ubah route reset password tanpa token di URL
Route::get('/reset-password', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');


// Rute untuk Pengguna yang Sudah Login
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/sentinel-dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/monitoring-map', [MapController::class, 'index'])->name('map.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::prefix('incentives')->name('incentives.')->group(function () {
        Route::get('/', [IncentiveController::class, 'index'])->name('index');
        Route::get('/create-activity', [IncentiveController::class, 'createActivity'])->name('create-activity');
        Route::post('/store-activity', [IncentiveController::class, 'storeActivity'])->name('store-activity');
        Route::post('/{incentive}/claim', [IncentiveController::class, 'claimIncentive'])->name('claim');
        Route::get('/history', [IncentiveController::class, 'userHistory'])->name('history');
    });
});

// === RUTE ADMIN PANEL ===
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/activities', [AdminActivityController::class, 'index'])->name('activities.index');
    
    // RUTE BARU UNTUK APPROVE & REJECT
    Route::post('/activities/{activity}/approve', [AdminActivityController::class, 'approve'])->name('activities.approve');
    Route::post('/activities/{activity}/reject', [AdminActivityController::class, 'reject'])->name('activities.reject');
});


// Rute Otentikasi Bawaan
require __DIR__.'/auth.php';