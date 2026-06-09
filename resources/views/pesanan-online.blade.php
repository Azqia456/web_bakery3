@extends('layouts.dashboard-layout')

@section('additional-styles')
<style>
    /* Pesanan Online Specific Styles */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .date-card {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--white);
        padding: 10px 16px;
        border-radius: var(--border-radius);
        border: 1px solid var(--medium-gray);
        font-size: 13px;
        color: var(--dark-gray);
    }

    .date-card i {
        color: var(--primary-brown);
        font-size: 16px;
    }

    .date-card .date-label {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 12px;
    }

    .date-card .date-value {
        font-size: 12px;
        color: var(--dark-gray);
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: var(--white);
        padding: 20px;
        border-radius: var(--border-radius-xl);
        border: 1px solid var(--medium-gray);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .stat-card .stat-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }

    .stat-card .stat-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .stat-card .stat-icon.blue { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }
    .stat-card .stat-icon.orange { background: rgba(245, 158, 11, 0.1); color: #F59E0B; }
    .stat-card .stat-icon.indigo { background: rgba(99, 102, 241, 0.1); color: #6366F1; }
    .stat-card .stat-icon.teal { background: rgba(20, 184, 166, 0.1); color: #14B8A6; }
    .stat-card .stat-icon.green { background: rgba(34, 197, 94, 0.1); color: #22C55E; }

    .stat-card .stat-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--dark-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 4px;
    }

    .stat-card .stat-desc {
        font-size: 12px;
        color: var(--dark-gray);
    }

    /* Filter Bar */
    .filter-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-input {
        padding: 8px 12px;
        border: 1px solid var(--medium-gray);
        border-radius: var(--border-radius);
        font-size: 13px;
        font-family: inherit;
        background: var(--white);
        color: var(--text-dark);
        transition: var(--transition);
    }

    .filter-input:focus {
        outline: none;
        border-color: var(--primary-brown);
        box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
    }

    .filter-select {
        padding: 8px 32px 8px 12px;
        border: 1px solid var(--medium-gray);
        border-radius: var(--border-radius);
        font-size: 13px;
        font-family: inherit;
        background: var(--white);
        color: var(--text-dark);
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236C757D' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        transition: var(--transition);
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--primary-brown);
        box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
    }

    .search-input-wrapper {
        position: relative;
        flex: 1;
        min-width: 240px;
        max-width: 400px;
    }

    .search-input-wrapper i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--dark-gray);
        font-size: 14px;
    }

    .search-input-wrapper input {
        width: 100%;
        padding: 8px 12px 8px 36px;
        border: 1px solid var(--medium-gray);
        border-radius: var(--border-radius);
        font-size: 13px;
        font-family: inherit;
        background: var(--white);
        color: var(--text-dark);
        transition: var(--transition);
    }

    .search-input-wrapper input:focus {
        outline: none;
        border-color: var(--primary-brown);
        box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
    }

    .btn-icon-action {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border: 1px solid var(--medium-gray);
        border-radius: var(--border-radius);
        background: var(--white);
        color: var(--text-dark);
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        font-family: inherit;
    }

    .btn-icon-action:hover {
        background: var(--light-gray);
        border-color: var(--dark-gray);
    }

    .btn-export {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border: none;
        border-radius: var(--border-radius);
        background: linear-gradient(135deg, var(--primary-brown), #D4A574);
        color: var(--white);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        font-family: inherit;
    }

    .btn-export:hover {
        background: linear-gradient(135deg, #6B4F33, #c49557);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(139, 111, 71, 0.2);
    }

    /* Table */
    .table-container {
        background: var(--white);
        border-radius: var(--border-radius-xl);
        border: 1px solid var(--medium-gray);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead th {
        background: var(--light-gray);
        padding: 14px 16px;
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        color: var(--text-dark);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--medium-gray);
        white-space: nowrap;
    }

    .data-table tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--medium-gray);
        font-size: 13px;
        color: var(--text-dark);
        vertical-align: middle;
    }

    .data-table tbody tr:hover {
        background: var(--light-gray);
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Order Number */
    .order-number {
        font-weight: 700;
        color: var(--text-dark);
        font-size: 13px;
    }

    /* Customer Info */
    .customer-info .customer-name {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 13px;
    }

    .customer-info .customer-phone {
        font-size: 12px;
        color: var(--dark-gray);
        margin-top: 2px;
    }

    /* Badges */
    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }

    .badge-lunas {
        background: rgba(34, 197, 94, 0.1);
        color: #22C55E;
    }

    .badge-belum-lunas {
        background: rgba(239, 68, 68, 0.1);
        color: #EF4444;
    }

    .badge-menunggu {
        background: rgba(245, 158, 11, 0.1);
        color: #F59E0B;
    }

    .status-menunggu-konfirmasi {
        background: rgba(245, 158, 11, 0.1);
        color: #F59E0B;
    }

    .status-diproses {
        background: rgba(59, 130, 246, 0.1);
        color: #3B82F6;
    }

    .status-siap-diambil {
        background: rgba(34, 197, 94, 0.1);
        color: #22C55E;
    }

    .status-dikirim {
        background: rgba(139, 92, 246, 0.1);
        color: #8B5CF6;
    }

    .status-selesai {
        background: rgba(20, 184, 166, 0.1);
        color: #14B8A6;
    }

    /* Action Buttons */
    .action-group {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        font-family: inherit;
        border: 1px solid var(--medium-gray);
        background: var(--white);
        color: var(--text-dark);
    }

    .btn-action:hover {
        background: var(--light-gray);
        border-color: var(--dark-gray);
    }

    .btn-action-primary {
        background: linear-gradient(135deg, var(--primary-brown), #D4A574);
        color: var(--white);
        border: none;
    }

    .btn-action-primary:hover {
        background: linear-gradient(135deg, #6B4F33, #c49557);
        box-shadow: 0 2px 6px rgba(139, 111, 71, 0.2);
    }

    /* Time Info */
    .time-info .time-date {
        font-weight: 500;
        color: var(--text-dark);
        font-size: 13px;
    }

    .time-info .time-hour {
        font-size: 12px;
        color: var(--dark-gray);
        margin-top: 2px;
    }

    /* Info Section */
    .info-section {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 16px;
        background: rgba(245, 158, 11, 0.05);
        border: 1px solid rgba(245, 158, 11, 0.15);
        border-radius: var(--border-radius);
        margin-top: 20px;
    }

    .info-section i {
        color: #F59E0B;
        font-size: 18px;
        margin-top: 2px;
    }

    .info-section .info-title {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 13px;
        margin-bottom: 4px;
    }

    .info-section .info-text {
        font-size: 12px;
        color: var(--dark-gray);
        line-height: 1.5;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        border-top: 1px solid var(--medium-gray);
        background: var(--light-gray);
    }

    .pagination-info {
        font-size: 13px;
        color: var(--dark-gray);
        white-space: nowrap;
    }

    .pagination-nav-custom {
        display: flex;
        gap: 4px;
        align-items: center;
    }

    .pagination-nav-custom .page-btn {
        min-width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid var(--medium-gray);
        background: var(--white);
        color: var(--text-dark);
        text-decoration: none;
        transition: var(--transition);
        padding: 0 8px;
        line-height: 1;
        cursor: pointer;
    }

    .pagination-nav-custom .page-btn:hover:not(.disabled):not(.active) {
        background: var(--cream);
        border-color: var(--light-brown);
    }

    .pagination-nav-custom .page-btn.active {
        background: var(--light-brown);
        color: var(--white);
        border-color: var(--light-brown);
        cursor: default;
    }

    .pagination-nav-custom .page-btn.disabled {
        opacity: 0.4;
        cursor: default;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--dark-gray);
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        color: var(--medium-gray);
    }

    .empty-state p {
        font-size: 14px;
    }

    /* Modal Styles */
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
        max-width: 600px;
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

    .modal-footer {
        padding: 20px 24px;
        border-top: 1px solid var(--medium-gray);
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        background: linear-gradient(135deg, rgba(139, 111, 71, 0.02), rgba(212, 165, 116, 0.02));
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

    .section-divider {
        padding: 16px 0;
        border-top: 1px solid var(--medium-gray);
        margin-top: 20px;
    }

    .section-divider h4 {
        font-size: 13px;
        font-weight: 600;
        color: var(--dark-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
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
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .btn-cancel:hover {
        background: #d4d4d4;
        transform: translateY(-2px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-input-wrapper {
            max-width: none;
        }

        .data-table {
            display: block;
            overflow-x: auto;
        }

        .header-actions {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .inline-editable {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        padding: 2px 4px;
        border-radius: 4px;
        transition: background 0.15s;
    }
    .inline-editable:hover {
        background: rgba(0,0,0,0.04);
    }
    .inline-editable .edit-icon {
        font-size: 10px;
        color: var(--dark-gray);
        opacity: 0;
        transition: opacity 0.15s;
    }
    .inline-editable:hover .edit-icon {
        opacity: 1;
    }
    .inline-editable.editing {
        cursor: default;
    }
    .inline-editable select {
        padding: 4px 6px;
        border: 1px solid var(--brown);
        border-radius: 4px;
        font-size: 12px;
        font-family: inherit;
        background: var(--white);
        color: var(--text-dark);
        min-width: 130px;
    }
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <!-- Date Card (now separate from page title which is in header) -->
    <div class="header-actions" style="justify-content: flex-end; margin-bottom: 16px;">
        <div class="date-card">
            <i class="far fa-calendar-alt"></i>
            <div>
                <div class="date-label">Hari Ini</div>
                <div class="date-value">{{ now()->locale('id')->translatedFormat('d F Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon blue">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="stat-label">Semua Pesanan</div>
            </div>
            <div class="stat-value">{{ $stats['semua'] }}</div>
            <div class="stat-desc">Total pesanan masuk</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon orange">
                    <i class="far fa-clock"></i>
                </div>
                <div class="stat-label">Menunggu Konfirmasi</div>
            </div>
            <div class="stat-value">{{ $stats['menunggu_konfirmasi'] }}</div>
            <div class="stat-desc">Perlu konfirmasi</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon indigo">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="stat-label">Diproses</div>
            </div>
            <div class="stat-value">{{ $stats['diproses'] }}</div>
            <div class="stat-desc">Sedang diproses</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon teal">
                    <i class="fas fa-motorcycle"></i>
                </div>
                <div class="stat-label">Siap Diambil/Dikirim</div>
            </div>
            <div class="stat-value">{{ $stats['siap_diambil'] + $stats['dikirim'] }}</div>
            <div class="stat-desc">Siap diambil/dikirim</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-label">Selesai</div>
            </div>
            <div class="stat-value">{{ $stats['selesai'] }}</div>
            <div class="stat-desc">Pesanan selesai</div>
        </div>
    </div>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('pesanan-online') }}" class="filter-bar" id="filterForm">
        <div class="filter-group">
            <input type="date" name="date" class="filter-input" value="{{ request('date') }}" onchange="this.form.submit()">
        </div>

        <div class="filter-group">
            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="menunggu_konfirmasi" {{ request('status') == 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="siap_diambil" {{ request('status') == 'siap_diambil' ? 'selected' : '' }}>Siap Diambil</option>
                <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        <div class="search-input-wrapper">
            <i class="fas fa-search"></i>
            <input type="text" name="search" placeholder="Cari no. pesanan / pelanggan / produk..." value="{{ request('search') }}" onkeyup="if(event.key === 'Enter') this.form.submit()">
        </div>

        <button type="button" class="btn-icon-action" onclick="window.location.reload()">
            <i class="fas fa-sync-alt"></i>
            Refresh
        </button>

        {{-- <button type="button" class="btn-export" onclick="exportData()">
            <i class="fas fa-download"></i>
            Export
        </button> --}}
    </form>

    <!-- Table -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th>Bukti Transfer</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanans as $pesanan)
                <tr>
                    <td>
                        <span class="order-number">
                            #ON-{{ $pesanan->tgl_pesan->format('dmY') }}-{{ str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT) }}
                        </span>
                    </td>
                    <td>
                        <div class="customer-info">
                            <div class="customer-name">{{ $pesanan->pelanggan->nama ?? 'Pelanggan' }}</div>
                            <div class="customer-phone">{{ $pesanan->pelanggan->no_tlp ?? '-' }}</div>
                        </div>
                    </td>
                    <td>
                        {{ $pesanan->detailPesanans->sum('jumlah_pesan') }} item
                    </td>
                    <td>
                        <strong>Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</strong>
                    </td>
                    <td>
                        <div class="inline-editable" onclick="startInlineEdit(this, 'pembayaran', {{ $pesanan->id_pesanan }})">
                            @if($pesanan->status_pembayaran == 'lunas' || $pesanan->status_bayar == 'lunas')
                                <span class="badge badge-lunas">Lunas</span>
                            @elseif($pesanan->status_pembayaran == 'menunggu_verifikasi')
                                <span class="badge badge-menunggu">Menunggu</span>
                            @else
                                <span class="badge badge-belum-lunas">Belum Lunas</span>
                            @endif
                            <i class="fas fa-pen edit-icon"></i>
                        </div>
                    </td>
                    <td>
                        <div class="inline-editable" onclick="startInlineEdit(this, 'status', {{ $pesanan->id_pesanan }})">
                            @if($pesanan->status_pesanan == 'menunggu_konfirmasi')
                                <span class="badge status-menunggu-konfirmasi">Menunggu Konfirmasi</span>
                            @elseif($pesanan->status_pesanan == 'diproses')
                                <span class="badge status-diproses">Diproses</span>
                            @elseif($pesanan->status_pesanan == 'siap_diambil')
                                <span class="badge status-siap-diambil">Siap Diambil</span>
                            @elseif($pesanan->status_pesanan == 'dikirim')
                                <span class="badge status-dikirim">Dikirim</span>
                            @elseif($pesanan->status_pesanan == 'selesai')
                                <span class="badge status-selesai">Selesai</span>
                            @else
                                <span class="badge badge-menunggu">Menunggu Konfirmasi</span>
                            @endif
                            <i class="fas fa-pen edit-icon"></i>
                        </div>
                    </td>
                    <td>
                        @if($pesanan->bukti_transfer)
                            <button class="btn-action btn-action-primary" onclick="showBuktiTransfer('{{ asset('storage/' . $pesanan->bukti_transfer) }}')">
                                <i class="fas fa-image"></i> Lihat
                            </button>
                        @else
                            <span style="color: var(--dark-gray); font-size: 13px;">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="time-info">
                            <div class="time-date">{{ $pesanan->tgl_pesan->format('d/m/Y') }}</div>
                            <div class="time-hour">{{ $pesanan->tgl_pesan->format('H:i') }} WIB</div>
                        </div>
                    </td>
                    <td>
                        <div class="action-group">
                            <button class="btn-action" onclick="showDetail({{ $pesanan->id_pesanan }})">Detail</button>
                            <button class="btn-action btn-action-primary" onclick="submitOrder({{ $pesanan->id_pesanan }})">Submit</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada pesanan online</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($pesanans->hasPages())
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Menampilkan {{ $pesanans->firstItem() ?? 0 }} sampai {{ $pesanans->lastItem() ?? 0 }} dari {{ $pesanans->total() }} pesanan
            </div>
            <div class="pagination-nav-custom">
                {{-- Previous --}}
                @if($pesanans->onFirstPage())
                    <span class="page-btn disabled">&laquo;</span>
                @else
                    <a href="{{ $pesanans->previousPageUrl() }}" class="page-btn">&laquo;</a>
                @endif

                {{-- Page Numbers --}}
                @foreach($pesanans->getUrlRange(1, $pesanans->lastPage()) as $page => $url)
                    @if($page == $pesanans->currentPage())
                        <span class="page-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($pesanans->hasMorePages())
                    <a href="{{ $pesanans->nextPageUrl() }}" class="page-btn">&raquo;</a>
                @else
                    <span class="page-btn disabled">&raquo;</span>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <i class="fas fa-info-circle"></i>
        <div>
            <div class="info-title">Informasi</div>
            <div class="info-text">Pesanan akan otomatis masuk ke Riwayat Pesanan setelah pelanggan menyelesaikan pembayaran.</div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="modal" style="display: none;">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3 class="modal-title">Detail Pesanan</h3>
            <button class="modal-close" onclick="closeDetailModal()">&times;</button>
        </div>
        <div class="modal-body" id="detailModalBody">
            <!-- Content loaded via JS -->
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeDetailModal()">Tutup</button>
        </div>
    </div>
</div>

<!-- Bukti Transfer Modal -->
<div id="buktiTransferModal" class="modal" style="display: none;">
    <div class="modal-content" style="max-width: 500px; text-align: center;">
        <div class="modal-header">
            <h3 class="modal-title">Bukti Transfer</h3>
            <button class="modal-close" onclick="closeBuktiTransferModal()">&times;</button>
        </div>
        <div class="modal-body">
            <img id="buktiTransferImage" src="" alt="Bukti Transfer" style="max-width: 100%; border-radius: 8px;" />
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeBuktiTransferModal()">Tutup</button>
        </div>
    </div>
</div>
@endsection

@section('additional-scripts')
<script>
    function showDetail(id) {
        fetch(`/api/pesanan/${id}`)
            .then(r => r.json())
            .then(data => {
                const modalBody = document.getElementById('detailModalBody');
                modalBody.innerHTML = `
                    <div class="detail-section">
                        <div class="detail-row">
                            <div class="detail-label">No. Pesanan</div>
                            <div class="detail-value">#ON-${data.tgl_pesan.substring(0,10).replace(/-/g,'')}-${String(data.id_pesanan).padStart(3,'0')}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Pelanggan</div>
                            <div class="detail-value">${data.pelanggan?.nama || '-'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">No. Telepon</div>
                            <div class="detail-value">${data.pelanggan?.no_tlp || '-'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Total</div>
                            <div class="detail-value">Rp ${parseInt(data.total_bayar).toLocaleString('id-ID')}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Status Pembayaran</div>
                            <div class="detail-value">${data.status_bayar === 'lunas' ? 'Lunas' : 'Belum Lunas'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Status Pesanan</div>
                            <div class="detail-value">${data.status_pesanan?.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) || 'Menunggu Konfirmasi'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Tanggal Pesan</div>
                            <div class="detail-value">${new Date(data.tgl_pesan).toLocaleString('id-ID')}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Metode Pengambilan</div>
                            <div class="detail-value">${data.metode_pengambilan || '-'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Metode Pembayaran</div>
                            <div class="detail-value">${data.metode_pembayaran || '-'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Catatan</div>
                            <div class="detail-value">${data.catatan_pesanan || '-'}</div>
                        </div>
                    </div>
                    <div class="section-divider">
                        <h4>Produk</h4>
                        ${(data.detail_pesanans || []).map(d => `
                            <div class="detail-row">
                                <div class="detail-label">${d.produk?.nama_produk || 'Produk'}</div>
                                <div class="detail-value">${d.jumlah_pesan} x Rp ${parseInt(d.produk?.harga_produk || 0).toLocaleString('id-ID')}</div>
                            </div>
                        `).join('')}
                    </div>
                `;
                document.getElementById('detailModal').style.display = 'flex';
            })
            .catch(err => {
                alert('Gagal memuat detail pesanan');
                console.error(err);
            });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    function submitOrder(id) {
        if (!confirm('Konfirmasi submit pesanan ini?')) return;

        fetch(`/api/pesanan/${id}/submit`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                alert('Pesanan berhasil di-submit!');
                window.location.reload();
            } else {
                alert(data.message || 'Gagal submit pesanan');
            }
        })
        .catch(err => {
            alert('Gagal submit pesanan');
            console.error(err);
        });
    }

    function exportData() {
        const params = new URLSearchParams(window.location.search);
        window.location.href = `/api/pesanan-online/export?${params.toString()}`;
    }

    // Close modal on outside click
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) closeDetailModal();
    });

    function showBuktiTransfer(url) {
        document.getElementById('buktiTransferImage').src = url;
        document.getElementById('buktiTransferModal').style.display = 'flex';
    }

    function closeBuktiTransferModal() {
        document.getElementById('buktiTransferModal').style.display = 'none';
    }

    document.getElementById('buktiTransferModal').addEventListener('click', function(e) {
        if (e.target === this) closeBuktiTransferModal();
    });

    const paymentOptions = [
        { value: 'lunas', label: 'Lunas', cls: 'badge-lunas' },
        { value: 'menunggu_verifikasi', label: 'Menunggu', cls: 'badge-menunggu' },
        { value: 'belum_bayar', label: 'Belum Lunas', cls: 'badge-belum-lunas' },
    ];

    const statusOptions = [
        { value: 'menunggu_konfirmasi', label: 'Menunggu Konfirmasi', cls: 'status-menunggu-konfirmasi' },
        { value: 'diproses', label: 'Diproses', cls: 'status-diproses' },
        { value: 'siap_diambil', label: 'Siap Diambil', cls: 'status-siap-diambil' },
        { value: 'dikirim', label: 'Dikirim', cls: 'status-dikirim' },
        { value: 'selesai', label: 'Selesai', cls: 'status-selesai' },
    ];

    function startInlineEdit(el, type, id) {
        if (el.classList.contains('editing')) return;

        const currentBadge = el.querySelector('span.badge');
        const currentText = currentBadge ? currentBadge.textContent.trim() : '';
        const options = type === 'pembayaran' ? paymentOptions : statusOptions;
        const field = type === 'pembayaran' ? 'status_pembayaran' : 'status_pesanan';

        el.classList.add('editing');
        el.innerHTML = '';

        const select = document.createElement('select');
        options.forEach(opt => {
            const option = document.createElement('option');
            option.value = opt.value;
            option.textContent = opt.label;
            if (opt.label === currentText) option.selected = true;
            select.appendChild(option);
        });

        el.appendChild(select);
        select.focus();

        const updateValue = () => {
            const newValue = select.value;
            const selected = options.find(o => o.value === newValue);

            fetch(`/api/pesanans/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ [field]: newValue }),
            })
            .then(r => r.json())
            .then(() => {
                el.classList.remove('editing');
                el.innerHTML = `<span class="badge ${selected.cls}">${selected.label}</span><i class="fas fa-pen edit-icon"></i>`;
            })
            .catch(err => {
                el.classList.remove('editing');
                el.innerHTML = currentBadge ? currentBadge.outerHTML + '<i class="fas fa-pen edit-icon"></i>' : '<i class="fas fa-pen edit-icon"></i>';
                alert('Gagal mengupdate');
                console.error(err);
            });
        };

        select.addEventListener('change', updateValue);
        select.addEventListener('blur', updateValue);
    }
</script>
@endsection
