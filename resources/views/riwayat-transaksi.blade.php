<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Transaksi - Three D Bakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-brown: #8B6F47;
            --light-brown: #D4A574;
            --cream: #F7F3E9;
            --light-cream: #F5EFE7;
            --white: #FFFFFF;
            --light-gray: #F8F9FA;
            --medium-gray: #E9ECEF;
            --dark-gray: #6C757D;
            --text-dark: #2D3748;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --blue: #3B82F6;
            --purple: #9333EA;
            --brown: #92400E;
            --green: #22C55E;
            --border-radius: 12px;
            --border-radius-xl: 16px;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--cream);
            color: var(--text-dark);
            line-height: 1.6;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* ========== SIDEBAR ========== */
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
            font-weight: 500;
            font-size: 14px;
            background: none;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: left;
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
            margin-right: 12px;
            text-align: center;
            font-size: 16px;
        }

        .sidebar-menu-item .toggle-arrow {
            font-size: 12px;
            transition: transform 0.3s ease;
            margin-left: auto;
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

        /* ========== MAIN CONTENT ========== */
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

        .content {
            padding: 24px;
        }

        /* Summary Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--white);
            padding: 24px;
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--medium-gray);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-brown), #D4A574);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .stat-card-icon.blue { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }
        .stat-card-icon.green { background: rgba(34, 197, 94, 0.1); color: #22C55E; }
        .stat-card-icon.orange { background: rgba(249, 115, 22, 0.1); color: #F97316; }
        .stat-card-icon.purple { background: rgba(147, 51, 234, 0.1); color: #9333EA; }

        .stat-card-label {
            font-size: 13px;
            color: var(--dark-gray);
            font-weight: 500;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
        }

        /* Table Section */
        .table-section {
            background: var(--white);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            border: 1px solid var(--medium-gray);
        }

        .table-toolbar {
            padding: 20px 24px;
            background: var(--light-gray);
            border-bottom: 1px solid var(--medium-gray);
            display: flex;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 200px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 10px 16px 10px 40px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            background: var(--white);
            font-size: 14px;
            transition: var(--transition);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .search-box input:hover {
            border-color: #D4A574;
            box-shadow: 0 2px 6px rgba(139, 111, 71, 0.1);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-brown);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--dark-gray);
            font-size: 14px;
        }

        .filter-group {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .filter-group label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-dark);
            white-space: nowrap;
        }

        .form-control {
            padding: 8px 12px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            background: var(--white);
            font-size: 13px;
            color: var(--text-dark);
            cursor: pointer;
            transition: var(--transition);
        }

        .form-control:hover {
            border-color: #D4A574;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-brown);
            box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: var(--light-gray);
            padding: 16px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: var(--text-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--medium-gray);
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--medium-gray);
            font-size: 14px;
        }

        tbody tr:hover {
            background: var(--light-gray);
            transition: var(--transition);
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        /* Badge Tipe */
        .badge.tipe-pelanggan {
            background: rgba(59, 130, 246, 0.1);
            color: #3B82F6;
        }

        .badge.tipe-karyawan {
            background: rgba(249, 115, 22, 0.1);
            color: #F97316;
        }

        /* Badge Sumber */
        .badge.sumber-online {
            background: rgba(147, 51, 234, 0.1);
            color: #9333EA;
        }

        .badge.sumber-offline {
            background: rgba(146, 64, 14, 0.1);
            color: #92400E;
        }

        .badge.sumber-setor {
            background: rgba(34, 197, 94, 0.1);
            color: #22C55E;
        }

        /* Badge Metode Pembayaran */
        .badge.metode-cash {
            background: rgba(34, 197, 94, 0.1);
            color: #22C55E;
        }

        .badge.metode-transfer {
            background: rgba(59, 130, 246, 0.1);
            color: #3B82F6;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 8px;
            background: var(--light-gray);
            color: var(--dark-gray);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            font-size: 14px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .btn-icon:hover {
            background: var(--primary-brown);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(139, 111, 71, 0.15);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-y: auto;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: var(--white);
            border-radius: var(--border-radius-xl);
            max-width: 700px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--medium-gray);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, rgba(139, 111, 71, 0.05), rgba(212, 165, 116, 0.05));
        }

        .modal-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 24px;
            color: var(--dark-gray);
            transition: var(--transition);
        }

        .modal-close:hover {
            color: var(--text-dark);
        }

        .modal-body {
            padding: 24px;
        }

        .detail-section {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--medium-gray);
        }

        .detail-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 140px 1fr;
            gap: 12px;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .detail-label {
            font-weight: 600;
            color: var(--dark-gray);
        }

        .detail-value {
            color: var(--text-dark);
        }

        .detail-section h4 {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid rgba(139, 111, 71, 0.1);
        }

        .toast-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            max-width: 400px;
            z-index: 3000;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .toast {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 16px 20px;
            box-shadow: var(--shadow-lg);
            display: flex;
            gap: 12px;
            align-items: flex-start;
            border-left: 4px solid var(--blue);
            animation: slideInUp 0.3s ease;
        }

        .toast.success {
            border-left-color: #22C55E;
        }

        .toast.error {
            border-left-color: #EF4444;
        }

        .toast-icon {
            font-size: 18px;
            margin-top: 2px;
        }

        .toast-text {
            font-size: 14px;
            color: var(--text-dark);
        }

        @keyframes slideInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 40px;
            color: var(--dark-gray);
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 16px;
            color: var(--medium-gray);
        }

        .empty-state-text {
            font-size: 16px;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .table-toolbar {
                flex-direction: column;
            }

            .search-box {
                min-width: auto;
            }

            .filter-group {
                flex-direction: column;
                width: 100%;
            }

            .filter-group label,
            .form-control {
                width: 100%;
            }

            .toast-container {
                left: 16px;
                right: 16px;
                max-width: none;
            }

            .modal-content {
                max-width: 95%;
            }
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--light-gray);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--medium-gray);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--dark-gray);
        }
    </style>
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
                    <a href="/riwayat-transaksi" style="justify-content: flex-start; gap: 12px;">
                        <i class="fas fa-credit-card"></i>
                        <span style="font-weight:700;">Riwayat Transaksi</span>
                    </a>
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
                        <a href="/laporan-setoran-karyawan" class="sidebar-submenu-item">Laporan Setoran Karyawan</a>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <h1 class="header-title">Riwayat Transaksi</h1>
                </div>
            </header>

            <!-- Content -->
            <div class="content">
                <!-- Summary Stats -->
                <section class="stats-grid" id="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-icon blue">
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="stat-card-label">Total Transaksi</div>
                        <div class="stat-card-value" id="total-transaksi">0</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-icon orange">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="stat-card-label">Pemasukan Hari Ini</div>
                        <div class="stat-card-value" id="pemasukan-hari-ini">Rp 0</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-icon green">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="stat-card-label">Transaksi Pelanggan</div>
                        <div class="stat-card-value" id="transaksi-pelanggan">0</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-icon purple">
                            <i class="fas fa-hand-holding-dollar"></i>
                        </div>
                        <div class="stat-card-label">Stor Karyawan</div>
                        <div class="stat-card-value" id="stor-karyawan">0</div>
                    </div>
                </section>

                <!-- Table Section -->
                <div class="table-section">
                    <!-- Filter Toolbar -->
                    <div class="table-toolbar">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchTransaksi" placeholder="Cari nama pelanggan, karyawan, ID transaksi...">
                        </div>
                        <div class="filter-group" style="margin-left: auto;">
                            <label style="margin: 0; font-weight: 600; color: var(--primary-brown);">📅 Transaksi Hari Ini</label>
                        </div>
                    </div>
                    <div class="table-toolbar" style="padding: 12px 24px;">
                        <div class="filter-group">
                            <label>Tipe:</label>
                            <select class="form-control" id="filterTipe" onchange="filterTable()">
                                <option value="">Semua</option>
                                <option value="pelanggan">Pelanggan</option>
                                <option value="karyawan">Karyawan</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Sumber:</label>
                            <select class="form-control" id="filterSumber" onchange="filterTable()">
                                <option value="">Semua</option>
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                                <option value="setor">Setor Karyawan</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Metode:</label>
                            <select class="form-control" id="filterMetode" onchange="filterTable()">
                                <option value="">Semua</option>
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                    </div>

                    <!-- Table -->
                    <table id="tabelTransaksi">
                        <thead>
                            <tr>
                                <th style="width: 100px;">ID Transaksi</th>
                                <th>Nama</th>
                                <th style="width: 90px;">Tipe</th>
                                <th style="width: 90px;">Sumber</th>
                                <th style="width: 90px;">Metode</th>
                                <th style="width: 120px;">Total</th>
                                <th style="width: 110px;">Tanggal</th>
                                <th style="width: 80px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bodyTransaksi">
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 60px 20px;">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-inbox"></i>
                                        </div>
                                        <div class="empty-state-text">Belum ada riwayat transaksi</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Transaksi -->
    <div id="modalDetail" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Detail Transaksi</h3>
                <button class="modal-close" onclick="closeModal('modalDetail')">×</button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Content dinamis akan dimuat di sini -->
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        // Data structure untuk transaksi
        let transaksiData = [];

        // Inisialisasi
        document.addEventListener('DOMContentLoaded', function() {
            initializeData();
            renderTable();
            updateStats();
            setupSearch();
        });

        // Initialize data
        function initializeData() {
            // Sample data: menggabungkan pesanan pelanggan dan setoran karyawan
            transaksiData = [
                {
                    id: 'TRX001',
                    nama: 'Budi Santoso',
                    tipe: 'pelanggan',
                    sumber: 'online',
                    metode_pembayaran: 'transfer',
                    total: 250000,
                    tanggal_transaksi: '2025-06-02',
                    no_hp: '08123456789',
                    alamat: 'Jl. Merdeka No. 123',
                    metode_pengambilan: 'delivery',
                    tanggal_delivery: '2025-06-03',
                    produk: [
                        { nama: 'Roti Tawar', qty: 2, harga: 30000 },
                        { nama: 'Donat Glaze', qty: 3, harga: 50000 }
                    ]
                },
                {
                    id: 'TRX002',
                    nama: 'Siti Nurhaliza',
                    tipe: 'pelanggan',
                    sumber: 'offline',
                    metode_pembayaran: 'cash',
                    total: 150000,
                    tanggal_transaksi: '2025-06-02',
                    no_hp: '08987654321',
                    alamat: 'Jl. Sudirman No. 456',
                    metode_pengambilan: 'pickup',
                    tanggal_pickup: '2025-06-02',
                    produk: [
                        { nama: 'Kue Tart', qty: 1, harga: 150000 }
                    ]
                },
                {
                    id: 'TRX003',
                    nama: 'Ahmad Wijaya',
                    tipe: 'karyawan',
                    sumber: 'setor',
                    metode_pembayaran: 'cash',
                    total: 500000,
                    tanggal_transaksi: '2025-06-02',
                    tanggal_setor: '2025-06-02',
                    produk: [
                        { nama: 'Roti Croissant', qty: 50, harga: 10000 }
                    ]
                }
            ];
        }

        // Render Table
        function renderTable() {
            const tbody = document.getElementById('bodyTransaksi');
            
            if (transaksiData.length === 0) {
                tbody.innerHTML = `<tr>
                    <td colspan="8" style="text-align: center; padding: 60px 20px;">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <div class="empty-state-text">Belum ada riwayat transaksi</div>
                        </div>
                    </td>
                </tr>`;
                return;
            }

            tbody.innerHTML = transaksiData.map(item => {
                const tipeBadge = item.tipe === 'pelanggan' ? 'tipe-pelanggan' : 'tipe-karyawan';
                const tipeText = item.tipe === 'pelanggan' ? 'Pelanggan' : 'Karyawan';
                
                const sumberBadge = item.sumber === 'online' ? 'sumber-online' : 
                                   (item.sumber === 'offline' ? 'sumber-offline' : 'sumber-setor');
                const sumberText = item.sumber === 'online' ? 'Online' : 
                                  (item.sumber === 'offline' ? 'Offline' : 'Setor Karyawan');
                
                const metodeBadge = 'metode-' + item.metode_pembayaran;
                const metodeText = item.metode_pembayaran === 'cash' ? 'Cash' : 'Transfer';

                return `
                <tr data-tipe="${item.tipe}" data-sumber="${item.sumber}" data-metode="${item.metode_pembayaran}" data-tanggal="${item.tanggal_transaksi}">
                    <td><strong>${item.id}</strong></td>
                    <td>${item.nama}</td>
                    <td><span class="badge ${tipeBadge}">${tipeText}</span></td>
                    <td><span class="badge ${sumberBadge}">${sumberText}</span></td>
                    <td><span class="badge ${metodeBadge}">${metodeText}</span></td>
                    <td><strong>Rp ${item.total.toLocaleString('id-ID')}</strong></td>
                    <td>${item.tanggal_transaksi}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="showDetail('${item.id}')" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="downloadInvoice('${item.id}')" title="Download Invoice">
                                <i class="fas fa-file-invoice"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                `;
            }).join('');
        }

        // Show Detail Modal
        function showDetail(transaksiId) {
            const transaksi = transaksiData.find(t => t.id === transaksiId);
            if (!transaksi) return;

            const detailContent = document.getElementById('detailContent');
            
            if (transaksi.tipe === 'pelanggan') {
                let produkHTML = transaksi.produk.map(p => `
                    <tr>
                        <td>${p.nama}</td>
                        <td style="text-align: center;">${p.qty}</td>
                        <td style="text-align: right;">Rp ${(p.harga * p.qty).toLocaleString('id-ID')}</td>
                    </tr>
                `).join('');

                detailContent.innerHTML = `
                    <div class="detail-section">
                        <h4>DATA PELANGGAN</h4>
                        <div class="detail-row">
                            <div class="detail-label">ID Transaksi</div>
                            <div class="detail-value">${transaksi.id}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Nama Pelanggan</div>
                            <div class="detail-value">${transaksi.nama}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">No HP</div>
                            <div class="detail-value">${transaksi.no_hp || '-'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Alamat</div>
                            <div class="detail-value">${transaksi.alamat || '-'}</div>
                        </div>
                    </div>
                    
                    <div class="detail-section">
                        <h4>DETAIL TRANSAKSI</h4>
                        <div class="detail-row">
                            <div class="detail-label">Sumber Transaksi</div>
                            <div class="detail-value">${transaksi.sumber === 'online' ? 'Online' : 'Offline'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Metode Pembayaran</div>
                            <div class="detail-value">${transaksi.metode_pembayaran === 'cash' ? 'Cash' : 'Transfer'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Tanggal Transaksi</div>
                            <div class="detail-value">${transaksi.tanggal_transaksi || '-'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Tanggal ${transaksi.metode_pengambilan === 'delivery' ? 'Delivery' : 'Pickup'}</div>
                            <div class="detail-value">${transaksi.metode_pengambilan === 'delivery' ? transaksi.tanggal_delivery : transaksi.tanggal_pickup}</div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h4>DETAIL PRODUK</h4>
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 1px solid var(--medium-gray);">
                                    <th style="text-align: left; padding: 8px 0; font-weight: 600;">Produk</th>
                                    <th style="text-align: center; padding: 8px 0; font-weight: 600; width: 80px;">Qty</th>
                                    <th style="text-align: right; padding: 8px 0; font-weight: 600; width: 150px;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${produkHTML}
                            </tbody>
                            <tfoot style="border-top: 2px solid var(--medium-gray);">
                                <tr>
                                    <td colspan="2" style="padding: 12px 0; text-align: left; font-weight: 600;">Total Bayar:</td>
                                    <td style="text-align: right; padding: 12px 0; font-weight: 600; color: var(--primary-brown);">Rp ${transaksi.total.toLocaleString('id-ID')}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="detail-section">
                        <h4>STATUS PEMBAYARAN</h4>
                        <div class="detail-row">
                            <div class="detail-label">Status</div>
                            <div class="detail-value"><span class="badge metode-cash">Lunas</span></div>
                        </div>
                    </div>
                `;
            } else {
                let produkHTML = transaksi.produk.map(p => `
                    <tr>
                        <td>${p.nama}</td>
                        <td style="text-align: center;">${p.qty}</td>
                        <td style="text-align: right;">Rp ${(p.harga * p.qty).toLocaleString('id-ID')}</td>
                    </tr>
                `).join('');

                detailContent.innerHTML = `
                    <div class="detail-section">
                        <h4>DATA KARYAWAN</h4>
                        <div class="detail-row">
                            <div class="detail-label">ID Transaksi</div>
                            <div class="detail-value">${transaksi.id}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Nama Karyawan</div>
                            <div class="detail-value">${transaksi.nama}</div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h4>DETAIL PRODUK</h4>
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 1px solid var(--medium-gray);">
                                    <th style="text-align: left; padding: 8px 0; font-weight: 600;">Produk</th>
                                    <th style="text-align: center; padding: 8px 0; font-weight: 600; width: 80px;">Qty</th>
                                    <th style="text-align: right; padding: 8px 0; font-weight: 600; width: 150px;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${produkHTML}
                            </tbody>
                            <tfoot style="border-top: 2px solid var(--medium-gray);">
                                <tr>
                                    <td colspan="2" style="padding: 12px 0; text-align: left; font-weight: 600;">Total Setor:</td>
                                    <td style="text-align: right; padding: 12px 0; font-weight: 600; color: var(--primary-brown);">Rp ${transaksi.total.toLocaleString('id-ID')}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="detail-section">
                        <h4>STATUS SETORAN</h4>
                        <div class="detail-row">
                            <div class="detail-label">Tanggal Ambil</div>
                            <div class="detail-value">${transaksi.tanggal_transaksi || '-'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Tanggal Setor</div>
                            <div class="detail-value">${transaksi.tanggal_setor || '-'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Status</div>
                            <div class="detail-value"><span class="badge sumber-setor">Lunas</span></div>
                        </div>
                    </div>
                `;
            }

            document.getElementById('modalDetail').classList.add('show');
        }

        // Download Invoice
        function downloadInvoice(transaksiId) {
            const transaksi = transaksiData.find(t => t.id === transaksiId);
            if (!transaksi) return;

            let invoiceContent = `
INVOICE TRANSAKSI
=================================
ID Transaksi: ${transaksi.id}
Tanggal: ${transaksi.tanggal_transaksi}
Nama: ${transaksi.nama}
${transaksi.no_hp ? 'No HP: ' + transaksi.no_hp + '\n' : ''}
Tipe: ${transaksi.tipe === 'pelanggan' ? 'Pelanggan' : 'Karyawan'}
Sumber: ${transaksi.sumber === 'online' ? 'Online' : (transaksi.sumber === 'offline' ? 'Offline' : 'Setor Karyawan')}

DETAIL PRODUK:
${transaksi.produk.map(p => `${p.nama} x${p.qty} = Rp ${(p.harga * p.qty).toLocaleString('id-ID')}`).join('\n')}

=================================
Total: Rp ${transaksi.total.toLocaleString('id-ID')}
Status: Lunas
            `;

            const blob = new Blob([invoiceContent], { type: 'text/plain' });
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `Invoice_${transaksi.id}.txt`;
            link.click();
            window.URL.revokeObjectURL(url);
            
            showToast('Invoice berhasil diunduh', 'success');
        }

        // Filter Table
        function filterTable() {
            const searchValue = document.getElementById('searchTransaksi').value.toLowerCase();
            const filterTipe = document.getElementById('filterTipe').value;
            const filterSumber = document.getElementById('filterSumber').value;
            const filterMetode = document.getElementById('filterMetode').value;

            const tbody = document.getElementById('bodyTransaksi');
            const rows = tbody.getElementsByTagName('tr');

            let hasVisibleRows = false;
            const today = new Date().toISOString().split('T')[0];

            for (let i = 0; i < rows.length; i++) {
                if (rows[i].textContent.includes('Belum ada riwayat')) continue;

                const text = rows[i].textContent.toLowerCase();
                const tipe = rows[i].getAttribute('data-tipe');
                const sumber = rows[i].getAttribute('data-sumber');
                const metode = rows[i].getAttribute('data-metode');
                const tanggal = rows[i].getAttribute('data-tanggal');

                let show = text.includes(searchValue);
                // Filter HANYA transaksi hari ini (DATE(tanggal_transaksi) = CURRENT_DATE)
                show = show && tanggal === today;

                if (filterTipe) show = show && tipe === filterTipe;
                if (filterSumber) show = show && sumber === filterSumber;
                if (filterMetode) show = show && metode === filterMetode;

                rows[i].style.display = show ? '' : 'none';
                if (show) hasVisibleRows = true;
            }

            if (!hasVisibleRows) {
                tbody.innerHTML = `<tr>
                    <td colspan="8" style="text-align: center; padding: 60px 20px;">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <div class="empty-state-text">Transaksi tidak ditemukan</div>
                        </div>
                    </td>
                </tr>`;
            }
        }

        // Setup Search
        function setupSearch() {
            document.getElementById('searchTransaksi').addEventListener('keyup', filterTable);
        }

        // Update Stats
        function updateStats() {
            const today = new Date().toISOString().split('T')[0];
            // Hanya hitung transaksi HARI INI (WHERE DATE(tanggal_transaksi) = CURRENT_DATE)
            const todayTransaksi = transaksiData.filter(t => t.tanggal_transaksi === today);
            const totalTransaksi = todayTransaksi.length;
            const pemasukan = todayTransaksi.reduce((sum, t) => sum + t.total, 0);
            const transaksiPelanggan = todayTransaksi.filter(t => t.tipe === 'pelanggan').length;
            const storKaryawan = todayTransaksi.filter(t => t.tipe === 'karyawan').length;

            document.getElementById('total-transaksi').textContent = totalTransaksi;
            document.getElementById('pemasukan-hari-ini').textContent = 'Rp ' + pemasukan.toLocaleString('id-ID');
            document.getElementById('transaksi-pelanggan').textContent = transaksiPelanggan;
            document.getElementById('stor-karyawan').textContent = storKaryawan;
        }

        // Close Modal
        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
        }

        // Toast Notification
        function showToast(message, type = 'info') {
            const toastContainer = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            
            let icon = 'fas fa-info-circle';
            if (type === 'success') icon = 'fas fa-check-circle';
            if (type === 'error') icon = 'fas fa-exclamation-circle';
            
            toast.innerHTML = `
                <div class="toast-icon"><i class="${icon}"></i></div>
                <div class="toast-text">${message}</div>
            `;
            
            toastContainer.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Toggle Submenu
        function toggleSubmenu(button) {
            const submenu = button.nextElementSibling;
            const arrow = button.querySelector('.toggle-arrow');
            
            submenu.classList.toggle('open');
            arrow.classList.toggle('open');
            button.classList.toggle('active');
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('show');
            }
        });
    </script>
</body>
</html>
