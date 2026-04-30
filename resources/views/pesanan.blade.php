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
            --primary-brown: #8B6F47;
            --light-brown: #D4A574;
            --cream: #F7F3E9;
            --light-cream: #F5EFE7;
            --white: #FFFFFF;
            --light-gray: #F8F9FA;
            --medium-gray: #E9ECEF;
            --dark-gray: #6C757D;
            --text-dark: #2D3748;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --blue: #3B82F6;
            --yellow: #F59E0B;
            --red: #EF4444;
            --green: #22C55E;
            --border-radius: 12px;
            --transition: all 0.3s ease;
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

        /* ========== SIDEBAR ========== */
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

        /* ========== MAIN CONTENT ========== */
        .main-content {
            flex: 1;
            margin-left: 280px;
            background-color: var(--cream);
        }

        /* ========== PAGE LAYOUT ========== */
        .page-container {
            padding: 24px;
            min-height: 100vh;
        }

        /* ========== HEADER ========== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .btn-add {
            background: linear-gradient(135deg, var(--light-brown), var(--primary-brown));
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: var(--border-radius);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-logout {
            background: linear-gradient(135deg, #EF4444, #DC2626);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: var(--border-radius);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* ========== FILTER & SEARCH ========== */
        .filter-section {
            background: var(--white);
            padding: 20px;
            border-radius: var(--border-radius);
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
            display: flex;
            gap: 16px;
            align-items: end;
            flex-wrap: wrap;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .search-input,
        .filter-select {
            width: 100%;
            padding: 10px 16px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            font-size: 14px;
            background-color: var(--white);
            color: var(--text-dark);
            transition: all 0.3s ease;
        }

        .search-input {
            position: relative;
        }

        .search-input:focus,
        .filter-select:focus {
            outline: none;
            border-color: var(--primary-brown);
            box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
            background-color: var(--white);
        }

        .filter-select {
            cursor: pointer;
        }

        /* ========== TABLE SECTION ========== */
        .table-container {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table thead {
            background-color: var(--light-cream);
        }

        .orders-table th {
            padding: 20px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: var(--primary-brown);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--medium-gray);
        }

        .orders-table td {
            padding: 18px 16px;
            border-bottom: 1px solid var(--medium-gray);
            font-size: 14px;
            color: var(--text-dark);
        }

        .orders-table tbody tr {
            transition: all 0.3s ease;
        }

        .orders-table tbody tr:hover {
            background-color: var(--light-cream);
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

        .badge-pelanggan {
            background-color: rgba(212, 165, 116, 0.15);
            color: #8B5E27;
        }

        .badge-karyawan {
            background-color: rgba(212, 165, 116, 0.15);
            color: #6B4C2F;
        }

        .badge-pending {
            background-color: rgba(245, 158, 11, 0.15);
            color: #92400E;
        }

        .badge-diproses {
            background-color: rgba(59, 130, 246, 0.15);
            color: #1E40AF;
        }

        .badge-selesai {
            background-color: rgba(34, 197, 94, 0.15);
            color: #166534;
        }

        .badge-lunas {
            background-color: rgba(34, 197, 94, 0.15);
            color: #166534;
        }

        .badge-belum {
            background-color: rgba(239, 68, 68, 0.15);
            color: #B91C1C;
        }

        /* ========== ACTION BUTTONS ========== */
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 14px;
            background-color: var(--light-gray);
            color: var(--dark-gray);
        }

        .btn-action:hover {
            transform: scale(1.1);
        }

        .btn-action.view:hover {
            background-color: var(--blue);
            color: white;
        }

        .btn-action.edit:hover {
            background-color: var(--yellow);
            color: white;
        }

        .btn-action.delete:hover {
            background-color: var(--red);
            color: white;
        }

        .btn-payment-confirm {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 14px;
            background-color: var(--green);
            color: white;
        }

        .btn-payment-confirm:hover {
            transform: scale(1.1);
            background-color: #16a34a;
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
            border-radius: 16px;
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
            padding: 28px 24px;
            border-bottom: 1px solid var(--medium-gray);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--light-cream);
        }

        .modal-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .btn-close {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background-color: var(--light-gray);
            color: var(--dark-gray);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 18px;
        }

        .btn-close:hover {
            background-color: var(--red);
            color: white;
        }

        .modal-close {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background-color: var(--light-gray);
            color: var(--dark-gray);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 18px;
        }

        .modal-close:hover {
            background-color: var(--red);
            color: white;
        }

        .modal-body {
            padding: 28px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .detail-item label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-item span {
            font-size: 16px;
            font-weight: 500;
            color: var(--primary-brown);
            padding: 8px 12px;
            background-color: var(--light-cream);
            border-radius: 8px;
        }

        /* ========== DETAIL MODAL STYLES ========== */
        .detail-modal-content {
            background-color: var(--white);
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            max-width: 800px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .detail-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 32px;
            border-bottom: 1px solid var(--medium-gray);
            background: linear-gradient(135deg, var(--cream), var(--light-cream));
            border-radius: 16px 16px 0 0;
        }

        .detail-modal-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-brown);
        }

        .detail-modal-close {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background-color: var(--light-gray);
            color: var(--dark-gray);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .detail-modal-close:hover {
            background-color: var(--red);
            color: white;
            transform: scale(1.1);
        }

        .detail-modal-body {
            padding: 32px;
        }

        .detail-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .detail-info-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .detail-info-item label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-info-item span {
            font-size: 16px;
            font-weight: 500;
            color: var(--primary-brown);
            padding: 12px 16px;
            background-color: var(--light-cream);
            border-radius: 8px;
        }

        .detail-products-section h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-brown);
            margin-bottom: 16px;
        }

        .detail-products-table {
            border: 1px solid var(--medium-gray);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .detail-table-header {
            display: grid;
            grid-template-columns: 3fr 1fr 1.5fr 1.5fr;
            background-color: var(--light-cream);
            padding: 16px 20px;
            font-weight: 600;
            color: var(--primary-brown);
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .detail-table-body {
            background-color: var(--white);
        }

        .detail-product-row {
            display: grid;
            grid-template-columns: 3fr 1fr 1.5fr 1.5fr;
            padding: 16px 20px;
            border-bottom: 1px solid var(--medium-gray);
            align-items: center;
        }

        .detail-product-row:last-child {
            border-bottom: none;
        }

        .detail-product-name {
            font-weight: 500;
            color: var(--text-dark);
        }

        .detail-product-qty,
        .detail-product-price,
        .detail-product-subtotal {
            text-align: center;
            font-weight: 500;
        }

        .detail-total-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 0;
            border-top: 2px solid var(--medium-gray);
            margin-top: 24px;
        }

        .detail-total-label {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .detail-total-amount {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-brown);
        }

        .detail-modal-footer {
            padding: 24px 32px;
            border-top: 1px solid var(--medium-gray);
            background-color: var(--light-cream);
            border-radius: 0 0 16px 16px;
            display: flex;
            justify-content: flex-end;
        }

        /* ========== FORM STYLES ========== */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            font-size: 14px;
            background-color: var(--white);
            color: var(--text-dark);
            transition: all 0.3s ease;
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--primary-brown);
            box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
        }

        .form-group-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .product-item {
            display: flex;
            gap: 12px;
            align-items: end;
            padding: 16px;
            background-color: var(--light-cream);
            border-radius: var(--border-radius);
            margin-bottom: 12px;
        }

        .product-item-input {
            flex: 1;
        }

        .btn-remove-product {
            background-color: var(--red);
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-remove-product:hover {
            background-color: #DC2626;
        }

        .btn-add-product {
            background-color: var(--light-cream);
            color: var(--primary-brown);
            border: 2px solid var(--primary-brown);
            padding: 10px 16px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-add-product:hover {
            background-color: var(--primary-brown);
            color: white;
        }

        .total-section {
            background-color: var(--light-cream);
            padding: 20px;
            border-radius: var(--border-radius);
            margin-top: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 2px solid var(--light-brown);
        }

        .total-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--primary-brown);
        }

        .total-amount {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-brown);
        }

        .modal-footer {
            padding: 20px 28px;
            border-top: 1px solid var(--medium-gray);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-secondary {
            background-color: var(--light-gray);
            color: var(--dark-gray);
            border: 1px solid var(--medium-gray);
            padding: 12px 24px;
            border-radius: var(--border-radius);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: var(--medium-gray);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--light-brown), var(--primary-brown));
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: var(--border-radius);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* ========== EMPTY STATE ========== */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--dark-gray);
        }

        .empty-state-icon {
            font-size: 48px;
            color: var(--light-brown);
            margin-bottom: 16px;
        }

        .empty-state-text {
            font-size: 16px;
            font-weight: 500;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1024px) {
            .page-container {
                padding: 16px;
            }

            .filter-section {
                flex-direction: column;
            }

            .filter-group {
                width: 100%;
            }

            .form-group-row {
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

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .page-title {
                font-size: 24px;
            }

            .orders-table {
                font-size: 12px;
            }

            .orders-table th,
            .orders-table td {
                padding: 12px 8px;
            }

            .action-buttons {
                flex-wrap: wrap;
            }

            .modal {
                width: 95%;
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
            background: var(--medium-gray);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--dark-gray);
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1>🍞 Three D Bakery</h1>
                <p>Management System</p>
            </div>
            <nav class="sidebar-menu">
                <div class="sidebar-menu-item">
                    <a href="/dashboard">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <a href="/pesanan" class="active">
                        <i class="fas fa-shopping-cart"></i>
                        Pesanan
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <a href="#" >
                        <i class="fas fa-users"></i>
                        Pelanggan
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <a href="#">
                        <i class="fas fa-user-tie"></i>
                        Karyawan
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <a href="#">
                        <i class="fas fa-box"></i>
                        Produk
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <a href="#">
                        <i class="fas fa-credit-card"></i>
                        Pembayaran
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <a href="#">
                        <i class="fas fa-chart-line"></i>
                        Laporan
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <a href="#">
                        <i class="fas fa-cog"></i>
                        Pengaturan
                    </a>
                </div>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="page-container">
                <!-- HEADER -->
                <div class="page-header">
                    <h1 class="page-title">Pesanan</h1>
                    <div class="page-header-actions">
                        <button class="btn-add" onclick="openAddModal()">
                            <i class="fas fa-plus"></i>
                            Tambah Pesanan
                        </button>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-logout">
                                <i class="fas fa-right-from-bracket"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

                <!-- FILTER & SEARCH -->
                <div class="filter-section">
                    <div class="filter-group" style="flex: 2;">
                        <input 
                            type="text" 
                            class="search-input" 
                            id="searchInput" 
                            placeholder="Cari pesanan..."
                            onkeyup="filterTable()"
                        >
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Status</label>
                        <select class="filter-select" id="statusFilter" onchange="filterTable()">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Tipe</label>
                        <select class="filter-select" id="typeFilter" onchange="filterTable()">
                            <option value="">Semua Tipe</option>
                            <option value="pelanggan">Pelanggan</option>
                            <option value="karyawan">Karyawan</option>
                        </select>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="table-container">
                    <div class="table-wrapper">
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
                            <tbody id="tableBody">
                                <!-- Data akan diisi oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH PESANAN -->
    <div class="modal-overlay" id="addOrderModal">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Tambah Pesanan</h2>
                <button class="btn-close" onclick="closeAddModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <form id="orderForm">
                    <div class="form-group-row">
                        <div class="form-group">
                            <label class="form-label">Tipe Pesanan</label>
                            <select class="form-select" id="orderType" required>
                                <option value="">Pilih Tipe</option>
                                <option value="pelanggan">Pelanggan</option>
                                <option value="karyawan">Karyawan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-input" id="customerName" placeholder="Masukkan nama" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Produk</label>
                        <div id="productsContainer">
                            <div class="product-item">
                                <div class="product-item-input" style="flex: 2;">
                                    <select class="form-select" onchange="updateTotal()">
                                        <option value="0">Pilih Produk</option>
                                        <option value="25000">Roti Tawar - Rp 25.000</option>
                                        <option value="15000">Croissant - Rp 15.000</option>
                                        <option value="12000">Donut - Rp 12.000</option>
                                        <option value="75000">Cake - Rp 75.000</option>
                                        <option value="8000">Bread Roll - Rp 8.000</option>
                                    </select>
                                </div>
                                <div class="product-item-input" style="flex: 1;">
                                    <input type="number" class="form-input" placeholder="Jumlah" value="1" min="1" onchange="updateTotal()">
                                </div>
                                <button type="button" class="btn-remove-product" onclick="removeProduct(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn-add-product" onclick="addProductRow()">
                            <i class="fas fa-plus"></i> Tambah Produk
                        </button>
                    </div>

                    <div class="total-section">
                        <span class="total-label">Total Pesanan:</span>
                        <span class="total-amount" id="totalDisplay">Rp 0</span>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeAddModal()">Batal</button>
                <button class="btn-primary" onclick="saveOrder()">Simpan Pesanan</button>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal-overlay" id="detailModal">
        <div class="detail-modal-content">
            <div class="detail-modal-header">
                <h2>Detail Pesanan</h2>
                <button class="detail-modal-close" onclick="closeDetailModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="detail-modal-body">
                <!-- Informasi Utama -->
                <div class="detail-info-grid">
                    <div class="detail-info-item">
                        <label>ID Pesanan</label>
                        <span id="detailOrderId"></span>
                    </div>
                    <div class="detail-info-item">
                        <label>Nama</label>
                        <span id="detailCustomerName"></span>
                    </div>
                    <div class="detail-info-item">
                        <label>Tipe</label>
                        <span id="detailOrderType"></span>
                    </div>
                    <div class="detail-info-item">
                        <label>Status</label>
                        <span id="detailStatusBadge"></span>
                    </div>
                    <div class="detail-info-item">
                        <label>Pembayaran</label>
                        <span id="detailPaymentBadge"></span>
                    </div>
                    <div class="detail-info-item">
                        <label>Tanggal</label>
                        <span id="detailDate"></span>
                    </div>
                </div>

                <!-- Tabel Produk -->
                <div class="detail-products-section">
                    <h3>Detail Produk</h3>
                    <div class="detail-products-table">
                        <div class="detail-table-header">
                            <div class="detail-col-product">Nama Produk</div>
                            <div class="detail-col-qty">Jumlah</div>
                            <div class="detail-col-price">Harga</div>
                            <div class="detail-col-subtotal">Subtotal</div>
                        </div>
                        <div id="detailProductsBody" class="detail-table-body">
                            <!-- Products will be rendered here -->
                        </div>
                    </div>
                </div>

                <!-- Total -->
                <div class="detail-total-section">
                    <div class="detail-total-label">Total Bayar</div>
                    <div class="detail-total-amount" id="detailTotalAmount"></div>
                </div>
            </div>

            <div class="detail-modal-footer">
                <button class="btn-secondary" onclick="closeDetailModal()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal-overlay" id="editModal">
        <div class="modal">
            <div class="modal-header">
                <h3>Edit Pesanan</h3>
                <button class="modal-close" onclick="closeEditModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <form class="form-grid">
                    <input type="hidden" id="editOrderId">
                    <div class="form-group">
                        <label for="editCustomerName">Nama Pelanggan:</label>
                        <input type="text" id="editCustomerName" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="editOrderType">Tipe Pesanan:</label>
                        <select id="editOrderType" class="form-select" required>
                            <option value="pelanggan">Pelanggan</option>
                            <option value="karyawan">Karyawan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editStatus">Status:</label>
                        <select id="editStatus" class="form-select" required>
                            <option value="pending">Pending</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editPayment">Pembayaran:</label>
                        <select id="editPayment" class="form-select" required>
                            <option value="belum">Belum Lunas</option>
                            <option value="lunas">Lunas</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeEditModal()">Batal</button>
                <button class="btn-primary" onclick="saveEditOrder()">Simpan Perubahan</button>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Data dummy pesanan
        let orders = [
            { 
                id: 'ORD-001', 
                name: 'Siti Aminah', 
                type: 'pelanggan', 
                status: 'selesai', 
                payment: 'lunas', 
                tanggal: '2024-01-15',
                produk: [
                    { nama_produk: 'Roti Tawar', jumlah: 2, harga: 25000 },
                    { nama_produk: 'Croissant', jumlah: 1, harga: 15000 }
                ],
                total: 65000 
            },
            { 
                id: 'ORD-002', 
                name: 'Budi Raharjo', 
                type: 'karyawan', 
                status: 'pending', 
                payment: 'belum', 
                tanggal: '2024-01-16',
                produk: [
                    { nama_produk: 'Donut', jumlah: 3, harga: 12000 }
                ],
                total: 36000 
            },
            { 
                id: 'ORD-003', 
                name: 'Rina Putri', 
                type: 'pelanggan', 
                status: 'diproses', 
                payment: 'lunas', 
                tanggal: '2024-01-17',
                produk: [
                    { nama_produk: 'Cake', jumlah: 1, harga: 75000 },
                    { nama_produk: 'Bread Roll', jumlah: 2, harga: 8000 }
                ],
                total: 91000 
            },
            { 
                id: 'ORD-004', 
                name: 'Ahmad Suryanto', 
                type: 'karyawan', 
                status: 'selesai', 
                payment: 'lunas', 
                tanggal: '2024-01-18',
                produk: [
                    { nama_produk: 'Roti Tawar', jumlah: 5, harga: 25000 },
                    { nama_produk: 'Croissant', jumlah: 2, harga: 15000 }
                ],
                total: 155000 
            },
            { 
                id: 'ORD-005', 
                name: 'Maya Wijaya', 
                type: 'pelanggan', 
                status: 'pending', 
                payment: 'belum', 
                tanggal: '2024-01-19',
                produk: [
                    { nama_produk: 'Donut', jumlah: 4, harga: 12000 },
                    { nama_produk: 'Bread Roll', jumlah: 1, harga: 8000 }
                ],
                total: 56000 
            },
            { 
                id: 'ORD-006', 
                name: 'Hendra Gunawan', 
                type: 'karyawan', 
                status: 'diproses', 
                payment: 'lunas', 
                tanggal: '2024-01-20',
                produk: [
                    { nama_produk: 'Cake', jumlah: 2, harga: 75000 }
                ],
                total: 150000 
            },
            { 
                id: 'ORD-007', 
                name: 'Indira Salsabila', 
                type: 'pelanggan', 
                status: 'selesai', 
                payment: 'lunas', 
                tanggal: '2024-01-21',
                produk: [
                    { nama_produk: 'Roti Tawar', jumlah: 3, harga: 25000 },
                    { nama_produk: 'Croissant', jumlah: 1, harga: 15000 },
                    { nama_produk: 'Donut', jumlah: 2, harga: 12000 }
                ],
                total: 109000 
            },
        ];

        // Load orders from localStorage
        function loadOrders() {
            const savedOrders = localStorage.getItem('bakery_orders');
            if (savedOrders) {
                orders = JSON.parse(savedOrders);
            }
        }

        // Save orders to localStorage
        function saveOrders() {
            localStorage.setItem('bakery_orders', JSON.stringify(orders));
        }
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }

        // Get badge class
        function getStatusBadgeClass(status) {
            const statusMap = {
                'pending': 'badge-pending',
                'diproses': 'badge-diproses',
                'selesai': 'badge-selesai'
            };
            return statusMap[status] || 'badge-pending';
        }

        function getPaymentBadgeClass(payment) {
            return payment === 'lunas' ? 'badge-lunas' : 'badge-belum';
        }

        function getTypeBadgeClass(type) {
            return type === 'pelanggan' ? 'badge-pelanggan' : 'badge-karyawan';
        }

        // Render table
        function renderTable(dataToRender = orders) {
            const tableBody = document.getElementById('tableBody');
            
            if (dataToRender.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <p class="empty-state-text">Tidak ada pesanan yang ditemukan</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            tableBody.innerHTML = dataToRender.map(order => `
                <tr>
                    <td><strong>${order.id}</strong></td>
                    <td>${order.name}</td>
                    <td><span class="badge ${getTypeBadgeClass(order.type)}">${order.type === 'pelanggan' ? 'Pelanggan' : 'Karyawan'}</span></td>
                    <td><span class="badge ${getStatusBadgeClass(order.status)}">${capitalize(order.status)}</span></td>
                    <td><span class="badge ${getPaymentBadgeClass(order.payment)}">${order.payment === 'lunas' ? 'Lunas' : 'Belum Lunas'}</span></td>
                    <td><strong>${formatRupiah(order.total)}</strong></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action view" title="Detail" data-id="${order.id}" data-action="view">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-action edit" title="Edit" data-id="${order.id}" data-action="edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-action delete" title="Hapus" data-id="${order.id}" data-action="delete">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn-payment-confirm" title="Selesaikan Pesanan" data-id="${order.id}" data-action="complete" ${order.status === 'selesai' ? 'disabled' : ''}>
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Capitalize string
        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        // Filter table
        function filterTable() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const statusValue = document.getElementById('statusFilter').value;
            const typeValue = document.getElementById('typeFilter').value;

            const filtered = orders.filter(order => {
                const matchSearch = order.name.toLowerCase().includes(searchValue) || 
                                   order.id.toLowerCase().includes(searchValue);
                const matchStatus = !statusValue || order.status === statusValue;
                const matchType = !typeValue || order.type === typeValue;
                
                return matchSearch && matchStatus && matchType;
            });

            renderTable(filtered);
        }

        // Modal functions
        function openAddModal() {
            document.getElementById('addOrderModal').classList.add('active');
        }

        function closeAddModal() {
            document.getElementById('addOrderModal').classList.remove('active');
            document.getElementById('orderForm').reset();
            document.getElementById('productsContainer').innerHTML = `
                <div class="product-item">
                    <div class="product-item-input" style="flex: 2;">
                        <select class="form-select" onchange="updateTotal()">
                            <option value="0">Pilih Produk</option>
                            <option value="25000">Roti Tawar - Rp 25.000</option>
                            <option value="15000">Croissant - Rp 15.000</option>
                            <option value="12000">Donut - Rp 12.000</option>
                            <option value="75000">Cake - Rp 75.000</option>
                            <option value="8000">Bread Roll - Rp 8.000</option>
                        </select>
                    </div>
                    <div class="product-item-input" style="flex: 1;">
                        <input type="number" class="form-input" placeholder="Jumlah" value="1" min="1" onchange="updateTotal()">
                    </div>
                    <button type="button" class="btn-remove-product" onclick="removeProduct(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            updateTotal();
        }

        // Event delegation for action buttons
        document.addEventListener('click', function(e) {
            const button = e.target.closest('[data-action]');
            if (!button) return;

            const action = button.dataset.action;
            const orderId = button.dataset.id;

            switch (action) {
                case 'view':
                    showDetail(orderId);
                    break;
                case 'edit':
                    openEditModal(orderId);
                    break;
                case 'delete':
                    deleteOrder(orderId);
                    break;
                case 'complete':
                    confirmPayment(orderId);
                    break;
            }
        });

        // Close modal when clicking overlay
        document.getElementById('addOrderModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddModal();
            }
        });

        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });

        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        // Add product row
        function addProductRow() {
            const container = document.getElementById('productsContainer');
            const newRow = document.createElement('div');
            newRow.className = 'product-item';
            newRow.innerHTML = `
                <div class="product-item-input" style="flex: 2;">
                    <select class="form-select" onchange="updateTotal()">
                        <option value="0">Pilih Produk</option>
                        <option value="25000">Roti Tawar - Rp 25.000</option>
                        <option value="15000">Croissant - Rp 15.000</option>
                        <option value="12000">Donut - Rp 12.000</option>
                        <option value="75000">Cake - Rp 75.000</option>
                        <option value="8000">Bread Roll - Rp 8.000</option>
                    </select>
                </div>
                <div class="product-item-input" style="flex: 1;">
                    <input type="number" class="form-input" placeholder="Jumlah" value="1" min="1" onchange="updateTotal()">
                </div>
                <button type="button" class="btn-remove-product" onclick="removeProduct(this)">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            container.appendChild(newRow);
            updateTotal();
        }

        // Remove product row
        function removeProduct(button) {
            button.closest('.product-item').remove();
            updateTotal();
        }

        // Update total
        function updateTotal() {
            const products = document.querySelectorAll('.product-item');
            let total = 0;

            products.forEach(item => {
                const select = item.querySelector('select');
                const input = item.querySelector('input');
                const price = parseInt(select.value) || 0;
                const quantity = parseInt(input.value) || 1;
                total += price * quantity;
            });

            document.getElementById('totalDisplay').textContent = formatRupiah(total);
        }

        // Show detail modal
        function showDetail(orderId) {
            const order = orders.find(o => o.id === orderId);
            if (!order) return;

            // Fill basic information
            document.getElementById('detailOrderId').textContent = order.id;
            document.getElementById('detailCustomerName').textContent = order.name;
            document.getElementById('detailOrderType').textContent = order.type === 'pelanggan' ? 'Pelanggan' : 'Karyawan';
            document.getElementById('detailDate').textContent = formatDate(order.tanggal);

            // Status badge
            const statusBadge = document.getElementById('detailStatusBadge');
            statusBadge.className = `badge ${getStatusBadgeClass(order.status)}`;
            statusBadge.textContent = capitalize(order.status);

            // Payment badge
            const paymentBadge = document.getElementById('detailPaymentBadge');
            paymentBadge.className = `badge ${getPaymentBadgeClass(order.payment)}`;
            paymentBadge.textContent = order.payment === 'lunas' ? 'Lunas' : 'Belum Lunas';

            // Render products table
            const productsBody = document.getElementById('detailProductsBody');
            productsBody.innerHTML = '';

            order.produk.forEach(product => {
                const subtotal = product.jumlah * product.harga;
                const productRow = document.createElement('div');
                productRow.className = 'detail-product-row';
                productRow.innerHTML = `
                    <div class="detail-product-name">${product.nama_produk}</div>
                    <div class="detail-product-qty">${product.jumlah}</div>
                    <div class="detail-product-price">${formatRupiah(product.harga)}</div>
                    <div class="detail-product-subtotal">${formatRupiah(subtotal)}</div>
                `;
                productsBody.appendChild(productRow);
            });

            // Set total amount
            document.getElementById('detailTotalAmount').textContent = formatRupiah(order.total);

            // Show modal
            document.getElementById('detailModal').classList.add('active');
        }

        // Format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        // Close detail modal
        function closeDetailModal() {
            document.getElementById('detailModal').classList.remove('active');
        }

        // Open edit modal
        function openEditModal(orderId) {
            const order = orders.find(o => o.id === orderId);
            if (!order) return;

            document.getElementById('editOrderId').value = order.id;
            document.getElementById('editCustomerName').value = order.name;
            document.getElementById('editOrderType').value = order.type;
            document.getElementById('editStatus').value = order.status;
            document.getElementById('editPayment').value = order.payment;

            document.getElementById('editModal').classList.add('active');
        }

        // Close edit modal
        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
        }

        // Save edit order
        function saveEditOrder() {
            const orderId = document.getElementById('editOrderId').value;
            const customerName = document.getElementById('editCustomerName').value;
            const orderType = document.getElementById('editOrderType').value;
            const status = document.getElementById('editStatus').value;
            const payment = document.getElementById('editPayment').value;

            if (!customerName) {
                alert('Nama pelanggan tidak boleh kosong');
                return;
            }

            const orderIndex = orders.findIndex(o => o.id === orderId);
            if (orderIndex === -1) return;

            orders[orderIndex].name = customerName;
            orders[orderIndex].type = orderType;
            orders[orderIndex].status = status;
            orders[orderIndex].payment = payment;
            saveOrders();

            alert('Pesanan berhasil diperbarui!');
            closeEditModal();
            renderTable();
            filterTable();
        }

        // Delete order
        function deleteOrder(orderId) {
            if (!confirm(`Apakah Anda yakin ingin menghapus pesanan ${orderId}?`)) {
                return;
            }

            const orderIndex = orders.findIndex(o => o.id === orderId);
            if (orderIndex === -1) return;

            orders.splice(orderIndex, 1);
            saveOrders();
            alert('Pesanan berhasil dihapus!');
            renderTable();
            filterTable();
        }

        // Confirm payment and complete order
        function confirmPayment(orderId) {
            if (!confirm(`Apakah Anda yakin ingin menyelesaikan pesanan ${orderId}?`)) {
                return;
            }

            const order = orders.find(o => o.id === orderId);
            if (!order) return;

            order.payment = 'lunas';
            order.status = 'selesai';
            saveOrders();
            alert('Pesanan berhasil diselesaikan!');
            renderTable();
            filterTable();
        }

        // Save order
        function saveOrder() {
            const orderType = document.getElementById('orderType').value;
            const customerName = document.getElementById('customerName').value;

            if (!orderType || !customerName) {
                alert('Silakan isi tipe dan nama pelanggan');
                return;
            }

            // Hitung total dari produk yang dipilih dan buat array produk
            const products = document.querySelectorAll('.product-item');
            let totalAmount = 0;
            const produkArray = [];

            products.forEach(item => {
                const select = item.querySelector('select');
                const input = item.querySelector('input');
                const productName = select.options[select.selectedIndex].text.split(' - ')[0];
                const price = parseInt(select.value) || 0;
                const quantity = parseInt(input.value) || 1;
                
                if (price > 0 && quantity > 0) {
                    totalAmount += price * quantity;
                    produkArray.push({
                        nama_produk: productName,
                        jumlah: quantity,
                        harga: price
                    });
                }
            });

            if (totalAmount === 0 || produkArray.length === 0) {
                alert('Silakan pilih produk terlebih dahulu');
                return;
            }

            // Generate ID pesanan baru
            const lastOrder = orders[orders.length - 1];
            const lastNumber = parseInt(lastOrder.id.split('-')[1]);
            const newId = `ORD-${String(lastNumber + 1).padStart(3, '0')}`;

            // Buat object pesanan baru dengan struktur lengkap
            const newOrder = {
                id: newId,
                name: customerName,
                type: orderType,
                status: 'pending',
                payment: 'belum',
                metode_pembayaran: 'Tunai',
                tanggal: new Date().toISOString().split('T')[0], // Format YYYY-MM-DD
                produk: produkArray,
                total: totalAmount
            };

            // Tambahkan ke array
            orders.push(newOrder);
            saveOrders();

            // Tampilkan success message
            alert(`Pesanan ${newId} berhasil disimpan!\n\nNama: ${customerName}\nTipe: ${capitalize(orderType)}\nTotal: ${formatRupiah(totalAmount)}`);

            // Reset dan tutup modal
            closeAddModal();
            renderTable();
            filterTable();
        }

        // Initialize on page load
        window.addEventListener('DOMContentLoaded', function() {
            loadOrders();
            renderTable();
        });
    </script>
</body>
</html>
