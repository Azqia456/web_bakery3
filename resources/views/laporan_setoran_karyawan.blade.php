@include('layouts.app')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Setoran Karyawan - Three D Bakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-green: #8B6F47;
            --primary-brown: #8B6F47;
            --light-green: #D4A574;
            --light-brown: #D4A574;
            --cream: #F7F3E9;
            --white: #FFFFFF;
            --light-gray: #F8F9FA;
            --medium-gray: #E9ECEF;
            --dark-gray: #6C757D;
            --text-dark: #2D3748;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
            --border-radius-xl: 16px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--cream);
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, var(--primary-brown), var(--light-brown));
            color: var(--white);
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-lg);
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-header h1 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 4px;
            letter-spacing: -0.025em;
        }

        .sidebar-header p {
            font-size: 12px;
            opacity: 0.8;
            font-weight: 500;
        }

        .sidebar-menu {
            padding: 16px 0;
        }

        .sidebar-menu-item {
            margin: 4px 16px;
        }

        .sidebar-menu-item > a,
        .sidebar-menu-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: var(--transition);
            font-weight: 600;
            font-size: 14px;
            background: none;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: left;
            letter-spacing: 0.3px;
        }

        .sidebar-menu-item > a:hover,
        .sidebar-menu-item > a.active,
        .sidebar-menu-toggle:hover,
        .sidebar-menu-toggle.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: var(--white);
        }

        .sidebar-menu-item > a.active {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .sidebar-menu-item i {
            width: 20px;
            min-width: 20px;
            margin-right: 12px;
            text-align: center;
            font-size: 16px;
        }

        .sidebar-menu-item .toggle-arrow {
            font-size: 12px;
            transition: transform 0.3s ease;
            margin-left: auto;
            flex-shrink: 0;
        }

        .sidebar-menu-item .toggle-arrow.open {
            transform: rotate(180deg);
        }

        .sidebar-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background: rgba(0, 0, 0, 0.1);
            border-radius: var(--border-radius);
            margin: 0 8px;
        }

        .sidebar-submenu.open {
            max-height: 500px;
        }

        .sidebar-submenu-item {
            padding: 10px 16px 10px 48px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 13px;
            font-weight: 400;
            transition: var(--transition);
        }

        .sidebar-submenu-item:hover,
        .sidebar-submenu-item.active {
            color: var(--white);
            padding-left: 52px;
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            background-color: var(--cream);
        }

        .header {
            background: var(--white);
            border-bottom: 1px solid var(--medium-gray);
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .header-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .page-container {
            padding: 24px;
        }

        .content-card {
            background: var(--white);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--medium-gray);
            padding: 30px;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-state {
            text-align: center;
            color: var(--dark-gray);
        }

        .empty-state i {
            font-size: 64px;
            color: var(--light-brown);
            margin-bottom: 16px;
            opacity: 0.6;
        }

        .empty-state h2 {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 14px;
            color: var(--dark-gray);
        }

        .logout-btn {
            background: linear-gradient(135deg, #EF4444, #DC2626);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .header-title {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1>🍞 Three D Bakery</h1>
                <p>Management System</p>
            </div>
            <nav class="sidebar-menu">
                <div class="sidebar-menu-item">
                    <a href="/dashboard" style="justify-content: flex-start; gap: 12px;">
                        <i class="fas fa-tachometer-alt"></i>
                        <span style="font-weight:700;">Dashboard</span>
                    </a>
                </div>

                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle" onclick="toggleSubmenu(this)" style="justify-content: flex-start; gap: 12px;">
                        <i class="fas fa-shopping-cart"></i>
                        <span style="font-weight:700;">Pesanan</span>
                        <i class="fas fa-chevron-down toggle-arrow"></i>
                    </button>
                    <div class="sidebar-submenu">
                        <a href="/pesanan-online" class="sidebar-submenu-item">Pesanan Online</a>
                        <a href="/pesanan-offline" class="sidebar-submenu-item">Pesanan Offline</a>
                    </div>
                </div>

                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle" onclick="toggleSubmenu(this)" style="justify-content: flex-start; gap: 12px;">
                        <i class="fas fa-database"></i>
                        <span style="font-weight:700;">Data</span>
                        <i class="fas fa-chevron-down toggle-arrow"></i>
                    </button>
                    <div class="sidebar-submenu">
                        <a href="/data-karyawan" class="sidebar-submenu-item">Data Karyawan</a>
                        <a href="/data-pelanggan" class="sidebar-submenu-item">Data Pelanggan</a>
                    </div>
                </div>

                <div class="sidebar-menu-item">
                    <a href="/produk" style="justify-content: flex-start; gap: 12px;">
                        <i class="fas fa-box"></i>
                        <span style="font-weight:700;">Produk</span>
                    </a>
                </div>

                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle" onclick="toggleSubmenu(this)" style="justify-content: flex-start; gap: 12px;">
                        <i class="fas fa-credit-card"></i>
                        <span style="font-weight:700;">Pembayaran</span>
                        <i class="fas fa-chevron-down toggle-arrow"></i>
                    </button>
                    <div class="sidebar-submenu">
                        <a href="/stor-karyawan" class="sidebar-submenu-item">Stor Karyawan</a>
                        <a href="/riwayat-transaksi" class="sidebar-submenu-item">Riwayat Transaksi Pelanggan</a>
                    </div>
                </div>

                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle" onclick="toggleSubmenu(this)" style="justify-content: flex-start; gap: 12px;">
                        <i class="fas fa-chart-line"></i>
                        <span style="font-weight:700;">Laporan</span>
                        <i class="fas fa-chevron-down toggle-arrow"></i>
                    </button>
                    <div class="sidebar-submenu">
                        <a href="/laporan-penjualan" class="sidebar-submenu-item">Laporan Penjualan</a>
                        <a href="/laporan-pesanan-online" class="sidebar-submenu-item">Laporan Pesanan Online</a>
                        <a href="/laporan-pesanan-offline" class="sidebar-submenu-item">Laporan Pesanan Offline</a>
                        <a href="/laporan-pembayaran" class="sidebar-submenu-item">Laporan Pembayaran</a>
                        <a href="/laporan-setoran-karyawan" class="sidebar-submenu-item active">Laporan Setoran Karyawan</a>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <header class="header">
                <h1 class="header-title">👥 Laporan Setoran Karyawan</h1>
                <div class="header-right">
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-right-from-bracket"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <div class="page-container">
                <!-- Statistics Cards -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 24px;">
                    <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #28a745;">
                        <h6 style="color: #6c757d; font-size: 13px; margin-bottom: 8px; font-weight: 600;">Total Setoran</h6>
                        <h3 style="color: #28a745; font-size: 24px; font-weight: 700; margin: 0;">
                            Rp {{ number_format($totalSetoran ?? 0, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #007bff;">
                        <h6 style="color: #6c757d; font-size: 13px; margin-bottom: 8px; font-weight: 600;">Jumlah Setoran</h6>
                        <h3 style="color: #007bff; font-size: 24px; font-weight: 700; margin: 0;">
                            {{ $jumlahSetoran ?? 0 }}
                        </h3>
                    </div>
                </div>

                <!-- Filter Section -->
                <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 24px;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; align-items: flex-end;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: #333;">Tanggal Mulai</label>
                            <input type="date" id="startDate" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 13px;" value="{{ $startDate ?? date('Y-m-d') }}">
                        </div>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: #333;">Tanggal Akhir</label>
                            <input type="date" id="endDate" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 13px;" value="{{ $endDate ?? date('Y-m-d') }}">
                        </div>
                        <button onclick="filterData()" style="background: #8B6F47; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 13px; width: 100%; transition: background 0.3s;">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                </div>

                <!-- Table Section -->
                <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <h5 style="font-weight: 700; margin-bottom: 20px; color: #333;">Daftar Setoran Karyawan</h5>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                            <thead>
                                <tr style="border-bottom: 2px solid #f0f0f0; background: #f8f9fa;">
                                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #333;">Nama Karyawan</th>
                                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #333;">Produk Diambil</th>
                                    <th style="padding: 12px; text-align: right; font-weight: 600; color: #333;">Total Setoran</th>
                                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #333;">Tanggal Setoran</th>
                                    <th style="padding: 12px; text-align: center; font-weight: 600; color: #333;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($setoranData ?? [] as $item)
                                    <tr style="border-bottom: 1px solid #f0f0f0; transition: background 0.2s;">
                                        <td style="padding: 12px;">{{ $item['nama_karyawan'] ?? '-' }}</td>
                                        <td style="padding: 12px;">{{ $item['produk_diambil'] ?? '-' }}</td>
                                        <td style="padding: 12px; text-align: right; font-weight: 600; color: #28a745;">
                                            Rp {{ number_format($item['total_setoran'] ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td style="padding: 12px;">{{ date('d-m-Y', strtotime($item['tanggal_setoran'] ?? now())) }}</td>
                                        <td style="padding: 12px; text-align: center;">
                                            @php
                                                $status = $item['status'] ?? 'pending';
                                                $badgeClass = match($status) {
                                                    'checked' => 'background: #d1e7dd; color: #0f5132;',
                                                    'pending' => 'background: #fff3cd; color: #664d03;',
                                                    'rejected' => 'background: #f8d7da; color: #842029;',
                                                    default => 'background: #cfe2ff; color: #084298;'
                                                };
                                            @endphp
                                            <span style="{{ $badgeClass }} padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="padding: 24px; text-align: center; color: #999;">
                                            Tidak ada data setoran karyawan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterData() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            if(startDate && endDate) {
                const url = new URL(window.location);
                url.searchParams.set('start_date', startDate);
                url.searchParams.set('end_date', endDate);
                window.location = url.toString();
            }
        }

        document.getElementById('endDate').addEventListener('keypress', function(e) {
            if(e.key === 'Enter') {
                filterData();
            }
        });

        function toggleSubmenu(button) {
            const submenu = button.nextElementSibling;
            const arrow = button.querySelector('.toggle-arrow');
            
            submenu.classList.toggle('open');
            arrow.classList.toggle('open');
            button.classList.toggle('active');
        }

        // Highlight active submenu item
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const submenuItems = document.querySelectorAll('.sidebar-submenu-item');
            
            submenuItems.forEach(item => {
                if (item.getAttribute('href') === currentPath) {
                    item.classList.add('active');
                    const submenu = item.parentElement;
                    const button = submenu.previousElementSibling;
                    submenu.classList.add('open');
                    button.classList.add('active');
                    button.querySelector('.toggle-arrow').classList.add('open');
                }
            });
        });
    </script>
</body>
</html>
