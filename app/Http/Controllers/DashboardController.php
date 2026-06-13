<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // dd("ini dashboard");s
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Summary cards
        $totalPemesanan = Pesanan::count();

        // Pendapatan Bulan Ini = offline (karyawan lunas + pelanggan lunas) + online (lunas)
        $offlineKaryawanBulanIni = Pesanan::where('sumber_pesanan', 'offline')
            ->whereNotNull('id_karyawan')
            ->where('status_bayar', 'lunas')
            ->whereBetween('tgl_pesan', [$startOfMonth, $endOfMonth])
            ->sum('total_bayar');
        $offlinePelangganBulanIni = Pesanan::where('sumber_pesanan', 'offline')
            ->whereNotNull('id_pelanggan')
            ->where('status_pembayaran', 'lunas')
            ->whereBetween('tgl_pesan', [$startOfMonth, $endOfMonth])
            ->sum('total_bayar');
        $onlineBulanIni = Pesanan::where('sumber_pesanan', 'online')
            ->where('status_pembayaran', 'lunas')
            ->whereBetween('tgl_pesan', [$startOfMonth, $endOfMonth])
            ->sum('total_bayar');
        $pendapatanBulanIni = $offlineKaryawanBulanIni + $offlinePelangganBulanIni + $onlineBulanIni;

        $pesananBelumLunas = Pesanan::where('status_pembayaran', 'belum_bayar')->count();

        // Setoran Karyawan = offline karyawan yang sudah lunas (status_bayar)
        $setoranKaryawan = Pesanan::where('sumber_pesanan', 'offline')
            ->whereNotNull('id_karyawan')
            ->where('status_bayar', 'lunas')
            ->sum('total_bayar') ?? 0;

        // Statistics
        $totalProduk = \App\Models\Produk::where('status', 'Aktif')->count();
        $totalKaryawan = Karyawan::where('status', 'Aktif')->count();
        $totalPelanggan = \App\Models\Pelanggan::count();
        $pesananHariIni = Pesanan::whereDate('tgl_pesan', $today)->count();

        // Orders chart (last 7 days)
        $hari = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $ordersChartLabels = [];
        $ordersChartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $ordersChartLabels[] = $hari[$date->dayOfWeek];
            $ordersChartData[] = Pesanan::whereDate('tgl_pesan', $date)->count();
        }

        // Top customers (by order count)
        $topCustomers = \App\Models\Pelanggan::withCount('pesanans')
            ->orderBy('pesanans_count', 'desc')
            ->limit(5)
            ->get();

        // Deposits chart (top karyawan by setoran lunas)
        $topKaryawan = Karyawan::where('status', 'Aktif')
            ->withSum(['pesanans' => function ($q) {
                $q->where('sumber_pesanan', 'offline')->where('status_bayar', 'lunas');
            }], 'total_bayar')
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
        $recentDeposits = Pesanan::where('sumber_pesanan', 'offline')
            ->whereNotNull('id_karyawan')
            ->where('status_bayar', 'lunas')
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
        $pelanggan = Pelanggan::where('id_user', auth()->id())->first();
        return view('pelanggan.dashboard_pelanggan', compact('pelanggan'));
    }

    public function produkPelanggan()
    {
        $pelanggan = Pelanggan::where('id_user', auth()->id())->first();
        return view('pelanggan.produk', compact('pelanggan'));
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
        $pelanggan = Pelanggan::where('id_user', auth()->id())->first();
        $idPelanggan = $pelanggan ? $pelanggan->id_pelanggan : null;

        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        $pesananQuery = Pesanan::where('id_pelanggan', $idPelanggan);

        $totalOrders = (clone $pesananQuery)->count();
        $completedOrders = (clone $pesananQuery)->whereIn('status_pesanan', ['Selesai', 'completed'])->count();
        $activeOrders = $totalOrders - $completedOrders;

        $totalSpentThisMonth = (clone $pesananQuery)
            ->whereBetween('tgl_pesan', [$startOfMonth, $endOfMonth])
            ->where('status_pembayaran', 'lunas')
            ->sum('total_bayar');

        $totalSpent = (clone $pesananQuery)
            ->where('status_pembayaran', 'lunas')
            ->sum('total_bayar');

        $ordersChart = $this->getWeeklyChartData($idPelanggan, $startOfWeek, $endOfWeek);

        $recentOrders = (clone $pesananQuery)
            ->with(['detailPesanans.produk'])
            ->latest('tgl_pesan')
            ->limit(3)
            ->get()
            ->map(function ($order) {
                $produkNames = $order->detailPesanans->pluck('produk.nama')->filter()->implode(', ') ?: '-';
                return [
                    'kode' => 'ORD-' . $order->id_pesanan,
                    'tanggal' => $order->tgl_pesan ? $order->tgl_pesan->format('Y-m-d') : '-',
                    'produk' => $produkNames,
                    'total' => 'Rp ' . number_format($order->total_bayar ?? 0, 0, ',', '.'),
                    'status_pesanan' => $order->status_pesanan ?? 'Menunggu',
                ];
            });

        $statusRingkasan = [
            [
                'label' => 'Diproses',
                'value' => (clone $pesananQuery)->where('status_pesanan', 'Diproses')->count(),
                'class' => 'warning',
            ],
            [
                'label' => 'Dikirim',
                'value' => (clone $pesananQuery)->where('status_pesanan', 'Dikirim')->count(),
                'class' => 'info',
            ],
            [
                'label' => 'Selesai',
                'value' => $completedOrders,
                'class' => 'success',
            ],
        ];

        return response()->json([
            'summary_cards' => [
                [
                    'title' => 'Total Pesanan',
                    'value' => $totalOrders,
                    'change' => $activeOrders . ' pesanan aktif',
                    'change_type' => 'positive',
                    'icon' => 'fas fa-box-open',
                    'color' => 'blue'
                ],
                [
                    'title' => 'Total Belanja Bulan Ini',
                    'value' => 'Rp ' . number_format($totalSpentThisMonth, 0, ',', '.'),
                    'change' => 'Total: Rp ' . number_format($totalSpent, 0, ',', '.'),
                    'change_type' => 'positive',
                    'icon' => 'fas fa-shopping-bag',
                    'color' => 'green'
                ],
                [
                    'title' => 'Pesanan Selesai',
                    'value' => $completedOrders,
                    'change' => 'Dari ' . $totalOrders . ' total',
                    'change_type' => 'positive',
                    'icon' => 'fas fa-check-circle',
                    'color' => 'purple'
                ]
            ],
            'orders_chart' => $ordersChart,
            'orders_list' => $recentOrders,
            'status_ringkasan' => $statusRingkasan,
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    private function getWeeklyChartData($idPelanggan, $startOfWeek, $endOfWeek)
    {
        if (!$idPelanggan) {
            return ['labels' => ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'], 'data' => [0, 0, 0, 0, 0, 0, 0]];
        }

        $labels = [];
        $data = [];
        $current = $startOfWeek->copy();

        while ($current->lte($endOfWeek)) {
            $dayLabel = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'][$current->dayOfWeek];
            $labels[] = $dayLabel;

            $count = Pesanan::where('id_pelanggan', $idPelanggan)
                ->whereDate('tgl_pesan', $current->toDateString())
                ->count();

            $data[] = $count;
            $current->addDay();
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
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

    public function laporanPesananOffline(Request $request)
    {
        $today = Carbon::today();

        // Default date range: 7 hari terakhir
        $endDate = $request->input('end_date', $today->toDateString());
        $startDate = $request->input('start_date', $today->copy()->subDays(6)->toDateString());

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $offlineQuery = Pesanan::where('sumber_pesanan', 'offline')
            ->whereBetween('tgl_pesan', [$start, $end]);

        // Summary metrics
        $totalTransaksi = (clone $offlineQuery)->count();
        $totalPembayaran = (clone $offlineQuery)->sum('total_bayar') ?? 0;
        $produkTerjual = \App\Models\Detail_Pesanan::whereHas('pesanan', function ($q) use ($start, $end) {
                $q->where('sumber_pesanan', 'offline')
                  ->whereBetween('tgl_pesan', [$start, $end]);
            })->sum('jumlah_pesan') ?? 0;

        // Detail table: each row = one order item from offline orders
        $transaksiData = \App\Models\Detail_Pesanan::whereHas('pesanan', function ($q) use ($start, $end) {
                $q->where('sumber_pesanan', 'offline')
                  ->whereBetween('tgl_pesan', [$start, $end]);
            })
            ->with(['pesanan.pelanggan', 'pesanan.karyawan', 'produk'])
            ->get()
            ->map(function ($detail) {
                $nama = $detail->pesanan->pelanggan->nama
                    ?? $detail->pesanan->karyawan->nama
                    ?? 'Pelanggan';
                return [
                    'nama_pelanggan' => $nama,
                    'produk' => $detail->produk->nama_produk ?? 'Produk',
                    'jumlah' => (int) $detail->jumlah_pesan,
                    'total_pembayaran' => (float) ($detail->produk->harga_produk ?? 0) * (int) $detail->jumlah_pesan,
                    'tanggal' => $detail->pesanan->tgl_pesan->format('Y-m-d'),
                ];
            })
            ->values()
            ->toArray();

        return view('laporan_pesanan_offline', compact(
            'totalTransaksi',
            'totalPembayaran',
            'produkTerjual',
            'transaksiData',
            'startDate',
            'endDate'
        ));
    }

    public function laporanPesananOnline(Request $request)
    {
        $today = Carbon::today();

        // Default date range: 7 hari terakhir
        $endDate = $request->input('end_date', $today->toDateString());
        $startDate = $request->input('start_date', $today->copy()->subDays(6)->toDateString());

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $onlineQuery = Pesanan::where('sumber_pesanan', 'online')
            ->whereBetween('tgl_pesan', [$start, $end]);

        // Summary metrics (tetap seperti yang sudah ada)
        $totalPesanan = (clone $onlineQuery)->count();
        $totalPembayaran = (clone $onlineQuery)->sum('total_bayar') ?? 0;
        $pesananSelesai = (clone $onlineQuery)->where('status_pesanan', 'selesai')->count();

        // Data table: online, status_pembayaran = lunas (sama struktur seperti offline)
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
                    'no_pesanan' => '#ON-' . $p->tgl_pesan->format('dmY') . '-' . str_pad($p->id_pesanan, 3, '0', STR_PAD_LEFT),
                    'nama' => $p->pelanggan->nama ?? '-',
                    'produk' => $produk,
                    'total' => (float) $p->total_bayar,
                    'created_at' => $p->created_at->format('Y-m-d H:i'),
                    'status_bayar' => 'Lunas',
                    'tipe' => 'Pelanggan',
                    'status' => $statusLabel,
                ];
            })
            ->values();

        return view('laporan_pesanan_online', compact(
            'totalPesanan',
            'totalPembayaran',
            'pesananSelesai',
            'pesananData',
            'startDate',
            'endDate'
        ));
    }

    public function laporanPenjualan(Request $request)
    {
        $today = Carbon::today();
        $now = Carbon::now();

        // Default date range: 30 hari terakhir
        $endDate = $request->input('end_date', $today->toDateString());
        $startDate = $request->input('start_date', $today->copy()->subDays(29)->toDateString());

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // Metrics: total harian, mingguan, bulanan
        $totalHarian = Pesanan::whereDate('tgl_pesan', $today)->sum('total_bayar') ?? 0;
        $totalMingguan = Pesanan::whereBetween('tgl_pesan', [
            $now->copy()->startOfWeek(), $now->copy()->endOfWeek()
        ])->sum('total_bayar') ?? 0;
        $totalBulanan = Pesanan::whereBetween('tgl_pesan', [
            $now->copy()->startOfMonth(), $now->copy()->endOfMonth()
        ])->sum('total_bayar') ?? 0;
        $jumlahTransaksi = Pesanan::whereBetween('tgl_pesan', [$start, $end])->count();

        // Daily sales data for chart and table
        $salesData = Pesanan::whereBetween('tgl_pesan', [$start, $end])
            ->selectRaw('DATE(tgl_pesan) as tanggal, COUNT(*) as jumlah_transaksi, SUM(total_bayar) as total_pendapatan')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get()
            ->toArray();

        return view('laporan_penjualan', compact(
            'totalHarian',
            'totalMingguan',
            'totalBulanan',
            'jumlahTransaksi',
            'salesData',
            'startDate',
            'endDate'
        ));
    }
}
