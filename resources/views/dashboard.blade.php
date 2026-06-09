@extends('layouts.dashboard-layout', ['pageTitle' => 'Dashboard'])

@section('additional-styles')
<style>
    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .summary-card {
        background: var(--white);
        padding: 24px;
        border-radius: var(--border-radius-xl);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--medium-gray);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .summary-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-green), #81C784);
    }

    .summary-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .summary-card-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--border-radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 16px;
    }

    .summary-card-icon.blue { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }
    .summary-card-icon.green { background: rgba(34, 197, 94, 0.1); color: #22C55E; }
    .summary-card-icon.orange { background: rgba(249, 115, 22, 0.1); color: #F97316; }
    .summary-card-icon.purple { background: rgba(147, 51, 234, 0.1); color: #9333EA; }

    .summary-card-title {
        font-size: 14px;
        color: var(--dark-gray);
        font-weight: 500;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .summary-card-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .summary-card-change {
        display: flex;
        align-items: center;
        font-size: 12px;
        font-weight: 500;
        color: var(--dark-gray);
    }

    .summary-card-change i {
        margin-right: 4px;
    }

    .empty-state {
        padding: 24px;
        text-align: center;
        color: var(--dark-gray);
        font-size: 14px;
    }

    .charts-section {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 32px;
    }

    .chart-card {
        background: var(--white);
        border-radius: var(--border-radius-xl);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--medium-gray);
        overflow: hidden;
    }

    .chart-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--medium-gray);
        background: var(--light-gray);
    }

    .chart-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
    }

    .chart-title i {
        margin-right: 8px;
        color: var(--primary-green);
    }

    .chart-content {
        padding: 24px;
        height: 300px;
    }

    .customers-panel {
        background: var(--white);
        border-radius: var(--border-radius-xl);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--medium-gray);
        overflow: hidden;
    }

    .customers-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--medium-gray);
        background: var(--light-gray);
    }

    .customers-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
    }

    .customers-title i {
        margin-right: 8px;
        color: var(--primary-green);
    }

    .customers-list {
        max-height: 300px;
        overflow-y: auto;
    }

    .bottom-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .deposits-panel {
        background: var(--white);
        border-radius: var(--border-radius-xl);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--medium-gray);
        overflow: hidden;
    }

    .deposits-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--medium-gray);
        background: var(--light-gray);
    }

    .deposits-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
    }

    .deposits-title i {
        margin-right: 8px;
        color: var(--primary-green);
    }

    .deposits-list {
        max-height: 300px;
        overflow-y: auto;
    }

    .statistics-panel {
        background: var(--white);
        border-radius: var(--border-radius-xl);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--medium-gray);
        overflow: hidden;
    }

    .statistics-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--medium-gray);
        background: var(--light-gray);
    }

    .statistics-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
    }

    .statistics-title i {
        margin-right: 8px;
        color: var(--primary-green);
    }

    .statistics-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        padding: 24px;
    }

    .statistic-item {
        text-align: center;
        padding: 20px;
        background: var(--white);
        border-radius: var(--border-radius);
        border: 1px solid var(--medium-gray);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .statistic-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .statistic-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--border-radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin: 0 auto 12px;
    }

    .statistic-icon.blue { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }
    .statistic-icon.green { background: rgba(34, 197, 94, 0.1); color: #22C55E; }
    .statistic-icon.purple { background: rgba(147, 51, 234, 0.1); color: #9333EA; }
    .statistic-icon.orange { background: rgba(249, 115, 22, 0.1); color: #F97316; }

    .statistic-value {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-dark);
        display: block;
        margin-bottom: 4px;
    }

    .statistic-label {
        font-size: 12px;
        color: var(--dark-gray);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .customer-item, .deposit-item {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        border-bottom: 1px solid var(--medium-gray);
        transition: var(--transition);
    }
    .customer-item:hover, .deposit-item:hover {
        background: var(--light-gray);
    }
    .customer-item:last-child, .deposit-item:last-child {
        border-bottom: none;
    }
    .customer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary-green);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        margin-right: 12px;
        flex-shrink: 0;
    }
    .customer-info, .deposit-info {
        flex: 1;
        min-width: 0;
    }
    .customer-name, .deposit-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 2px;
    }
    .customer-meta, .deposit-date {
        font-size: 12px;
        color: var(--dark-gray);
    }
    .deposit-amount {
        font-size: 14px;
        font-weight: 700;
        color: var(--primary-green);
        margin-left: 8px;
        white-space: nowrap;
    }

    @media (max-width: 1024px) {
        .charts-section {
            grid-template-columns: 1fr;
        }

        .bottom-section {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .summary-cards {
            grid-template-columns: 1fr;
        }

        .statistics-grid {
            grid-template-columns: 1fr 1fr;
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
<main class="dashboard-content">
    <section class="summary-cards" id="summary-cards">
        <div class="summary-card">
            <div class="summary-card-icon blue">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="summary-card-title">Total Pemesanan</div>
            <div class="summary-card-value">{{ number_format($totalPemesanan, 0, ',', '.') }}</div>
            <div class="summary-card-change">
                <i class="fas fa-chart-line"></i>
                {{ $totalPemesanan > 0 ? 'Total keseluruhan' : 'Belum ada data' }}
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-card-icon green">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="summary-card-title">Pendapatan Bulan Ini</div>
            <div class="summary-card-value">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
            <div class="summary-card-change">
                <i class="fas fa-chart-line"></i>
                {{ $pendapatanBulanIni > 0 ? 'Bulan ' . now()->isoFormat('MMMM YYYY') : 'Belum ada data' }}
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-card-icon orange">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="summary-card-title">Pesanan Belum Lunas</div>
            <div class="summary-card-value">{{ number_format($pesananBelumLunas, 0, ',', '.') }}</div>
            <div class="summary-card-change">
                <i class="fas fa-clock"></i>
                {{ $pesananBelumLunas > 0 ? 'Perlu ditindaklanjuti' : 'Belum ada data' }}
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-card-icon purple">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div class="summary-card-title">Setoran Karyawan</div>
            <div class="summary-card-value">Rp {{ number_format($setoranKaryawan, 0, ',', '.') }}</div>
            <div class="summary-card-change">
                <i class="fas fa-chart-line"></i>
                {{ $setoranKaryawan > 0 ? 'Total keseluruhan' : 'Belum ada data' }}
            </div>
        </div>
    </section>

    <section class="charts-section">
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">
                    <i class="fas fa-chart-line"></i>
                    Grafik Total Pemesanan
                </h3>
            </div>
            <div class="chart-content">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>

        <div class="customers-panel">
            <div class="customers-header">
                <h3 class="customers-title">
                    <i class="fas fa-users"></i>
                    Pelanggan yang Pesan
                </h3>
            </div>
            <div class="customers-list" id="customers-list">
                @if($topCustomers->count() > 0)
                    @foreach($topCustomers as $customer)
                    <div class="customer-item">
                        <div class="customer-avatar">{{ strtoupper(substr($customer->nama, 0, 2)) }}</div>
                        <div class="customer-info">
                            <div class="customer-name">{{ $customer->nama }}</div>
                            <div class="customer-meta">{{ $customer->pesanans_count }} pesanan</div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">Belum ada pelanggan.</div>
                @endif
            </div>
        </div>
    </section>

    <section class="bottom-section">
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">
                    <i class="fas fa-chart-bar"></i>
                    Grafik Setor Karyawan
                </h3>
            </div>
            <div class="chart-content">
                <canvas id="depositsChart"></canvas>
            </div>
        </div>

        <div class="deposits-panel">
            <div class="deposits-header">
                <h3 class="deposits-title">
                    <i class="fas fa-coins"></i>
                    Setoran Karyawan Terbaru
                </h3>
            </div>
            <div class="deposits-list" id="deposits-list">
                @if($recentDeposits->count() > 0)
                    @foreach($recentDeposits as $deposit)
                    <div class="deposit-item">
                        <div class="deposit-info">
                            <div class="deposit-name">{{ $deposit->karyawan->nama ?? 'Unknown' }}</div>
                            <div class="deposit-date">{{ $deposit->tgl_pesan ? \Carbon\Carbon::parse($deposit->tgl_pesan)->format('d M Y') : '-' }}</div>
                        </div>
                        <div class="deposit-amount">Rp {{ number_format($deposit->total_bayar, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">Belum ada setoran terbaru.</div>
                @endif
            </div>
        </div>
    </section>

    <section class="statistics-panel">
        <div class="statistics-header">
            <h3 class="statistics-title">
                <i class="fas fa-chart-pie"></i>
                Statistik Umum
            </h3>
        </div>
        <div class="statistics-grid" id="statistics-grid">
            <div class="statistic-item">
                <div class="statistic-icon blue">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="statistic-value">{{ number_format($totalProduk, 0, ',', '.') }}</div>
                <div class="statistic-label">Total Produk</div>
            </div>
            <div class="statistic-item">
                <div class="statistic-icon green">
                    <i class="fas fa-id-badge"></i>
                </div>
                <div class="statistic-value">{{ number_format($totalKaryawan, 0, ',', '.') }}</div>
                <div class="statistic-label">Total Karyawan</div>
            </div>
            <div class="statistic-item">
                <div class="statistic-icon purple">
                    <i class="fas fa-users"></i>
                </div>
                <div class="statistic-value">{{ number_format($totalPelanggan, 0, ',', '.') }}</div>
                <div class="statistic-label">Total Pelanggan</div>
            </div>
            <div class="statistic-item">
                <div class="statistic-icon orange">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="statistic-value">{{ number_format($pesananHariIni, 0, ',', '.') }}</div>
                <div class="statistic-label">Pesanan Hari Ini</div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('additional-scripts')
<script>
    let ordersChart, depositsChart;

    // Initialize charts with data
    function initCharts() {
        // Orders Line Chart
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        ordersChart = new Chart(ordersCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($ordersChartLabels) !!},
                datasets: [{
                    label: 'Total Pemesanan',
                    data: {!! json_encode($ordersChartData) !!},
                    borderColor: 'rgba(168, 218, 220, 1)',
                    backgroundColor: 'rgba(168, 218, 220, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(168, 218, 220, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    }
                }
            }
        });

        // Deposits Bar Chart
        const depositsCtx = document.getElementById('depositsChart').getContext('2d');
        depositsChart = new Chart(depositsCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($depositsChartLabels) !!},
                datasets: [{
                    label: 'Setoran (Rp)',
                    data: {!! json_encode($depositsChartData) !!},
                    backgroundColor: 'rgba(168, 218, 220, 0.8)',
                    borderColor: 'rgba(168, 218, 220, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                    barThickness: 32
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                                }
                                return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                            }
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    }
                }
            }
        });
    }

    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initCharts();
    });
</script>
@endsection
