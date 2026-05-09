<aside class="sidebar">
    <div class="sidebar-header">
        <h1>🍞 Three D Bakery</h1>
        <p>Management System</p>
    </div>
    <nav class="sidebar-menu">
        <div class="sidebar-menu-item">
            <a href="/dashboard" class="{{ Request::is('dashboard') ? 'active' : '' }}" style="justify-content: flex-start; gap: 12px;">
                <i class="fas fa-tachometer-alt"></i>
                <span style="font-weight:700;">Dashboard</span>
            </a>
        </div>

        <div class="sidebar-menu-item">
            <button class="sidebar-menu-toggle {{ Request::is('pesanan*') ? 'active' : '' }}" onclick="toggleSubmenu(this)" style="justify-content: flex-start; gap: 12px;">
                <i class="fas fa-shopping-cart"></i>
                <span style="font-weight:700;">Pesanan</span>
                <i class="fas fa-chevron-down toggle-arrow {{ Request::is('pesanan*') ? 'open' : '' }}"></i>
            </button>
            <div class="sidebar-submenu {{ Request::is('pesanan*') ? 'open' : '' }}">
                <a href="/pesanan-online" class="sidebar-submenu-item {{ Request::is('pesanan-online') ? 'active' : '' }}">Pesanan Online</a>
                <a href="/pesanan-offline" class="sidebar-submenu-item {{ Request::is('pesanan-offline') ? 'active' : '' }}">Pesanan Offline</a>
            </div>
        </div>

        <div class="sidebar-menu-item">
            <button class="sidebar-menu-toggle {{ Request::is('data*') ? 'active' : '' }}" onclick="toggleSubmenu(this)" style="justify-content: flex-start; gap: 12px;">
                <i class="fas fa-database"></i>
                <span style="font-weight:700;">Data</span>
                <i class="fas fa-chevron-down toggle-arrow {{ Request::is('data*') ? 'open' : '' }}"></i>
            </button>
            <div class="sidebar-submenu {{ Request::is('data*') ? 'open' : '' }}">
                <a href="/data-karyawan" class="sidebar-submenu-item {{ Request::is('data-karyawan') ? 'active' : '' }}">Data Karyawan</a>
                <a href="/data-pelanggan" class="sidebar-submenu-item {{ Request::is('data-pelanggan') ? 'active' : '' }}">Data Pelanggan</a>
            </div>
        </div>

        <div class="sidebar-menu-item">
            <a href="/produk" class="{{ Request::is('produk') ? 'active' : '' }}" style="justify-content: flex-start; gap: 12px;">
                <i class="fas fa-box"></i>
                <span style="font-weight:700;">Produk</span>
            </a>
        </div>

        <div class="sidebar-menu-item">
            <button class="sidebar-menu-toggle {{ Request::is('stor*') || Request::is('riwayat*') ? 'active' : '' }}" onclick="toggleSubmenu(this)" style="justify-content: flex-start; gap: 12px;">
                <i class="fas fa-credit-card"></i>
                <span style="font-weight:700;">Pembayaran</span>
                <i class="fas fa-chevron-down toggle-arrow {{ Request::is('stor*') || Request::is('riwayat*') ? 'open' : '' }}"></i>
            </button>
            <div class="sidebar-submenu {{ Request::is('stor*') || Request::is('riwayat*') ? 'open' : '' }}">
                <a href="/stor-karyawan" class="sidebar-submenu-item {{ Request::is('stor-karyawan') ? 'active' : '' }}">Stor Karyawan</a>
                <a href="/riwayat-transaksi" class="sidebar-submenu-item {{ Request::is('riwayat-transaksi') ? 'active' : '' }}">Riwayat Transaksi Pelanggan</a>
            </div>
        </div>

        <div class="sidebar-menu-item">
            <a href="/laporan" class="{{ Request::is('laporan') ? 'active' : '' }}" style="justify-content: flex-start; gap: 12px;">
                <i class="fas fa-chart-line"></i>
                <span style="font-weight:700;">Laporan</span>
            </a>
        </div>
    </nav>
</aside>