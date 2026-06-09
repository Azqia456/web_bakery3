@extends('layouts.dashboard-layout', ['pageTitle' => 'Laporan Pesanan Online'])

@section('additional-styles')
<style>
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
</style>
@endsection

@section('content')
    <div class="page-container">
        <!-- Statistics Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 28px;">
            <!-- Card 1: Total Pesanan -->
            <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); border-top: 4px solid #0d6efd; transition: transform 0.3s, box-shadow 0.3s;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Pesanan Online</p>
                        <h3 style="margin: 12px 0 0 0; color: #0d6efd; font-size: 32px; font-weight: 700;">
                            {{ $totalPesanan ?? 0 }}
                        </h3>
                    </div>
                    <div style="background: rgba(13, 110, 253, 0.1); border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-shopping-cart" style="font-size: 28px; color: #0d6efd;"></i>
                    </div>
                </div>
            </div>

            <!-- Card 2: Total Pembayaran -->
            <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); border-top: 4px solid #198754; transition: transform 0.3s, box-shadow 0.3s;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Pembayaran</p>
                        <h3 style="margin: 12px 0 0 0; color: #198754; font-size: 28px; font-weight: 700;">
                            Rp {{ number_format($totalPembayaran ?? 0, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div style="background: rgba(25, 135, 84, 0.1); border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-wallet" style="font-size: 28px; color: #198754;"></i>
                    </div>
                </div>
            </div>

            <!-- Card 3: Pesanan Selesai -->
            <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); border-top: 4px solid #fd7e14; transition: transform 0.3s, box-shadow 0.3s;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Pesanan Selesai</p>
                        <h3 style="margin: 12px 0 0 0; color: #fd7e14; font-size: 32px; font-weight: 700;">
                            {{ $pesananSelesai ?? 0 }}
                        </h3>
                    </div>
                    <div style="background: rgba(253, 126, 20, 0.1); border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-check-circle" style="font-size: 28px; color: #fd7e14;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); margin-bottom: 28px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; align-items: flex-end;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: #333;">Tanggal Mulai</label>
                    <input type="date" id="startDate" style="width: 100%; padding: 10px 12px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 13px; font-family: inherit;" value="{{ $startDate ?? date('Y-m-d', strtotime('-7 days')) }}">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: #333;">Tanggal Akhir</label>
                    <input type="date" id="endDate" style="width: 100%; padding: 10px 12px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 13px; font-family: inherit;" value="{{ $endDate ?? date('Y-m-d') }}">
                </div>
                <button onclick="filterData()" style="background: #0d6efd; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 13px; width: 100%; transition: background 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </div>

        <!-- Table Section -->
        <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 4px rgba(0,0,0,0.08);">
            <h5 style="font-weight: 700; margin-bottom: 20px; color: #333; font-size: 16px;">Daftar Pesanan Online</h5>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="border-bottom: 2px solid #dee2e6; background: #f8f9fa;">
                            <th style="padding: 14px 12px; text-align: left; font-weight: 600; color: #495057;">Nama Pelanggan</th>
                            <th style="padding: 14px 12px; text-align: left; font-weight: 600; color: #495057;">Produk</th>
                            <th style="padding: 14px 12px; text-align: center; font-weight: 600; color: #495057;">Jumlah</th>
                            <th style="padding: 14px 12px; text-align: right; font-weight: 600; color: #495057;">Total Bayar</th>
                            <th style="padding: 14px 12px; text-align: center; font-weight: 600; color: #495057;">Tanggal Pesanan</th>
                            <th style="padding: 14px 12px; text-align: center; font-weight: 600; color: #495057;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesananData ?? [] as $item)
                            <tr style="border-bottom: 1px solid #e9ecef; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='white'">
                                <td style="padding: 14px 12px; color: #333;">{{ $item['nama_pelanggan'] ?? 'Pelanggan' }}</td>
                                <td style="padding: 14px 12px; color: #333;">{{ $item['produk'] ?? 'Produk' }}</td>
                                <td style="padding: 14px 12px; text-align: center;">
                                    <span style="background: #cfe2ff; color: #084298; padding: 6px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                        {{ $item['jumlah'] ?? 1 }}
                                    </span>
                                </td>
                                <td style="padding: 14px 12px; text-align: right; font-weight: 600; color: #198754;">
                                    Rp {{ number_format($item['total_bayar'] ?? 0, 0, ',', '.') }}
                                </td>
                                <td style="padding: 14px 12px; text-align: center; color: #6c757d;">
                                    {{ date('d-m-Y', strtotime($item['tanggal'] ?? now())) }}
                                </td>
                                <td style="padding: 14px 12px; text-align: center;">
                                    @php
                                        $status = $item['status'] ?? 'diproses';
                                        $badgeStyle = match($status) {
                                            'selesai' => 'background: #d1e7dd; color: #0f5132;',
                                            'dikirim' => 'background: #cfe2ff; color: #084298;',
                                            'dibatalkan' => 'background: #f8d7da; color: #842029;',
                                            default => 'background: #fff3cd; color: #664d03;'
                                        };
                                    @endphp
                                    <span style="{{ $badgeStyle }} padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; display: inline-block;">
                                        @switch($status)
                                            @case('diproses')
                                                <i class="fas fa-hourglass-half"></i> Diproses
                                                @break
                                            @case('dikirim')
                                                <i class="fas fa-truck"></i> Dikirim
                                                @break
                                            @case('selesai')
                                                <i class="fas fa-check"></i> Selesai
                                                @break
                                            @case('dibatalkan')
                                                <i class="fas fa-times"></i> Dibatalkan
                                                @break
                                            @default
                                                {{ ucfirst($status) }}
                                        @endswitch
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding: 32px 12px; text-align: center; color: #999;">
                                    <i class="fas fa-inbox" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
                                    Tidak ada data pesanan online
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('additional-scripts')
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
</script>
@endsection
