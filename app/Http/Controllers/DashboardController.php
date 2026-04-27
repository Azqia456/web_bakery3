<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function pelanggan()
    {
        return view('dashboard.pelanggan');
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

    public function getPelangganStats()
    {
        return response()->json([
            'summary_cards' => [
                [
                    'title' => 'Pesanan Aktif Saya',
                    'value' => 3,
                    'change' => '+1 pesanan baru',
                    'change_type' => 'positive',
                    'icon' => 'fas fa-box-open',
                    'color' => 'blue'
                ],
                [
                    'title' => 'Status Pembayaran',
                    'value' => '1 Belum Lunas',
                    'change' => 'Perlu ditindaklanjuti',
                    'change_type' => 'negative',
                    'icon' => 'fas fa-wallet',
                    'color' => 'orange'
                ],
                [
                    'title' => 'Total Belanja Bulan Ini',
                    'value' => 'Rp 1.250.000',
                    'change' => '+12% dari bulan lalu',
                    'change_type' => 'positive',
                    'icon' => 'fas fa-shopping-bag',
                    'color' => 'green'
                ],
                [
                    'title' => 'Estimasi Pengiriman',
                    'value' => '2 Hari',
                    'change' => 'Rata-rata lebih cepat',
                    'change_type' => 'positive',
                    'icon' => 'fas fa-truck',
                    'color' => 'purple'
                ]
            ],
            'orders_chart' => [
                'labels' => ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                'data' => [1, 2, 1, 3, 2, 4, 3]
            ],
            'orders_list' => [
                [
                    'kode' => 'ORD-260401',
                    'tanggal' => '2026-04-24',
                    'produk' => 'Roti Coklat Premium',
                    'total' => 'Rp 350.000',
                    'status_pesanan' => 'Diproses',
                    'status_bayar' => 'Lunas'
                ],
                [
                    'kode' => 'ORD-260395',
                    'tanggal' => '2026-04-22',
                    'produk' => 'Cake Ulang Tahun',
                    'total' => 'Rp 650.000',
                    'status_pesanan' => 'Dikirim',
                    'status_bayar' => 'Lunas'
                ],
                [
                    'kode' => 'ORD-260388',
                    'tanggal' => '2026-04-20',
                    'produk' => 'Pastry Box',
                    'total' => 'Rp 250.000',
                    'status_pesanan' => 'Menunggu Konfirmasi',
                    'status_bayar' => 'Belum Lunas'
                ]
            ],
            'status_ringkasan' => [
                [
                    'label' => 'Diproses',
                    'value' => 1,
                    'class' => 'warning'
                ],
                [
                    'label' => 'Dikirim',
                    'value' => 1,
                    'class' => 'info'
                ],
                [
                    'label' => 'Belum Lunas',
                    'value' => 1,
                    'class' => 'warning'
                ],
                [
                    'label' => 'Lunas',
                    'value' => 2,
                    'class' => 'success'
                ]
            ]
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }
}
