<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three D Bakery - {{ $pageTitle ?? 'Dashboard' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        /* Sidebar */
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
            justify-content: flex-start;
            gap: 12px;
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

        .sidebar-menu-item i,
        .sidebar-menu-toggle i {
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

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            background-color: var(--cream);
        }

        /* Header */
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

        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .search-bar {
            position: relative;
            width: 320px;
        }

        .search-bar input {
            width: 100%;
            padding: 10px 16px 10px 40px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius-xl);
            background: var(--light-gray);
            font-size: 14px;
            transition: var(--transition);
        }

        .search-bar input:focus {
            outline: none;
            border-color: var(--primary-green);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(168, 218, 220, 0.1);
        }

        .search-bar i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--dark-gray);
            font-size: 14px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .profile-menu {
            position: relative;
        }

        .notification-btn,
        .profile-btn {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--light-gray);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            color: var(--dark-gray);
        }

        .notification-btn:hover,
        .profile-btn:hover {
            background: var(--medium-gray);
            transform: scale(1.05);
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 18px;
            height: 18px;
            background: #EF4444;
            color: white;
            border-radius: 50%;
            font-size: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-green), #81C784);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        .profile-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 180px;
            background: var(--white);
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            padding: 8px;
            display: none;
            z-index: 1001;
        }

        .profile-dropdown.show {
            display: block;
        }

        .profile-dropdown a,
        .profile-dropdown button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border: none;
            border-radius: 10px;
            background: transparent;
            color: var(--text-dark);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-align: left;
            transition: var(--transition);
        }

        .profile-dropdown a:hover,
        .profile-dropdown button:hover {
            background: var(--light-gray);
        }

        .profile-dropdown .logout-action {
            color: #EF4444;
        }

        /* Dashboard Content */
        .dashboard-content {
            padding: 24px;
        }

        @media (max-width: 768px) {
            .sidebar { width: 250px; }
            .main-content { margin-left: 250px; }
            .search-bar { width: 200px; }
            .header { flex-wrap: wrap; }
        }

        @media (max-width: 480px) {
            .sidebar { width: 200px; }
            .main-content { margin-left: 200px; }
            .header-title { font-size: 18px; }
            .search-bar { display: none; }
        }
    </style>
    @yield('additional-styles')
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1>🍞 Three D Bakery</h1>
                <p>Management System</p>
            </div>
            <nav class="sidebar-menu">
                <div class="sidebar-menu-item">
                    <a href="/dashboard" class="@if(request()->path() === 'dashboard') active @endif">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle @if(request()->is('pesanan*')) active @endif" onclick="toggleMenu(this)">
                        <span><i class="fas fa-shopping-cart"></i> Pesanan</span>
                        <i class="fas fa-chevron-down toggle-arrow @if(request()->is('pesanan*')) open @endif"></i>
                    </button>
                    <div class="sidebar-submenu @if(request()->is('pesanan*')) open @endif">
                        <a href="/pesanan-online" class="sidebar-submenu-item @if(request()->path() === 'pesanan-online') active @endif">Pesanan Online</a>
                        <a href="/pesanan-offline" class="sidebar-submenu-item @if(request()->path() === 'pesanan-offline') active @endif">Pesanan Offline</a>
                    </div>
                </div>
                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle @if(request()->is('data*')) active @endif" onclick="toggleMenu(this)">
                        <span><i class="fas fa-database"></i> Data</span>
                        <i class="fas fa-chevron-down toggle-arrow @if(request()->is('data*')) open @endif"></i>
                    </button>
                    <div class="sidebar-submenu @if(request()->is('data*')) open @endif">
                        <a href="/data-karyawan" class="sidebar-submenu-item @if(request()->path() === 'data-karyawan') active @endif">Data Karyawan</a>
                        <a href="/data-pelanggan" class="sidebar-submenu-item @if(request()->path() === 'data-pelanggan') active @endif">Data Pelanggan</a>
                    </div>
                </div>
                <div class="sidebar-menu-item">
                    <a href="/produk" class="@if(request()->path() === 'produk') active @endif">
                        <i class="fas fa-box"></i>
                        <span>Produk</span>
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle @if(request()->is('stor*') || request()->is('riwayat*')) active @endif" onclick="toggleMenu(this)">
                        <span><i class="fas fa-money-bill-wave"></i> Pembayaran</span>
                        <i class="fas fa-chevron-down toggle-arrow @if(request()->is('stor*') || request()->is('riwayat*')) open @endif"></i>
                    </button>
                    <div class="sidebar-submenu @if(request()->is('stor*') || request()->is('riwayat*')) open @endif">
                        <a href="/stor-karyawan" class="sidebar-submenu-item @if(request()->path() === 'stor-karyawan') active @endif">Stor Karyawan</a>
                        <a href="/riwayat-transaksi" class="sidebar-submenu-item @if(request()->path() === 'riwayat-transaksi') active @endif">Riwayat Transaksi</a>
                    </div>
                </div>
                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle @if(request()->is('laporan*')) active @endif" onclick="toggleMenu(this)">
                        <span><i class="fas fa-file-alt"></i> Laporan</span>
                        <i class="fas fa-chevron-down toggle-arrow @if(request()->is('laporan*')) open @endif"></i>
                    </button>
                    <div class="sidebar-submenu @if(request()->is('laporan*')) open @endif">
                        <a href="/laporan-penjualan" class="sidebar-submenu-item @if(request()->path() === 'laporan-penjualan') active @endif">Laporan Penjualan</a>
                        <a href="/laporan-pesanan-online" class="sidebar-submenu-item @if(request()->path() === 'laporan-pesanan-online') active @endif">Laporan Pesanan Online</a>
                        <a href="/laporan-pesanan-offline" class="sidebar-submenu-item @if(request()->path() === 'laporan-pesanan-offline') active @endif">Laporan Pesanan Offline</a>
                        <a href="/laporan-pembayaran" class="sidebar-submenu-item @if(request()->path() === 'laporan-pembayaran') active @endif">Laporan Pembayaran</a>
                        <a href="/laporan-setoran-karyawan" class="sidebar-submenu-item @if(request()->path() === 'laporan-setoran-karyawan') active @endif">Laporan Setoran Karyawan</a>
                    </div>
                </div>
            </nav>
        </aside>

        <div class="main-content">
            <header class="header">
                <div class="header-left">
                    <h1 class="header-title">{{ $pageTitle ?? 'Dashboard' }}</h1>
                </div>

                @if(isset($showSearchBar) && $showSearchBar)
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Cari pesanan, pelanggan, produk...">
                </div>
                @endif

                <div class="header-right">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">0</span>
                    </button>
                    <div class="profile-menu">
                        @php
                            $userName = Auth::user()->name ?? 'User';
                            $parts = preg_split('/\s+/', trim($userName));
                            $initials = '';
                            foreach ($parts as $part) {
                                if ($part !== '') {
                                    $initials .= strtoupper(substr($part, 0, 1));
                                }
                            }
                            $initials = substr($initials, 0, 2);
                        @endphp
                        <button type="button" class="profile-btn" id="profileMenuButton" aria-haspopup="true" aria-expanded="false" title="Akun">
                            <div class="profile-avatar">{{ $initials }}</div>
                        </button>

                        <div class="profile-dropdown" id="profileDropdown">
                            <a href="{{ route('profile.edit') ?? '#' }}">
                                <i class="fas fa-user"></i>
                                Profil
                            </a>
                            <form action="{{ route('logout') ?? '#' }}" method="POST">
                                @csrf
                                <button type="submit" class="logout-action">
                                    <i class="fas fa-right-from-bracket"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    <script>
        function toggleMenu(button) {
            const submenu = button.nextElementSibling;
            const arrow = button.querySelector('.toggle-arrow');
            
            submenu.classList.toggle('open');
            arrow.classList.toggle('open');
        }

        // Profile menu toggle
        document.getElementById('profileMenuButton')?.addEventListener('click', function() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('show');
        });

        // Close profile menu when clicking outside
        document.addEventListener('click', function(event) {
            const profileMenu = document.querySelector('.profile-menu');
            if (profileMenu && !profileMenu.contains(event.target)) {
                document.getElementById('profileDropdown')?.classList.remove('show');
            }
        });
    </script>
    @yield('additional-scripts')
</body>
</html>
