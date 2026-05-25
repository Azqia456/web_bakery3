@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --primary-brown: #8B6F47;
        --light-brown: #D4A574;
        --cream: #F7F3E9;
        --white: #FFFFFF;
        --light-gray: #F8F9FA;
        --medium-gray: #E9ECEF;
        --dark-gray: #6C757D;
        --text-dark: #2D3748;
        --accent: #C69C6D;
        --accent-dark: #8B6F47;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 6px 16px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 16px 28px rgba(0, 0, 0, 0.12);
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
        font-size: 16px;
        background: var(--cream);
        color: var(--text-dark);
    }

    .min-h-screen > nav {
        display: none;
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
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 4px;
        letter-spacing: -0.02em;
    }

    .sidebar-header p {
        font-size: 13px;
        opacity: 0.85;
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
        font-size: 15px;
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
        font-size: 17px;
    }

    .sidebar-menu-item .toggle-arrow {
        font-size: 13px;
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
        font-size: 14px;
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
        min-height: 100vh;
        background:
            radial-gradient(1200px 600px at 10% 0%, rgba(212, 165, 116, 0.18), transparent 50%),
            radial-gradient(900px 500px at 90% 10%, rgba(139, 111, 71, 0.12), transparent 45%),
            var(--cream);
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
        gap: 12px;
    }

    .menu-btn {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        border: 1px solid var(--medium-gray);
        background: var(--light-gray);
        color: var(--text-dark);
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .menu-btn:hover {
        background: var(--medium-gray);
        transform: translateY(-1px);
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 15px;
        color: var(--dark-gray);
        font-weight: 600;
    }

    .breadcrumb .current {
        color: var(--text-dark);
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 12px;
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
        color: var(--white);
        border-radius: 50%;
        font-size: 11px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-menu {
        position: relative;
    }

    .profile-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-brown), #C8A25A);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
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
        font-size: 15px;
        font-weight: 600;
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

    .dashboard-content {
        padding: 28px 24px 40px;
    }

    .page-hero {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
        animation: fadeUp 0.5s ease;
    }

    .page-title h1 {
        font-size: 32px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .page-title p {
        margin-top: 8px;
        color: #8A7561;
        font-size: 17px;
        font-weight: 300;
    }

    .page-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-input {
        position: relative;
        min-width: 240px;
        flex: 1;
    }

    .search-input input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border: 1px solid var(--medium-gray);
        border-radius: 12px;
        background: var(--white);
        font-size: 15px;
        transition: var(--transition);
    }

    .search-input input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(198, 156, 109, 0.16);
    }

    .search-input i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--dark-gray);
        font-size: 15px;
    }

    .filter-select {
        position: relative;
    }

    .filter-select select {
        padding: 10px 36px 10px 36px;
        border: 1px solid var(--medium-gray);
        border-radius: 12px;
        background: var(--white);
        font-size: 15px;
        appearance: none;
        cursor: pointer;
        min-width: 140px;
    }

    .filter-select i {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: var(--dark-gray);
        font-size: 13px;
        pointer-events: none;
    }

    .filter-select .filter-icon {
        left: 12px;
    }

    .filter-select .select-arrow {
        right: 12px;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, var(--accent), var(--accent-dark));
        color: var(--white);
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .summary-card {
        background: var(--white);
        border-radius: var(--border-radius-xl);
        border: 1px solid rgba(198, 156, 109, 0.2);
        padding: 18px;
        display: flex;
        gap: 14px;
        align-items: center;
        box-shadow: var(--shadow-sm);
        animation: fadeUp 0.6s ease;
    }

    .summary-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .summary-icon.tan { background: rgba(198, 156, 109, 0.18); color: #8B6F47; }
    .summary-icon.green { background: rgba(34, 197, 94, 0.15); color: #22C55E; }
    .summary-icon.orange { background: rgba(249, 115, 22, 0.15); color: #F97316; }
    .summary-icon.blue { background: rgba(59, 130, 246, 0.15); color: #3B82F6; }

    .summary-meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .summary-title {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--dark-gray);
    }

    .summary-value {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .summary-subtext {
        font-size: 13px;
        color: #8A7561;
    }

    .table-card {
        background: var(--white);
        border-radius: var(--border-radius-xl);
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(198, 156, 109, 0.2);
        overflow: hidden;
        animation: fadeUp 0.7s ease;
    }

    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px;
        border-bottom: 1px solid var(--medium-gray);
        background: linear-gradient(180deg, #FFFDF9 0%, #FFFFFF 100%);
    }

    .table-title h2 {
        font-size: 23px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .table-title span {
        font-size: 17px;
        color: var(--dark-gray);
    }

    .btn-ghost {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 10px;
        border: 1px solid var(--medium-gray);
        background: var(--light-gray);
        color: var(--text-dark);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-ghost:hover {
        background: var(--medium-gray);
    }

    .table-wrap {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 720px;
    }

    th,
    td {
        padding: 14px 16px;
        text-align: left;
        font-size: 16px;
    }

    thead th {
        background: #FCFAF7;
        color: #806D5A;
        font-weight: 700;
        font-size: 17px;
        letter-spacing: 0.3px;
    }

    tbody tr {
        border-top: 1px solid var(--medium-gray);
        transition: var(--transition);
    }

    tbody tr:hover {
        background: #FBF8F2;
    }

    .table-date {
        display: block;
        font-weight: 600;
        color: var(--text-dark);
    }

    .table-time {
        display: block;
        font-size: 50x;
        color: var(--dark-gray);
        margin-top: 4px;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        border: 1px solid var(--medium-gray);
        background: var(--light-gray);
        color: #6B5F54;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
    }

    .action-btn:hover {
        background: var(--medium-gray);
        color: var(--text-dark);
    }

    .action-btn.danger {
        color: #EF4444;
        border-color: rgba(239, 68, 68, 0.2);
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(12px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 1024px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .main-content {
            margin-left: 0;
        }

        .page-hero {
            flex-direction: column;
        }

        .page-actions {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .header {
            padding: 12px 16px;
        }

        .dashboard-content {
            padding: 20px 16px 32px;
        }

        .page-title h1 {
            font-size: 40px;
        }
    }

    @media (min-width: 768px) {
        .page-title h1 {
            font-size: 40px;
        }

        .page-title p {
            font-size: px;
        }
    }
</style>

<div class="dashboard">
    @include('profile.partials.sidebar_owner')

    <div class="main-content">
        <header class="header">
            <div class="header-left">
                <button class="menu-btn" type="button" aria-label="Menu">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="breadcrumb">
                    <span>Owner</span>
                    <span>/</span>
                    <span class="current">Data Pelanggan</span>
                </div>
            </div>
            <div class="header-right">
                <button class="notification-btn" type="button" aria-label="Notifikasi">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">0</span>
                </button>
                <div class="profile-menu">
                    @php
                        $userName = Auth::user()->name ?? 'Admin';
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
                        <a href="{{ route('profile.edit') }}">
                            <i class="fas fa-user"></i>
                            Profil
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
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

        <main class="dashboard-content">
            <section class="page-hero">
                <div class="page-title">
                    <h1>Data Pelanggan</h1>
                    <p>Kelola seluruh data pelanggan Three D Bakery</p>
                </div>
                <div class="page-actions">
                    <div class="search-input">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Cari pelanggan...">
                    </div>
                    <div class="filter-select">
                        <i class="fas fa-filter filter-icon"></i>
                        <select>
                            <option>Filter</option>
                            <option>Terbaru</option>
                            <option>Terlama</option>
                            <option>Terbanyak Pesanan</option>
                        </select>
                        <i class="fas fa-chevron-down select-arrow"></i>
                    </div>
                    <button class="btn-primary" type="button">
                        <i class="fas fa-plus"></i>
                        Tambah Pelanggan
                    </button>
                </div>
            </section>

            <section class="summary-grid">
                <div class="summary-card">
                    <div class="summary-icon tan">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="summary-meta">
                        <span class="summary-title">Total Pelanggan</span>
                        <span class="summary-value">120</span>
                        <span class="summary-subtext">Semua pelanggan terdaftar</span>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon green">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="summary-meta">
                        <span class="summary-title">Pelanggan Online</span>
                        <span class="summary-value">80</span>
                        <span class="summary-subtext">Dari website dan aplikasi</span>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon orange">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="summary-meta">
                        <span class="summary-title">Pelanggan Offline</span>
                        <span class="summary-value">40</span>
                        <span class="summary-subtext">Dari toko langsung</span>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon blue">
                        <i class="fas fa-bag-shopping"></i>
                    </div>
                    <div class="summary-meta">
                        <span class="summary-title">Total Pesanan Hari Ini</span>
                        <span class="summary-value">58</span>
                        <span class="summary-subtext">Semua transaksi hari ini</span>
                    </div>
                </div>
            </section>

            <section class="table-card">
                <div class="table-header">
                    <div class="table-title">
                        <h2>Daftar Pelanggan</h2>
                        <span>Daftar pelanggan terbaru Three D Bakery</span>
                    </div>
                    <button class="btn-ghost" type="button">
                        <i class="fas fa-file-export"></i>
                        Export
                    </button>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>No. HP</th>
                                <th>Total Pesanan</th>
                                <th>Terakhir Pesan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Aquila Aulia</td>
                                <td>0812-3456-7890</td>
                                <td>12 Pesanan</td>
                                <td>
                                    <span class="table-date">22 Mei 2026</span>
                                    <span class="table-time">10:45 WIB</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn" type="button" aria-label="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn" type="button" aria-label="Edit">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button class="action-btn danger" type="button" aria-label="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Rina Putri</td>
                                <td>0821-4567-8901</td>
                                <td>8 Pesanan</td>
                                <td>
                                    <span class="table-date">21 Mei 2026</span>
                                    <span class="table-time">16:20 WIB</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn" type="button" aria-label="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn" type="button" aria-label="Edit">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button class="action-btn danger" type="button" aria-label="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Dimas Saputra</td>
                                <td>0813-5678-9012</td>
                                <td>5 Pesanan</td>
                                <td>
                                    <span class="table-date">22 Mei 2026</span>
                                    <span class="table-time">09:15 WIB</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn" type="button" aria-label="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn" type="button" aria-label="Edit">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button class="action-btn danger" type="button" aria-label="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Nabila Putri</td>
                                <td>0822-6789-0123</td>
                                <td>3 Pesanan</td>
                                <td>
                                    <span class="table-date">20 Mei 2026</span>
                                    <span class="table-time">18:30 WIB</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn" type="button" aria-label="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn" type="button" aria-label="Edit">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button class="action-btn danger" type="button" aria-label="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Fajar Ramadhan</td>
                                <td>0831-7890-1234</td>
                                <td>7 Pesanan</td>
                                <td>
                                    <span class="table-date">22 Mei 2026</span>
                                    <span class="table-time">11:05 WIB</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn" type="button" aria-label="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn" type="button" aria-label="Edit">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button class="action-btn danger" type="button" aria-label="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</div>

<script>
    function toggleSubmenu(button) {
        const submenu = button.nextElementSibling;
        const arrow = button.querySelector('.toggle-arrow');

        submenu.classList.toggle('open');
        arrow.classList.toggle('open');
        button.classList.toggle('active');
    }

    const profileMenuButton = document.getElementById('profileMenuButton');
    const profileDropdown = document.getElementById('profileDropdown');

    if (profileMenuButton && profileDropdown) {
        const closeProfileDropdown = () => {
            profileDropdown.classList.remove('show');
            profileMenuButton.setAttribute('aria-expanded', 'false');
        };

        profileMenuButton.addEventListener('click', function(event) {
            event.stopPropagation();
            const isOpen = profileDropdown.classList.toggle('show');
            profileMenuButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        profileDropdown.addEventListener('click', function(event) {
            event.stopPropagation();
        });

        document.addEventListener('click', closeProfileDropdown);
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeProfileDropdown();
            }
        });
    }
</script>
@endsection
