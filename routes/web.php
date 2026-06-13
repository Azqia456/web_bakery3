<?php

use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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
use App\Models\Pesanan;
use Carbon\Carbon;

Route::get('/', [WelcomeController::class, 'index']);

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Email Verification after Registration
    Route::get('/register/verify', [AuthController::class, 'showVerifyEmailRegistration'])->name('register.verify');
    Route::post('/register/verify', [AuthController::class, 'verifyEmailRegistration'])->name('register.verify.submit');
    Route::post('/register/verify/resend', [AuthController::class, 'resendRegisterOtp'])->name('register.verify.resend');

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
    Route::get('/pelanggan/produk', [DashboardController::class, 'produkPelanggan'])->middleware('role:pelanggan')->name('pelanggan.produk');
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
    Route::get('/pelanggan/pesanan/data', [PesananController::class, 'pelangganOrders'])->middleware('role:pelanggan');
    Route::post('/pelanggan/pesanan', [PesananController::class, 'createPelangganOrder'])->middleware('role:pelanggan')->name('pelanggan.pesanan.store');
    Route::get('/pesanan', [PesananController::class, 'view'])->middleware('role:owner')->name('pesanan');
    Route::get('/pesanan-offline', [PesananController::class, 'offline'])->name('pesanan-offline');
    Route::post('/pesanan-offline', [App\Http\Controllers\PesananOfflineController::class, 'store'])->middleware('role:owner');
    Route::put('/pesanan-offline/{id_pesanan}', [App\Http\Controllers\PesananOfflineController::class, 'update'])->middleware('role:owner');
    Route::delete('/pesanan-offline/{id_pesanan}', [App\Http\Controllers\PesananOfflineController::class, 'destroy'])->middleware('role:owner');
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

    // PESANAN AJAX ENDPOINTS
    Route::get('/api/pesanan/{id_pesanan}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::post('/api/pesanan/{id_pesanan}/submit', [PesananController::class, 'submitOrder'])->name('pesanan.submit');

    // KARYAWAN AJAX ENDPOINTS
    Route::post('/api/karyawans', [KaryawanController::class, 'store'])->name('karyawans.store');
    Route::get('/api/karyawans-export', [KaryawanController::class, 'export'])->name('karyawans.export');
    Route::get('/api/karyawans-autocomplete', [KaryawanController::class, 'autocomplete'])->name('karyawans.autocomplete');
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
    Route::get('/laporan-penjualan', [DashboardController::class, 'laporanPenjualan'])->name('laporan-penjualan');
    Route::get('/laporan-pesanan-online', [DashboardController::class, 'laporanPesananOnline'])->name('laporan-pesanan-online');
    Route::get('/laporan-pesanan-online/export', function (Request $request) {
        $startDate = $request->input('start_date', now()->subDays(6)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $pesananData = Pesanan::with(['pelanggan', 'detailPesanans.produk'])
            ->where('sumber_pesanan', 'online')
            ->where('status_pembayaran', 'lunas')
            ->whereBetween('tgl_pesan', [$start, $end])
            ->orderBy('tgl_pesan', 'desc')
            ->get()
            ->map(function ($p) {
                $produk = $p->detailPesanans->pluck('produk.nama_produk')->filter()->implode(', ') ?: '-';
                $statusLabel = match($p->status_pesanan) {
                    'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                    'diproses' => 'Diproses',
                    'siap_diambil' => 'Siap Diambil',
                    'dikirim' => 'Dikirim',
                    'selesai' => 'Selesai',
                    default => $p->status_pesanan ?? '-',
                };
                return [
                    '#ON-' . $p->tgl_pesan->format('dmY') . '-' . str_pad($p->id_pesanan, 3, '0', STR_PAD_LEFT),
                    $p->pelanggan->nama ?? '-',
                    $produk,
                    (float) $p->total_bayar,
                    $p->created_at->format('Y-m-d H:i'),
                    'Lunas',
                    'Pelanggan',
                    $statusLabel,
                ];
            });

        $filename = 'laporan-pesanan-online-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($pesananData) {
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($output, ['No. Pesanan', 'Nama', 'Produk', 'Total', 'Orderan Dibuat', 'Status Bayar', 'Tipe Pesanan', 'Status']);

            foreach ($pesananData as $row) {
                fputcsv($output, $row);
            }

            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    })->name('laporan-pesanan-online.export');
    // Route::get('/laporan-pesanan-offline', [DashboardController::class, 'laporanPesananOffline'])->name('laporan-pesanan-offline');
    Route::get('/laporan-pembayaran', function () {
        return view('laporan_pembayaran');
    })->name('laporan-pembayaran');
    Route::get('/laporan-pesanan-offline', function (Request $request) {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $tipe = $request->input('tipe', 'semua');

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // Karyawan: offline, id_karyawan NOT NULL, status_bayar = lunas
        $qKaryawan = Pesanan::with(['karyawan', 'detailPesanans.produk'])
            ->where('sumber_pesanan', 'offline')
            ->whereNotNull('id_karyawan')
            ->where('status_bayar', 'lunas')
            ->whereBetween('tgl_pesan', [$start, $end]);

        // Pelanggan: offline, id_pelanggan NOT NULL, status_pembayaran = lunas
        $qPelanggan = Pesanan::with(['pelanggan', 'detailPesanans.produk'])
            ->where('sumber_pesanan', 'offline')
            ->whereNotNull('id_pelanggan')
            ->where('status_pembayaran', 'lunas')
            ->whereBetween('tgl_pesan', [$start, $end]);

        // Stats: aggregate sebelum filter tipe
        $totalSetoran = (clone $qKaryawan)->sum('total_bayar') + (clone $qPelanggan)->sum('total_bayar');
        $jumlahSetoran = (clone $qKaryawan)->count() + (clone $qPelanggan)->count();

        $mapKaryawan = function ($p) {
            $produk = $p->detailPesanans->pluck('produk.nama_produk')->filter()->implode(', ') ?: '-';
            return [
                'no_pesanan' => '#OFF-' . $p->tgl_pesan->format('dmY') . '-' . str_pad($p->id_pesanan, 3, '0', STR_PAD_LEFT),
                'nama' => $p->karyawan->nama ?? '-',
                'produk' => $produk,
                'total' => (float) $p->total_bayar,
                'created_at' => $p->created_at->format('Y-m-d H:i'),
                'status_bayar' => 'Lunas',
                'tipe' => 'Karyawan',
                'status' => 'Sudah Setor',
            ];
        };

        $mapPelanggan = function ($p) {
            $produk = $p->detailPesanans->pluck('produk.nama_produk')->filter()->implode(', ') ?: '-';
            $statusPesanan = $p->status_pesanan;
            $statusLabel = match($statusPesanan) {
                'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                'diproses' => 'Diproses',
                'siap_diambil' => 'Siap Diambil',
                'dikirim' => 'Dikirim',
                'selesai' => 'Selesai',
                default => $statusPesanan ?? '-',
            };
            return [
                'no_pesanan' => '#OFF-' . $p->tgl_pesan->format('dmY') . '-' . str_pad($p->id_pesanan, 3, '0', STR_PAD_LEFT),
                'nama' => $p->pelanggan->nama ?? '-',
                'produk' => $produk,
                'total' => (float) $p->total_bayar,
                'created_at' => $p->created_at->format('Y-m-d H:i'),
                'status_bayar' => 'Lunas',
                'tipe' => 'Pelanggan',
                'status' => $statusLabel,
            ];
        };

        if ($tipe === 'karyawan') {
            $setoranData = (clone $qKaryawan)->orderBy('tgl_pesan', 'desc')->get()->map($mapKaryawan)->values();
        } elseif ($tipe === 'pelanggan') {
            $setoranData = (clone $qPelanggan)->orderBy('tgl_pesan', 'desc')->get()->map($mapPelanggan)->values();
        } else {
            $karyawanData = (clone $qKaryawan)->get()->map($mapKaryawan);
            $pelangganData = (clone $qPelanggan)->get()->map($mapPelanggan);
            $setoranData = $karyawanData->concat($pelangganData)->sortByDesc('created_at')->values();
        }

        return view('laporan_setoran_karyawan', compact(
            'totalSetoran', 'jumlahSetoran', 'setoranData', 'startDate', 'endDate', 'tipe'
        ));
    })->name('laporan-pesanan-offline');

    Route::get('/laporan-pesanan-offline/export', function (Request $request) {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $tipe = $request->input('tipe', 'semua');

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $qKaryawan = Pesanan::with(['karyawan', 'detailPesanans.produk'])
            ->where('sumber_pesanan', 'offline')
            ->whereNotNull('id_karyawan')
            ->where('status_bayar', 'lunas')
            ->whereBetween('tgl_pesan', [$start, $end]);

        $qPelanggan = Pesanan::with(['pelanggan', 'detailPesanans.produk'])
            ->where('sumber_pesanan', 'offline')
            ->whereNotNull('id_pelanggan')
            ->where('status_pembayaran', 'lunas')
            ->whereBetween('tgl_pesan', [$start, $end]);

        $mapFn = function ($p, $tipe) {
            $produk = $p->detailPesanans->pluck('produk.nama_produk')->filter()->implode(', ') ?: '-';
            $no = '#OFF-' . $p->tgl_pesan->format('dmY') . '-' . str_pad($p->id_pesanan, 3, '0', STR_PAD_LEFT);
            if ($tipe === 'karyawan') {
                return [
                    $no,
                    $p->karyawan->nama ?? '-',
                    $produk,
                    (float) $p->total_bayar,
                    $p->created_at->format('Y-m-d H:i'),
                    'Lunas',
                    'Karyawan',
                    'Sudah Setor',
                ];
            }
            $statusLabel = match($p->status_pesanan) {
                'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                'diproses' => 'Diproses',
                'siap_diambil' => 'Siap Diambil',
                'dikirim' => 'Dikirim',
                'selesai' => 'Selesai',
                default => $p->status_pesanan ?? '-',
            };
            return [
                $no,
                $p->pelanggan->nama ?? '-',
                $produk,
                (float) $p->total_bayar,
                $p->created_at->format('Y-m-d H:i'),
                'Lunas',
                'Pelanggan',
                $statusLabel,
            ];
        };

        if ($tipe === 'karyawan') {
            $rows = (clone $qKaryawan)->orderBy('tgl_pesan', 'desc')->get()->map(fn($p) => $mapFn($p, 'karyawan'));
        } elseif ($tipe === 'pelanggan') {
            $rows = (clone $qPelanggan)->orderBy('tgl_pesan', 'desc')->get()->map(fn($p) => $mapFn($p, 'pelanggan'));
        } else {
            $k = (clone $qKaryawan)->get()->map(fn($p) => $mapFn($p, 'karyawan'));
            $p = (clone $qPelanggan)->get()->map(fn($p) => $mapFn($p, 'pelanggan'));
            $rows = $k->concat($p);
        }

        $filename = 'laporan-pesanan-offline-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($rows) {
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($output, ['No. Pesanan', 'Nama', 'Produk', 'Total', 'Orderan Dibuat', 'Status Bayar', 'Tipe Pesanan', 'Status']);
            foreach ($rows as $row) {
                fputcsv($output, $row);
            }
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    })->name('laporan-pesanan-offline.export');
});

Route::get('test-aja', function () {
    return Pesanan::with(['pelanggan', 'karyawan', 'detailPesanans', 'detailPesanans.produk'])
        ->where('id_pelanggan', \App\Models\Pelanggan::where('id_user', 7)->first()->id_pelanggan)
        ->orderBy('tgl_pesan', 'desc')
        ->get();

});