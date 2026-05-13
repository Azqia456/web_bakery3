@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* VARIABEL DAN CSS DARI DASHBOARD */
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

    body {
        font-family: 'Poppins', 'Inter', sans-serif;
        background-color: var(--cream);
        color: var(--text-dark);
        margin: 0;
    }

    .min-h-screen > nav { display: none; }

    .dashboard {
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar CSS */
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
    }
    .sidebar-header p {
        font-size: 12px;
        opacity: 0.8;
        font-weight: 500;
    }
    .sidebar-menu { padding: 16px 0; }
    .sidebar-menu-item { margin: 4px 16px; }
    .sidebar-menu-item > a, .sidebar-menu-toggle {
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
    }
    .sidebar-menu-item > a:hover, .sidebar-menu-item > a.active,
    .sidebar-menu-toggle:hover, .sidebar-menu-toggle.active {
        background-color: rgba(255, 255, 255, 0.15);
        color: var(--white);
    }
    .sidebar-menu-item > a.active {
        background-color: rgba(255, 255, 255, 0.2);
    }
    .sidebar-menu-item i, .sidebar-menu-toggle i {
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
    }
    .sidebar-menu-item .toggle-arrow.open { transform: rotate(180deg); }
    .sidebar-submenu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        background: rgba(0, 0, 0, 0.1);
        border-radius: var(--border-radius);
        margin: 0 8px;
    }
    .sidebar-submenu.open { max-height: 500px; }
    .sidebar-submenu-item {
        padding: 10px 16px 10px 48px;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        display: flex;
        align-items: center;
        font-size: 13px;
        transition: var(--transition);
    }
    .sidebar-submenu-item:hover { color: var(--white); padding-left: 52px; }

    /* Main Content CSS */
    .main-content {
        flex: 1;
        margin-left: 280px;
        background-color: var(--cream);
    }

    /* Header CSS */
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
    .header-title { font-size: 22px; font-weight: 700; color: var(--text-dark); margin: 0; }
    .header-right { display: flex; align-items: center; gap: 14px; }
    .notification-btn {
        position: relative;
        width: 40px; height: 40px;
        border-radius: 50%;
        background: var(--light-gray);
        border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: var(--transition); color: var(--dark-gray);
    }
    .notification-btn:hover { background: var(--medium-gray); transform: scale(1.05); }
    .notification-badge {
        position: absolute; top: -2px; right: -2px;
        width: 18px; height: 18px;
        background: #EF4444; color: white;
        border-radius: 50%; font-size: 10px; font-weight: 600;
        display: flex; align-items: center; justify-content: center;
    }
    .profile-btn {
        position: relative;
        display: inline-flex; align-items: center; gap: 10px;
        padding: 6px 10px;
        border-radius: 999px;
        background: var(--light-gray);
        border: none; cursor: pointer;
        transition: var(--transition); color: var(--text-dark);
    }
    .profile-btn:hover { background: var(--medium-gray); }
    .profile-avatar {
        width: 32px; height: 32px; border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-green), #81C784);
        color: white; display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 13px;
    }
    .profile-name { font-size: 14px; font-weight: 600; color: var(--text-dark); }
    .profile-dropdown {
        position: absolute; top: calc(100% + 10px); right: 0;
        min-width: 180px; background: var(--white);
        border: 1px solid var(--medium-gray); border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg); padding: 8px; display: none; z-index: 1001;
    }
    .profile-dropdown.show { display: block; }
    .profile-dropdown a, .profile-dropdown button {
        width: 100%; display: flex; align-items: center; gap: 10px;
        padding: 10px 12px; border: none; border-radius: 10px;
        background: transparent; color: var(--text-dark);
        text-decoration: none; font-size: 14px; font-weight: 500;
        cursor: pointer; text-align: left; transition: var(--transition);
    }
    .profile-dropdown a:hover, .profile-dropdown button:hover { background: var(--light-gray); }
    .profile-dropdown .logout-action { color: #EF4444; }

    .dashboard-content { padding: 24px; }

    /* CSS KHUSUS HALAMAN PRODUK */
    .line-clamp-2 {
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .product-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white; border-radius: 12px; border: 1px solid #E8DFD5; overflow: hidden;
    }
    .product-card:hover {
        transform: translateY(-6px); box-shadow: 0 16px 32px rgba(134, 111, 71, 0.12); border-color: #D4BFA8;
    }
    .product-image {
        width: 100%; height: 200px; object-fit: cover; transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .product-card:hover .product-image { transform: scale(1.05); }
    .filter-badge {
        display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px;
        border-radius: 20px; border: 1px solid #D4BFA8; background: white; color: #6B5F54;
        font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.3s ease;
    }
    .filter-badge.active { background: #C69C6D; color: white; border-color: #C69C6D; }
    .filter-badge:hover:not(.active) { border-color: #A0815A; }
    .btn-transition { transition: all 0.3s ease; }
    .btn-transition:active { transform: scale(0.98); }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar { transform: translateX(-100%); }
        .main-content { margin-left: 0; }
        .header { padding: 12px 16px; }
    }
</style>

<div class="dashboard">
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
                <a href="/produk" class="active" style="justify-content: flex-start; gap: 12px;">
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
                <a href="/laporan" style="justify-content: flex-start; gap: 12px;">
                    <i class="fas fa-chart-line"></i>
                    <span style="font-weight:700;">Laporan</span>
                </a>
            </div>
        </nav>
    </aside>

    <div class="main-content">
        <header class="header">
            <div class="header-left">
                <h1 class="header-title">Produk</h1>
            </div>

            <div class="header-right">
                <button class="notification-btn" type="button" aria-label="Notifikasi">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 01-6 0" />
                    </svg>
                    <span class="notification-badge">3</span>
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
                        <span class="profile-name">{{ $userName }}</span>
                    </button>

                    <div class="profile-dropdown" id="profileDropdown">
                        <a href="#"> <i class="fas fa-user"></i>
                            Profil
                        </a>
                        <form action="#" method="POST"> @csrf
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
            <div class="max-w-7xl mx-auto">
                <div class="mb-8 md:mb-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#42352A] mb-2">
                        Katalog Produk
                    </h2>
                    <p class="text-[#8B7355] text-base md:text-lg font-light">
                        Kelola semua produk roti dan varian rasa
                    </p>
                </div>

                <div class="flex flex-col gap-4 md:flex-row md:gap-6 md:items-center md:justify-between mb-10">
                    <div class="flex gap-2 items-center flex-wrap">
                        <button class="filter-badge active" data-filter="semua">
                            <span>🎯</span>
                            <span>Semua Produk</span>
                        </button>
                        <button class="filter-badge" data-filter="aktif">
                            <span>🟢</span>
                            <span>Aktif</span>
                        </button>
                        <button class="filter-badge" data-filter="nonaktif">
                            <span>⭕</span>
                            <span>Nonaktif</span>
                        </button>
                    </div>

                    <div class="flex gap-3 w-full md:w-auto md:flex-1 justify-end">
                        <div class="relative w-full md:w-80">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-[#A0815A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input
                                type="text"
                                id="searchInput"
                                placeholder="Cari produk..."
                                class="w-full pl-10 pr-4 py-2.5 rounded-lg bg-white border border-[#D4BFA8] focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent text-[#42352A] placeholder-[#A0815A] text-sm"
                            />
                        </div>

                        <button class="btn-transition flex items-center justify-center gap-2 px-4 py-2.5 bg-[#C69C6D] hover:bg-[#B38A5C] text-white rounded-lg font-semibold text-sm shadow-sm whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Tambah Produk</span>
                        </button>
                    </div>
                </div>

                <div id="produkGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    </div>

                <div id="emptyState" class="hidden text-center py-20">
                    <div class="text-7xl mb-4">📦</div>
                    <h3 class="text-2xl md:text-3xl font-bold text-[#42352A] mb-2">
                        Tidak ada produk
                    </h3>
                    <p class="text-[#8B7355] text-lg">
                        Coba ubah filter atau cari dengan kata kunci yang berbeda
                    </p>
                </div>
            </div>
        </main>
    </div>
</div>

<div id="addProductModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="border-b border-[#E5D5C0] p-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-[#42352A]">Tambah Produk Baru</h2>
                <button type="button" id="closeModal" class="text-[#8B7355] hover:text-[#42352A] text-2xl leading-none">
                    ×
                </button>
            </div>
        </div>

        <form id="addProductForm" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    Nama Produk
                </label>
                <input
                    type="text"
                    id="productName"
                    placeholder="Contoh: D'Coklat"
                    class="w-full px-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent"
                    required
                />
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    Deskripsi
                </label>
                <textarea
                    id="productDescription"
                    placeholder="Deskripsi produk..."
                    rows="3"
                    class="w-full px-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent resize-none"
                    required
                ></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    Harga
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-[#A0815A] font-semibold">Rp. </span>
                    <input
                        type="number"
                        id="productPrice"
                        placeholder="1.300"
                        class="w-full pl-12 pr-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent"
                        required
                    />
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    URL Gambar
                </label>
                <input
                    type="text"
                    id="productImage"
                    placeholder="/image/produk.jpg"
                    class="w-full px-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent text-sm"
                    required
                />
            </div>

            <div class="flex gap-3 pt-4 border-t border-[#E5D5C0]">
                <button
                    type="button"
                    id="cancelBtn"
                    class="flex-1 px-4 py-2.5 border border-[#D4BFA8] rounded-lg text-[#42352A] font-semibold hover:bg-[#F9F6F1] transition-colors"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="flex-1 px-4 py-2.5 bg-[#C69C6D] hover:bg-[#B38A5C] text-white rounded-lg font-semibold transition-colors"
                >
                    Tambah
                </button>
            </div>
        </form>
    </div>
</div>

<div id="editProductModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="border-b border-[#E5D5C0] p-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-[#42352A]">Edit Produk</h2>
                <button type="button" id="closeEditModal" class="text-[#8B7355] hover:text-[#42352A] text-2xl leading-none">
                    ×
                </button>
            </div>
        </div>

        <form id="editProductForm" class="p-6 space-y-4">
            <input type="hidden" id="editProductId" />

            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    Nama Produk
                </label>
                <input
                    type="text"
                    id="editProductName"
                    class="w-full px-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent"
                    required
                />
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    Deskripsi
                </label>
                <textarea
                    id="editProductDescription"
                    rows="3"
                    class="w-full px-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent resize-none"
                    required
                ></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    Harga
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-[#A0815A] font-semibold">Rp. </span>
                    <input
                        type="number"
                        id="editProductPrice"
                        class="w-full pl-12 pr-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent"
                        required
                    />
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    URL Gambar
                </label>
                <input
                    type="text"
                    id="editProductImage"
                    class="w-full px-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent text-sm"
                    required
                />
            </div>

            <div class="flex gap-3 pt-4 border-t border-[#E5D5C0]">
                <button
                    type="button"
                    id="cancelEditBtn"
                    class="flex-1 px-4 py-2.5 border border-[#D4BFA8] rounded-lg text-[#42352A] font-semibold hover:bg-[#F9F6F1] transition-colors"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="flex-1 px-4 py-2.5 bg-[#C69C6D] hover:bg-[#B38A5C] text-white rounded-lg font-semibold transition-colors"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // FUNGSI UNTUK SIDEBAR DAN HEADER DARI DASHBOARD
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

    // DATA DAN FUNGSI PRODUK - SINKRONISASI DENGAN DATABASE
    let produkData = [];
    let currentFilter = 'semua';
    let currentSearch = '';

    // Load data produk dari API
    async function loadProducts() {
        try {
            const response = await fetch('/api/produks');
            const data = await response.json();
            
            // Transform data dari database ke format UI
            produkData = data.map(produk => ({
                id: produk.id_produk,
                nama: produk.nama_produk,
                harga: produk.harga_produk,
                deskripsi: '',
                gambar: 'https://via.placeholder.com/400x300?text=' + encodeURIComponent(produk.nama_produk),
                status: 'aktif'
            }));
            
            renderProducts();
        } catch (error) {
            console.error('Error loading products:', error);
            renderProducts();
        }
    }

    function renderProducts() {
        const grid = document.getElementById('produkGrid');
        const emptyState = document.getElementById('emptyState');
        
        const filtered = produkData.filter((produk) => {
            const matchSearch = produk.nama.toLowerCase().includes(currentSearch.toLowerCase());
            const matchFilter = currentFilter === 'semua' || produk.status === currentFilter;
            return matchSearch && matchFilter;
        });

        if (filtered.length === 0) {
            grid.innerHTML = '';
            emptyState.classList.remove('hidden');
            return;
        }

        grid.innerHTML = filtered.map(produk => `
            <div class="product-card bg-white rounded-lg border border-[#E8DFD5]">
                <div class="relative h-48 overflow-hidden bg-[#F5F1EB]">
                    <img
                        src="${produk.gambar}"
                        alt="${produk.nama}"
                        class="product-image w-full h-full"
                        onerror="this.src='https://via.placeholder.com/400x300?text=${encodeURIComponent(produk.nama)}'"
                    />
                    <div class="absolute top-3 right-3">
                        <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-500 text-white text-xs font-bold rounded-full shadow-md">
                            <span class="w-1.5 h-1.5 bg-emerald-200 rounded-full"></span>
                            Aktif
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-base font-bold text-[#42352A] mb-2 line-clamp-1">${produk.nama}</h3>
                    <p class="text-sm text-[#8B7355] mb-3 line-clamp-2">${produk.deskripsi || 'Produk dari database'}</p>
                    <p class="text-base font-bold text-[#A0815A] mb-3">Rp. ${Number(produk.harga).toLocaleString('id-ID')}</p>
                    <div class="flex gap-2">
                        <button class="btn-transition edit-btn flex-1 flex items-center justify-center gap-1.5 px-3 py-2 bg-[#F9D79B] hover:bg-[#F6C878] text-[#42352A] rounded-lg font-semibold text-sm shadow-sm" data-product-id="${produk.id}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Edit</span>
                        </button>
                        <button class="btn-transition delete-btn flex-1 flex items-center justify-center gap-1.5 px-3 py-2 bg-[#FFD1DC] hover:bg-[#FFBBD4] text-[#C41E3A] rounded-lg font-semibold text-sm shadow-sm" data-product-id="${produk.id}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');

        attachButtonListeners();
    }

    function attachButtonListeners() {
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const productId = parseInt(e.currentTarget.dataset.productId);
                const product = produkData.find(p => p.id === productId);
                
                if (product) {
                    document.getElementById('editProductId').value = product.id;
                    document.getElementById('editProductName').value = product.nama;
                    document.getElementById('editProductDescription').value = product.deskripsi || '';
                    document.getElementById('editProductPrice').value = product.harga;
                    document.getElementById('editProductImage').value = product.gambar;
                    document.getElementById('editProductModal').classList.remove('hidden');
                }
            });
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                const productId = parseInt(e.currentTarget.dataset.productId);
                const product = produkData.find(p => p.id === productId);
                
                if (product && confirm(`Hapus produk "${product.nama}"?`)) {
                    try {
                        const response = await fetch(`/api/produks/${productId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                                'Accept': 'application/json'
                            }
                        });
                        
                        if (response.ok) {
                            produkData = produkData.filter(p => p.id !== productId);
                            renderProducts();
                            alert('Produk berhasil dihapus!');
                        } else {
                            alert('Gagal menghapus produk!');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghapus produk!');
                    }
                }
            });
        });
    }

    document.getElementById('searchInput').addEventListener('input', (e) => {
        currentSearch = e.target.value;
        renderProducts();
    });

    document.querySelectorAll('.filter-badge').forEach(btn => {
        btn.addEventListener('click', (e) => {
            currentFilter = e.currentTarget.dataset.filter;
            document.querySelectorAll('.filter-badge').forEach(b => b.classList.remove('active'));
            e.currentTarget.classList.add('active');
            renderProducts();
        });
    });

    // Modals
    const modal = document.getElementById('addProductModal');
    const addProductForm = document.getElementById('addProductForm');

    setTimeout(() => {
        const tambahBtn = Array.from(document.querySelectorAll('button')).find(btn => btn.textContent.includes('Tambah Produk'));
        if (tambahBtn) tambahBtn.addEventListener('click', () => modal.classList.remove('hidden'));
    }, 100);

    document.getElementById('closeModal').addEventListener('click', () => { modal.classList.add('hidden'); addProductForm.reset(); });
    document.getElementById('cancelBtn').addEventListener('click', () => { modal.classList.add('hidden'); addProductForm.reset(); });
    modal.addEventListener('click', (e) => { if (e.target === modal) { modal.classList.add('hidden'); addProductForm.reset(); } });

    addProductForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = {
            nama_produk: document.getElementById('productName').value,
            harga_produk: parseFloat(document.getElementById('productPrice').value)
        };

        try {
            const response = await fetch('/api/produks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (response.ok) {
                produkData.push({
                    id: result.id_produk,
                    nama: result.nama_produk,
                    harga: result.harga_produk,
                    deskripsi: '',
                    gambar: 'https://via.placeholder.com/400x300?text=' + encodeURIComponent(result.nama_produk),
                    status: 'aktif'
                });
                renderProducts();
                modal.classList.add('hidden');
                addProductForm.reset();
                alert('Produk berhasil ditambahkan ke database!');
            } else {
                alert('Gagal menambahkan produk: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menambahkan produk!');
        }
    });

    const editModal = document.getElementById('editProductModal');
    const editProductForm = document.getElementById('editProductForm');

    document.getElementById('closeEditModal').addEventListener('click', () => { editModal.classList.add('hidden'); editProductForm.reset(); });
    document.getElementById('cancelEditBtn').addEventListener('click', () => { editModal.classList.add('hidden'); editProductForm.reset(); });
    editModal.addEventListener('click', (e) => { if (e.target === editModal) { editModal.classList.add('hidden'); editProductForm.reset(); } });

    editProductForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const productId = parseInt(document.getElementById('editProductId').value);
        const formData = {
            nama_produk: document.getElementById('editProductName').value,
            harga_produk: parseFloat(document.getElementById('editProductPrice').value)
        };

        try {
            const response = await fetch(`/api/produks/${productId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (response.ok) {
                const product = produkData.find(p => p.id === productId);
                if (product) {
                    product.nama = result.nama_produk;
                    product.harga = result.harga_produk;
                    renderProducts();
                }
                editModal.classList.add('hidden');
                editProductForm.reset();
                alert('Produk berhasil diperbarui di database!');
            } else {
                alert('Gagal memperbarui produk: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memperbarui produk!');
        }
    });

    // Load produk saat halaman dimuat
    loadProducts();
</script>
@endsection