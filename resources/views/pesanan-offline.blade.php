<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Offline - Three D Bakery</title>
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
            --yellow: #F59E0B;
            --red: #EF4444;
            --green: #22C55E;
            --border-radius: 12px;
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

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-primary {
            background-color: var(--primary-brown);
            color: var(--white);
            padding: 10px 20px;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .btn-primary:hover {
            background-color: #6B4F33;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .content {
            padding: 24px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            background: var(--white);
            padding: 20px 24px;
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-sm);
        }

        .page-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .tabs {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            border-bottom: 2px solid var(--medium-gray);
        }

        .tab {
            padding: 12px 24px;
            background: none;
            border: none;
            color: var(--dark-gray);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
        }

        .tab.active {
            color: var(--primary-brown);
            border-bottom-color: var(--primary-brown);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Table Section */
        .table-section {
            background: var(--white);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-md);
            overflow: hidden;
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
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-brown);
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

        .filter-select {
            padding: 10px 12px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            background: var(--white);
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary-brown);
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
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-badge.pending {
            background: rgba(249, 158, 11, 0.1);
            color: #F59E0B;
        }

        .status-badge.proses {
            background: rgba(59, 130, 246, 0.1);
            color: #3B82F6;
        }

        .status-badge.selesai {
            background: rgba(34, 197, 94, 0.1);
            color: #22C55E;
        }

        .status-badge.stor {
            background: rgba(34, 197, 94, 0.1);
            color: #22C55E;
        }

        .status-badge.belum_stor {
            background: rgba(249, 158, 11, 0.1);
            color: #F59E0B;
        }

        .payment-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .payment-badge.lunas {
            background: rgba(34, 197, 94, 0.1);
            color: #22C55E;
        }

        .payment-badge.belum_lunas {
            background: rgba(239, 68, 68, 0.1);
            color: #EF4444;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 6px;
            background: var(--light-gray);
            color: var(--text-dark);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            font-size: 14px;
        }

        .btn-icon:hover {
            background: var(--primary-brown);
            color: var(--white);
        }

        .btn-icon.delete:hover {
            background: var(--red);
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
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: var(--white);
            border-radius: var(--border-radius-xl);
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--medium-gray);
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-dark);
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            font-size: 14px;
            font-family: inherit;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-brown);
            box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* Product List in Modal */
        .product-list {
            border-top: 1px solid var(--medium-gray);
            padding-top: 16px;
            margin-top: 16px;
        }

        .product-item {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            padding: 12px;
            background: var(--light-gray);
            border-radius: var(--border-radius);
            align-items: flex-end;
        }

        .product-item-controls {
            flex: 1;
        }

        .product-item label {
            font-size: 12px;
            font-weight: 500;
            color: var(--dark-gray);
            display: block;
            margin-bottom: 4px;
        }

        .product-item input {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--medium-gray);
            border-radius: 6px;
            font-size: 13px;
        }

        .btn-delete-product {
            background: var(--red);
            color: var(--white);
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-delete-product:hover {
            background: #d32f2f;
        }

        .btn-add-product {
            background: var(--primary-brown);
            color: var(--white);
            border: none;
            padding: 10px 16px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: var(--transition);
            width: 100%;
            margin-bottom: 16px;
        }

        .btn-add-product:hover {
            background: #6B4F33;
        }

        .total-section {
            background: var(--light-gray);
            padding: 16px;
            border-radius: var(--border-radius);
            margin: 16px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
        }

        .modal-footer {
            padding: 20px 24px;
            border-top: 1px solid var(--medium-gray);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-cancel {
            background: var(--medium-gray);
            color: var(--text-dark);
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            font-size: 14px;
        }

        .btn-cancel:hover {
            background: #d4d4d4;
        }

        .btn-save {
            background: var(--primary-brown);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            font-size: 14px;
        }

        .btn-save:hover {
            background: #6B4F33;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .table-toolbar {
                flex-direction: column;
            }

            .search-box {
                min-width: auto;
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
                    <a href="/dashboard">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </div>

                <!-- Pesanan Menu -->
                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle" onclick="toggleSubmenu(this)">
                        <span><i class="fas fa-shopping-cart"></i> Pesanan</span>
                        <i class="fas fa-chevron-down toggle-arrow open"></i>
                    </button>
                    <div class="sidebar-submenu open">
                        <a href="/pesanan-online" class="sidebar-submenu-item">Pesanan Online</a>
                        <a href="/pesanan-offline" class="sidebar-submenu-item active">Pesanan Offline</a>
                    </div>
                </div>

                <!-- Data Menu -->
                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle" onclick="toggleSubmenu(this)">
                        <span><i class="fas fa-database"></i> Data</span>
                        <i class="fas fa-chevron-down toggle-arrow"></i>
                    </button>
                    <div class="sidebar-submenu">
                        <a href="/data-karyawan" class="sidebar-submenu-item">Data Karyawan</a>
                        <a href="/data-pelanggan" class="sidebar-submenu-item">Data Pelanggan</a>
                    </div>
                </div>

                <!-- Produk Menu -->
                <div class="sidebar-menu-item">
                    <a href="/produk">
                        <i class="fas fa-box"></i>
                        Produk
                    </a>
                </div>

                <!-- Pembayaran Menu -->
                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle" onclick="toggleSubmenu(this)">
                        <span><i class="fas fa-credit-card"></i> Pembayaran</span>
                        <i class="fas fa-chevron-down toggle-arrow"></i>
                    </button>
                    <div class="sidebar-submenu">
                        <a href="/stor-karyawan" class="sidebar-submenu-item">Stor Karyawan</a>
                        <a href="/riwayat-transaksi" class="sidebar-submenu-item">Riwayat Transaksi Pelanggan</a>
                    </div>
                </div>

                <!-- Laporan Menu -->
                <div class="sidebar-menu-item">
                    <a href="/laporan">
                        <i class="fas fa-chart-line"></i>
                        Laporan
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <h1 class="header-title">Pesanan Offline</h1>
                </div>
                <div class="header-right">
                    <button class="btn-primary" onclick="openAddModal()">
                        <i class="fas fa-plus"></i>
                        Tambah Pesanan
                    </button>
                </div>
            </header>

            <!-- Content -->
            <div class="content">
                <!-- Tabs -->
                <div class="tabs">
                    <button class="tab active" onclick="switchTab(this, 'karyawan')">
                        <i class="fas fa-users"></i> Pesanan Karyawan
                    </button>
                    <button class="tab" onclick="switchTab(this, 'pelanggan')">
                        <i class="fas fa-user"></i> Pesanan Pelanggan
                    </button>
                </div>

                <!-- Pesanan Karyawan Tab -->
                <div id="tab-karyawan" class="tab-content active">
                    <div class="table-section">
                        <div class="table-toolbar">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="searchKaryawan" placeholder="Cari nama karyawan, ID pesanan...">
                            </div>
                            <div class="filter-group">
                                <label style="font-size: 13px; font-weight: 500;">Filter Status:</label>
                                <select class="filter-select" id="filterKaryawan" onchange="filterTable('karyawan')">
                                    <option value="">Semua Status</option>
                                    <option value="stor">Stor</option>
                                    <option value="belum_stor">Belum Stor</option>
                                </select>
                            </div>
                        </div>
                        <table id="tableKaryawan">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Nama Karyawan</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bodyKaryawan">
                                <tr>
                                    <td colspan="5" style="text-align: center; color: var(--dark-gray);">
                                        <i class="fas fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                                        Belum ada pesanan karyawan
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pesanan Pelanggan Tab -->
                <div id="tab-pelanggan" class="tab-content">
                    <div class="table-section">
                        <div class="table-toolbar">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="searchPelanggan" placeholder="Cari nama pelanggan, ID pesanan...">
                            </div>
                            <div class="filter-group">
                                <label style="font-size: 13px; font-weight: 500;">Filter Status:</label>
                                <select class="filter-select" id="filterPelanggan" onchange="filterTable('pelanggan')">
                                    <option value="">Semua Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="di_proses">Di Proses</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <table id="tablePelanggan">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Status</th>
                                    <th>Pembayaran</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bodyPelanggan">
                                <tr>
                                    <td colspan="6" style="text-align: center; color: var(--dark-gray);">
                                        <i class="fas fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                                        Belum ada pesanan pelanggan
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add/Edit Pesanan -->
    <div id="modalAddPesanan" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitleAdd">Tambah Pesanan</h3>
                <button class="modal-close" onclick="closeModal('modalAddPesanan')">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Tipe Pesanan <span style="color: var(--red);">*</span></label>
                    <div style="display: flex; gap: 16px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-weight: 400; cursor: pointer;">
                            <input type="radio" name="tipePesanan" value="karyawan" onchange="changePesananType()" checked>
                            Karyawan
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; font-weight: 400; cursor: pointer;">
                            <input type="radio" name="tipePesanan" value="pelanggan" onchange="changePesananType()">
                            Pelanggan
                        </label>
                    </div>
                </div>

                <!-- Tipe Pesanan: Karyawan -->
                <div id="formKaryawan">
                    <div class="form-group">
                        <label class="form-label">Nama Karyawan <span style="color: var(--red);">*</span></label>
                        <input type="text" class="form-control" id="namaKaryawan" placeholder="Masukkan nama karyawan">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Pickup <span style="color: var(--red);">*</span></label>
                        <input type="date" class="form-control" id="tanggalPickupKaryawan">
                    </div>
                </div>

                <!-- Tipe Pesanan: Pelanggan -->
                <div id="formPelanggan" style="display: none;">
                    <div class="form-group">
                        <label class="form-label">Nama Pelanggan <span style="color: var(--red);">*</span></label>
                        <input type="text" class="form-control" id="namaPelanggan" placeholder="Masukkan nama pelanggan">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Metode Pengambilan <span style="color: var(--red);">*</span></label>
                        <div style="display: flex; gap: 16px;">
                            <label style="display: flex; align-items: center; gap: 8px; font-weight: 400; cursor: pointer;">
                                <input type="radio" name="metodeMetode" value="delivery" onchange="changeMetode()">
                                Delivery
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; font-weight: 400; cursor: pointer;">
                                <input type="radio" name="metodeMetode" value="pickup" onchange="changeMetode()" checked>
                                Pickup
                            </label>
                        </div>
                    </div>
                    <div class="form-group" id="tanggalDeliveryGroup" style="display: none;">
                        <label class="form-label">Tanggal Delivery</label>
                        <input type="date" class="form-control" id="tanggalDelivery">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Pickup <span style="color: var(--red);">*</span></label>
                        <input type="date" class="form-control" id="tanggalPickupPelanggan">
                    </div>
                </div>

                <!-- Produk Section -->
                <div class="form-group">
                    <label class="form-label">Produk <span style="color: var(--red);">*</span></label>
                    <button type="button" class="btn-add-product" onclick="addProductRow()">
                        <i class="fas fa-plus"></i> Tambah Produk
                    </button>
                    <div id="productList" class="product-list">
                    </div>
                </div>

                <!-- Total Section -->
                <div class="total-section">
                    <span>Total Pesanan:</span>
                    <span id="totalPesanan">Rp 0</span>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel" onclick="closeModal('modalAddPesanan')">Batal</button>
                <button class="btn-save" onclick="savePesanan()">Simpan</button>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pesanan -->
    <div id="modalDetail" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="detailTitle">Detail Pesanan</h3>
                <button class="modal-close" onclick="closeModal('modalDetail')">×</button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Content will be populated by JavaScript -->
            </div>
            <div class="modal-footer">
                <button class="btn-cancel" onclick="closeModal('modalDetail')">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pesanan -->
    <div id="modalEdit" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="editTitle">Edit Pesanan</h3>
                <button class="modal-close" onclick="closeModal('modalEdit')">×</button>
            </div>
            <div class="modal-body" id="editContent">
                <!-- Content will be populated by JavaScript -->
            </div>
            <div class="modal-footer">
                <button class="btn-cancel" onclick="closeModal('modalEdit')">Batal</button>
                <button class="btn-save" onclick="saveEdit()">Simpan Perubahan</button>
            </div>
        </div>
    </div>

    <script>
        // Sample data (in production, this would come from database)
        let pesananData = {
            karyawan: [
                {
                    id: 'K001',
                    nama: 'Budi Santoso',
                    status: 'stor',
                    tanggal_pesan: '2026-04-20',
                    tanggal_pickup: '2026-04-22',
                    total: 250000,
                    produk: [
                        { nama: 'Roti Tawar', jumlah: 5, harga: 30000, subtotal: 150000 },
                        { nama: 'Donat Glaze', jumlah: 2, harga: 50000, subtotal: 100000 }
                    ]
                }
            ],
            pelanggan: [
                {
                    id: 'P001',
                    nama: 'Siti Handoko',
                    status: 'pending',
                    tanggal_pesan: '2026-04-21',
                    pembayaran: 'belum_lunas',
                    tanggal_pickup: '2026-04-23',
                    total: 500000,
                    produk: [
                        { nama: 'Kue Tart', jumlah: 1, harga: 300000, subtotal: 300000 },
                        { nama: 'Roti Croissant', jumlah: 2, harga: 100000, subtotal: 200000 }
                    ]
                }
            ]
        };

        let currentTab = 'karyawan';
        let productCount = 0;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            renderTables();
            setupSearch();
        });

        // Render Tables
        function renderTables() {
            renderKaryawanTable();
            renderPelangganTable();
        }

        function renderKaryawanTable() {
            const tbody = document.getElementById('bodyKaryawan');
            if (pesananData.karyawan.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" style="text-align: center; color: var(--dark-gray); padding: 40px;">
                    <i class="fas fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                    Belum ada pesanan karyawan
                </td></tr>`;
                return;
            }

            tbody.innerHTML = pesananData.karyawan.map(item => `
                <tr>
                    <td>${item.id}</td>
                    <td>${item.nama}</td>
                    <td><span class="status-badge ${item.status}">${item.status === 'stor' ? 'Stor' : 'Belum Stor'}</span></td>
                    <td>Rp ${(item.total).toLocaleString('id-ID')}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="showDetail('karyawan', ${pesananData.karyawan.indexOf(item)})" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="showEdit('karyawan', ${pesananData.karyawan.indexOf(item)})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon delete" onclick="deletePesanan('karyawan', ${pesananData.karyawan.indexOf(item)})" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn-icon" onclick="markComplete('karyawan', ${pesananData.karyawan.indexOf(item)})" title="Selesai">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function renderPelangganTable() {
            const tbody = document.getElementById('bodyPelanggan');
            if (pesananData.pelanggan.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" style="text-align: center; color: var(--dark-gray); padding: 40px;">
                    <i class="fas fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                    Belum ada pesanan pelanggan
                </td></tr>`;
                return;
            }

            tbody.innerHTML = pesananData.pelanggan.map(item => `
                <tr>
                    <td>${item.id}</td>
                    <td>${item.nama}</td>
                    <td><span class="status-badge ${item.status}">${item.status === 'pending' ? 'Pending' : item.status === 'di_proses' ? 'Di Proses' : 'Selesai'}</span></td>
                    <td><span class="payment-badge ${item.pembayaran}">${item.pembayaran === 'lunas' ? 'Lunas' : 'Belum Lunas'}</span></td>
                    <td>Rp ${(item.total).toLocaleString('id-ID')}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="showDetail('pelanggan', ${pesananData.pelanggan.indexOf(item)})" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="showEdit('pelanggan', ${pesananData.pelanggan.indexOf(item)})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon delete" onclick="deletePesanan('pelanggan', ${pesananData.pelanggan.indexOf(item)})" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn-icon" onclick="markComplete('pelanggan', ${pesananData.pelanggan.indexOf(item)})" title="Selesai">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Tab Switching
        function switchTab(button, tab) {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            button.classList.add('active');
            document.getElementById('tab-' + tab).classList.add('active');
            currentTab = tab;
        }

        // Modal Functions
        function openAddModal() {
            productCount = 0;
            document.getElementById('modalAddPesanan').classList.add('show');
            document.getElementById('productList').innerHTML = '';
            document.getElementById('totalPesanan').textContent = 'Rp 0';
            document.querySelector('input[name="tipePesanan"][value="karyawan"]').checked = true;
            changePesananType();
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
        }

        function changePesananType() {
            const type = document.querySelector('input[name="tipePesanan"]:checked').value;
            if (type === 'karyawan') {
                document.getElementById('formKaryawan').style.display = 'block';
                document.getElementById('formPelanggan').style.display = 'none';
            } else {
                document.getElementById('formKaryawan').style.display = 'none';
                document.getElementById('formPelanggan').style.display = 'block';
            }
        }

        function changeMetode() {
            const metode = document.querySelector('input[name="metodeMetode"]:checked').value;
            if (metode === 'delivery') {
                document.getElementById('tanggalDeliveryGroup').style.display = 'block';
            } else {
                document.getElementById('tanggalDeliveryGroup').style.display = 'none';
            }
        }

        function addProductRow() {
            productCount++;
            const productList = document.getElementById('productList');
            const productRow = document.createElement('div');
            productRow.className = 'product-item';
            productRow.id = 'product-' + productCount;
            productRow.innerHTML = `
                <div class="product-item-controls" style="flex: 1;">
                    <label>Pilih Produk</label>
                    <select class="form-control" onchange="updateTotal()">
                        <option value="">-- Pilih Produk --</option>
                        <option value="roti_tawar|30000">Roti Tawar - Rp 30.000</option>
                        <option value="donat_glaze|50000">Donat Glaze - Rp 50.000</option>
                        <option value="kue_tart|300000">Kue Tart - Rp 300.000</option>
                        <option value="roti_croissant|100000">Roti Croissant - Rp 100.000</option>
                    </select>
                </div>
                <div class="product-item-controls" style="flex: 0.5;">
                    <label>Jumlah</label>
                    <input type="number" min="1" value="1" class="form-control" onchange="updateTotal()">
                </div>
                <button type="button" class="btn-delete-product" onclick="deleteProductRow(${productCount})">Hapus</button>
            `;
            productList.appendChild(productRow);
        }

        function deleteProductRow(id) {
            const elem = document.getElementById('product-' + id);
            if (elem) {
                elem.remove();
                updateTotal();
            }
        }

        function updateTotal() {
            let total = 0;
            const products = document.querySelectorAll('.product-item');
            products.forEach(p => {
                const select = p.querySelector('select');
                const input = p.querySelector('input[type="number"]');
                if (select.value && input.value) {
                    const [name, price] = select.value.split('|');
                    total += parseInt(price) * parseInt(input.value);
                }
            });
            document.getElementById('totalPesanan').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        function savePesanan() {
            const type = document.querySelector('input[name="tipePesanan"]:checked').value;
            const newPesanan = {
                id: type === 'karyawan' ? 'K' + String(pesananData.karyawan.length + 1).padStart(3, '0') : 'P' + String(pesananData.pelanggan.length + 1).padStart(3, '0'),
                nama: type === 'karyawan' ? document.getElementById('namaKaryawan').value : document.getElementById('namaPelanggan').value,
                status: type === 'karyawan' ? 'belum_stor' : 'pending',
                tanggal_pesan: new Date().toISOString().split('T')[0],
                total: parseInt(document.getElementById('totalPesanan').textContent.replace(/\D/g, '')) || 0,
                produk: []
            };

            if (type === 'karyawan') {
                newPesanan.tanggal_pickup = document.getElementById('tanggalPickupKaryawan').value;
                pesananData.karyawan.push(newPesanan);
            } else {
                newPesanan.pembayaran = 'belum_lunas';
                newPesanan.tanggal_pickup = document.getElementById('tanggalPickupPelanggan').value;
                pesananData.pelanggan.push(newPesanan);
            }

            renderTables();
            closeModal('modalAddPesanan');
            alert('Pesanan berhasil disimpan!');
        }

        function showDetail(type, index) {
            const pesanan = type === 'karyawan' ? pesananData.karyawan[index] : pesananData.pelanggan[index];
            const detailContent = document.getElementById('detailContent');
            const isKaryawan = type === 'karyawan';

            let html = `
                <div class="form-group">
                    <label style="font-weight: 600; color: var(--dark-gray);">ID Pesanan</label>
                    <p style="margin-top: 4px; font-size: 14px;">${pesanan.id}</p>
                </div>
                <div class="form-group">
                    <label style="font-weight: 600; color: var(--dark-gray);">Nama ${isKaryawan ? 'Karyawan' : 'Pelanggan'}</label>
                    <p style="margin-top: 4px; font-size: 14px;">${pesanan.nama}</p>
                </div>
                <div class="form-group">
                    <label style="font-weight: 600; color: var(--dark-gray);">Status</label>
                    <p style="margin-top: 4px; font-size: 14px;">
                        <span class="status-badge ${pesanan.status}">${isKaryawan ? (pesanan.status === 'stor' ? 'Stor' : 'Belum Stor') : (pesanan.status === 'pending' ? 'Pending' : pesanan.status === 'di_proses' ? 'Di Proses' : 'Selesai')}</span>
                    </p>
                </div>
                <div class="form-group">
                    <label style="font-weight: 600; color: var(--dark-gray);">Tanggal Pesan</label>
                    <p style="margin-top: 4px; font-size: 14px;">${new Date(pesanan.tanggal_pesan).toLocaleDateString('id-ID')}</p>
                </div>
            `;

            if (!isKaryawan) {
                html += `
                    <div class="form-group">
                        <label style="font-weight: 600; color: var(--dark-gray);">Pembayaran</label>
                        <p style="margin-top: 4px; font-size: 14px;">
                            <span class="payment-badge ${pesanan.pembayaran}">${pesanan.pembayaran === 'lunas' ? 'Lunas' : 'Belum Lunas'}</span>
                        </p>
                    </div>
                `;
            }

            html += `
                <div class="form-group">
                    <label style="font-weight: 600; color: var(--dark-gray);">Tanggal Pickup</label>
                    <p style="margin-top: 4px; font-size: 14px;">${new Date(pesanan.tanggal_pickup).toLocaleDateString('id-ID')}</p>
                </div>
                <div class="form-group">
                    <label style="font-weight: 600; color: var(--dark-gray); margin-bottom: 12px; display: block;">Detail Produk</label>
                    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                        <thead>
                            <tr style="background: var(--light-gray);">
                                <th style="padding: 8px; border: 1px solid var(--medium-gray); text-align: left;">Produk</th>
                                <th style="padding: 8px; border: 1px solid var(--medium-gray); text-align: center;">Jumlah</th>
                                <th style="padding: 8px; border: 1px solid var(--medium-gray); text-align: right;">Harga</th>
                                <th style="padding: 8px; border: 1px solid var(--medium-gray); text-align: right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            pesanan.produk.forEach(p => {
                html += `
                    <tr>
                        <td style="padding: 8px; border: 1px solid var(--medium-gray);">${p.nama}</td>
                        <td style="padding: 8px; border: 1px solid var(--medium-gray); text-align: center;">${p.jumlah}</td>
                        <td style="padding: 8px; border: 1px solid var(--medium-gray); text-align: right;">Rp ${(p.harga).toLocaleString('id-ID')}</td>
                        <td style="padding: 8px; border: 1px solid var(--medium-gray); text-align: right;">Rp ${(p.subtotal).toLocaleString('id-ID')}</td>
                    </tr>
                `;
            });

            html += `
                        </tbody>
                    </table>
                </div>
                <div class="total-section">
                    <span>Total Keseluruhan:</span>
                    <span>Rp ${(pesanan.total).toLocaleString('id-ID')}</span>
                </div>
            `;

            detailContent.innerHTML = html;
            document.getElementById('modalDetail').classList.add('show');
        }

        function showEdit(type, index) {
            const pesanan = type === 'karyawan' ? pesananData.karyawan[index] : pesananData.pelanggan[index];
            const isKaryawan = type === 'karyawan';
            let editContent = document.getElementById('editContent');

            let html = `
                <input type="hidden" id="editType" value="${type}">
                <input type="hidden" id="editIndex" value="${index}">
                <div class="form-group">
                    <label class="form-label">Nama ${isKaryawan ? 'Karyawan' : 'Pelanggan'}</label>
                    <input type="text" class="form-control" id="editNama" value="${pesanan.nama}">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-control" id="editStatus">
            `;

            if (isKaryawan) {
                html += `
                        <option value="stor" ${pesanan.status === 'stor' ? 'selected' : ''}>Stor</option>
                        <option value="belum_stor" ${pesanan.status === 'belum_stor' ? 'selected' : ''}>Belum Stor</option>
                `;
            } else {
                html += `
                        <option value="pending" ${pesanan.status === 'pending' ? 'selected' : ''}>Pending</option>
                        <option value="di_proses" ${pesanan.status === 'di_proses' ? 'selected' : ''}>Di Proses</option>
                        <option value="selesai" ${pesanan.status === 'selesai' ? 'selected' : ''}>Selesai</option>
                `;
            }

            html += `</select>
                </div>
            `;

            if (!isKaryawan) {
                html += `
                    <div class="form-group">
                        <label class="form-label">Pembayaran</label>
                        <select class="form-control" id="editPembayaran">
                            <option value="lunas" ${pesanan.pembayaran === 'lunas' ? 'selected' : ''}>Lunas</option>
                            <option value="belum_lunas" ${pesanan.pembayaran === 'belum_lunas' ? 'selected' : ''}>Belum Lunas</option>
                        </select>
                    </div>
                `;
            }

            editContent.innerHTML = html;
            document.getElementById('modalEdit').classList.add('show');
        }

        function saveEdit() {
            const type = document.getElementById('editType').value;
            const index = parseInt(document.getElementById('editIndex').value);
            const pesanan = type === 'karyawan' ? pesananData.karyawan[index] : pesananData.pelanggan[index];

            pesanan.nama = document.getElementById('editNama').value;
            pesanan.status = document.getElementById('editStatus').value;

            if (type !== 'karyawan') {
                pesanan.pembayaran = document.getElementById('editPembayaran').value;
            }

            renderTables();
            closeModal('modalEdit');
            alert('Perubahan berhasil disimpan!');
        }

        function deletePesanan(type, index) {
            if (confirm('Apakah Anda yakin ingin menghapus pesanan ini?')) {
                if (type === 'karyawan') {
                    pesananData.karyawan.splice(index, 1);
                } else {
                    pesananData.pelanggan.splice(index, 1);
                }
                renderTables();
                alert('Pesanan berhasil dihapus!');
            }
        }

        function markComplete(type, index) {
            const pesanan = type === 'karyawan' ? pesananData.karyawan[index] : pesananData.pelanggan[index];
            if (type === 'karyawan') {
                pesanan.status = pesanan.status === 'stor' ? 'belum_stor' : 'stor';
            } else {
                pesanan.status = pesanan.status === 'selesai' ? 'pending' : 'selesai';
            }
            renderTables();
        }

        // Search Functions
        function setupSearch() {
            document.getElementById('searchKaryawan').addEventListener('keyup', function() {
                filterTable('karyawan');
            });
            document.getElementById('searchPelanggan').addEventListener('keyup', function() {
                filterTable('pelanggan');
            });
        }

        function filterTable(type) {
            const searchValue = type === 'karyawan' ? 
                document.getElementById('searchKaryawan').value.toLowerCase() : 
                document.getElementById('searchPelanggan').value.toLowerCase();
            const filterValue = type === 'karyawan' ? 
                document.getElementById('filterKaryawan').value : 
                document.getElementById('filterPelanggan').value;

            const tbody = type === 'karyawan' ? 
                document.getElementById('bodyKaryawan') : 
                document.getElementById('bodyPelanggan');
            const rows = tbody.getElementsByTagName('tr');

            let hasVisibleRows = false;

            for (let row of rows) {
                const text = row.textContent.toLowerCase();
                const status = row.getAttribute('data-status') || '';
                
                let show = text.includes(searchValue);
                if (filterValue) {
                    show = show && status === filterValue;
                }

                row.style.display = show ? '' : 'none';
                if (show) hasVisibleRows = true;
            }

            if (!hasVisibleRows && pesananData[type].length > 0) {
                tbody.innerHTML = `<tr><td colspan="${type === 'karyawan' ? 5 : 6}" style="text-align: center; color: var(--dark-gray); padding: 40px;">
                    <i class="fas fa-search" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                    Pesanan tidak ditemukan
                </td></tr>`;
            }
        }

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
