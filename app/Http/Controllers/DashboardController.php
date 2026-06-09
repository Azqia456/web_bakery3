<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Pesanan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Summary cards
        $totalPemesanan = Pesanan::count();
        $pendapatanBulanIni = Pesanan::whereBetween('tgl_pesan', [$startOfMonth, $endOfMonth])->sum('total_bayar') ?? 0;
        $pesananBelumLunas = Pesanan::where('status_bayar', 'belum_lunas')->count();
        $setoranKaryawan = Pesanan::whereNotNull('id_karyawan')
            ->whereNull('id_pelanggan')
            ->sum('total_bayar') ?? 0;

        // Statistics
        $totalProduk = \App\Models\Produk::where('status', 'Aktif')->count();
        $totalKaryawan = Karyawan::where('status', 'Aktif')->count();
        $totalPelanggan = \App\Models\Pelanggan::count();
        $pesananHariIni = Pesanan::whereDate('tgl_pesan', $today)->count();

        // Orders chart (last 7 days)
        $ordersChartLabels = [];
        $ordersChartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $ordersChartLabels[] = $date->isoFormat('ddd');
            $ordersChartData[] = Pesanan::whereDate('tgl_pesan', $date)->count();
        }

        // Top customers (by order count)
        $topCustomers = \App\Models\Pelanggan::withCount('pesanans')
            ->orderBy('pesanans_count', 'desc')
            ->limit(5)
            ->get();

        // Deposits chart (top karyawan by setoran)
        $topKaryawan = Karyawan::where('status', 'Aktif')
            ->withSum('pesanans', 'total_bayar')
            ->orderBy('pesanans_sum_total_bayar', 'desc')
            ->limit(5)
            ->get();

        $depositsChartLabels = [];
        $depositsChartData = [];
        foreach ($topKaryawan as $karyawan) {
            $depositsChartLabels[] = $karyawan->nama;
            $depositsChartData[] = $karyawan->pesanans_sum_total_bayar ?? 0;
        }

        // Recent deposits
        $recentDeposits = Pesanan::whereNotNull('id_karyawan')
            ->whereNull('id_pelanggan')
            ->with('karyawan')
            ->orderBy('tgl_pesan', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalPemesanan',
            'pendapatanBulanIni',
            'pesananBelumLunas',
            'setoranKaryawan',
            'totalProduk',
            'totalKaryawan',
            'totalPelanggan',
            'pesananHariIni',
            'ordersChartLabels',
            'ordersChartData',
            'topCustomers',
            'depositsChartLabels',
            'depositsChartData',
            'recentDeposits'
        ));
    }

    public function pelanggan()
    {
        return view('pelanggan.dashboard_pelanggan');
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
                    'status_pesanan' => 'Diproses'
                ],
                [
                    'kode' => 'ORD-260395',
                    'tanggal' => '2026-04-22',
                    'produk' => 'Cake Ulang Tahun',
                    'total' => 'Rp 650.000',
                    'status_pesanan' => 'Dikirim'
                ],
                [
                    'kode' => 'ORD-260388',
                    'tanggal' => '2026-04-20',
                    'produk' => 'Pastry Box',
                    'total' => 'Rp 250.000',
                    'status_pesanan' => 'Menunggu Konfirmasi'
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
                    'label' => 'Menunggu Konfirmasi',
                    'value' => 1,
                    'class' => 'warning'
                ]
            ]
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    public function dataKaryawan()
    {
        // dd("masuk ke data karyawan");
        $karyawans = Karyawan::paginate(10);
        
        $total = Karyawan::count();
        $aktif = Karyawan::where('status', 'Aktif')->count();
        $nonaktif = Karyawan::where('status', 'Nonaktif')->count();
        
        return view('data-karyawan', compact('karyawans', 'total', 'aktif', 'nonaktif'));
    }

    public function dataPelanggan()
    {
        return view('data-pelanggan');
    }

    public function produk()
    {
        return view('produk');
    }

    public function storKaryawan()
    {
        return view('stor-karyawan');
    }

    public function riwayatTransaksi(Request $request)
    {
        $query = Pesanan::with(['pelanggan', 'karyawan', 'detailPesanans.produk'])
            ->orderBy('tgl_pesan', 'desc');

        // Filter by tipe (pelanggan/karyawan)
        if ($request->filled('tipe')) {
            if ($request->tipe === 'pelanggan') {
                $query->whereNotNull('id_pelanggan');
            } elseif ($request->tipe === 'karyawan') {
                $query->whereNull('id_pelanggan')->whereNotNull('id_karyawan');
            }
        }

        // Filter by sumber (online/offline)
        if ($request->filled('sumber')) {
            if ($request->sumber === 'setor') {
                $query->whereNull('id_pelanggan')->whereNotNull('id_karyawan');
            } else {
                $query->where('sumber_pesanan', $request->sumber);
            }
        }

        // Filter by metode pembayaran
        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id_pesanan', 'like', "%{$search}%")
                  ->orWhereHas('pelanggan', function ($pq) use ($search) {
                      $pq->where('nama', 'like', "%{$search}%")
                         ->orWhere('no_tlp', 'like', "%{$search}%");
                  })
                  ->orWhereHas('karyawan', function ($kq) use ($search) {
                      $kq->where('nama', 'like', "%{$search}%")
                         ->orWhere('no_tlp', 'like', "%{$search}%");
                  });
            });
        }

        $pesanans = $query->paginate(15)->withQueryString();

        // Calculate stats
        $today = Carbon::today();
        $stats = [
            'total' => Pesanan::count(),
            'pemasukan_hari_ini' => Pesanan::whereDate('tgl_pesan', $today)->sum('total_bayar') ?? 0,
            'transaksi_pelanggan' => Pesanan::whereNotNull('id_pelanggan')->whereDate('tgl_pesan', $today)->count(),
            'stor_karyawan' => Pesanan::whereNull('id_pelanggan')->whereNotNull('id_karyawan')->whereDate('tgl_pesan', $today)->count(),
        ];

        return view('riwayat-transaksi', compact('pesanans', 'stats'));
    }

    public function laporan()
    {
        return view('laporan');
    }
}
