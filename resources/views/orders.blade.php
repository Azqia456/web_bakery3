<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan - Three D Bakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --brown-light: #D4A574;
            --cream: #F5EFE7;
            --white: #FFFFFF;
            --pink-light: #F8D7DA;
            --gray-light: #F8F8F8;
            --gray-text: #6B7280;
            --brown-dark: #8B6F47;
            --shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 8px 20px rgba(0, 0, 0, 0.12);
            --blue: #3B82F6;
            --yellow: #F59E0B;
            --red: #EF4444;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--gray-light);
            color: #333;
        }

        /* ========== LAYOUT ========== */
        .container-main {
            display: flex;
            min-height: 100vh;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            width: 260px;
            background: var(--white);
            padding: 30px 20px;
            border-right: 1px solid #e5e7eb;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            left: 0;
            top: 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
        }

        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
            text-decoration: none;
            color: var(--brown-dark);
            font-weight: 700;
            font-size: 20px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--brown-light), var(--pink-light));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            margin-right: 10px;
            font-weight: bold;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: var(--gray-text);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: var(--cream);
            color: var(--brown-dark);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            stroke-width: 2;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
        }

        /* ========== HEADER ========== */
        .header {
            background: var(--white);
            padding: 20px 40px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow);
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--brown-dark);
        }

        .add-order-btn {
            background: linear-gradient(135deg, var(--brown-light), var(--brown-dark));
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }

        .add-order-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* ========== CONTENT AREA ========== */
        .content {
            flex: 1;
            padding: 30px 40px;
            background-color: var(--gray-light);
            overflow-y: auto;
        }

        /* ========== TABLE ========== */
        .orders-table-container {
            background: var(--white);
            border-radius: 15px;
            box-shadow: var(--shadow);
            overflow: hidden;
            border: 1px solid #f3f4f6;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table thead {
            background-color: var(--cream);
        }

        .orders-table th {
            padding: 20px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: var(--brown-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e5e7eb;
        }

        .orders-table td {
            padding: 20px 16px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
            color: #374151;
        }

        /* ========== BADGES ========== */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-tipe-pelanggan {
            background-color: rgba(212, 165, 116, 0.1);
            color: var(--brown-light);
        }

        .badge-tipe-karyawan {
            background-color: rgba(248, 215, 218, 0.1);
            color: var(--pink-light);
        }

        .badge-status-selesai {
            background-color: rgba(34, 197, 94, 0.1);
            color: #16a34a;
        }

        .badge-status-menunggu {
            background-color: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }

        .badge-status-diproses {
            background-color: rgba(59, 130, 246, 0.1);
            color: #2563eb;
        }

        .badge-status-dikonfirmasi {
            background-color: rgba(139, 92, 246, 0.1);
            color: #7c3aed;
        }

        .badge-pembayaran-lunas {
            background-color: rgba(34, 197, 94, 0.1);
            color: #16a34a;
        }

        .badge-pembayaran-belum-lunas {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        /* ========== ACTION BUTTONS ========== */
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            background-color: var(--gray-light);
            color: var(--gray-text);
            font-size: 14px;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .action-btn.view:hover {
            background-color: var(--blue);
            color: white;
        }

        .action-btn.edit:hover {
            background-color: var(--yellow);
            color: white;
        }

        .action-btn.delete:hover {
            background-color: var(--red);
            color: white;
        }

        .action-btn.confirm-payment:hover {
            background-color: #10b981;
            color: white;
        }

        .action-btn.complete-order:hover {
            background-color: #8b5cf6;
            color: white;
        }

        /* ========== MODAL ========== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.9);
            transition: all 0.3s ease;
        }

        .modal-overlay.active .modal {
            transform: scale(1);
        }

        .modal-header {
            padding: 30px 30px 20px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
        }

        .modal-close {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background-color: var(--gray-light);
            color: var(--gray-text);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background-color: #ef4444;
            color: white;
        }

        .modal-body {
            padding: 30px;
        }

        /* ========== DETAIL MODAL STYLES ========== */
        .detail-section {
            margin-bottom: 24px;
        }

        .detail-row {
            display: flex;
            gap: 24px;
            margin-bottom: 16px;
        }

        .detail-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .detail-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--brown-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 16px;
            font-weight: 500;
            color: #374151;
        }

        .detail-divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 24px 0;
        }

        .detail-subtitle {
            font-size: 18px;
            font-weight: 600;
            color: var(--brown-dark);
            margin-bottom: 16px;
        }

        .products-list {
            background-color: var(--gray-light);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .product-name {
            font-weight: 500;
            color: #374151;
        }

        .product-quantity {
            font-size: 14px;
            color: var(--gray-text);
            background-color: var(--cream);
            padding: 2px 8px;
            border-radius: 6px;
        }

        .product-price {
            font-weight: 600;
            color: var(--brown-dark);
        }

        .detail-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--cream);
            padding: 20px;
            border-radius: 10px;
            border: 2px solid var(--brown-light);
        }

        .detail-total-label {
            font-size: 16px;
            font-weight: 600;
            color: var(--brown-dark);
        }

        .detail-total-amount {
            font-size: 24px;
            font-weight: 700;
            color: var(--brown-dark);
        }

        /* ========== FORM STYLES ========== */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-select,
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 14px;
            background-color: var(--white);
            transition: all 0.3s ease;
        }

        .form-select:focus,
        .form-input:focus {
            outline: none;
            border-color: var(--brown-light);
            box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.1);
        }

        .product-row {
            display: flex;
            gap: 12px;
            align-items: end;
            margin-bottom: 16px;
        }

        .product-row .form-select,
        .product-row .form-input {
            flex: 1;
        }

        .add-product-btn {
            background-color: var(--cream);
            color: var(--brown-dark);
            border: 1px solid var(--brown-light);
            padding: 12px 16px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .add-product-btn:hover {
            background-color: var(--brown-light);
            color: white;
        }

        .total-section {
            background-color: var(--cream);
            padding: 20px;
            border-radius: 10px;
            margin-top: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-label {
            font-size: 16px;
            font-weight: 600;
            color: var(--brown-dark);
        }

        .total-amount {
            font-size: 20px;
            font-weight: 700;
            color: var(--brown-dark);
        }

        .modal-footer {
            padding: 20px 30px 30px;
            border-top: 1px solid #f3f4f6;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-secondary {
            background-color: var(--gray-light);
            color: var(--gray-text);
            border: 1px solid #d1d5db;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #e5e7eb;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--brown-light), var(--brown-dark));
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }

        .btn-danger {
            background-color: var(--red);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                padding: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .content {
                padding: 20px;
            }

            .header {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .page-title {
                font-size: 24px;
            }

            .orders-table-container {
                overflow-x: auto;
            }

            .orders-table {
                min-width: 800px;
            }

            .modal {
                width: 95%;
                margin: 20px;
            }

            .modal-header,
            .modal-body,
            .modal-footer {
                padding: 20px;
            }

            .product-row {
                flex-direction: column;
                gap: 8px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 4px;
            }
        }

        /* ========== SCROLLBAR ========== */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="container-main">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <a href="/dashboard" class="logo">
                <div class="logo-icon">🥖</div>
                <span>Three D</span>
            </a>

            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 12h18M3 6h18M3 18h18M5 9v6M19 9v6"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/orders" class="nav-link active">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 3v18M3 9h18M3 15h18"/>
                            </svg>
                            Pesanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M12 3a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/>
                            </svg>
                            Pelanggan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 3a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/>
                            </svg>
                            Karyawan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="9" cy="21" r="1"/>
                                <circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                            Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                                <path d="M16 2v10M8 2v10M6 7h12"/>
                            </svg>
                            Pembayaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="2" x2="12" y2="22"/>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                            </svg>
                            Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="1"/>
                                <circle cx="19" cy="12" r="1"/>
                                <circle cx="5" cy="12" r="1"/>
                            </svg>
                            Pengaturan
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <!-- HEADER -->
            <header class="header">
                <h1 class="page-title">Pesanan</h1>
                <button class="add-order-btn" onclick="openModal()">
                    <i class="fas fa-plus"></i>
                    Tambah Pesanan
                </button>
            </header>

            <!-- CONTENT -->
            <div class="content">
                <div class="orders-table-container">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Pembayaran</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders ?? [] as $order)
                            <tr>
                                <td>{{ $order['id'] }}</td>
                                <td>{{ $order['name'] }}</td>
                                <td><span class="badge badge-tipe-{{ strtolower($order['type']) }}">{{ $order['type'] }}</span></td>
                                <td><span class="badge badge-status-{{ strtolower(str_replace(' ', '', $order['status'])) }}">{{ $order['status'] }}</span></td>
                                <td><span class="badge badge-pembayaran-{{ strtolower(str_replace(' ', '-', $order['payment'])) }}">{{ $order['payment'] }}</span></td>
                                <td>Rp {{ number_format($order['total']) }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn view" title="Lihat Detail" onclick="openDetailModal('{{ $order['id'] }}')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn edit" title="Edit" onclick="openEditModal('{{ $order['id'] }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn delete" title="Hapus" onclick="confirmDelete('{{ $order['id'] }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @if($order['payment'] === 'Belum Lunas')
                                        <button class="action-btn confirm-payment" title="Konfirmasi Pembayaran" onclick="confirmPayment('{{ $order['id'] }}')">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                        @endif
                                        @if($order['status'] !== 'Selesai')
                                        <button class="action-btn complete-order" title="Selesaikan Pesanan" onclick="completeOrder('{{ $order['id'] }}')">
                                            <i class="fas fa-check-double"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH PESANAN -->
    <div class="modal-overlay" id="addOrderModal">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Tambah Pesanan</h2>
                <button class="modal-close" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Tipe Pesanan</label>
                    <select class="form-select" id="orderType">
                        <option value="">Pilih Tipe Pesanan</option>
                        <option value="pelanggan">Pelanggan</option>
                        <option value="karyawan">Karyawan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Pelanggan</label>
                    <select class="form-select" id="customer">
                        <option value="">Pilih Pelanggan</option>
                        <option value="siti-dewi">Siti Dewi</option>
                        <option value="budi-raharjo">Budi Raharjo</option>
                        <option value="rina-putri">Rina Putri</option>
                        <option value="ahmad-nur">Ahmad Nur</option>
                        <option value="indra-maulana">Indra Maulana</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Produk</label>
                    <div id="productsContainer">
                        <div class="product-row">
                            <select class="form-select">
                                <option value="">Pilih Produk</option>
                                <option value="roti-tawar">Roti Tawar - Rp 25.000</option>
                                <option value="croissant">Croissant - Rp 15.000</option>
                                <option value="donut">Donut - Rp 12.000</option>
                                <option value="cake">Cake - Rp 75.000</option>
                                <option value="bread-roll">Bread Roll - Rp 8.000</option>
                            </select>
                            <input type="number" class="form-input" placeholder="Jumlah" min="1">
                            <button class="add-product-btn" onclick="removeProduct(this)">Hapus</button>
                        </div>
                    </div>
                    <button class="add-product-btn" onclick="addProduct()" style="margin-top: 12px;">+ Tambah Produk</button>
                </div>

                <div class="total-section">
                    <span class="total-label">Total:</span>
                    <span class="total-amount" id="totalAmount">Rp 0</span>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeModal()">Batal</button>
                <button class="btn-primary" onclick="submitOrder()">Simpan Pesanan</button>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL PESANAN -->
    <div class="modal-overlay" id="detailOrderModal">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Detail Pesanan <span id="detailOrderId"></span></h2>
                <button class="modal-close" onclick="closeDetailModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="detail-section">
                    <div class="detail-row">
                        <div class="detail-item">
                            <label class="detail-label">Nama Pelanggan:</label>
                            <span class="detail-value" id="detailCustomerName"></span>
                        </div>
                        <div class="detail-item">
                            <label class="detail-label">Tipe Pesanan:</label>
                            <span class="detail-value" id="detailOrderType"></span>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-item">
                            <label class="detail-label">Status Pesanan:</label>
                            <span class="badge" id="detailStatusBadge"></span>
                        </div>
                        <div class="detail-item">
                            <label class="detail-label">Status Pembayaran:</label>
                            <span class="badge" id="detailPaymentBadge"></span>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-item">
                            <label class="detail-label">Tanggal Pesanan:</label>
                            <span class="detail-value" id="detailOrderDate"></span>
                        </div>
                    </div>

                    <div class="detail-divider"></div>

                    <div class="detail-section">
                        <h3 class="detail-subtitle">Detail Produk</h3>
                        <div class="products-list" id="detailProductsList">
                            <!-- Products will be populated by JavaScript -->
                        </div>
                    </div>

                    <div class="detail-total">
                        <span class="detail-total-label">Total Pembayaran:</span>
                        <span class="detail-total-amount" id="detailTotalAmount"></span>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeDetailModal()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT PESANAN -->
    <div class="modal-overlay" id="editOrderModal">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Edit Pesanan <span id="editOrderId"></span></h2>
                <button class="modal-close" onclick="closeEditModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Status Pesanan</label>
                    <select class="form-select" id="editOrderStatus">
                        <option value="Menunggu">Menunggu</option>
                        <option value="Dikonfirmasi">Dikonfirmasi</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Produk</label>
                    <div id="editProductsContainer">
                        <!-- Products will be populated by JavaScript -->
                    </div>
                    <button class="add-product-btn" onclick="addEditProduct()" style="margin-top: 12px;">+ Tambah Produk</button>
                </div>

                <div class="total-section">
                    <span class="total-label">Total:</span>
                    <span class="total-amount" id="editTotalAmount">Rp 0</span>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeEditModal()">Batal</button>
                <button class="btn-primary" onclick="updateOrder()">Update Pesanan</button>
            </div>
        </div>
    </div>

    <!-- MODAL KONFIRMASI HAPUS -->
    <div class="modal-overlay" id="deleteConfirmModal">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Konfirmasi Hapus</h2>
                <button class="modal-close" onclick="closeDeleteModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <p style="text-align: center; font-size: 16px; color: #374151; margin-bottom: 24px;">
                    Apakah Anda yakin ingin menghapus pesanan <strong id="deleteOrderId"></strong>?
                </p>
                <p style="text-align: center; font-size: 14px; color: #6b7280;">
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>

            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeDeleteModal()">Batal</button>
                <button class="btn-danger" onclick="deleteOrder()">Hapus</button>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function openModal() {
            document.getElementById('addOrderModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('addOrderModal').classList.remove('active');
        }

        // Detail modal functions
        function openDetailModal(orderId) {
            // Fetch order data from API
            fetch(`/api/orders/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert('Order tidak ditemukan');
                        return;
                    }

                    // Populate modal with data
                    document.getElementById('detailOrderId').textContent = data.id;
                    document.getElementById('detailCustomerName').textContent = data.name;
                    document.getElementById('detailOrderType').textContent = data.type;
                    document.getElementById('detailOrderStatus').textContent = data.status;
                    document.getElementById('detailPaymentStatus').textContent = data.payment;
                    document.getElementById('detailOrderDate').textContent = data.date;
                    document.getElementById('detailTotalAmount').textContent = `Rp ${data.total.toLocaleString()}`;

                    // Set badge classes
                    const statusBadge = document.getElementById('detailStatusBadge');
                    const paymentBadge = document.getElementById('detailPaymentBadge');

                    statusBadge.className = 'badge';
                    if (data.status === 'Selesai') statusBadge.classList.add('badge-status-selesai');
                    else if (data.status === 'Menunggu') statusBadge.classList.add('badge-status-menunggu');
                    else if (data.status === 'Diproses') statusBadge.classList.add('badge-status-diproses');
                    else if (data.status === 'Dikonfirmasi') statusBadge.classList.add('badge-status-dikonfirmasi');

                    paymentBadge.className = 'badge';
                    if (data.payment === 'Lunas') paymentBadge.classList.add('badge-pembayaran-lunas');
                    else paymentBadge.classList.add('badge-pembayaran-belum-lunas');

                    // Populate products list
                    const productsList = document.getElementById('detailProductsList');
                    productsList.innerHTML = '';
                    data.products.forEach(product => {
                        const productItem = document.createElement('div');
                        productItem.className = 'product-item';
                        productItem.innerHTML = `
                            <div class="product-info">
                                <span class="product-name">${product.name}</span>
                                <span class="product-quantity">x${product.quantity}</span>
                            </div>
                            <span class="product-price">Rp ${(product.price * product.quantity).toLocaleString()}</span>
                        `;
                        productsList.appendChild(productItem);
                    });

                    // Show modal
                    document.getElementById('detailOrderModal').classList.add('active');
                })
                .catch(error => {
                    console.error('Error fetching order data:', error);
                    alert('Terjadi kesalahan saat memuat data pesanan');
                });
        }

        function closeDetailModal() {
            document.getElementById('detailOrderModal').classList.remove('active');
        }

        // Edit modal functions
        function openEditModal(orderId) {
            // Fetch order data
            fetch(`/api/orders/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert('Order tidak ditemukan');
                        return;
                    }

                    // Populate modal with data
                    document.getElementById('editOrderId').textContent = data.id;
                    document.getElementById('editOrderStatus').value = data.status;

                    // Populate products
                    const productsContainer = document.getElementById('editProductsContainer');
                    productsContainer.innerHTML = '';
                    data.products.forEach(product => {
                        const productRow = document.createElement('div');
                        productRow.className = 'product-row';
                        productRow.innerHTML = `
                            <select class="form-select">
                                <option value="">Pilih Produk</option>
                                <option value="roti-tawar" ${product.name === 'Roti Tawar' ? 'selected' : ''}>Roti Tawar - Rp 25.000</option>
                                <option value="croissant" ${product.name === 'Croissant' ? 'selected' : ''}>Croissant - Rp 15.000</option>
                                <option value="donut" ${product.name === 'Donut' ? 'selected' : ''}>Donut - Rp 12.000</option>
                                <option value="cake" ${product.name === 'Cake' ? 'selected' : ''}>Cake - Rp 75.000</option>
                                <option value="bread-roll" ${product.name === 'Bread Roll' ? 'selected' : ''}>Bread Roll - Rp 8.000</option>
                            </select>
                            <input type="number" class="form-input" placeholder="Jumlah" min="1" value="${product.quantity}">
                            <button class="add-product-btn" onclick="removeProduct(this)">Hapus</button>
                        `;
                        productsContainer.appendChild(productRow);
                    });

                    updateEditTotal();

                    // Show modal
                    document.getElementById('editOrderModal').classList.add('active');
                })
                .catch(error => {
                    console.error('Error fetching order data:', error);
                    alert('Terjadi kesalahan saat memuat data pesanan');
                });
        }

        function closeEditModal() {
            document.getElementById('editOrderModal').classList.remove('active');
        }

        // Delete modal functions
        function confirmDelete(orderId) {
            document.getElementById('deleteOrderId').textContent = orderId;
            document.getElementById('deleteConfirmModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteConfirmModal').classList.remove('active');
        }

        function deleteOrder() {
            const orderId = document.getElementById('deleteOrderId').textContent;
            // In real app, this would send DELETE request to server
            alert(`Pesanan ${orderId} berhasil dihapus!`);
            closeDeleteModal();
            // Reload page to refresh data
            location.reload();
        }

        // Additional actions
        function confirmPayment(orderId) {
            if (confirm(`Konfirmasi pembayaran untuk pesanan ${orderId}?`)) {
                // In real app, this would update payment status
                alert(`Pembayaran pesanan ${orderId} berhasil dikonfirmasi!`);
                location.reload();
            }
        }

        function completeOrder(orderId) {
            if (confirm(`Selesaikan pesanan ${orderId}?`)) {
                // In real app, this would update order status
                alert(`Pesanan ${orderId} berhasil diselesaikan!`);
                location.reload();
            }
        }

        // Close modals when clicking overlay
        document.getElementById('addOrderModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        document.getElementById('detailOrderModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });

        document.getElementById('editOrderModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        document.getElementById('deleteConfirmModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Add product function
        function addProduct() {
            const container = document.getElementById('productsContainer');
            const productRow = document.createElement('div');
            productRow.className = 'product-row';
            productRow.innerHTML = `
                <select class="form-select">
                    <option value="">Pilih Produk</option>
                    <option value="roti-tawar">Roti Tawar - Rp 25.000</option>
                    <option value="croissant">Croissant - Rp 15.000</option>
                    <option value="donut">Donut - Rp 12.000</option>
                    <option value="cake">Cake - Rp 75.000</option>
                    <option value="bread-roll">Bread Roll - Rp 8.000</option>
                </select>
                <input type="number" class="form-input" placeholder="Jumlah" min="1">
                <button class="add-product-btn" onclick="removeProduct(this)">Hapus</button>
            `;
            container.appendChild(productRow);
            updateTotal();
        }

        function addEditProduct() {
            const container = document.getElementById('editProductsContainer');
            const productRow = document.createElement('div');
            productRow.className = 'product-row';
            productRow.innerHTML = `
                <select class="form-select">
                    <option value="">Pilih Produk</option>
                    <option value="roti-tawar">Roti Tawar - Rp 25.000</option>
                    <option value="croissant">Croissant - Rp 15.000</option>
                    <option value="donut">Donut - Rp 12.000</option>
                    <option value="cake">Cake - Rp 75.000</option>
                    <option value="bread-roll">Bread Roll - Rp 8.000</option>
                </select>
                <input type="number" class="form-input" placeholder="Jumlah" min="1">
                <button class="add-product-btn" onclick="removeProduct(this)">Hapus</button>
            `;
            container.appendChild(productRow);
            updateEditTotal();
        }

        // Remove product function
        function removeProduct(button) {
            button.closest('.product-row').remove();
            updateTotal();
            updateEditTotal();
        }

        // Update total function (dummy calculation)
        function updateTotal() {
            const totalElement = document.getElementById('totalAmount');
            // Dummy calculation - in real app this would calculate based on selected products
            const randomTotal = Math.floor(Math.random() * 500) + 50;
            totalElement.textContent = `Rp ${randomTotal}.000`;
        }

        function updateEditTotal() {
            const totalElement = document.getElementById('editTotalAmount');
            // Dummy calculation - in real app this would calculate based on selected products
            const randomTotal = Math.floor(Math.random() * 500) + 50;
            totalElement.textContent = `Rp ${randomTotal}.000`;
        }

        // Submit order function
        function submitOrder() {
            // Dummy submit - in real app this would send data to server
            alert('Pesanan berhasil disimpan!');
            closeModal();
            // Reset form
            document.getElementById('orderType').value = '';
            document.getElementById('customer').value = '';
            document.getElementById('productsContainer').innerHTML = `
                <div class="product-row">
                    <select class="form-select">
                        <option value="">Pilih Produk</option>
                        <option value="roti-tawar">Roti Tawar - Rp 25.000</option>
                        <option value="croissant">Croissant - Rp 15.000</option>
                        <option value="donut">Donut - Rp 12.000</option>
                        <option value="cake">Cake - Rp 75.000</option>
                        <option value="bread-roll">Bread Roll - Rp 8.000</option>
                    </select>
                    <input type="number" class="form-input" placeholder="Jumlah" min="1">
                    <button class="add-product-btn" onclick="removeProduct(this)">Hapus</button>
                </div>
            `;
            updateTotal();
        }

        function updateOrder() {
            // Dummy update - in real app this would send data to server
            alert('Pesanan berhasil diupdate!');
            closeEditModal();
            location.reload();
        }

        // Update total on input changes
        document.addEventListener('input', updateTotal);
        document.addEventListener('change', updateTotal);
        document.addEventListener('input', updateEditTotal);
        document.addEventListener('change', updateEditTotal);
    </script>
</body>
</html>