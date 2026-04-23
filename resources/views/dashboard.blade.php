<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three D Bakery - Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-green: #A8DADC;
            --light-green: #E8F4F8;
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--cream);
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, var(--primary-green), #81C784);
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

        .sidebar-menu-item a {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: var(--transition);
            font-weight: 500;
            font-size: 14px;
        }

        .sidebar-menu-item a:hover,
        .sidebar-menu-item a.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: var(--white);
            transform: translateX(4px);
        }

        .sidebar-menu-item i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
            font-size: 16px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            background-color: var(--cream);
        }

        /* Header */
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

        .search-bar {
            position: relative;
            width: 320px;
        }

        .search-bar input {
            width: 100%;
            padding: 10px 16px 10px 40px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius-xl);
            background: var(--light-gray);
            font-size: 14px;
            transition: var(--transition);
        }

        .search-bar input:focus {
            outline: none;
            border-color: var(--primary-green);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(168, 218, 220, 0.1);
        }

        .search-bar i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--dark-gray);
            font-size: 14px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
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
            color: white;
            border-radius: 50%;
            font-size: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-green), #81C784);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        /* Dashboard Content */
        .dashboard-content {
            padding: 24px;
        }

        /* Summary Cards */
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
        }

        .summary-card-change.positive {
            color: #22C55E;
        }

        .summary-card-change.negative {
            color: #EF4444;
        }

        .summary-card-change i {
            margin-right: 4px;
        }

        /* Charts Section */
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

        /* Customers Panel */
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

        .customer-item {
            display: flex;
            align-items: center;
            padding: 16px 24px;
            border-bottom: 1px solid var(--medium-gray);
            transition: var(--transition);
        }

        .customer-item:hover {
            background: var(--light-gray);
        }

        .customer-item:last-child {
            border-bottom: none;
        }

        .customer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-green), #81C784);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .customer-info h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .customer-meta {
            font-size: 12px;
            color: var(--dark-gray);
        }

        .customer-category {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 500;
            text-transform: uppercase;
            margin-left: 8px;
        }

        .customer-category.vip {
            background: rgba(249, 115, 22, 0.1);
            color: #F97316;
        }

        .customer-category.regular {
            background: rgba(107, 114, 128, 0.1);
            color: #6B7280;
        }

        .customer-category.new {
            background: rgba(34, 197, 94, 0.1);
            color: #22C55E;
        }

        /* Bottom Section */
        .bottom-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        /* Deposits Panel */
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

        .deposit-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            border-bottom: 1px solid var(--medium-gray);
            transition: var(--transition);
        }

        .deposit-item:hover {
            background: var(--light-gray);
        }

        .deposit-item:last-child {
            border-bottom: none;
        }

        .deposit-info h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .deposit-date {
            font-size: 12px;
            color: var(--dark-gray);
        }

        .deposit-amount {
            text-align: right;
        }

        .deposit-amount .value {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            display: block;
        }

        .deposit-status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 500;
            background: rgba(34, 197, 94, 0.1);
            color: #22C55E;
            margin-top: 4px;
        }

        /* Statistics */
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
            background: var(--light-green);
            border-radius: var(--border-radius);
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

        /* Responsive */
        @media (max-width: 1024px) {
            .charts-section {
                grid-template-columns: 1fr;
            }

            .bottom-section {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .header {
                padding: 12px 16px;
            }

            .search-bar {
                width: 200px;
            }

            .summary-cards {
                grid-template-columns: 1fr;
            }

            .statistics-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(168, 218, 220, 0.3);
            border-radius: 50%;
            border-top-color: var(--primary-green);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Scrollbar */
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
                    <a href="/dashboard" class="active">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <a href="/orders">
                        <i class="fas fa-shopping-cart"></i>
                        Pesanan
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <a href="/customers">
                        <i class="fas fa-users"></i>
                        Pelanggan
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <a href="/employees">
                        <i class="fas fa-user-tie"></i>
                        Karyawan
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <a href="/products">
                        <i class="fas fa-box"></i>
                        Produk
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <a href="/payments">
                        <i class="fas fa-credit-card"></i>
                        Pembayaran
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <a href="/reports">
                        <i class="fas fa-chart-line"></i>
                        Laporan
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <a href="/settings">
                        <i class="fas fa-cog"></i>
                        Pengaturan
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <h1 class="header-title">Dashboard</h1>
                </div>

                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Cari pesanan, pelanggan, produk...">
                </div>

                <div class="header-right">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <button class="profile-btn">
                        <div class="profile-avatar">JD</div>
                    </button>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="dashboard-content">
                <!-- Summary Cards -->
                <section class="summary-cards" id="summary-cards">
                    <!-- Cards will be populated by JavaScript -->
                </section>

                <!-- Charts Section -->
                <section class="charts-section">
                    <!-- Orders Chart -->
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

                    <!-- Customers Panel -->
                    <div class="customers-panel">
                        <div class="customers-header">
                            <h3 class="customers-title">
                                <i class="fas fa-users"></i>
                                Pelanggan yang Pesan
                            </h3>
                        </div>
                        <div class="customers-list" id="customers-list">
                            <!-- Customers will be populated by JavaScript -->
                        </div>
                    </div>
                </section>

                <!-- Bottom Section -->
                <section class="bottom-section">
                    <!-- Deposits Chart -->
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

                    <!-- Deposits List -->
                    <div class="deposits-panel">
                        <div class="deposits-header">
                            <h3 class="deposits-title">
                                <i class="fas fa-coins"></i>
                                Setoran Karyawan Terbaru
                            </h3>
                        </div>
                        <div class="deposits-list" id="deposits-list">
                            <!-- Deposits will be populated by JavaScript -->
                        </div>
                    </div>
                </section>

                <!-- Statistics -->
                <section class="statistics-panel">
                    <div class="statistics-header">
                        <h3 class="statistics-title">
                            <i class="fas fa-chart-pie"></i>
                            Statistik Umum
                        </h3>
                    </div>
                    <div class="statistics-grid" id="statistics-grid">
                        <!-- Statistics will be populated by JavaScript -->
                    </div>
                </section>
            </main>
        </div>
    </div>

    <script>
        let ordersChart, depositsChart;

        // Initialize charts
        function initCharts() {
            // Orders Line Chart
            const ordersCtx = document.getElementById('ordersChart').getContext('2d');
            ordersChart = new Chart(ordersCtx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Total Pemesanan',
                        data: [],
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
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuart'
                    }
                }
            });

            // Deposits Bar Chart
            const depositsCtx = document.getElementById('depositsChart').getContext('2d');
            depositsChart = new Chart(depositsCtx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Setoran (Rp)',
                        data: [],
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
                                    return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                                }
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuart'
                    }
                }
            });
        }

        // Load dashboard data
        function loadDashboardData() {
            fetch('/api/dashboard/stats')
                .then(response => response.json())
                .then(data => {
                    updateSummaryCards(data.summary_cards);
                    updateOrdersChart(data.orders_chart);
                    updateCustomersList(data.customers_list);
                    updateDepositsChart(data.deposits_chart);
                    updateDepositsList(data.deposits_list);
                    updateStatistics(data.statistics);
                })
                .catch(error => {
                    console.error('Error loading dashboard data:', error);
                });
        }

        // Update summary cards
        function updateSummaryCards(cards) {
            const container = document.getElementById('summary-cards');
            container.innerHTML = '';

            cards.forEach(card => {
                const cardElement = document.createElement('div');
                cardElement.className = 'summary-card';

                cardElement.innerHTML = `
                    <div class="summary-card-icon ${card.color}">
                        <i class="${card.icon}"></i>
                    </div>
                    <div class="summary-card-title">${card.title}</div>
                    <div class="summary-card-value">${card.value}</div>
                    <div class="summary-card-change ${card.change_type}">
                        <i class="fas fa-arrow-${card.change_type === 'positive' ? 'up' : 'down'}"></i>
                        ${card.change} dari bulan lalu
                    </div>
                `;

                container.appendChild(cardElement);
            });
        }

        // Update orders chart
        function updateOrdersChart(chartData) {
            if (ordersChart) {
                ordersChart.data.labels = chartData.labels;
                ordersChart.data.datasets[0].data = chartData.data;
                ordersChart.update();
            }
        }

        // Update customers list
        function updateCustomersList(customers) {
            const container = document.getElementById('customers-list');
            container.innerHTML = '';

            customers.forEach(customer => {
                const item = document.createElement('div');
                item.className = 'customer-item';

                item.innerHTML = `
                    <div class="customer-avatar">${customer.avatar}</div>
                    <div class="customer-info">
                        <h4>${customer.name}</h4>
                        <div class="customer-meta">
                            ${customer.orders_count} pesanan • ${customer.last_order}
                            <span class="customer-category ${customer.category.toLowerCase()}">${customer.category}</span>
                        </div>
                    </div>
                `;

                container.appendChild(item);
            });
        }

        // Update deposits chart
        function updateDepositsChart(chartData) {
            if (depositsChart) {
                depositsChart.data.labels = chartData.labels;
                depositsChart.data.datasets[0].data = chartData.data;
                depositsChart.update();
            }
        }

        // Update deposits list
        function updateDepositsList(deposits) {
            const container = document.getElementById('deposits-list');
            container.innerHTML = '';

            deposits.forEach(deposit => {
                const item = document.createElement('div');
                item.className = 'deposit-item';

                item.innerHTML = `
                    <div class="deposit-info">
                        <h4>${deposit.name}</h4>
                        <div class="deposit-date">${deposit.date}</div>
                    </div>
                    <div class="deposit-amount">
                        <div class="value">Rp ${(deposit.amount / 1000000).toFixed(1)}M</div>
                        <span class="deposit-status">${deposit.status}</span>
                    </div>
                `;

                container.appendChild(item);
            });
        }

        // Update statistics
        function updateStatistics(statistics) {
            const container = document.getElementById('statistics-grid');
            container.innerHTML = '';

            statistics.forEach(stat => {
                const item = document.createElement('div');
                item.className = 'statistic-item';

                item.innerHTML = `
                    <div class="statistic-icon ${stat.color}">
                        <i class="${stat.icon}"></i>
                    </div>
                    <div class="statistic-value">${stat.value.toLocaleString('id-ID')}</div>
                    <div class="statistic-label">${stat.label}</div>
                `;

                container.appendChild(item);
            });
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initCharts();
            loadDashboardData();

            // Auto refresh every 30 seconds
            setInterval(loadDashboardData, 30000);
        });
    </script>
</body>
</html>