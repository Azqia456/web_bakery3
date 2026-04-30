<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\PasswordController;

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

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/orders', function () {
        return redirect()->route('pesanan');
    });

    Route::get('/customers', function () {
        return redirect()->route('pelanggan.dashboard');
    });

    Route::get('/employees', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/products', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/payments', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/reports', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/settings', function () {
        return redirect()->route('profile.edit');
    });

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
});

// Protected Routes
Route::middleware('auth')->group(function () {

    // OWNER
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('role:owner')->name('dashboard');

    // PELANGGAN
    Route::get('/pelanggan/dashboard_pelanggan', [DashboardController::class, 'pelanggan'])->middleware('role:pelanggan')->name('pelanggan.dashboard');

    // API
    Route::get('/api/dashboard/stats', [DashboardController::class, 'getStats'])->middleware('role:owner');
    Route::get('/api/pelanggan/dashboard_pelanggan/stats', [DashboardController::class, 'getPelangganStats'])->middleware('role:pelanggan');

    // PESANAN
    Route::get('/pelanggan/pesanan', [PesananController::class, 'pelangganView'])->middleware('role:pelanggan');
    Route::get('/pesanan', [PesananController::class, 'view'])->middleware('role:owner')->name('pesanan');
    Route::get('/pesanan-offline', [PesananController::class, 'offline'])->name('pesanan-offline');
    Route::get('/pesanan-online', [PesananController::class, 'online'])->name('pesanan-online');

    // DATA
    Route::get('/data-karyawan', [DashboardController::class, 'dataKaryawan'])->name('data-karyawan');
    Route::get('/data-pelanggan', [DashboardController::class, 'dataPelanggan'])->name('data-pelanggan');

    // PRODUK
    Route::get('/produk', [DashboardController::class, 'produk'])->name('produk');

    // PEMBAYARAN
    Route::get('/stor-karyawan', [DashboardController::class, 'storKaryawan'])->name('stor-karyawan');
    Route::get('/riwayat-transaksi', [DashboardController::class, 'riwayatTransaksi'])->name('riwayat-transaksi');

    // LAPORAN
    Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan');
});