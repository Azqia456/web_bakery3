<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Pesanan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.dashboard-layout', function ($view) {
            $view->with('pesananOnlineBadge', Pesanan::where('sumber_pesanan', 'online')
                ->where('status_pesanan', 'menunggu_konfirmasi')
                ->count());

            $view->with('pesananOfflineBadge',
                Pesanan::where('sumber_pesanan', 'offline')
                    ->whereNotNull('id_karyawan')
                    ->where('status_bayar', 'belum_lunas')
                    ->count()
                +
                Pesanan::where('sumber_pesanan', 'offline')
                    ->whereNotNull('id_pelanggan')
                    ->whereNull('id_karyawan')
                    ->where('status_pembayaran', 'belum_bayar')
                    ->count()
            );
        });
    }
}
