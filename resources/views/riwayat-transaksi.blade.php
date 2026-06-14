@extends('layouts.dashboard-layout', ['pageTitle' => 'Riwayat Transaksi'])

@section('additional-styles')
<style>
    :root {
        --blue: #3B82F6;
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
    }

    .pagination-nav {
        display: flex;
        gap: 4px;
    }

    .pagination-nav a,
    .pagination-nav span {
        min-width: 36px;
        height: 36px;
        display: flex;
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
    }

    .pagination-nav a:hover {
        background: var(--cream);
        border-color: var(--light-brown);
    }

    .pagination-nav .active {
        background: var(--light-brown);
        color: var(--white);
        border-color: var(--light-brown);
    }

    .pagination-nav .disabled {
        opacity: 0.4;
        cursor: default;
    }

    /* Responsive */
    @media (max-width: 768px) {
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
@endsection

@section('content')
<div class="content">
    <!-- Summary Stats -->
    <section class="stats-grid" id="stats-grid">
        <div class="stat-card">
            <div class="stat-card-icon blue">
                <i class="fas fa-list"></i>
            </div>
            <div class="stat-card-label">Total Transaksi</div>
            <div class="stat-card-value">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon orange">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-card-label">Pemasukan Hari Ini</div>
            <div class="stat-card-value">Rp {{ number_format($stats['pemasukan_hari_ini'], 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon green">
                <i class="fas fa-user"></i>
            </div>
            <div class="stat-card-label">Transaksi Pelanggan Hari Ini</div>
            <div class="stat-card-value">{{ $stats['transaksi_pelanggan'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon purple">
                <i class="fas fa-hand-holding-dollar"></i>
            </div>
            <div class="stat-card-label">Stor Karyawan Hari Ini</div>
            <div class="stat-card-value">{{ $stats['stor_karyawan'] }}</div>
        </div>
    </section>

    <!-- Table Section -->
    <div class="table-section">
        <!-- Filter Toolbar -->
        <form method="GET" action="{{ route('riwayat-transaksi') }}" id="filterForm">
            <div class="table-toolbar">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" id="searchTransaksi" placeholder="Cari nama pelanggan, karyawan, ID transaksi..." value="{{ request('search') }}">
                </div>
                <div class="filter-group" style="margin-left: auto;">
                    <label style="margin: 0; font-weight: 600; color: var(--primary-brown);">📅 Transaksi Hari Ini</label>
                </div>
            </div>
            <div class="table-toolbar" style="padding: 12px 24px;">
                <div class="filter-group">
                    <label>Tipe:</label>
                    <select class="form-control" name="tipe" id="filterTipe" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        <option value="pelanggan" {{ request('tipe') == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                        <option value="karyawan" {{ request('tipe') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Sumber:</label>
                    <select class="form-control" name="sumber" id="filterSumber" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        <option value="online" {{ request('sumber') == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ request('sumber') == 'offline' ? 'selected' : '' }}>Offline</option>
                        <option value="setor" {{ request('sumber') == 'setor' ? 'selected' : '' }}>Setor Karyawan</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Metode:</label>
                    <select class="form-control" name="metode" id="filterMetode" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        <option value="cash" {{ request('metode') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="transfer" {{ request('metode') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                    </select>
                </div>
                <div class="filter-group" style="margin-left: auto;">
                    <button type="button" class="btn-icon" onclick="window.location.href='{{ route('riwayat-transaksi') }}'" title="Reset Filter">
                        <i class="fas fa-undo"></i>
                    </button>
                </div>
            </div>
        </form>

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
                @forelse($pesanans as $pesanan)
                @php
                    $isPelanggan = $pesanan->id_pelanggan !== null;
                    $nama = $isPelanggan ? ($pesanan->pelanggan->nama ?? 'Pelanggan') : ($pesanan->karyawan->nama ?? 'Karyawan');
                    $tipe = $isPelanggan ? 'pelanggan' : 'karyawan';
                    $tipeText = $isPelanggan ? 'Pelanggan' : 'Karyawan';
                    $tipeBadge = $isPelanggan ? 'tipe-pelanggan' : 'tipe-karyawan';

                    if (!$isPelanggan) {
                        $sumber = 'setor';
                        $sumberText = 'Setor Karyawan';
                        $sumberBadge = 'sumber-setor';
                    } else {
                        $sumber = $pesanan->sumber_pesanan ?? 'offline';
                        $sumberText = $sumber == 'online' ? 'Online' : 'Offline';
                        $sumberBadge = $sumber == 'online' ? 'sumber-online' : 'sumber-offline';
                    }

                    $metode = $pesanan->metode_pembayaran ?? 'cash';
                    $metodeText = $metode == 'cash' ? 'Cash' : 'Transfer';
                    $metodeBadge = 'metode-' . $metode;

                    $trxId = $pesanan->sumber_pesanan === 'online'
                        ? '#ON-' . \Carbon\Carbon::parse($pesanan->tgl_pesan)->format('dmY') . '-' . str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT)
                        : '#OFF-' . \Carbon\Carbon::parse($pesanan->tgl_pesan)->format('dmY') . '-' . str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT);
                @endphp
                <tr data-tipe="{{ $tipe }}" data-sumber="{{ $sumber }}" data-metode="{{ $metode }}" data-tanggal="{{ \Carbon\Carbon::parse($pesanan->tgl_pesan)->format('Y-m-d') }}">
                    <td><strong>{{ $trxId }}</strong></td>
                    <td>{{ $nama }}</td>
                    <td><span class="badge {{ $tipeBadge }}">{{ $tipeText }}</span></td>
                    <td><span class="badge {{ $sumberBadge }}">{{ $sumberText }}</span></td>
                    <td><span class="badge {{ $metodeBadge }}">{{ $metodeText }}</span></td>
                    <td><strong>Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($pesanan->tgl_pesan)->format('d/m/Y') }}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="showDetail({{ $pesanan->id_pesanan }})" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
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
                @endforelse
            </tbody>
        </table>

        @if($pesanans->hasPages())
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Menampilkan {{ $pesanans->firstItem() ?? 0 }} sampai {{ $pesanans->lastItem() ?? 0 }} dari {{ $pesanans->total() }} transaksi
            </div>
            <div class="pagination-nav">
                {{ $pesanans->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal Detail Transaksi -->
<div id="modalDetail" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Detail Transaksi</h3>
            <button class="modal-close" onclick="closeModal('modalDetail')">&times;</button>
        </div>
        <div class="modal-body" id="detailContent">
            <!-- Content dinamis akan dimuat di sini -->
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>
@endsection

@section('additional-scripts')
<script>
    // Data transaksi dari server
    const transaksiData = @json($pesanans->items());

    // Show Detail Modal
    function showDetail(idPesanan) {
        const transaksi = transaksiData.find(t => t.id_pesanan === idPesanan);
        if (!transaksi) {
            showToast('Data transaksi tidak ditemukan', 'error');
            return;
        }

        const isPelanggan = transaksi.id_pelanggan !== null;
        const detailContent = document.getElementById('detailContent');

        let produkHTML = '';
        if (transaksi.detail_pesanans && transaksi.detail_pesanans.length > 0) {
            produkHTML = transaksi.detail_pesanans.map(d => {
                const harga = d.produk?.harga_produk ?? 0;
                const subtotal = harga * d.jumlah_pesan;
                return `
                    <tr>
                        <td>${d.produk?.nama_produk ?? 'Produk'}</td>
                        <td style="text-align: center;">${d.jumlah_pesan}</td>
                        <td style="text-align: right;">Rp ${parseInt(subtotal).toLocaleString('id-ID')}</td>
                    </tr>
                `;
            }).join('');
        } else {
            produkHTML = '<tr><td colspan="3" style="text-align: center; color: var(--dark-gray);">Tidak ada data produk</td></tr>';
        }

        if (isPelanggan) {
            const pelanggan = transaksi.pelanggan || {};
            const metodePengambilan = transaksi.metode_pengambilan || 'pickup';
            const tanggalPengambilan = metodePengambilan === 'delivery'
                ? (transaksi.tgl_delivery ?? '-')
                : (transaksi.tgl_pesan ? new Date(transaksi.tgl_pesan).toLocaleDateString('id-ID') : '-');

            detailContent.innerHTML = `
                <div class="detail-section">
                    <h4>DATA PELANGGAN</h4>
                    <div class="detail-row">
                        <div class="detail-label">ID Pesanan</div>
                        <div class="detail-value">#${transaksi.id_pesanan}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Nama Pelanggan</div>
                        <div class="detail-value">${pelanggan.nama ?? '-'}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">No HP</div>
                        <div class="detail-value">${pelanggan.no_tlp ?? '-'}</div>
                    </div>
                    ${transaksi.alamat_delivery ? `
                    <div class="detail-row">
                        <div class="detail-label">Alamat Delivery</div>
                        <div class="detail-value">${transaksi.alamat_delivery}</div>
                    </div>` : ''}
                </div>

                <div class="detail-section">
                    <h4>DETAIL TRANSAKSI</h4>
                    <div class="detail-row">
                        <div class="detail-label">Sumber</div>
                        <div class="detail-value">${transaksi.sumber_pesanan === 'online' ? 'Online' : 'Offline'}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Metode Pembayaran</div>
                        <div class="detail-value">${(transaksi.metode_pembayaran ?? 'cash').toUpperCase()}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Status Pembayaran</div>
                        <div class="detail-value">${transaksi.status_bayar === 'lunas' ? 'Lunas' : 'Belum Lunas'}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Status Pesanan</div>
                        <div class="detail-value">${(transaksi.status_pesanan ?? 'menunggu_konfirmasi').replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Tanggal Pesan</div>
                        <div class="detail-value">${transaksi.tgl_pesan ? new Date(transaksi.tgl_pesan).toLocaleString('id-ID') : '-'}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Metode Pengambilan</div>
                        <div class="detail-value">${metodePengambilan === 'delivery' ? 'Delivery' : 'Pickup'}</div>
                    </div>
                    ${metodePengambilan === 'delivery' && transaksi.tgl_delivery ? `
                    <div class="detail-row">
                        <div class="detail-label">Tanggal Delivery</div>
                        <div class="detail-value">${new Date(transaksi.tgl_delivery).toLocaleDateString('id-ID')}</div>
                    </div>` : ''}
                    ${transaksi.catatan_pesanan ? `
                    <div class="detail-row">
                        <div class="detail-label">Catatan</div>
                        <div class="detail-value">${transaksi.catatan_pesanan}</div>
                    </div>` : ''}
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
                                <td style="text-align: right; padding: 12px 0; font-weight: 600; color: var(--primary-brown);">Rp ${parseInt(transaksi.total_bayar).toLocaleString('id-ID')}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            `;
        } else {
            const karyawan = transaksi.karyawan || {};

            detailContent.innerHTML = `
                <div class="detail-section">
                    <h4>DATA KARYAWAN</h4>
                    <div class="detail-row">
                        <div class="detail-label">ID Pesanan</div>
                        <div class="detail-value">#${transaksi.id_pesanan}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Nama Karyawan</div>
                        <div class="detail-value">${karyawan.nama ?? '-'}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">No HP</div>
                        <div class="detail-value">${karyawan.no_tlp ?? '-'}</div>
                    </div>
                </div>

                <div class="detail-section">
                    <h4>DETAIL TRANSAKSI</h4>
                    <div class="detail-row">
                        <div class="detail-label">Sumber</div>
                        <div class="detail-value">Setor Karyawan</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Tanggal Pesan</div>
                        <div class="detail-value">${transaksi.tgl_pesan ? new Date(transaksi.tgl_pesan).toLocaleString('id-ID') : '-'}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Status Bayar</div>
                        <div class="detail-value">${transaksi.status_bayar === 'lunas' ? 'Lunas' : 'Belum Lunas'}</div>
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
                                <td style="text-align: right; padding: 12px 0; font-weight: 600; color: var(--primary-brown);">Rp ${parseInt(transaksi.total_bayar).toLocaleString('id-ID')}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            `;
        }

        document.getElementById('modalDetail').classList.add('show');
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

    // Search handler
    document.getElementById('searchTransaksi')?.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('filterForm').submit();
        }
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            e.target.classList.remove('show');
        }
    });
</script>
@endsection
