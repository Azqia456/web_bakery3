<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {

    // OWNER
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // PELANGGAN
    Route::get('/pelanggan/dashboard_pelanggan', [DashboardController::class, 'pelanggan']);

    // API
    Route::get('/api/dashboard/stats', [DashboardController::class, 'getStats']);
    Route::get('/api/pelanggan/dashboard_pelanggan/stats', [DashboardController::class, 'getPelangganStats']);

    // PESANAN
    Route::get('/pelanggan/pesanan', [PesananController::class, 'pelangganView']);
    Route::get('/pesanan', [PesananController::class, 'view']);
});