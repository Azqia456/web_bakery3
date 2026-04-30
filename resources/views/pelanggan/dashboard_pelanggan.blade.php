<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three D Bakery - Dashboard Pelanggan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-brown: #8B6F47;
            --light-brown: #F5EFE7;
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
            letter-spacing: -0.025em;
        }

        .sidebar-header p {
            font-size: 12px;
            opacity: 0.85;
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
            color: rgba(255, 255, 255, 0.92);
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

        .main-content {
            flex: 1;
            margin-left: 280px;
            background-color: var(--cream);
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

        .header-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .header-subtitle {
            color: var(--dark-gray);
            font-size: 13px;
            margin-top: 2px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .profile-menu {
            position: relative;
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
            font-size: 14px;
            font-weight: 500;
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
            padding: 24px;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .summary-card {
            background: var(--white);
            padding: 20px;
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--medium-gray);
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

        .summary-card-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .summary-card-icon.blue { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }
        .summary-card-icon.green { background: rgba(34, 197, 94, 0.1); color: #22C55E; }
        .summary-card-icon.orange { background: rgba(249, 115, 22, 0.1); color: #F97316; }
        .summary-card-icon.purple { background: rgba(147, 51, 234, 0.1); color: #9333EA; }

        .summary-card-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--dark-gray);
            margin-bottom: 6px;
        }

        .summary-card-value {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .summary-card-change {
            font-size: 12px;
            font-weight: 600;
        }

        .summary-card-change.positive { color: #22C55E; }
        .summary-card-change.negative { color: #EF4444; }

        .content-grid {
            display: grid;
            grid-template-columns: 1.7fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        .card {
            background: var(--white);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--medium-gray);
            overflow: hidden;
        }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--medium-gray);
            background: var(--light-gray);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-body {
            padding: 18px 20px;
        }

        .chart-wrap {
            height: 280px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 680px;
        }

        th,
        td {
            text-align: left;
            padding: 12px 10px;
            border-bottom: 1px solid var(--medium-gray);
            font-size: 13px;
        }

        th {
            color: var(--dark-gray);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .status {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .status.success { color: #166534; background: #DCFCE7; }
        .status.warning { color: #9A3412; background: #FFEDD5; }
        .status.info { color: #1D4ED8; background: #DBEAFE; }

        .status-summary-list {
            display: grid;
            gap: 10px;
        }

        .status-summary-item {
            border: 1px solid var(--medium-gray);
            border-radius: 10px;
            padding: 12px;
            font-size: 13px;
            background: #fffdf9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .status-summary-left {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-dark);
            font-weight: 600;
        }

        .status-summary-value {
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            border: 1px solid var(--medium-gray);
        }

        .quick-actions {
            display: grid;
            gap: 10px;
        }

        .quick-actions a {
            display: block;
            text-decoration: none;
            color: var(--text-dark);
            border: 1px solid var(--medium-gray);
            border-radius: 10px;
            background: #fff;
            padding: 12px;
            transition: var(--transition);
            font-size: 13px;
            font-weight: 600;
        }

        .quick-actions a:hover {
            background: #fdf8ef;
            transform: translateX(3px);
        }

        @media (max-width: 1080px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 900px) {
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }

            .dashboard {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 12px 16px;
            }

            .header-title {
                font-size: 20px;
            }

            .dashboard-content {
                padding: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1>🍞 Three D Bakery</h1>
                <p>Panel Pelanggan</p>
            </div>
            <nav class="sidebar-menu">
                <div class="sidebar-menu-item">
                    <a href="{{ route('pelanggan.dashboard') }}" class="active"><i class="fas fa-tachometer-alt"></i>Dashboard Pelanggan</a>
                </div>
                <div class="sidebar-menu-item">
                    <a href="{{ url('/pelanggan/pesanan') }}"><i class="fas fa-shopping-cart"></i>Pesanan Saya</a>
                </div>
            </nav>
        </aside>

        <main class="main-content">
            <header class="header">
                <div>
                    <h1 class="header-title">Dashboard Pelanggan</h1>
                    <p class="header-subtitle">Informasi pesanan dan pembayaran Anda dalam satu halaman</p>
                </div>
                <div class="header-right">
                    <button class="notification-btn" type="button" aria-label="Notifikasi">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">1</span>
                    </button>
                    <div class="profile-menu">
                        <button type="button" class="profile-btn" id="profileMenuButton" aria-haspopup="true" aria-expanded="false" title="Akun">
                            <div class="profile-avatar">P</div>
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

            <section class="dashboard-content">
                <div class="summary-cards" id="summaryCards"></div>

                <div class="content-grid">
                    <article class="card">
                        <div class="card-header">
                            <h2 class="card-title"><i class="fas fa-chart-area"></i>Tren Pesanan Mingguan</h2>
                        </div>
                        <div class="card-body">
                            <div class="chart-wrap">
                                <canvas id="ordersChart"></canvas>
                            </div>
                        </div>
                    </article>

                    <article class="card">
                        <div class="card-header">
                            <h2 class="card-title"><i class="fas fa-clipboard-list"></i>Ringkasan Status</h2>
                        </div>
                        <div class="card-body">
                            <div class="status-summary-list" id="statusSummaryList"></div>
                        </div>
                    </article>
                </div>

                <div class="content-grid" style="grid-template-columns: 2fr 1fr;">
                    <article class="card">
                        <div class="card-header">
                            <h2 class="card-title"><i class="fas fa-receipt"></i>Status Pesanan & Pembayaran</h2>
                        </div>
                        <div class="card-body table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Tanggal</th>
                                        <th>Produk</th>
                                        <th>Total</th>
                                        <th>Status Pesanan</th>
                                    </tr>
                                </thead>
                                <tbody id="ordersTableBody"></tbody>
                            </table>
                        </div>
                    </article>

                    <article class="card">
                        <div class="card-header">
                            <h2 class="card-title"><i class="fas fa-bolt"></i>Aksi Cepat</h2>
                        </div>
                        <div class="card-body">
                            <div class="quick-actions">
                                <a href="{{ url('/pelanggan/pesanan') }}"><i class="fas fa-bag-shopping"></i> Pesan Sekarang</a>
                                <a href="/pelanggan/pesanan"><i class="fas fa-search"></i> Lacak Pesanan</a>
                            </div>
                        </div>
                    </article>
                </div>
            </section>
        </main>
    </div>

    <script>
        let ordersChart;

        function renderSummaryCards(cards) {
            const summaryCards = document.getElementById('summaryCards');
            summaryCards.innerHTML = cards.map(card => `
                <article class="summary-card">
                    <div class="summary-card-icon ${card.color}">
                        <i class="${card.icon}"></i>
                    </div>
                    <div class="summary-card-title">${card.title}</div>
                    <div class="summary-card-value">${card.value}</div>
                    <div class="summary-card-change ${card.change_type}">${card.change}</div>
                </article>
            `).join('');
        }

        function createOrdersChart(data) {
            const ctx = document.getElementById('ordersChart').getContext('2d');
            if (ordersChart) {
                ordersChart.destroy();
            }

            ordersChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Jumlah Pesanan',
                        data: data.data,
                        borderColor: '#8B6F47',
                        backgroundColor: 'rgba(139, 111, 71, 0.15)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }

        function getOrderStatusClass(status) {
            if (status.toLowerCase().includes('dikirim')) return 'info';
            if (status.toLowerCase().includes('proses')) return 'warning';
            return 'warning';
        }

        function renderOrdersTable(orders) {
            const ordersTableBody = document.getElementById('ordersTableBody');
            ordersTableBody.innerHTML = orders.map(order => `
                <tr>
                    <td>${order.kode}</td>
                    <td>${order.tanggal}</td>
                    <td>${order.produk}</td>
                    <td>${order.total}</td>
                    <td><span class="status ${getOrderStatusClass(order.status_pesanan)}">${order.status_pesanan}</span></td>
                </tr>
            `).join('');
        }

        function renderStatusSummary(items) {
            const statusSummaryList = document.getElementById('statusSummaryList');
            statusSummaryList.innerHTML = items.map(item => `
                <div class="status-summary-item">
                    <div class="status-summary-left">
                        <i class="fas fa-circle"></i>
                        <span>${item.label}</span>
                    </div>
                    <span class="status-summary-value status ${item.class}">${item.value}</span>
                </div>
            `).join('');
        }

        async function loadDashboard() {
            try {
                const response = await fetch('/api/pelanggan/dashboard_pelanggan/stats');
                if (!response.ok) {
                    throw new Error('Gagal memuat data dashboard pelanggan');
                }

                const data = await response.json();
                renderSummaryCards(data.summary_cards);
                createOrdersChart(data.orders_chart);
                renderOrdersTable(data.orders_list);
                renderStatusSummary(data.status_ringkasan);
            } catch (error) {
                console.error(error);
            }
        }

        const profileMenuButton = document.getElementById('profileMenuButton');
        const profileDropdown = document.getElementById('profileDropdown');

        if (profileMenuButton && profileDropdown) {
            profileMenuButton.addEventListener('click', () => {
                profileDropdown.classList.toggle('show');
                const expanded = profileDropdown.classList.contains('show');
                profileMenuButton.setAttribute('aria-expanded', expanded ? 'true' : 'false');
            });

            document.addEventListener('click', (event) => {
                if (!profileMenuButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.remove('show');
                    profileMenuButton.setAttribute('aria-expanded', 'false');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', loadDashboard);
    </script>
</body>
</html>
