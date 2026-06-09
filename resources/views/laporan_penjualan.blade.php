@extends('layouts.dashboard-layout', ['pageTitle' => 'Laporan Penjualan'])

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
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 24px;">
            <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #28a745;">
                <h6 style="color: #6c757d; font-size: 13px; margin-bottom: 8px; font-weight: 600;">Total Penjualan Harian</h6>
                <h3 style="color: #28a745; font-size: 24px; font-weight: 700; margin: 0;">
                    Rp {{ number_format($totalHarian ?? 0, 0, ',', '.') }}
                </h3>
            </div>
            <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #007bff;">
                <h6 style="color: #6c757d; font-size: 13px; margin-bottom: 8px; font-weight: 600;">Total Penjualan Mingguan</h6>
                <h3 style="color: #007bff; font-size: 24px; font-weight: 700; margin: 0;">
                    Rp {{ number_format($totalMingguan ?? 0, 0, ',', '.') }}
                </h3>
            </div>
            <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #17a2b8;">
                <h6 style="color: #6c757d; font-size: 13px; margin-bottom: 8px; font-weight: 600;">Total Penjualan Bulanan</h6>
                <h3 style="color: #17a2b8; font-size: 24px; font-weight: 700; margin: 0;">
                    Rp {{ number_format($totalBulanan ?? 0, 0, ',', '.') }}
                </h3>
            </div>
            <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #ffc107;">
                <h6 style="color: #6c757d; font-size: 13px; margin-bottom: 8px; font-weight: 600;">Jumlah Transaksi</h6>
                <h3 style="color: #ffc107; font-size: 24px; font-weight: 700; margin: 0;">
                    {{ $jumlahTransaksi ?? 0 }}
                </h3>
            </div>
        </div>

        <!-- Filter Section -->
        <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 24px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; align-items: flex-end;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: #333;">Tanggal Mulai</label>
                    <input type="date" id="startDate" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 13px;" value="{{ $startDate ?? date('Y-m-d') }}">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: #333;">Tanggal Akhir</label>
                    <input type="date" id="endDate" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 13px;" value="{{ $endDate ?? date('Y-m-d') }}">
                </div>
                <button onclick="filterData()" style="background: #8B6F47; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 13px; width: 100%; transition: background 0.3s;">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </div>

        <!-- Chart Section -->
        <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 24px;">
            <h5 style="font-weight: 700; margin-bottom: 20px; color: #333;">Grafik Penjualan Harian</h5>
            <canvas id="salesChart" style="max-height: 300px;"></canvas>
        </div>

        <!-- Table Section -->
        <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h5 style="font-weight: 700; margin-bottom: 20px; color: #333;">Detail Penjualan</h5>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="border-bottom: 2px solid #f0f0f0; background: #f8f9fa;">
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #333;">Tanggal</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #333;">Jumlah Transaksi</th>
                            <th style="padding: 12px; text-align: right; font-weight: 600; color: #333;">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($salesData ?? [] as $item)
                            <tr style="border-bottom: 1px solid #f0f0f0; transition: background 0.2s;">
                                <td style="padding: 12px;">{{ date('d-m-Y', strtotime($item['tanggal'] ?? now())) }}</td>
                                <td style="padding: 12px;">
                                    <span style="background: #cfe2ff; color: #084298; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                        {{ $item['jumlah_transaksi'] ?? 0 }}
                                    </span>
                                </td>
                                <td style="padding: 12px; text-align: right; font-weight: 600; color: #28a745;">
                                    Rp {{ number_format($item['total_pendapatan'] ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="padding: 24px; text-align: center; color: #999;">
                                    Tidak ada data penjualan
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
    // Chart.js untuk grafik penjualan
    const chartData = {
        labels: @json(array_column($salesData ?? [], 'tanggal') ?: [date('Y-m-d')]),
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: @json(array_column($salesData ?? [], 'total_pendapatan') ?: [0]),
            borderColor: '#8B6F47',
            backgroundColor: 'rgba(139, 111, 71, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: '#8B6F47',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
        }]
    };

    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

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
