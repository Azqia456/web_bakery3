@extends('layouts.dashboard-layout', ['pageTitle' => 'Data Pelanggan'])

@section('additional-styles')
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
        --font-base: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    button,
    input,
    select,
    textarea {
        font-family: inherit;
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
        font-size: 22px;
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

    .per-page-select select {
        min-width: 70px;
        padding: 10px 30px 10px 12px;
    }

    .per-page-select .filter-icon {
        display: none;
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
        .page-hero {
            flex-direction: column;
        }

        .page-actions {
            width: 100%;
        }
    }

    /* Status Badge Styles */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-top: 4px;
    }

    .status-badge .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .status-online {
        background-color: rgba(34, 197, 94, 0.1);
        color: #22C55E;
    }

    .status-online .status-dot {
        background-color: #22C55E;
        animation: pulse-online 2s ease-in-out infinite;
    }

    .status-offline {
        background-color: rgba(198, 156, 109, 0.15);
        color: #8B6F47;
    }

    .status-offline .status-dot {
        background-color: #8B6F47;
    }

    @keyframes pulse-online {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .pelanggan-name {
        font-weight: 600;
        display: block;
    }

    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal {
        background: var(--white);
        border-radius: var(--border-radius-xl);
        box-shadow: var(--shadow-lg);
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        animation: slideUp 0.3s ease;
        z-index: 10000;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid var(--medium-gray);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: var(--dark-gray);
        transition: var(--transition);
    }

    .modal-close:hover {
        color: var(--text-dark);
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 16px 20px;
        border-top: 1px solid var(--medium-gray);
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 6px;
        color: var(--text-dark);
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--medium-gray);
        border-radius: var(--border-radius);
        font-family: inherit;
        font-size: 14px;
        transition: var(--transition);
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(198, 156, 109, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 80px;
    }

    .btn-cancel {
        padding: 10px 20px;
        border: 1px solid var(--medium-gray);
        background: var(--light-gray);
        color: var(--text-dark);
        border-radius: var(--border-radius);
        cursor: pointer;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-cancel:hover {
        background: var(--medium-gray);
    }

    .btn-submit {
        padding: 10px 20px;
        border: none;
        background: linear-gradient(135deg, var(--accent), var(--accent-dark));
        color: var(--white);
        border-radius: var(--border-radius);
        cursor: pointer;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Toast Notification */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10001;
        max-width: 350px;
    }

    .toast {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        padding: 16px;
        margin-bottom: 12px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
        animation: slideInRight 0.3s ease;
        border-left: 4px solid var(--accent);
    }

    .toast.success {
        border-left-color: #22C55E;
    }

    .toast.success .toast-icon {
        color: #22C55E;
    }

    .toast.error {
        border-left-color: #EF4444;
    }

    .toast.error .toast-icon {
        color: #EF4444;
    }

    .toast.info {
        border-left-color: #3B82F6;
    }

    .toast.info .toast-icon {
        color: #3B82F6;
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .toast-icon {
        font-size: 18px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .toast-message {
        font-size: 14px;
        color: var(--text-dark);
        line-height: 1.4;
    }

    /* Pagination */
    .pagination-info {
        padding: 16px 20px;
        text-align: center;
        font-size: 13px;
        color: var(--dark-gray);
        background: var(--light-gray);
        border-top: 1px solid var(--medium-gray);
    }

    .pagination {
        display: flex;
        gap: 8px;
        padding: 16px 20px;
        justify-content: center;
        background: var(--light-gray);
        border-top: 1px solid var(--medium-gray);
        flex-wrap: wrap;
    }

    .pagination a,
    .pagination button {
        padding: 8px 12px;
        border: 1px solid var(--medium-gray);
        background: var(--white);
        color: var(--text-dark);
        border-radius: 6px;
        cursor: pointer;
        transition: var(--transition);
        font-size: 13px;
        font-weight: 600;
    }

    .pagination a:hover,
    .pagination button:hover {
        background: var(--medium-gray);
    }

    .pagination .active {
        background: var(--accent);
        color: var(--white);
        border-color: var(--accent);
    }

    .pagination .disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .text-muted {
        color: var(--dark-gray);
    }

    /* Alamat Column Styling */
    .alamat-cell {
        display: inline-block;
        max-width: 250px;
        word-wrap: break-word;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
        white-space: normal;
        line-height: 1.4;
        font-size: 13px;
        color: var(--text-dark);
        cursor: help;
        position: relative;
    }

    /* Tooltip untuk alamat lengkap */
    .alamat-cell[title] {
        position: relative;
    }

    .alamat-cell[title]:hover::after {
        content: attr(title);
        position: absolute;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.9);
        color: var(--white);
        padding: 8px 12px;
        border-radius: 6px;
        white-space: normal;
        width: 220px;
        word-wrap: break-word;
        font-size: 12px;
        line-height: 1.4;
        z-index: 1000;
        font-weight: 400;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        animation: tooltipFadeIn 0.2s ease;
    }

    .alamat-cell[title]:hover::before {
        content: '';
        position: absolute;
        bottom: 120%;
        left: 50%;
        transform: translateX(-50%);
        border: 6px solid transparent;
        border-top-color: rgba(0, 0, 0, 0.9);
        z-index: 1000;
    }

    @keyframes tooltipFadeIn {
        from {
            opacity: 0;
            transform: translateX(-50%) translateY(4px);
        }
        to {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
    }

    @media (max-width: 768px) {
        .modal {
            width: 95%;
            max-width: 100%;
        }

        .toast-container {
            max-width: calc(100% - 20px);
            left: 10px;
            right: 10px;
        }

        .pagination {
            flex-direction: column;
            gap: 4px;
        }

        /* Responsive Alamat Column */
        .alamat-cell {
            max-width: 150px;
            font-size: 12px;
        }

        .alamat-cell[title]:hover::after {
            width: 180px;
            font-size: 11px;
            bottom: auto;
            top: 125%;
        }

        .alamat-cell[title]:hover::before {
            bottom: auto;
            top: 120%;
            border-top-color: transparent;
            border-bottom-color: rgba(0, 0, 0, 0.9);
        }

        table {
            font-size: 13px;
        }

        th, td {
            padding: 10px 6px;
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
@endsection

@section('content')
<main class="dashboard-content">
    <section class="page-hero">
        <div class="page-title">
            <p>Kelola seluruh data pelanggan Three D Bakery</p>
        </div>
        <div class="page-actions">
            <div class="search-input">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama atau nomor HP..." value="{{ $search ?? '' }}">
            </div>
            <div class="filter-select">
                <i class="fas fa-filter filter-icon"></i>
                <select id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="Online" {{ $status === 'Online' ? 'selected' : '' }}>Online</option>
                    <option value="Offline" {{ $status === 'Offline' ? 'selected' : '' }}>Offline</option>
                </select>
                <i class="fas fa-chevron-down select-arrow"></i>
            </div>
            <div class="filter-select per-page-select">
                <select id="perPageFilter">
                    <option value="5" {{ ($perPage ?? 10) == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ ($perPage ?? 10) == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ ($perPage ?? 10) == 50 ? 'selected' : '' }}>50</option>
                </select>
                <i class="fas fa-chevron-down select-arrow"></i>
            </div>
            <button class="btn-primary" type="button" id="btnTambahPelanggan">
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
                <span class="summary-value" id="totalPelanggan">{{ $stats['total_pelanggan'] ?? 0 }}</span>
                <span class="summary-subtext">Semua pelanggan terdaftar</span>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon green">
                <i class="fas fa-globe"></i>
            </div>
            <div class="summary-meta">
                <span class="summary-title">Pelanggan Online</span>
                <span class="summary-value" id="pelangganOnline">{{ $stats['pelanggan_online'] ?? 0 }}</span>
                <span class="summary-subtext">Dari website dan aplikasi</span>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon orange">
                <i class="fas fa-store"></i>
            </div>
            <div class="summary-meta">
                <span class="summary-title">Pelanggan Offline</span>
                <span class="summary-value" id="pelangganOffline">{{ $stats['pelanggan_offline'] ?? 0 }}</span>
                <span class="summary-subtext">Dari toko langsung</span>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon blue">
                <i class="fas fa-bag-shopping"></i>
            </div>
            <div class="summary-meta">
                <span class="summary-title">Total Pesanan Hari Ini</span>
                <span class="summary-value" id="totalPesananHariIni">{{ $stats['total_pesanan_hari_ini'] ?? 0 }}</span>
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
                        <th>Alamat</th>
                        <th>Total Pesanan</th>
                        <th>Terakhir Pesan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="pelanggantTableBody">
                    @forelse($pelanggans as $key => $pelanggan)
                        @php
                            $nomor = ($pelanggans->currentPage() - 1) * $pelanggans->perPage() + $key + 1;
                            $tanggalAkhir = $pelanggan->terakhir_pesan ? \Carbon\Carbon::parse($pelanggan->terakhir_pesan) : null;
                        @endphp
                        <tr data-id="{{ $pelanggan->id_pelanggan }}">
                            <td>{{ $nomor }}</td>
                            <td>
                                <span class="pelanggan-name">{{ $pelanggan->nama }}</span>
                                <span class="status-badge status-{{ strtolower($pelanggan->status) }}">
                                    <span class="status-dot"></span>
                                    {{ $pelanggan->status }}
                                </span>
                            </td>
                            <td>{{ $pelanggan->no_tlp }}</td>
                            <td>
                                <span class="alamat-cell" title="{{ $pelanggan->alamat }}">
                                    {{ Str::limit($pelanggan->alamat, 40, '...') }}
                                </span>
                            </td>
                            <td>{{ $pelanggan->total_pesanan ?? 0 }} Pesanan</td>
                            <td>
                                @if($tanggalAkhir)
                                    <span class="table-date">{{ $tanggalAkhir->locale('id')->format('d M Y') }}</span>
                                    <span class="table-time">{{ $tanggalAkhir->format('H:i') }} WIB</span>
                                @else
                                    <span class="table-date text-muted">Belum ada pesanan</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn btn-view" type="button" aria-label="Lihat" data-id="{{ $pelanggan->id_pelanggan }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn btn-edit" type="button" aria-label="Edit" data-id="{{ $pelanggan->id_pelanggan }}">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="action-btn danger btn-delete" type="button" aria-label="Hapus" data-id="{{ $pelanggan->id_pelanggan }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: #999;">
                                <i class="fas fa-inbox" style="font-size: 24px; margin-bottom: 12px; display: block;"></i>
                                Tidak ada pelanggan ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination Info -->
        @if($pelanggans->total() > 0)
        <div class="pagination-info">
            Menampilkan {{ $pelanggans->firstItem() }} sampai {{ $pelanggans->lastItem() }} dari {{ $pelanggans->total() }} pelanggan
        </div>
        <!-- Pagination Links -->
        <div class="pagination">
            @if ($pelanggans->onFirstPage())
                <span class="disabled">&laquo; Sebelumnya</span>
            @else
                <a href="{{ $pelanggans->previousPageUrl() }}">&laquo; Sebelumnya</a>
            @endif

            @foreach ($pelanggans->getUrlRange(1, $pelanggans->lastPage()) as $page => $url)
                @if ($page == $pelanggans->currentPage())
                    <button class="active">{{ $page }}</button>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            @if ($pelanggans->hasMorePages())
                <a href="{{ $pelanggans->nextPageUrl() }}">Selanjutnya &raquo;</a>
            @else
                <span class="disabled">Selanjutnya &raquo;</span>
            @endif
        </div>
        @endif
    </section>
</main>

<!-- Modal Add/Edit Pelanggan -->
<div class="modal-overlay" id="modalPelanggan">
    <div class="modal">
        <div class="modal-header">
            <h2 id="modalTitle">Tambah Pelanggan</h2>
            <button class="modal-close" type="button" onclick="closeModal('modalPelanggan')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="formPelanggan">
                @csrf
                <input type="hidden" id="pelangganId" name="pelanggan_id">
                
                <div class="form-group">
                    <label for="inputNama">Nama Pelanggan</label>
                    <input type="text" id="inputNama" name="nama" required>
                </div>

                <div class="form-group">
                    <label for="inputNoTlp">Nomor HP</label>
                    <input type="tel" id="inputNoTlp" name="no_tlp" placeholder="0812-1234-5678" required>
                </div>

                <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input type="email" id="inputEmail" name="email" placeholder="nama@example.com">
                </div>

                <div class="form-group">
                    <label for="inputAlamat">Alamat</label>
                    <textarea id="inputAlamat" name="alamat" required></textarea>
                </div>

                <div class="form-group">
                    <label for="inputStatus">Status</label>
                    <select id="inputStatus" name="status" required>
                        {{-- <option value="Online">Online (Website/Aplikasi)</option> --}}
                        <option value="Offline">Offline (Toko Langsung)</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" type="button" onclick="closeModal('modalPelanggan')">Batal</button>
            <button class="btn-submit" type="button" onclick="submitFormPelanggan()">Simpan</button>
        </div>
    </div>
</div>

<!-- Modal View Detail Pelanggan -->
<div class="modal-overlay" id="modalDetail">
    <div class="modal">
        <div class="modal-header">
            <h2>Detail Pelanggan</h2>
            <button class="modal-close" type="button" onclick="closeModal('modalDetail')">&times;</button>
        </div>
        <div class="modal-body" id="modalDetailContent">
            <!-- Will be populated via AJAX -->
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" type="button" onclick="closeModal('modalDetail')">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Delete -->
<div class="modal-overlay" id="modalDelete">
    <div class="modal" style="max-width: 400px;">
        <div class="modal-header">
            <h2>Hapus Pelanggan</h2>
            <button class="modal-close" type="button" onclick="closeModal('modalDelete')">&times;</button>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus pelanggan <strong id="deletePelangganName"></strong>?</p>
            <p style="color: #EF4444; margin-top: 12px; font-size: 13px;">
                <i class="fas fa-exclamation-circle"></i> Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" type="button" onclick="closeModal('modalDelete')">Batal</button>
            <button class="btn-submit" type="button" onclick="confirmDelete()" style="background: linear-gradient(135deg, #EF4444, #DC2626);">Hapus</button>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>
@endsection

@section('additional-scripts')
<script>
    // BASE URLs
    const API_BASE_URL = '{{ url("/api") }}';

    // Modal Functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
    }

    function resetFormPelanggan() {
        document.getElementById('formPelanggan').reset();
        document.getElementById('pelangganId').value = '';
        document.getElementById('modalTitle').textContent = 'Tambah Pelanggan';
        document.getElementById('inputStatus').value = 'Online';
    }

    // Toast Notification
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        let icon = '';
        if (type === 'success') icon = '<i class="fas fa-check-circle toast-icon"></i>';
        else if (type === 'error') icon = '<i class="fas fa-exclamation-circle toast-icon"></i>';
        else if (type === 'info') icon = '<i class="fas fa-info-circle toast-icon"></i>';

        toast.innerHTML = `${icon}<div class="toast-message">${message}</div>`;
        
        document.getElementById('toastContainer').appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    // Search and Filter
    document.getElementById('searchInput').addEventListener('keyup', debounce(function() {
        const search = this.value;
        const status = document.getElementById('statusFilter').value;
        const perPage = document.getElementById('perPageFilter').value;
        loadPelanggans(search, status, perPage, 1);
    }, 500));

    document.getElementById('statusFilter').addEventListener('change', function() {
        const search = document.getElementById('searchInput').value;
        const perPage = document.getElementById('perPageFilter').value;
        loadPelanggans(search, this.value, perPage, 1);
    });

    document.getElementById('perPageFilter').addEventListener('change', function() {
        const search = document.getElementById('searchInput').value;
        const status = document.getElementById('statusFilter').value;
        loadPelanggans(search, status, this.value, 1);
    });

    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Load Pelanggans with AJAX – dynamic table + pagination render
    function loadPelanggans(search = '', status = '', perPage = 10, page = 1) {
        const params = new URLSearchParams();
        if (search) params.append('search', search);
        if (status) params.append('status', status);
        params.append('page', page);
        params.append('per_page', perPage);

        fetch(`{{ route('data-pelanggan') }}?${params.toString()}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            renderTable(data);
            renderPagination(data.pagination, search, status, perPage);
            updateStats(data.stats);
            updateUrl(search, status, perPage, page);
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Gagal memuat data pelanggan', 'error');
        });
    }

    function renderTable(data) {
        const tbody = document.getElementById('pelanggantTableBody');
        const rows = data.data;
        const p = data.pagination;

        if (!rows || rows.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                <i class="fas fa-inbox" style="font-size: 24px; margin-bottom: 12px; display: block;"></i>
                Tidak ada pelanggan ditemukan</td></tr>`;
            return;
        }

        tbody.innerHTML = rows.map((pel, i) => {
            const no = (p.current_page - 1) * p.per_page + i + 1;
            const statusLower = (pel.status || '').toLowerCase();
            const alamat = pel.alamat || '';
            const alamatShort = alamat.length > 40 ? alamat.substring(0, 40) + '...' : alamat;
            const totalPesanan = pel.total_pesanan ?? 0;
            let lastOrderHtml = '<span class="table-date text-muted">Belum ada pesanan</span>';
            if (pel.terakhir_pesan) {
                const d = new Date(pel.terakhir_pesan);
                const dateStr = d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
                const timeStr = d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                lastOrderHtml = `<span class="table-date">${dateStr}</span><span class="table-time">${timeStr} WIB</span>`;
            }
            return `<tr data-id="${pel.id_pelanggan}">
                <td>${no}</td>
                <td>
                    <span class="pelanggan-name">${escHtml(pel.nama)}</span>
                    <span class="status-badge status-${statusLower}">
                        <span class="status-dot"></span> ${pel.status || ''}
                    </span>
                </td>
                <td>${escHtml(pel.no_tlp)}</td>
                <td><span class="alamat-cell" title="${escHtml(alamat)}">${escHtml(alamatShort)}</span></td>
                <td>${totalPesanan} Pesanan</td>
                <td>${lastOrderHtml}</td>
                <td>
                    <div class="action-buttons">
                        <button class="action-btn btn-view" type="button" aria-label="Lihat" data-id="${pel.id_pelanggan}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="action-btn btn-edit" type="button" aria-label="Edit" data-id="${pel.id_pelanggan}">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button class="action-btn danger btn-delete" type="button" aria-label="Hapus" data-id="${pel.id_pelanggan}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
        }).join('');
    }

    function renderPagination(p, search, status, perPage) {
        const paginationInfo = document.querySelector('.pagination-info');
        const paginationNav = document.querySelector('.pagination');
        if (!paginationInfo || !paginationNav) return;

        if (p.total === 0) {
            paginationInfo.textContent = '';
            paginationNav.innerHTML = '';
            return;
        }

        paginationInfo.textContent = `Menampilkan ${p.from} sampai ${p.to} dari ${p.total} pelanggan`;

        let html = '';
        const baseUrl = `{{ route('data-pelanggan') }}`;

        // Prev
        if (p.current_page <= 1) {
            html += '<span class="disabled">&laquo; Sebelumnya</span>';
        } else {
            html += `<a href="#" data-page="${p.current_page - 1}" data-search="${search}" data-status="${status}" data-per-page="${perPage}">&laquo; Sebelumnya</a>`;
        }

        // Pages
        for (let i = 1; i <= p.last_page; i++) {
            if (i === p.current_page) {
                html += `<button class="active">${i}</button>`;
            } else {
                html += `<a href="#" data-page="${i}" data-search="${search}" data-status="${status}" data-per-page="${perPage}">${i}</a>`;
            }
        }

        // Next
        if (p.current_page >= p.last_page) {
            html += '<span class="disabled">Selanjutnya &raquo;</span>';
        } else {
            html += `<a href="#" data-page="${p.current_page + 1}" data-search="${search}" data-status="${status}" data-per-page="${perPage}">Selanjutnya &raquo;</a>`;
        }

        paginationNav.innerHTML = html;
    }

    function updateStats(stats) {
        document.getElementById('totalPelanggan').textContent = stats.total_pelanggan;
        document.getElementById('pelangganOnline').textContent = stats.pelanggan_online;
        document.getElementById('pelangganOffline').textContent = stats.pelanggan_offline;
        document.getElementById('totalPesananHariIni').textContent = stats.total_pesanan_hari_ini;
    }

    function updateUrl(search, status, perPage, page) {
        const params = new URLSearchParams();
        if (search) params.set('search', search);
        if (status) params.set('status', status);
        if (perPage != '10') params.set('per_page', perPage);
        if (page > 1) params.set('page', page);
        const qs = params.toString();
        const newUrl = qs ? `{{ route('data-pelanggan') }}?${qs}` : `{{ route('data-pelanggan') }}`;
        window.history.replaceState({}, '', newUrl);
    }

    function escHtml(str) {
        if (!str) return '';
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // Pagination click delegation
    document.querySelector('.table-card')?.addEventListener('click', function(e) {
        const link = e.target.closest('.pagination a');
        if (!link) return;
        e.preventDefault();
        const page = link.dataset.page;
        const search = link.dataset.search || document.getElementById('searchInput').value;
        const status = link.dataset.status || document.getElementById('statusFilter').value;
        const perPage = link.dataset.perPage || document.getElementById('perPageFilter').value;
        loadPelanggans(search, status, perPage, page);
    });

    // Add/Edit Pelanggan
    document.getElementById('btnTambahPelanggan').addEventListener('click', function() {
        resetFormPelanggan();
        openModal('modalPelanggan');
    });

    function submitFormPelanggan() {
        const formData = new FormData(document.getElementById('formPelanggan'));
        const pelangganId = document.getElementById('pelangganId').value;
        const url = pelangganId ? `${API_BASE_URL}/pelanggans/${pelangganId}` : `${API_BASE_URL}/pelanggans`;
        const method = pelangganId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value || document.querySelector('input[name="csrf-token"]')?.value,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                closeModal('modalPelanggan');
                reloadCurrentPage();
            } else {
                showToast(data.message || 'Terjadi kesalahan', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Gagal menyimpan data pelanggan', 'error');
        });
    }

    function reloadCurrentPage() {
        const search = document.getElementById('searchInput').value;
        const status = document.getElementById('statusFilter').value;
        const perPage = document.getElementById('perPageFilter').value;
        const activePage = document.querySelector('.pagination .active');
        const page = activePage ? parseInt(activePage.textContent) : 1;
        loadPelanggans(search, status, perPage, page);
    }

    // View Detail
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-view')) {
            const pelangganId = e.target.closest('.btn-view').dataset.id;
            fetch(`${API_BASE_URL}/pelanggans/${pelangganId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const pelanggan = data.pelanggan;
                const pesanans = data.pesanans;
                let content = `
                    <div style="margin-bottom: 20px;">
                        <div class="form-group">
                            <label>Nama Pelanggan</label>
                            <p style="padding: 10px; background: var(--light-gray); border-radius: 6px;">${pelanggan.nama}</p>
                        </div>
                        <div class="form-group">
                            <label>Nomor HP</label>
                            <p style="padding: 10px; background: var(--light-gray); border-radius: 6px;">${pelanggan.no_tlp}</p>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <p style="padding: 10px; background: var(--light-gray); border-radius: 6px;">${pelanggan.email || '-'}</p>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <p style="padding: 10px; background: var(--light-gray); border-radius: 6px;">${pelanggan.alamat}</p>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <p style="padding: 10px; background: var(--light-gray); border-radius: 6px;">
                                <span class="status-badge status-${pelanggan.status.toLowerCase()}">
                                    <span class="status-dot"></span>
                                    ${pelanggan.status}
                                </span>
                            </p>
                        </div>
                        <div class="form-group">
                            <label>Total Pesanan</label>
                            <p style="padding: 10px; background: var(--light-gray); border-radius: 6px;">${pelanggan.total_pesanan || 0}</p>
                        </div>
                    </div>
                    <div style="margin-top: 20px; border-top: 1px solid var(--medium-gray); padding-top: 16px;">
                        <h3 style="margin-bottom: 12px; font-size: 14px; font-weight: 700;">Riwayat Pesanan</h3>
                        ${pesanans.length > 0 ? `
                            <div style="max-height: 300px; overflow-y: auto;">
                                ${pesanans.map(p => `
                                    <div style="padding: 10px; background: var(--light-gray); border-radius: 6px; margin-bottom: 8px; font-size: 13px;">
                                        <div><strong>#${p.id_pesanan}</strong> - ${new Date(p.tgl_pesan).toLocaleDateString('id-ID')}</div>
                                        <div style="color: var(--dark-gray); margin-top: 4px;">Rp. ${parseInt(p.total_bayar || 0).toLocaleString('id-ID')}</div>
                                    </div>
                                `).join('')}
                            </div>
                        ` : '<p style="color: var(--dark-gray); font-size: 13px;">Belum ada pesanan</p>'}
                    </div>
                `;
                document.getElementById('modalDetailContent').innerHTML = content;
                openModal('modalDetail');
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Gagal memuat detail pelanggan', 'error');
            });
        }
    });

    // Edit Pelanggan
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-edit')) {
            const pelangganId = e.target.closest('.btn-edit').dataset.id;
            fetch(`${API_BASE_URL}/pelanggans/${pelangganId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const pelanggan = data.pelanggan;
                document.getElementById('pelangganId').value = pelanggan.id_pelanggan;
                document.getElementById('inputNama').value = pelanggan.nama;
                document.getElementById('inputNoTlp').value = pelanggan.no_tlp;
                document.getElementById('inputEmail').value = pelanggan.email || '';
                document.getElementById('inputAlamat').value = pelanggan.alamat;
                document.getElementById('inputStatus').value = pelanggan.status;
                document.getElementById('modalTitle').textContent = 'Edit Pelanggan';
                openModal('modalPelanggan');
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Gagal memuat data pelanggan', 'error');
            });
        }
    });

    // Delete Pelanggan
    let deleteId = null;

    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-delete')) {
            deleteId = e.target.closest('.btn-delete').dataset.id;
            const row = e.target.closest('tr');
            const name = row.querySelector('.pelanggan-name').textContent;
            document.getElementById('deletePelangganName').textContent = name;
            openModal('modalDelete');
        }
    });

    function confirmDelete() {
        if (!deleteId) return;

        fetch(`${API_BASE_URL}/pelanggans/${deleteId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value || document.querySelector('input[name="csrf-token"]')?.value,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                closeModal('modalDelete');
                reloadCurrentPage();
            } else {
                showToast(data.message || 'Terjadi kesalahan', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Gagal menghapus pelanggan', 'error');
        });
    }

    // Close modal on overlay click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this.id);
            }
        });
    });

    // Auto-refresh stats every 30 seconds
    setInterval(function() {
        fetch(`${API_BASE_URL}/pelanggans-stats`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalPelanggan').textContent = data.total_pelanggan;
            document.getElementById('pelangganOnline').textContent = data.pelanggan_online;
            document.getElementById('pelangganOffline').textContent = data.pelanggan_offline;
            document.getElementById('totalPesananHariIni').textContent = data.total_pesanan_hari_ini;
        })
        .catch(error => console.error('Error:', error));
    }, 30000);
</script>
@endsection
