<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataPelangganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\PelangganProfileController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PasswordResetController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password Reset Routes (OTP-based)
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('/forgot-password', [PasswordResetController::class, 'requestPasswordReset'])->name('password.email');
    
    Route::get('/verify-otp', [PasswordResetController::class, 'showVerifyOtpForm'])->name('verify-otp');
    Route::post('/verify-otp', [PasswordResetController::class, 'verifyOtp'])->name('password.verify-otp');
    Route::post('/resend-otp', [PasswordResetController::class, 'resendOtp'])->name('password.resend-otp');
    
    Route::get('/reset-password', [PasswordResetController::class, 'showResetPasswordForm'])->name('reset-password');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.reset');
});

Route::post('/logout', [AuthController::class, 'logout'])
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

    // Email verification via OTP (custom endpoints)
    Route::post('/email/send-otp', [\App\Http\Controllers\Auth\EmailVerificationOtpController::class, 'sendOtp'])->name('email.send-otp');
    Route::post('/email/verify-otp', [\App\Http\Controllers\Auth\EmailVerificationOtpController::class, 'verifyOtp'])->name('email.verify-otp');
});

// Protected Routes
Route::middleware('auth')->group(function () {

    // OWNER
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('role:owner')->name('dashboard');

    // PELANGGAN
    Route::get('/pelanggan/dashboard_pelanggan', [DashboardController::class, 'pelanggan'])->middleware('role:pelanggan')->name('pelanggan.dashboard');
    Route::get('/pelanggan/profile', [PelangganProfileController::class, 'edit'])->middleware('role:pelanggan')->name('pelanggan.profile.edit');
    Route::patch('/pelanggan/profile', [PelangganProfileController::class, 'update'])->middleware('role:pelanggan')->name('pelanggan.profile.update');
    Route::post('/pelanggan/pembayaran/konfirmasi', [PesananController::class, 'confirmPaymentProof'])
        ->middleware('role:pelanggan')
        ->name('pelanggan.pembayaran.konfirmasi');

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
    Route::get('/data-pelanggan', [DataPelangganController::class, 'index'])->name('data-pelanggan');
    
    // PELANGGAN AJAX ENDPOINTS
    Route::post('/api/pelanggans', [DataPelangganController::class, 'store'])->name('pelanggans.store');
    Route::get('/api/pelanggans/{id_pelanggan}', [DataPelangganController::class, 'show'])->name('pelanggans.show');
    Route::put('/api/pelanggans/{id_pelanggan}', [DataPelangganController::class, 'update'])->name('pelanggans.update');
    Route::delete('/api/pelanggans/{id_pelanggan}', [DataPelangganController::class, 'destroy'])->name('pelanggans.destroy');
    Route::get('/api/pelanggans-autocomplete', [DataPelangganController::class, 'autocomplete'])->name('pelanggans.autocomplete');
    Route::post('/api/pelanggans/find-or-create', [DataPelangganController::class, 'findOrCreateForOfflineOrder'])->name('pelanggans.findOrCreate');
    Route::get('/api/pelanggans-stats', [DataPelangganController::class, 'statistics'])->name('pelanggans.statistics');

    // KARYAWAN AJAX ENDPOINTS
    Route::post('/api/karyawans', [KaryawanController::class, 'store'])->name('karyawans.store');
    Route::get('/api/karyawans/{id_karyawan}', [KaryawanController::class, 'show'])->name('karyawans.show');
    Route::put('/api/karyawans/{id_karyawan}', [KaryawanController::class, 'update'])->name('karyawans.update');
    Route::delete('/api/karyawans/{id_karyawan}', [KaryawanController::class, 'destroy'])->name('karyawans.destroy');

    // PRODUK
    Route::get('/produk', [DashboardController::class, 'produk'])->name('produk');

    // PEMBAYARAN
    Route::get('/stor-karyawan', [DashboardController::class, 'storKaryawan'])->name('stor-karyawan');
    Route::get('/riwayat-transaksi', [DashboardController::class, 'riwayatTransaksi'])->name('riwayat-transaksi');

    // LAPORAN
    Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan');
    Route::get('/laporan-penjualan', function () {
        return view('laporan_penjualan');
    })->name('laporan-penjualan');
    Route::get('/laporan-pesanan-online', function () {
        return view('laporan_pesanan_online');
    })->name('laporan-pesanan-online');
    Route::get('/laporan-pesanan-offline', function () {
        return view('laporan_pesanan_offline');
    })->name('laporan-pesanan-offline');
    Route::get('/laporan-pembayaran', function () {
        return view('laporan_pembayaran');
    })->name('laporan-pembayaran');
    Route::get('/laporan-setoran-karyawan', function () {
        return view('laporan_setoran_karyawan');
    })->name('laporan-setoran-karyawan');
});