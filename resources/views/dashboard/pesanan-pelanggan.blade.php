<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three D Bakery - Pesanan Saya</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-brown: #8B6F47;
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
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, var(--primary-brown), #D4A574);
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
        }

        .header {
            background: var(--white);
            border-bottom: 1px solid var(--medium-gray);
            padding: 16px 24px;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
        }

        .header p {
            color: var(--dark-gray);
            font-size: 13px;
            margin-top: 2px;
        }

        .content {
            padding: 24px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .summary-card {
            background: var(--white);
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-md);
            padding: 18px;
        }

        .summary-title {
            font-size: 12px;
            color: var(--dark-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .summary-value {
            font-size: 24px;
            font-weight: 700;
        }

        .table-card {
            background: var(--white);
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .table-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--medium-gray);
            background: var(--light-gray);
            font-weight: 600;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 640px;
        }

        th,
        td {
            text-align: left;
            padding: 12px 14px;
            border-bottom: 1px solid var(--medium-gray);
            font-size: 13px;
        }

        th {
            font-size: 12px;
            color: var(--dark-gray);
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

        @media (max-width: 900px) {
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
            }

            .dashboard {
                display: block;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1>Three D Bakery</h1>
                <p>Panel Pelanggan</p>
            </div>
            <nav class="sidebar-menu">
                <div class="sidebar-menu-item">
                    <a href="/dashboard/pelanggan"><i class="fas fa-home"></i>Dashboard Pelanggan</a>
                </div>
                <div class="sidebar-menu-item">
                    <a href="/pelanggan/pesanan" class="active"><i class="fas fa-box"></i>Pesanan Saya</a>
                </div>
            </nav>
        </aside>

        <main class="main-content">
            <header class="header">
                <h1>Pesanan Saya</h1>
                <p>Halaman pesanan khusus pelanggan dan tidak terhubung ke dashboard admin</p>
            </header>

            <section class="content">
                <div class="summary-grid">
                    <article class="summary-card">
                        <div class="summary-title">Total Pesanan</div>
                        <div class="summary-value">3</div>
                    </article>
                    <article class="summary-card">
                        <div class="summary-title">Sedang Diproses</div>
                        <div class="summary-value">1</div>
                    </article>
                    <article class="summary-card">
                        <div class="summary-title">Belum Lunas</div>
                        <div class="summary-value">1</div>
                    </article>
                </div>

                <article class="table-card">
                    <div class="table-header">Daftar Pesanan Pelanggan</div>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Tanggal</th>
                                    <th>Produk</th>
                                    <th>Total</th>
                                    <th>Status Pesanan</th>
                                    <th>Status Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>ORD-260401</td>
                                    <td>2026-04-24</td>
                                    <td>Roti Coklat Premium</td>
                                    <td>Rp 350.000</td>
                                    <td><span class="status warning">Diproses</span></td>
                                    <td><span class="status success">Lunas</span></td>
                                </tr>
                                <tr>
                                    <td>ORD-260395</td>
                                    <td>2026-04-22</td>
                                    <td>Cake Ulang Tahun</td>
                                    <td>Rp 650.000</td>
                                    <td><span class="status info">Dikirim</span></td>
                                    <td><span class="status success">Lunas</span></td>
                                </tr>
                                <tr>
                                    <td>ORD-260388</td>
                                    <td>2026-04-20</td>
                                    <td>Pastry Box</td>
                                    <td>Rp 250.000</td>
                                    <td><span class="status warning">Menunggu Konfirmasi</span></td>
                                    <td><span class="status warning">Belum Lunas</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </article>
            </section>
        </main>
    </div>
</body>
</html>
