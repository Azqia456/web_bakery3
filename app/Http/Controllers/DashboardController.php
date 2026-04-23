<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function getStats()
    {
        return response()->json([
            'summary_cards' => [
                [
                    'title' => 'Total Pemesanan',
                    'value' => 1248,
                    'change' => '+12%',
                    'change_type' => 'positive',
                    'icon' => 'fas fa-shopping-cart',
                    'color' => 'blue'
                ],
                [
                    'title' => 'Pendapatan Bulan Ini',
                    'value' => 'Rp 45.2M',
                    'change' => '+8%',
                    'change_type' => 'positive',
                    'icon' => 'fas fa-dollar-sign',
                    'color' => 'green'
                ],
                [
                    'title' => 'Pesanan Belum Lunas',
                    'value' => 156,
                    'change' => '-5%',
                    'change_type' => 'negative',
                    'icon' => 'fas fa-exclamation-triangle',
                    'color' => 'orange'
                ],
                [
                    'title' => 'Setoran Karyawan',
                    'value' => 'Rp 12.8M',
                    'change' => '+15%',
                    'change_type' => 'positive',
                    'icon' => 'fas fa-coins',
                    'color' => 'purple'
                ]
            ],
            'orders_chart' => [
                'labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                'data' => [145, 168, 192, 178, 203, 187, 175]
            ],
            'customers_list' => [
                [
                    'name' => 'Sarah Johnson',
                    'avatar' => 'SJ',
                    'orders_count' => 24,
                    'last_order' => '10 menit lalu',
                    'category' => 'VIP'
                ],
                [
                    'name' => 'Mike Chen',
                    'avatar' => 'MC',
                    'orders_count' => 18,
                    'last_order' => '25 menit lalu',
                    'category' => 'Regular'
                ],
                [
                    'name' => 'Emma Wilson',
                    'avatar' => 'EW',
                    'orders_count' => 12,
                    'last_order' => '1 jam lalu',
                    'category' => 'New'
                ],
                [
                    'name' => 'David Brown',
                    'avatar' => 'DB',
                    'orders_count' => 31,
                    'last_order' => '2 jam lalu',
                    'category' => 'VIP'
                ],
                [
                    'name' => 'Lisa Garcia',
                    'avatar' => 'LG',
                    'orders_count' => 8,
                    'last_order' => '3 jam lalu',
                    'category' => 'Regular'
                ]
            ],
            'deposits_chart' => [
                'labels' => ['Ahmad S.', 'Siti R.', 'Budi K.', 'Maya L.', 'Rian P.'],
                'data' => [2800000, 2400000, 2200000, 2100000, 1900000]
            ],
            'deposits_list' => [
                [
                    'name' => 'Ahmad S.',
                    'date' => '2026-04-23',
                    'amount' => 2800000,
                    'status' => 'Sudah Disetor'
                ],
                [
                    'name' => 'Siti R.',
                    'date' => '2026-04-23',
                    'amount' => 2400000,
                    'status' => 'Sudah Disetor'
                ],
                [
                    'name' => 'Budi K.',
                    'date' => '2026-04-23',
                    'amount' => 2200000,
                    'status' => 'Sudah Disetor'
                ],
                [
                    'name' => 'Maya L.',
                    'date' => '2026-04-23',
                    'amount' => 2100000,
                    'status' => 'Sudah Disetor'
                ],
                [
                    'name' => 'Rian P.',
                    'date' => '2026-04-23',
                    'amount' => 1900000,
                    'status' => 'Sudah Disetor'
                ]
            ],
            'statistics' => [
                [
                    'label' => 'Total Produk',
                    'value' => 1258,
                    'icon' => 'fas fa-box',
                    'color' => 'blue'
                ],
                [
                    'label' => 'Total Karyawan',
                    'value' => 24,
                    'icon' => 'fas fa-user-tie',
                    'color' => 'green'
                ],
                [
                    'label' => 'Total Pelanggan',
                    'value' => 3547,
                    'icon' => 'fas fa-users',
                    'color' => 'purple'
                ],
                [
                    'label' => 'Pesanan Hari Ini',
                    'value' => 284,
                    'icon' => 'fas fa-calendar-day',
                    'color' => 'orange'
                ]
            ]
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }
}
