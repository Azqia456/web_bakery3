<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pesanan Offline - Three D Bakery</title>
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
            --border-radius-xl: 16px;
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
            opacity: 0.8;
            font-weight: 500;
        }

        .sidebar-menu {
            padding: 16px 0;
        }

        .sidebar-menu-item {
            margin: 4px 16px;
        }

        .sidebar-menu-item > a,
        .sidebar-menu-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: var(--transition);
            font-weight: 500;
            font-size: 14px;
            background: none;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: left;
        }

        .sidebar-menu-item > a:hover,
        .sidebar-menu-item > a.active,
        .sidebar-menu-toggle:hover,
        .sidebar-menu-toggle.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: var(--white);
        }

        .sidebar-menu-item > a.active {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .sidebar-menu-item i,
        .sidebar-menu-toggle i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
            font-size: 16px;
        }

        .sidebar-menu-item .toggle-arrow {
            font-size: 12px;
            transition: transform 0.3s ease;
            margin-left: auto;
        }

        .sidebar-menu-item .toggle-arrow.open {
            transform: rotate(180deg);
        }

        .sidebar-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background: rgba(0, 0, 0, 0.1);
            border-radius: var(--border-radius);
            margin: 0 8px;
        }

        .sidebar-submenu.open {
            max-height: 500px;
        }

        .sidebar-submenu-item {
            padding: 10px 16px 10px 48px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 13px;
            font-weight: 400;
            transition: var(--transition);
        }

        .sidebar-submenu-item:hover,
        .sidebar-submenu-item.active {
            color: var(--white);
            padding-left: 52px;
        }

        /* ========== MAIN CONTENT ========== */
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

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-brown), #D4A574);
            color: var(--white);
            padding: 10px 24px;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(139, 111, 71, 0.15);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #6B4F33, #c49557);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 111, 71, 0.25);
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

        /* Tabs */
        .tabs {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            border-bottom: 2px solid var(--medium-gray);
            background: var(--white);
            padding: 0;
            border-radius: 0;
        }

        .tab {
            padding: 12px 24px;
            background: none;
            border: none;
            color: var(--dark-gray);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            font-size: 14px;
        }

        .tab:hover {
            color: var(--primary-brown);
        }

        .tab.active {
            color: var(--primary-brown);
            border-bottom-color: var(--primary-brown);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
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

        tbody tr {
            transition: var(--transition);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .status-badge.lunas {
            background: rgba(34, 197, 94, 0.1);
            color: #22C55E;
        }

        .status-badge.menunggu_verifikasi {
            background: rgba(245, 158, 11, 0.1);
            color: #F59E0B;
        }

        .status-badge.belum_bayar {
            background: rgba(239, 68, 68, 0.1);
            color: #EF4444;
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

        .btn-icon.delete:hover {
            background: var(--red);
            box-shadow: 0 4px 8px rgba(239, 68, 68, 0.15);
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.hidden-group {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            margin-bottom: 0;
            pointer-events: none;
            transition: max-height 0.3s ease, opacity 0.3s ease, margin-bottom 0.3s ease;
        }

        .form-group.hidden-group.visible {
            max-height: 240px;
            opacity: 1;
            margin-bottom: 20px;
            pointer-events: auto;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-dark);
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            font-size: 14px;
            font-family: inherit;
            transition: var(--transition);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .form-control:hover {
            border-color: #D4A574;
            box-shadow: 0 2px 6px rgba(139, 111, 71, 0.08);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-brown);
            box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
        }

        .form-control.textarea {
            min-height: 96px;
            resize: vertical;
        }

        .form-error {
            margin-top: 6px;
            font-size: 12px;
            color: var(--red);
            display: none;
        }

        .form-error.show {
            display: block;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* Product List in Modal */
        .product-list {
            border-top: 1px solid var(--medium-gray);
            padding-top: 16px;
            margin-top: 16px;
        }

        .product-item {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            padding: 12px;
            background: linear-gradient(135deg, rgba(139, 111, 71, 0.03), rgba(212, 165, 116, 0.03));
            border-radius: var(--border-radius);
            align-items: flex-end;
            border: 1px solid rgba(139, 111, 71, 0.08);
        }

        .product-item-controls {
            flex: 1;
        }

        .product-item label {
            font-size: 12px;
            font-weight: 500;
            color: var(--dark-gray);
            display: block;
            margin-bottom: 4px;
        }

        .product-item input,
        .product-item select {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--medium-gray);
            border-radius: 6px;
            font-size: 13px;
            transition: var(--transition);
        }

        .product-item input:focus,
        .product-item select:focus {
            outline: none;
            border-color: var(--primary-brown);
            box-shadow: 0 0 0 2px rgba(139, 111, 71, 0.08);
        }

        .btn-delete-product {
            background: var(--red);
            color: var(--white);
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 1px 3px rgba(239, 68, 68, 0.1);
        }

        .btn-delete-product:hover {
            background: #d32f2f;
            transform: translateY(-2px);
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.2);
        }

        .btn-add-product {
            background: var(--primary-brown);
            color: var(--white);
            border: none;
            padding: 10px 16px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: var(--transition);
            width: 100%;
            margin-bottom: 16px;
            box-shadow: 0 2px 6px rgba(139, 111, 71, 0.12);
        }

        .btn-add-product:hover {
            background: #6B4F33;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(139, 111, 71, 0.2);
        }

        .total-section {
            background: linear-gradient(135deg, rgba(139, 111, 71, 0.05), rgba(212, 165, 116, 0.05));
            padding: 16px;
            border-radius: var(--border-radius);
            margin: 16px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            border: 1px solid rgba(139, 111, 71, 0.1);
            color: var(--text-dark);
        }

        .modal-footer {
            padding: 20px 24px;
            border-top: 1px solid var(--medium-gray);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            background: linear-gradient(135deg, rgba(139, 111, 71, 0.02), rgba(212, 165, 116, 0.02));
            flex-wrap: wrap;
        }

        .btn-save {
            background: linear-gradient(135deg, var(--primary-brown), #D4A574);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(139, 111, 71, 0.15);
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #6B4F33, #c49557);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 111, 71, 0.25);
        }

        .btn-save.loading {
            opacity: 0.7;
            pointer-events: none;
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

        .btn-verify {
            background: linear-gradient(135deg, var(--green), #16a34a);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(34, 197, 94, 0.15);
        }

        .btn-verify:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.25);
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            z-index: 3000;
            max-width: 320px;
        }

        .toast {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 12px 14px;
            border-left: 4px solid var(--primary-brown);
            display: flex;
            gap: 10px;
            align-items: flex-start;
            animation: toastSlide 0.3s ease;
        }

        .toast.success {
            border-left-color: var(--green);
        }

        .toast.error {
            border-left-color: var(--red);
        }

        .toast.info {
            border-left-color: var(--yellow);
        }

        .toast .toast-icon {
            font-size: 16px;
            margin-top: 2px;
        }

        .toast .toast-text {
            font-size: 13px;
            color: var(--text-dark);
        }

        @keyframes toastSlide {
            from {
                opacity: 0;
                transform: translateX(10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Section Divider */
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

        /* Radio/Checkbox styling */
        .radio-group,
        .checkbox-group {
            display: flex;
            gap: 16px;
            margin-top: 8px;
        }

        .radio-item,
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 400;
            cursor: pointer;
        }

        .radio-item input,
        .checkbox-item input {
            cursor: pointer;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .table-toolbar {
                flex-direction: column;
            }

            .search-box {
                min-width: auto;
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

        /* Autocomplete results */
        .autocomplete-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--white);
            border: 1px solid var(--medium-gray);
            border-top: none;
            border-radius: 0 0 var(--border-radius) var(--border-radius);
            max-height: 200px;
            overflow-y: auto;
            z-index: 1100;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .autocomplete-item {
            padding: 12px 16px;
            cursor: pointer;
            transition: var(--transition);
            border-bottom: 1px solid var(--light-gray);
            font-size: 14px;
        }

        .autocomplete-item:hover {
            background: var(--light-gray);
        }

        .autocomplete-item:last-child {
            border-bottom: none;
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

        .form-section-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 20px 0 16px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid rgba(139, 111, 71, 0.1);
        }

        .radio-group-inline {
            display: flex;
            gap: 24px;
            margin-top: 8px;
        }

        .autocomplete-wrapper {
            position: relative;
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
                    <a href="/dashboard" style="justify-content: flex-start; gap: 12px;">
                        <i class="fas fa-tachometer-alt"></i>
                        <span style="font-weight:700;">Dashboard</span>
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle" onclick="toggleSubmenu(this)" style="justify-content: flex-start; gap: 12px;">
                        <i class="fas fa-shopping-cart"></i>
                        <span style="font-weight:700;">Pesanan</span>
                        <i class="fas fa-chevron-down toggle-arrow"></i>
                    </button>
                    <div class="sidebar-submenu">
                        <a href="/pesanan-online" class="sidebar-submenu-item">Pesanan Online</a>
                        <a href="/pesanan-offline" class="sidebar-submenu-item active">Pesanan Offline</a>
                    </div>
                </div>
                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle" onclick="toggleSubmenu(this)" style="justify-content: flex-start; gap: 12px;">
                        <i class="fas fa-database"></i>
                        <span style="font-weight:700;">Data</span>
                        <i class="fas fa-chevron-down toggle-arrow"></i>
                    </button>
                    <div class="sidebar-submenu">
                        <a href="/data-karyawan" class="sidebar-submenu-item">Data Karyawan</a>
                        <a href="/data-pelanggan" class="sidebar-submenu-item">Data Pelanggan</a>
                    </div>
                </div>
                <div class="sidebar-menu-item">
                    <a href="/produk" style="justify-content: flex-start; gap: 12px;">
                        <i class="fas fa-box"></i>
                        <span style="font-weight:700;">Produk</span>
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle" onclick="toggleSubmenu(this)" style="justify-content: flex-start; gap: 12px;">
                        <i class="fas fa-credit-card"></i>
                        <span style="font-weight:700;">Pembayaran</span>
                        <i class="fas fa-chevron-down toggle-arrow"></i>
                    </button>
                    <div class="sidebar-submenu">
                        <a href="/stor-karyawan" class="sidebar-submenu-item">Stor Karyawan</a>
                        <a href="/riwayat-transaksi" class="sidebar-submenu-item">Riwayat Transaksi Pelanggan</a>
                    </div>
                </div>
                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle" onclick="toggleSubmenu(this)" style="justify-content: flex-start; gap: 12px;">
                        <i class="fas fa-chart-line"></i>
                        <span style="font-weight:700;">Laporan</span>
                        <i class="fas fa-chevron-down toggle-arrow"></i>
                    </button>
                    <div class="sidebar-submenu">
                        <a href="/laporan-penjualan" class="sidebar-submenu-item">Laporan Penjualan</a>
                        <a href="/laporan-pesanan-online" class="sidebar-submenu-item">Laporan Pesanan Online</a>
                        <a href="/laporan-pesanan-offline" class="sidebar-submenu-item">Laporan Pesanan Offline</a>
                        <a href="/laporan-pembayaran" class="sidebar-submenu-item">Laporan Pembayaran</a>
                        <a href="/laporan-setoran-karyawan" class="sidebar-submenu-item">Laporan Setoran Karyawan</a>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <h1 class="header-title">Pesanan Offline</h1>
                </div>
                <div class="header-right">
                    <button class="btn-primary" onclick="openAddModal()">
                        <i class="fas fa-plus"></i>
                        Tambah Pesanan
                    </button>
                </div>
            </header>

            <!-- Content -->
            <div class="content">
                <!-- Summary Stats -->
                <section class="stats-grid" id="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-icon blue">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-card-label">Total Pesanan</div>
                        <div class="stat-card-value" id="total-pesanan">0</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-icon green">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-card-label">Pesanan Lunas</div>
                        <div class="stat-card-value" id="pesanan-lunas">0</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-icon orange">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div class="stat-card-label">Menunggu Verifikasi</div>
                        <div class="stat-card-value" id="pesanan-verifikasi">0</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-icon purple">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="stat-card-label">Total Revenue</div>
                        <div class="stat-card-value" id="total-revenue">Rp 0</div>
                    </div>
                </section>

                <!-- Tabs -->
                <div class="tabs">
                    <button class="tab active" onclick="switchTab(this, 'karyawan')">
                        <i class="fas fa-users"></i> Pesanan Karyawan
                    </button>
                    <button class="tab" onclick="switchTab(this, 'pelanggan')">
                        <i class="fas fa-user"></i> Pesanan Pelanggan
                    </button>
                </div>

                <!-- Pesanan Karyawan Tab -->
                <div id="tab-karyawan" class="tab-content active">
                    <div class="table-section">
                        <div class="table-toolbar">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="searchKaryawan" placeholder="Cari nama karyawan, ID pesanan...">
                            </div>
                            <div class="filter-group">
                                <label style="font-size: 13px; font-weight: 500;">Filter Status:</label>
                                <select class="form-control" id="filterKaryawan" onchange="filterTable('karyawan')">
                                    <option value="">Semua Status</option>
                                    <option value="stor">Stor</option>
                                    <option value="belum_stor">Belum Stor</option>
                                </select>
                            </div>
                        </div>
                        <table id="tableKaryawan">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Nama Karyawan</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bodyKaryawan">
                                <tr>
                                    <td colspan="5" style="text-align: center; color: var(--dark-gray);">
                                        <i class="fas fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                                        Belum ada pesanan karyawan
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pesanan Pelanggan Tab -->
                <div id="tab-pelanggan" class="tab-content">
                    <div class="table-section">
                        <div class="table-toolbar">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="searchPelanggan" placeholder="Cari nama pelanggan, ID pesanan...">
                            </div>
                            <div style="display: flex; gap: 12px; align-items: center;">
                                <label style="font-size: 13px; font-weight: 500;">Filter Status:</label>
                                <select class="form-control" id="filterPelanggan" onchange="filterTable('pelanggan')" style="max-width: 200px; padding: 8px 12px;">
                                    <option value="">Semua Status</option>
                                    <option value="diproses">Diproses</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <table id="tablePelanggan">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>No HP</th>
                                    <th>Metode Pengambilan</th>
                                    <th>Total Bayar</th>
                                    <th>Status Pesanan</th>
                                    <th>Tanggal</th>
                                    <th style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bodyPelanggan">
                                <tr>
                                    <td colspan="8" style="text-align: center; color: var(--dark-gray); padding: 40px;">
                                        <i class="fas fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                                        Belum ada pesanan pelanggan
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Pesanan -->
    <div id="modalAddPesanan" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitleAdd">Tambah Pesanan</h3>
                <button class="modal-close" onclick="closeModal('modalAddPesanan')">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Tipe Pesanan <span style="color: var(--red);">*</span></label>
                    <div style="display: flex; gap: 16px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-weight: 400; cursor: pointer;">
                            <input type="radio" name="tipePesanan" value="karyawan" onchange="changePesananType()" checked>
                            Karyawan
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; font-weight: 400; cursor: pointer;">
                            <input type="radio" name="tipePesanan" value="pelanggan" onchange="changePesananType()">
                            Pelanggan
                        </label>
                    </div>
                </div>

                <!-- Tipe Pesanan: Karyawan -->
                <div id="formKaryawan">
                    <div class="form-group">
                        <label class="form-label">Nama Karyawan <span style="color: var(--red);">*</span></label>
                        <input type="text" class="form-control" id="namaKaryawan" placeholder="Masukkan nama karyawan">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Pickup <span style="color: var(--red);">*</span></label>
                        <input type="date" class="form-control" id="tanggalPickupKaryawan">
                    </div>
                </div>

                <!-- Tipe Pesanan: Pelanggan -->
                <div id="formPelanggan" style="display: none;">
                    <div class="form-group">
                        <label class="form-label">Nama Pelanggan <span style="color: var(--red);">*</span></label>
                        <input type="text" class="form-control" id="namaPelanggan" placeholder="Masukkan nama pelanggan">
                        <div class="form-error" id="errorNamaPelanggan"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">No HP <span style="color: var(--red);">*</span></label>
                        <input type="tel" class="form-control" id="noHpPelanggan" placeholder="08xxxxxxxxxx" inputmode="numeric">
                        <div class="form-error" id="errorNoHpPelanggan"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Metode Pengambilan <span style="color: var(--red);">*</span></label>
                        <div style="display: flex; gap: 16px;">
                            <label style="display: flex; align-items: center; gap: 8px; font-weight: 400; cursor: pointer;">
                                <input type="radio" name="metodeMetode" value="delivery" onchange="changeMetode()">
                                Delivery
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; font-weight: 400; cursor: pointer;">
                                <input type="radio" name="metodeMetode" value="pickup" onchange="changeMetode()" checked>
                                Pickup
                            </label>
                        </div>
                    </div>
                    <div class="form-group" id="alamatDeliveryGroup" style="display: none;">
                        <label class="form-label">Alamat Lengkap <span style="color: var(--red);">*</span></label>
                        <textarea class="form-control textarea" id="alamatDelivery" placeholder="Masukkan alamat lengkap pelanggan"></textarea>
                        <div class="form-error" id="errorAlamatPelanggan"></div>
                    </div>
                    <div class="form-group" id="tanggalDeliveryGroup" style="display: none;">
                        <label class="form-label">Tanggal Delivery <span style="color: var(--red);">*</span></label>
                        <input type="date" class="form-control" id="tanggalDelivery">
                    </div>
                    <div class="form-group" id="tanggalPickupGroup">
                        <label class="form-label">Tanggal Pickup <span style="color: var(--red);">*</span></label>
                        <input type="date" class="form-control" id="tanggalPickupPelanggan">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Metode Pembayaran <span style="color: var(--red);">*</span></label>
                        <div style="display: flex; gap: 16px;">
                            <label style="display: flex; align-items: center; gap: 8px; font-weight: 400; cursor: pointer;">
                                <input type="radio" name="metodePayment" value="cash" onchange="changePaymentMethod()" checked>
                                Cash
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; font-weight: 400; cursor: pointer;">
                                <input type="radio" name="metodePayment" value="transfer" onchange="changePaymentMethod()">
                                Transfer
                            </label>
                        </div>
                    </div>
                    <div class="form-group" id="buktiBayarGroup" style="display: none;">
                        <label class="form-label">Upload Bukti Transfer <span style="color: var(--red);">*</span></label>
                        <input type="file" class="form-control" id="buktiBayar" accept=".jpg,.jpeg,.png,.pdf">
                        <div class="form-error" id="errorBuktiBayar"></div>
                    </div>
                </div>

                <!-- Produk Section -->
                <div class="form-group">
                    <label class="form-label">Produk <span style="color: var(--red);">*</span></label>
                    <button type="button" class="btn-add-product" onclick="addProductRow()">
                        <i class="fas fa-plus"></i> Tambah Produk
                    </button>
                    <div id="productList" class="product-list">
                    </div>
                </div>

                <!-- Total Section -->
                <div class="total-section">
                    <span>Total Pesanan:</span>
                    <span id="totalPesanan">Rp 0</span>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel" onclick="closeModal('modalAddPesanan')">Batal</button>
                <button class="btn-save" id="btnSavePesanan" onclick="savePesanan()">
                    <span class="btn-spinner"></span>
                    <span class="btn-text">Simpan</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pesanan -->
    <div id="modalDetail" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Detail Pesanan</h3>
                <button class="modal-close" onclick="closeModal('modalDetail')">×</button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Content will be populated by JavaScript -->
            </div>
            <div class="modal-footer" id="detailFooter">
                <button class="btn-cancel" onclick="closeModal('modalDetail')">Tutup</button>
            </div>
        </div>
    </div>

    <div class="toast-container" id="toastContainer"></div>

    <script>
        // Data structure untuk karyawan dan pelanggan
        let pesananData = {
            karyawan: [],
            pelanggan: []
        };
        let currentTab = 'karyawan';
        let productCount = 0;

        // Inisialisasi
        document.addEventListener('DOMContentLoaded', function() {
            renderTables();
            setupSearch();
            updateStats();
        });

        // Render Tables
        function renderTables() {
            renderKaryawanTable();
            renderPelangganTable();
            updateStats();
        }

        function renderKaryawanTable() {
            const tbody = document.getElementById('bodyKaryawan');
            if (pesananData.karyawan.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" style="text-align: center; color: var(--dark-gray); padding: 40px;">
                    <i class="fas fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                    Belum ada pesanan karyawan
                </td></tr>`;
                return;
            }

            tbody.innerHTML = pesananData.karyawan.map(item => `
                <tr>
                    <td>${item.id}</td>
                    <td>${item.nama}</td>
                    <td><span class="status-badge ${item.status}">${item.status === 'stor' ? 'Stor' : 'Belum Stor'}</span></td>
                    <td>Rp ${(item.total).toLocaleString('id-ID')}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="showDetail('karyawan', ${pesananData.karyawan.indexOf(item)})" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="showEdit('karyawan', ${pesananData.karyawan.indexOf(item)})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon delete" onclick="deletePesanan('karyawan', ${pesananData.karyawan.indexOf(item)})" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn-icon" onclick="markComplete('karyawan', ${pesananData.karyawan.indexOf(item)})" title="Selesai">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function renderPelangganTable() {
            const tbody = document.getElementById('bodyPelanggan');
            if (pesananData.pelanggan.length === 0) {
                tbody.innerHTML = `<tr><td colspan="8" style="text-align: center; color: var(--dark-gray); padding: 40px;">
                    <i class="fas fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                    Belum ada pesanan pelanggan
                </td></tr>`;
                return;
            }

            tbody.innerHTML = pesananData.pelanggan.map((item, index) => `
                <tr data-status="${item.status || 'diproses'}">
                    <td>${item.id}</td>
                    <td>${item.nama}</td>
                    <td>${item.no_hp || '-'}</td>
                    <td>${item.metode_pengambilan === 'delivery' ? 'Delivery' : 'Pickup'}</td>
                    <td>Rp ${(item.total).toLocaleString('id-ID')}</td>
                    <td><span class="status-badge ${item.status === 'selesai' ? 'selesai' : 'diproses'}">${item.status === 'selesai' ? 'Selesai' : 'Diproses'}</span></td>
                    <td>${item.tanggal_pesan}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="showDetail('pelanggan', ${index})" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="showEdit('pelanggan', ${index})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon delete" onclick="deletePesanan('pelanggan', ${index})" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn-icon" onclick="markComplete('pelanggan', ${index})" title="Selesai">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Tab Switching
        function switchTab(button, tab) {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            button.classList.add('active');
            document.getElementById('tab-' + tab).classList.add('active');
            currentTab = tab;
        }

        // Modal Functions
        function openAddModal() {
            productCount = 0;
            document.getElementById('modalAddPesanan').classList.add('show');
            document.getElementById('productList').innerHTML = '';
            document.getElementById('totalPesanan').textContent = 'Rp 0';
            document.querySelector('input[name="tipePesanan"][value="karyawan"]').checked = true;
            document.querySelector('input[name="metodeMetode"][value="pickup"]').checked = true;
            document.querySelector('input[name="metodePayment"][value="cash"]').checked = true;
            document.getElementById('buktiBayar').value = '';
            changePesananType();
            changeMetode();
            changePaymentMethod();
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
        }

        function changePesananType() {
            const type = document.querySelector('input[name="tipePesanan"]:checked').value;
            if (type === 'karyawan') {
                document.getElementById('formKaryawan').style.display = 'block';
                document.getElementById('formPelanggan').style.display = 'none';
            } else {
                document.getElementById('formKaryawan').style.display = 'none';
                document.getElementById('formPelanggan').style.display = 'block';
                changeMetode();
            }
        }

        function changeMetode() {
            const metode = document.querySelector('input[name="metodeMetode"]:checked').value;
            const alamatGroup = document.getElementById('alamatDeliveryGroup');
            const tanggalDeliveryGroup = document.getElementById('tanggalDeliveryGroup');
            const tanggalPickupGroup = document.getElementById('tanggalPickupGroup');
            
            if (metode === 'delivery') {
                alamatGroup.style.display = 'block';
                tanggalDeliveryGroup.style.display = 'block';
                tanggalPickupGroup.style.display = 'none';
            } else {
                alamatGroup.style.display = 'none';
                tanggalDeliveryGroup.style.display = 'none';
                tanggalPickupGroup.style.display = 'block';
            }
        }

        function changePaymentMethod() {
            const method = document.querySelector('input[name="metodePayment"]:checked').value;
            const buktiBayarGroup = document.getElementById('buktiBayarGroup');
            
            if (method === 'transfer') {
                buktiBayarGroup.style.display = 'block';
            } else {
                buktiBayarGroup.style.display = 'none';
            }
        }

        function addProductRow() {
            productCount++;
            const productList = document.getElementById('productList');
            const productRow = document.createElement('div');
            productRow.className = 'product-item';
            productRow.id = 'product-' + productCount;
            productRow.innerHTML = `
                <div class="product-item-controls" style="flex: 1;">
                    <label>Pilih Produk</label>
                    <select class="form-control" onchange="updateTotal()">
                        <option value="">-- Pilih Produk --</option>
                        <option value="roti_tawar|30000">Roti Tawar - Rp 30.000</option>
                        <option value="donat_glaze|50000">Donat Glaze - Rp 50.000</option>
                        <option value="kue_tart|300000">Kue Tart - Rp 300.000</option>
                        <option value="roti_croissant|100000">Roti Croissant - Rp 100.000</option>
                    </select>
                </div>
                <div class="product-item-controls" style="flex: 0.5;">
                    <label>Jumlah</label>
                    <input type="number" min="1" value="1" class="form-control" onchange="updateTotal()">
                </div>
                <button type="button" class="btn-delete-product" onclick="deleteProductRow(${productCount})">Hapus</button>
            `;
            productList.appendChild(productRow);
        }

        function deleteProductRow(id) {
            const elem = document.getElementById('product-' + id);
            if (elem) {
                elem.remove();
                updateTotal();
            }
        }

        function updateTotal() {
            let total = 0;
            const products = document.querySelectorAll('.product-item');
            products.forEach(p => {
                const select = p.querySelector('select');
                const input = p.querySelector('input[type="number"]');
                if (select.value && input.value) {
                    const [name, price] = select.value.split('|');
                    total += parseInt(price) * parseInt(input.value);
                }
            });
            document.getElementById('totalPesanan').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        function savePesanan() {
            const type = document.querySelector('input[name="tipePesanan"]:checked').value;
            const newPesanan = {
                id: type === 'karyawan' ? 'K' + String(pesananData.karyawan.length + 1).padStart(3, '0') : 'P' + String(pesananData.pelanggan.length + 1).padStart(3, '0'),
                nama: type === 'karyawan' ? document.getElementById('namaKaryawan').value : document.getElementById('namaPelanggan').value,
                status: type === 'karyawan' ? 'belum_stor' : 'diproses',
                tanggal_pesan: new Date().toISOString().split('T')[0],
                total: parseInt(document.getElementById('totalPesanan').textContent.replace(/\D/g, '')) || 0,
                produk: []
            };

            if (type === 'karyawan') {
                newPesanan.tanggal_pickup = document.getElementById('tanggalPickupKaryawan').value;
                pesananData.karyawan.push(newPesanan);
            } else {
                const metode = document.querySelector('input[name="metodeMetode"]:checked').value;
                const metodePayment = document.querySelector('input[name="metodePayment"]:checked').value;
                
                newPesanan.no_hp = document.getElementById('noHpPelanggan').value;
                newPesanan.metode_pengambilan = metode;
                newPesanan.metode_pembayaran = metodePayment;
                newPesanan.pembayaran = 'belum_lunas';
                
                if (metode === 'delivery') {
                    newPesanan.alamat_delivery = document.getElementById('alamatDelivery').value;
                    newPesanan.tanggal_delivery = document.getElementById('tanggalDelivery').value;
                } else {
                    newPesanan.tanggal_pickup = document.getElementById('tanggalPickupPelanggan').value;
                }
                
                if (metodePayment === 'transfer') {
                    const buktiBayarFile = document.getElementById('buktiBayar').files[0];
                    newPesanan.bukti_transfer = buktiBayarFile ? buktiBayarFile.name : '';
                }
                
                pesananData.pelanggan.push(newPesanan);
            }

            renderTables();
            closeModal('modalAddPesanan');
            alert('Pesanan berhasil disimpan!');
        }

        function showDetail(type, index) {
            // ...implementasi detail modal sesuai kebutuhan...
        }

        function showEdit(type, index) {
            // ...implementasi edit modal sesuai kebutuhan...
        }

        function deletePesanan(type, index) {
            if (confirm('Apakah Anda yakin ingin menghapus pesanan ini?')) {
                if (type === 'karyawan') {
                    pesananData.karyawan.splice(index, 1);
                } else {
                    pesananData.pelanggan.splice(index, 1);
                }
                renderTables();
                alert('Pesanan berhasil dihapus!');
            }
        }

        function markComplete(type, index) {
            const pesanan = type === 'karyawan' ? pesananData.karyawan[index] : pesananData.pelanggan[index];
            if (type === 'karyawan') {
                pesanan.status = pesanan.status === 'stor' ? 'belum_stor' : 'stor';
            } else {
                pesanan.status = pesanan.status === 'selesai' ? 'diproses' : 'selesai';
            }
            renderTables();
        }

        // Search Functions
        function setupSearch() {
            document.getElementById('searchKaryawan').addEventListener('keyup', function() {
                filterTable('karyawan');
            });
            document.getElementById('searchPelanggan').addEventListener('keyup', function() {
                filterTable('pelanggan');
            });
        }

        function filterTable(type) {
            if (!type) type = 'pelanggan';
            const searchValue = type === 'karyawan' ? 
                document.getElementById('searchKaryawan').value.toLowerCase() : 
                document.getElementById('searchPelanggan').value.toLowerCase();
            const filterValue = type === 'karyawan' ? 
                document.getElementById('filterKaryawan').value : 
                document.getElementById('filterPelanggan').value;

            const tbody = type === 'karyawan' ? 
                document.getElementById('bodyKaryawan') : 
                document.getElementById('bodyPelanggan');
            const rows = tbody.getElementsByTagName('tr');

            let hasVisibleRows = false;

            for (let row of rows) {
                const text = row.textContent.toLowerCase();
                const status = row.getAttribute('data-status') || '';
                
                let show = text.includes(searchValue);
                if (filterValue) {
                    show = show && status === filterValue;
                }

                row.style.display = show ? '' : 'none';
                if (show) hasVisibleRows = true;
            }

            if (!hasVisibleRows && pesananData[type].length > 0) {
                tbody.innerHTML = `<tr><td colspan="${type === 'karyawan' ? 5 : 8}" style="text-align: center; color: var(--dark-gray); padding: 40px;">
                    <i class="fas fa-search" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                    Pesanan tidak ditemukan
                </td></tr>`;
            }
        }

        function toggleSubmenu(button) {
            const submenu = button.nextElementSibling;
            const arrow = button.querySelector('.toggle-arrow');
            
            submenu.classList.toggle('open');
            arrow.classList.toggle('open');
            button.classList.toggle('active');
        }

        // Update Stats
        function updateStats() {
            const allPesanan = [...pesananData.karyawan, ...pesananData.pelanggan];
            const totalPesanan = allPesanan.length;
            const pesananSelesai = allPesanan.filter(p => p.status === 'selesai' || p.status === 'stor').length;
            const pesananPending = allPesanan.filter(p => p.status === 'pending' || p.status === 'belum_stor').length;
            const totalRevenue = allPesanan.reduce((sum, p) => sum + p.total, 0);

            document.getElementById('total-pesanan').textContent = totalPesanan;
            document.getElementById('pesanan-lunas').textContent = pesananSelesai;
            document.getElementById('pesanan-verifikasi').textContent = pesananPending;
            document.getElementById('total-revenue').textContent = 'Rp ' + totalRevenue.toLocaleString('id-ID');
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('show');
            }
        });
    </script>
</body>
</html>
