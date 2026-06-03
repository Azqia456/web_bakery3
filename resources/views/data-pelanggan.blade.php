@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --primary-brown: #8B6F47;
        --light-brown: #D4A574;
        --cream: #F7F3E9;
        --white: #FFFFFF;
        --light-gray: #F8F9FA;
        --medium-gray: #E9ECEF;
        --dark-gray: #6C757D;
        --text-dark: #2D3748;
        --accent: #C69C6D;
        --accent-dark: #8B6F47;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 6px 16px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 16px 28px rgba(0, 0, 0, 0.12);
        --border-radius: 12px;
        --border-radius-xl: 16px;
        --transition: all 0.3s ease;
        --font-base: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: var(--font-base);
        font-size: 16px;
        background: var(--cream);
        color: var(--text-dark);
        line-height: 1.6;
    }

    button,
    input,
    select,
    textarea {
        font-family: inherit;
    }

    .min-h-screen > nav {
        display: none;
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
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 4px;
        letter-spacing: -0.02em;
    }

    .sidebar-header p {
        font-size: 13px;
        opacity: 0.85;
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
        font-weight: 600;
        font-size: 15px;
        background: none;
        border: none;
        cursor: pointer;
        width: 100%;
        text-align: left;
        letter-spacing: 0.3px;
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
        min-width: 20px;
        margin-right: 12px;
        text-align: center;
        font-size: 17px;
    }

    .sidebar-menu-item .toggle-arrow {
        font-size: 13px;
        transition: transform 0.3s ease;
        margin-left: auto;
        flex-shrink: 0;
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
        font-size: 14px;
        font-weight: 400;
        transition: var(--transition);
    }

    .sidebar-submenu-item:hover,
    .sidebar-submenu-item.active {
        color: var(--white);
        padding-left: 52px;
    }

    .main-content {
        flex: 1;
        margin-left: 280px;
        min-height: 100vh;
        background:
            radial-gradient(1200px 600px at 10% 0%, rgba(212, 165, 116, 0.18), transparent 50%),
            radial-gradient(900px 500px at 90% 10%, rgba(139, 111, 71, 0.12), transparent 45%),
            var(--cream);
    }

    .header {
        background: var(--white);
        border-bottom: 1px solid var(--medium-gray);
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        box-shadow: var(--shadow-sm);
        position: sticky;
        top: 0;
        z-index: 999;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-title {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: var(--text-dark);
        letter-spacing: -0.02em;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 12px;
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
        color: var(--white);
        border-radius: 50%;
        font-size: 11px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-menu {
        position: relative;
    }

    .profile-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-brown), #C8A25A);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
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
        font-size: 15px;
        font-weight: 600;
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
        padding: 28px 24px 40px;
    }

    .page-hero {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
        animation: fadeUp 0.5s ease;
    }

    .page-title h1 {
        font-size: 32px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .page-title p {
        margin-top: 8px;
        color: #8A7561;
        font-size: 22px;
        font-weight: 300;
    }

    .page-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-input {
        position: relative;
        min-width: 240px;
        flex: 1;
    }

    .search-input input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border: 1px solid var(--medium-gray);
        border-radius: 12px;
        background: var(--white);
        font-size: 15px;
        transition: var(--transition);
    }

    .search-input input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(198, 156, 109, 0.16);
    }

    .search-input i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--dark-gray);
        font-size: 15px;
    }

    .filter-select {
        position: relative;
    }

    .filter-select select {
        padding: 10px 36px 10px 36px;
        border: 1px solid var(--medium-gray);
        border-radius: 12px;
        background: var(--white);
        font-size: 15px;
        appearance: none;
        cursor: pointer;
        min-width: 140px;
    }

    .filter-select i {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: var(--dark-gray);
        font-size: 13px;
        pointer-events: none;
    }

    .filter-select .filter-icon {
        left: 12px;
    }

    .filter-select .select-arrow {
        right: 12px;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, var(--accent), var(--accent-dark));
        color: var(--white);
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .summary-card {
        background: var(--white);
        border-radius: var(--border-radius-xl);
        border: 1px solid rgba(198, 156, 109, 0.2);
        padding: 18px;
        display: flex;
        gap: 14px;
        align-items: center;
        box-shadow: var(--shadow-sm);
        animation: fadeUp 0.6s ease;
    }

    .summary-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .summary-icon.tan { background: rgba(198, 156, 109, 0.18); color: #8B6F47; }
    .summary-icon.green { background: rgba(34, 197, 94, 0.15); color: #22C55E; }
    .summary-icon.orange { background: rgba(249, 115, 22, 0.15); color: #F97316; }
    .summary-icon.blue { background: rgba(59, 130, 246, 0.15); color: #3B82F6; }

    .summary-meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .summary-title {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--dark-gray);
    }

    .summary-value {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .summary-subtext {
        font-size: 13px;
        color: #8A7561;
    }

    .table-card {
        background: var(--white);
        border-radius: var(--border-radius-xl);
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(198, 156, 109, 0.2);
        overflow: hidden;
        animation: fadeUp 0.7s ease;
    }

    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px;
        border-bottom: 1px solid var(--medium-gray);
        background: linear-gradient(180deg, #FFFDF9 0%, #FFFFFF 100%);
    }

    .table-title h2 {
        font-size: 23px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .table-title span {
        font-size: 17px;
        color: var(--dark-gray);
    }

    .btn-ghost {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 10px;
        border: 1px solid var(--medium-gray);
        background: var(--light-gray);
        color: var(--text-dark);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-ghost:hover {
        background: var(--medium-gray);
    }

    .table-wrap {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 720px;
    }

    th,
    td {
        padding: 14px 16px;
        text-align: left;
        font-size: 16px;
    }

    thead th {
        background: #FCFAF7;
        color: #806D5A;
        font-weight: 700;
        font-size: 17px;
        letter-spacing: 0.3px;
    }

    tbody tr {
        border-top: 1px solid var(--medium-gray);
        transition: var(--transition);
    }

    tbody tr:hover {
        background: #FBF8F2;
    }

    .table-date {
        display: block;
        font-weight: 600;
        color: var(--text-dark);
    }

    .table-time {
        display: block;
        font-size: 50x;
        color: var(--dark-gray);
        margin-top: 4px;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        border: 1px solid var(--medium-gray);
        background: var(--light-gray);
        color: #6B5F54;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
    }

    .action-btn:hover {
        background: var(--medium-gray);
        color: var(--text-dark);
    }

    .action-btn.danger {
        color: #EF4444;
        border-color: rgba(239, 68, 68, 0.2);
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(12px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 1024px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .main-content {
            margin-left: 0;
        }

        .page-hero {
            flex-direction: column;
        }

        .page-actions {
            width: 100%;
        }
    }

    /* Status Badge Styles */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-top: 4px;
    }

    .status-badge .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .status-online {
        background-color: rgba(34, 197, 94, 0.1);
        color: #22C55E;
    }

    .status-online .status-dot {
        background-color: #22C55E;
        animation: pulse-online 2s ease-in-out infinite;
    }

    .status-offline {
        background-color: rgba(198, 156, 109, 0.15);
        color: #8B6F47;
    }

    .status-offline .status-dot {
        background-color: #8B6F47;
    }

    @keyframes pulse-online {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .pelanggan-name {
        font-weight: 600;
        display: block;
    }

    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal {
        background: var(--white);
        border-radius: var(--border-radius-xl);
        box-shadow: var(--shadow-lg);
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        animation: slideUp 0.3s ease;
        z-index: 10000;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid var(--medium-gray);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: var(--dark-gray);
        transition: var(--transition);
    }

    .modal-close:hover {
        color: var(--text-dark);
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 16px 20px;
        border-top: 1px solid var(--medium-gray);
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 6px;
        color: var(--text-dark);
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--medium-gray);
        border-radius: var(--border-radius);
        font-family: inherit;
        font-size: 14px;
        transition: var(--transition);
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(198, 156, 109, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 80px;
    }

    .btn-cancel {
        padding: 10px 20px;
        border: 1px solid var(--medium-gray);
        background: var(--light-gray);
        color: var(--text-dark);
        border-radius: var(--border-radius);
        cursor: pointer;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-cancel:hover {
        background: var(--medium-gray);
    }

    .btn-submit {
        padding: 10px 20px;
        border: none;
        background: linear-gradient(135deg, var(--accent), var(--accent-dark));
        color: var(--white);
        border-radius: var(--border-radius);
        cursor: pointer;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Toast Notification */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10001;
        max-width: 350px;
    }

    .toast {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        padding: 16px;
        margin-bottom: 12px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
        animation: slideInRight 0.3s ease;
        border-left: 4px solid var(--accent);
    }

    .toast.success {
        border-left-color: #22C55E;
    }

    .toast.success .toast-icon {
        color: #22C55E;
    }

    .toast.error {
        border-left-color: #EF4444;
    }

    .toast.error .toast-icon {
        color: #EF4444;
    }

    .toast.info {
        border-left-color: #3B82F6;
    }

    .toast.info .toast-icon {
        color: #3B82F6;
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .toast-icon {
        font-size: 18px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .toast-message {
        font-size: 14px;
        color: var(--text-dark);
        line-height: 1.4;
    }

    /* Pagination */
    .pagination-info {
        padding: 16px 20px;
        text-align: center;
        font-size: 13px;
        color: var(--dark-gray);
        background: var(--light-gray);
        border-top: 1px solid var(--medium-gray);
    }

    .pagination {
        display: flex;
        gap: 8px;
        padding: 16px 20px;
        justify-content: center;
        background: var(--light-gray);
        border-top: 1px solid var(--medium-gray);
        flex-wrap: wrap;
    }

    .pagination a,
    .pagination button {
        padding: 8px 12px;
        border: 1px solid var(--medium-gray);
        background: var(--white);
        color: var(--text-dark);
        border-radius: 6px;
        cursor: pointer;
        transition: var(--transition);
        font-size: 13px;
        font-weight: 600;
    }

    .pagination a:hover,
    .pagination button:hover {
        background: var(--medium-gray);
    }

    .pagination .active {
        background: var(--accent);
        color: var(--white);
        border-color: var(--accent);
    }

    .pagination .disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .text-muted {
        color: var(--dark-gray);
    }

    /* Alamat Column Styling */
    .alamat-cell {
        display: inline-block;
        max-width: 250px;
        word-wrap: break-word;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
        white-space: normal;
        line-height: 1.4;
        font-size: 13px;
        color: var(--text-dark);
        cursor: help;
        position: relative;
    }

    /* Tooltip untuk alamat lengkap */
    .alamat-cell[title] {
        position: relative;
    }

    .alamat-cell[title]:hover::after {
        content: attr(title);
        position: absolute;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.9);
        color: var(--white);
        padding: 8px 12px;
        border-radius: 6px;
        white-space: normal;
        width: 220px;
        word-wrap: break-word;
        font-size: 12px;
        line-height: 1.4;
        z-index: 1000;
        font-weight: 400;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        animation: tooltipFadeIn 0.2s ease;
    }

    .alamat-cell[title]:hover::before {
        content: '';
        position: absolute;
        bottom: 120%;
        left: 50%;
        transform: translateX(-50%);
        border: 6px solid transparent;
        border-top-color: rgba(0, 0, 0, 0.9);
        z-index: 1000;
    }

    @keyframes tooltipFadeIn {
        from {
            opacity: 0;
            transform: translateX(-50%) translateY(4px);
        }
        to {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
    }

    @media (max-width: 768px) {
        .modal {
            width: 95%;
            max-width: 100%;
        }

        .toast-container {
            max-width: calc(100% - 20px);
            left: 10px;
            right: 10px;
        }

        .pagination {
            flex-direction: column;
            gap: 4px;
        }

        /* Responsive Alamat Column */
        .alamat-cell {
            max-width: 150px;
            font-size: 12px;
        }

        .alamat-cell[title]:hover::after {
            width: 180px;
            font-size: 11px;
            bottom: auto;
            top: 125%;
        }

        .alamat-cell[title]:hover::before {
            bottom: auto;
            top: 120%;
            border-top-color: transparent;
            border-bottom-color: rgba(0, 0, 0, 0.9);
        }

        table {
            font-size: 13px;
        }

        th, td {
            padding: 10px 6px;
        }
    }

    @media (max-width: 768px) {
        .header {
            padding: 12px 16px;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .header-right {
            width: 100%;
            justify-content: flex-end;
        }

        .header-title {
            font-size: 20px;
        }

        .dashboard-content {
            padding: 20px 16px 32px;
        }

        .page-title h1 {
            font-size: 40px;
        }
    }

    @media (min-width: 768px) {
        .page-title h1 {
            font-size: 40px;
        }

        .page-title p {
            font-size: px;
        }
    }
</style>

<div class="dashboard">
    <aside class="sidebar">
        <div class="sidebar-header">
            <h1>🍞 Three D Bakery</h1>
            <p>Management System</p>
        </div>
        <nav class="sidebar-menu">
            <div class="sidebar-menu-item">
                <a href="/dashboard" class="{{ Request::is('dashboard') ? 'active' : '' }}" style="justify-content: flex-start; gap: 12px;">
                    <i class="fas fa-tachometer-alt"></i>
                    <span style="font-weight:700;">Dashboard</span>
                </a>
            </div>

            <div class="sidebar-menu-item">
                <button class="sidebar-menu-toggle {{ Request::is('pesanan*') ? 'active' : '' }}" onclick="toggleSubmenu(this)" style="justify-content: flex-start; gap: 12px;">
                    <i class="fas fa-shopping-cart"></i>
                    <span style="font-weight:700;">Pesanan</span>
                    <i class="fas fa-chevron-down toggle-arrow {{ Request::is('pesanan*') ? 'open' : '' }}"></i>
                </button>
                <div class="sidebar-submenu {{ Request::is('pesanan*') ? 'open' : '' }}">
                    <a href="/pesanan-online" class="sidebar-submenu-item {{ Request::is('pesanan-online') ? 'active' : '' }}">Pesanan Online</a>
                    <a href="/pesanan-offline" class="sidebar-submenu-item {{ Request::is('pesanan-offline') ? 'active' : '' }}">Pesanan Offline</a>
                </div>
            </div>

            <div class="sidebar-menu-item">
                <button class="sidebar-menu-toggle {{ Request::is('data*') ? 'active' : '' }}" onclick="toggleSubmenu(this)" style="justify-content: flex-start; gap: 12px;">
                    <i class="fas fa-database"></i>
                    <span style="font-weight:700;">Data</span>
                    <i class="fas fa-chevron-down toggle-arrow {{ Request::is('data*') ? 'open' : '' }}"></i>
                </button>
                <div class="sidebar-submenu {{ Request::is('data*') ? 'open' : '' }}">
                    <a href="/data-karyawan" class="sidebar-submenu-item {{ Request::is('data-karyawan') ? 'active' : '' }}">Data Karyawan</a>
                    <a href="/data-pelanggan" class="sidebar-submenu-item {{ Request::is('data-pelanggan') ? 'active' : '' }}">Data Pelanggan</a>
                </div>
            </div>

            <div class="sidebar-menu-item">
                <a href="/produk" class="{{ Request::is('produk') ? 'active' : '' }}" style="justify-content: flex-start; gap: 12px;">
                    <i class="fas fa-box"></i>
                    <span style="font-weight:700;">Produk</span>
                </a>
            </div>

            <div class="sidebar-menu-item">
                <a href="/riwayat-transaksi" class="{{ Request::is('riwayat-transaksi') ? 'active' : '' }}" style="justify-content: flex-start; gap: 12px;">
                    <i class="fas fa-credit-card"></i>
                    <span style="font-weight:700;">Riwayat Transaksi</span>
                </a>
            </div>

            <div class="sidebar-menu-item">
                <button class="sidebar-menu-toggle {{ Request::is('laporan*') ? 'active' : '' }}" onclick="toggleSubmenu(this)" style="justify-content: flex-start; gap: 12px;">
                    <i class="fas fa-chart-line"></i>
                    <span style="font-weight:700;">Laporan</span>
                    <i class="fas fa-chevron-down toggle-arrow {{ Request::is('laporan*') ? 'open' : '' }}"></i>
                </button>
                <div class="sidebar-submenu {{ Request::is('laporan*') ? 'open' : '' }}">
                    <a href="/laporan-penjualan" class="sidebar-submenu-item {{ Request::is('laporan-penjualan') ? 'active' : '' }}">Laporan Penjualan</a>
                    <a href="/laporan-pesanan-online" class="sidebar-submenu-item {{ Request::is('laporan-pesanan-online') ? 'active' : '' }}">Laporan Pesanan Online</a>
                    <a href="/laporan-pesanan-offline" class="sidebar-submenu-item {{ Request::is('laporan-pesanan-offline') ? 'active' : '' }}">Laporan Pesanan Offline</a>
                    <a href="/laporan-pembayaran" class="sidebar-submenu-item {{ Request::is('laporan-pembayaran') ? 'active' : '' }}">Laporan Pembayaran</a>
                    <a href="/laporan-setoran-karyawan" class="sidebar-submenu-item {{ Request::is('laporan-setoran-karyawan') ? 'active' : '' }}">Laporan Setoran Karyawan</a>
                </div>
            </div>
        </nav>
    </aside>

    <div class="main-content">
        <header class="header">
            <div class="header-left">
                <h1 class="header-title">Data Pelanggan</h1>
            </div>
            <div class="header-right">
                <button class="notification-btn" type="button" aria-label="Notifikasi">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">0</span>
                </button>
                <div class="profile-menu">
                    @php
                        $userName = Auth::user()->name ?? 'Admin';
                        $parts = preg_split('/\s+/', trim($userName));
                        $initials = '';
                        foreach ($parts as $part) {
                            if ($part !== '') {
                                $initials .= strtoupper(substr($part, 0, 1));
                            }
                        }
                        $initials = substr($initials, 0, 2);
                    @endphp
                    <button type="button" class="profile-btn" id="profileMenuButton" aria-haspopup="true" aria-expanded="false" title="Akun">
                        <div class="profile-avatar">{{ $initials }}</div>
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

        <main class="dashboard-content">
            <section class="page-hero">
                <div class="page-title">
                    <p>Kelola seluruh data pelanggan Three D Bakery</p>
                </div>
                <div class="page-actions">
                    <div class="search-input">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Cari nama atau nomor HP..." value="{{ $search ?? '' }}">
                    </div>
                    <div class="filter-select">
                        <i class="fas fa-filter filter-icon"></i>
                        <select id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="Online" {{ $status === 'Online' ? 'selected' : '' }}>Online</option>
                            <option value="Offline" {{ $status === 'Offline' ? 'selected' : '' }}>Offline</option>
                        </select>
                        <i class="fas fa-chevron-down select-arrow"></i>
                    </div>
                    <button class="btn-primary" type="button" id="btnTambahPelanggan">
                        <i class="fas fa-plus"></i>
                        Tambah Pelanggan
                    </button>
                </div>
            </section>

            <section class="summary-grid">
                <div class="summary-card">
                    <div class="summary-icon tan">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="summary-meta">
                        <span class="summary-title">Total Pelanggan</span>
                        <span class="summary-value" id="totalPelanggan">{{ $stats['total_pelanggan'] ?? 0 }}</span>
                        <span class="summary-subtext">Semua pelanggan terdaftar</span>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon green">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="summary-meta">
                        <span class="summary-title">Pelanggan Online</span>
                        <span class="summary-value" id="pelangganOnline">{{ $stats['pelanggan_online'] ?? 0 }}</span>
                        <span class="summary-subtext">Dari website dan aplikasi</span>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon orange">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="summary-meta">
                        <span class="summary-title">Pelanggan Offline</span>
                        <span class="summary-value" id="pelangganOffline">{{ $stats['pelanggan_offline'] ?? 0 }}</span>
                        <span class="summary-subtext">Dari toko langsung</span>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon blue">
                        <i class="fas fa-bag-shopping"></i>
                    </div>
                    <div class="summary-meta">
                        <span class="summary-title">Total Pesanan Hari Ini</span>
                        <span class="summary-value" id="totalPesananHariIni">{{ $stats['total_pesanan_hari_ini'] ?? 0 }}</span>
                        <span class="summary-subtext">Semua transaksi hari ini</span>
                    </div>
                </div>
            </section>

            <section class="table-card">
                <div class="table-header">
                    <div class="table-title">
                        <h2>Daftar Pelanggan</h2>
                        <span>Daftar pelanggan terbaru Three D Bakery</span>
                    </div>
                    <button class="btn-ghost" type="button">
                        <i class="fas fa-file-export"></i>
                        Export
                    </button>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>No. HP</th>
                                <th>Alamat</th>
                                <th>Total Pesanan</th>
                                <th>Terakhir Pesan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="pelanggantTableBody">
                            @forelse($pelanggans as $key => $pelanggan)
                                @php
                                    $nomor = ($pelanggans->currentPage() - 1) * $pelanggans->perPage() + $key + 1;
                                    $tanggalAkhir = $pelanggan->terakhir_pesan ? \Carbon\Carbon::parse($pelanggan->terakhir_pesan) : null;
                                @endphp
                                <tr data-id="{{ $pelanggan->id_pelanggan }}">
                                    <td>{{ $nomor }}</td>
                                    <td>
                                        <span class="pelanggan-name">{{ $pelanggan->nama }}</span>
                                        <span class="status-badge status-{{ strtolower($pelanggan->status) }}">
                                            <span class="status-dot"></span>
                                            {{ $pelanggan->status }}
                                        </span>
                                    </td>
                                    <td>{{ $pelanggan->no_tlp }}</td>
                                    <td>
                                        <span class="alamat-cell" title="{{ $pelanggan->alamat }}">
                                            {{ Str::limit($pelanggan->alamat, 40, '...') }}
                                        </span>
                                    </td>
                                    <td>{{ $pelanggan->total_pesanan ?? 0 }} Pesanan</td>
                                    <td>
                                        @if($tanggalAkhir)
                                            <span class="table-date">{{ $tanggalAkhir->locale('id')->format('d M Y') }}</span>
                                            <span class="table-time">{{ $tanggalAkhir->format('H:i') }} WIB</span>
                                        @else
                                            <span class="table-date text-muted">Belum ada pesanan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-view" type="button" aria-label="Lihat" data-id="{{ $pelanggan->id_pelanggan }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="action-btn btn-edit" type="button" aria-label="Edit" data-id="{{ $pelanggan->id_pelanggan }}">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="action-btn danger btn-delete" type="button" aria-label="Hapus" data-id="{{ $pelanggan->id_pelanggan }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 40px; color: #999;">
                                        <i class="fas fa-inbox" style="font-size: 24px; margin-bottom: 12px; display: block;"></i>
                                        Tidak ada pelanggan ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination Info -->
                @if($pelanggans->total() > 0)
                <div class="pagination-info">
                    Menampilkan {{ $pelanggans->firstItem() }} sampai {{ $pelanggans->lastItem() }} dari {{ $pelanggans->total() }} pelanggan
                </div>
                <!-- Pagination Links -->
                <div class="pagination">
                    @if ($pelanggans->onFirstPage())
                        <span class="disabled">&laquo; Sebelumnya</span>
                    @else
                        <a href="{{ $pelanggans->previousPageUrl() }}">&laquo; Sebelumnya</a>
                    @endif

                    @foreach ($pelanggans->getUrlRange(1, $pelanggans->lastPage()) as $page => $url)
                        @if ($page == $pelanggans->currentPage())
                            <button class="active">{{ $page }}</button>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($pelanggans->hasMorePages())
                        <a href="{{ $pelanggans->nextPageUrl() }}">Selanjutnya &raquo;</a>
                    @else
                        <span class="disabled">Selanjutnya &raquo;</span>
                    @endif
                </div>
                @endif
            </section>
        </main>
    </div>
</div>

<!-- Modal Add/Edit Pelanggan -->
<div class="modal-overlay" id="modalPelanggan">
    <div class="modal">
        <div class="modal-header">
            <h2 id="modalTitle">Tambah Pelanggan</h2>
            <button class="modal-close" type="button" onclick="closeModal('modalPelanggan')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="formPelanggan">
                @csrf
                <input type="hidden" id="pelangganId" name="pelanggan_id">
                
                <div class="form-group">
                    <label for="inputNama">Nama Pelanggan</label>
                    <input type="text" id="inputNama" name="nama" required>
                </div>

                <div class="form-group">
                    <label for="inputNoTlp">Nomor HP</label>
                    <input type="tel" id="inputNoTlp" name="no_tlp" placeholder="0812-1234-5678" required>
                </div>

                <div class="form-group">
                    <label for="inputEmail">Email (Opsional)</label>
                    <input type="email" id="inputEmail" name="email" placeholder="nama@example.com">
                </div>

                <div class="form-group">
                    <label for="inputAlamat">Alamat</label>
                    <textarea id="inputAlamat" name="alamat" required></textarea>
                </div>

                <div class="form-group">
                    <label for="inputStatus">Status</label>
                    <select id="inputStatus" name="status" required>
                        <option value="Online">Online (Website/Aplikasi)</option>
                        <option value="Offline">Offline (Toko Langsung)</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" type="button" onclick="closeModal('modalPelanggan')">Batal</button>
            <button class="btn-submit" type="button" onclick="submitFormPelanggan()">Simpan</button>
        </div>
    </div>
</div>

<!-- Modal View Detail Pelanggan -->
<div class="modal-overlay" id="modalDetail">
    <div class="modal">
        <div class="modal-header">
            <h2>Detail Pelanggan</h2>
            <button class="modal-close" type="button" onclick="closeModal('modalDetail')">&times;</button>
        </div>
        <div class="modal-body" id="modalDetailContent">
            <!-- Will be populated via AJAX -->
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" type="button" onclick="closeModal('modalDetail')">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Delete -->
<div class="modal-overlay" id="modalDelete">
    <div class="modal" style="max-width: 400px;">
        <div class="modal-header">
            <h2>Hapus Pelanggan</h2>
            <button class="modal-close" type="button" onclick="closeModal('modalDelete')">&times;</button>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus pelanggan <strong id="deletePelangganName"></strong>?</p>
            <p style="color: #EF4444; margin-top: 12px; font-size: 13px;">
                <i class="fas fa-exclamation-circle"></i> Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" type="button" onclick="closeModal('modalDelete')">Batal</button>
            <button class="btn-submit" type="button" onclick="confirmDelete()" style="background: linear-gradient(135deg, #EF4444, #DC2626);">Hapus</button>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<script>
    // BASE URLs
    const API_BASE_URL = '{{ url("/api") }}';

    // Modal Functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
    }

    function resetFormPelanggan() {
        document.getElementById('formPelanggan').reset();
        document.getElementById('pelangganId').value = '';
        document.getElementById('modalTitle').textContent = 'Tambah Pelanggan';
        document.getElementById('inputStatus').value = 'Online';
    }

    // Toast Notification
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        let icon = '';
        if (type === 'success') icon = '<i class="fas fa-check-circle toast-icon"></i>';
        else if (type === 'error') icon = '<i class="fas fa-exclamation-circle toast-icon"></i>';
        else if (type === 'info') icon = '<i class="fas fa-info-circle toast-icon"></i>';

        toast.innerHTML = `${icon}<div class="toast-message">${message}</div>`;
        
        document.getElementById('toastContainer').appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    // Search and Filter
    document.getElementById('searchInput').addEventListener('keyup', debounce(function() {
        const search = this.value;
        const status = document.getElementById('statusFilter').value;
        loadPelanggans(search, status, 1);
    }, 500));

    document.getElementById('statusFilter').addEventListener('change', function() {
        const search = document.getElementById('searchInput').value;
        loadPelanggans(search, this.value, 1);
    });

    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Load Pelanggans with AJAX
    function loadPelanggans(search = '', status = '', page = 1) {
        const params = new URLSearchParams();
        if (search) params.append('search', search);
        if (status) params.append('status', status);
        params.append('page', page);
        params.append('per_page', 10);

        fetch(`{{ route('data-pelanggan') }}?${params.toString()}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update stats
            document.getElementById('totalPelanggan').textContent = data.stats.total_pelanggan;
            document.getElementById('pelangganOnline').textContent = data.stats.pelanggan_online;
            document.getElementById('pelangganOffline').textContent = data.stats.pelanggan_offline;
            document.getElementById('totalPesananHariIni').textContent = data.stats.total_pesanan_hari_ini;

            // Reload table
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Gagal memuat data pelanggan', 'error');
        });
    }

    // Add/Edit Pelanggan
    document.getElementById('btnTambahPelanggan').addEventListener('click', function() {
        resetFormPelanggan();
        openModal('modalPelanggan');
    });

    function submitFormPelanggan() {
        const formData = new FormData(document.getElementById('formPelanggan'));
        const pelangganId = document.getElementById('pelangganId').value;
        const url = pelangganId ? `${API_BASE_URL}/pelanggans/${pelangganId}` : `${API_BASE_URL}/pelanggans`;
        const method = pelangganId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value || document.querySelector('input[name="csrf-token"]')?.value,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                closeModal('modalPelanggan');
                setTimeout(() => location.reload(), 500);
            } else {
                showToast(data.message || 'Terjadi kesalahan', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Gagal menyimpan data pelanggan', 'error');
        });
    }

    // View Detail
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-view')) {
            const pelangganId = e.target.closest('.btn-view').dataset.id;
            fetch(`${API_BASE_URL}/pelanggans/${pelangganId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const pelanggan = data.pelanggan;
                const pesanans = data.pesanans;
                let content = `
                    <div style="margin-bottom: 20px;">
                        <div class="form-group">
                            <label>Nama Pelanggan</label>
                            <p style="padding: 10px; background: var(--light-gray); border-radius: 6px;">${pelanggan.nama}</p>
                        </div>
                        <div class="form-group">
                            <label>Nomor HP</label>
                            <p style="padding: 10px; background: var(--light-gray); border-radius: 6px;">${pelanggan.no_tlp}</p>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <p style="padding: 10px; background: var(--light-gray); border-radius: 6px;">${pelanggan.email || '-'}</p>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <p style="padding: 10px; background: var(--light-gray); border-radius: 6px;">${pelanggan.alamat}</p>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <p style="padding: 10px; background: var(--light-gray); border-radius: 6px;">
                                <span class="status-badge status-${pelanggan.status.toLowerCase()}">
                                    <span class="status-dot"></span>
                                    ${pelanggan.status}
                                </span>
                            </p>
                        </div>
                        <div class="form-group">
                            <label>Total Pesanan</label>
                            <p style="padding: 10px; background: var(--light-gray); border-radius: 6px;">${pelanggan.total_pesanan || 0}</p>
                        </div>
                    </div>
                    <div style="margin-top: 20px; border-top: 1px solid var(--medium-gray); padding-top: 16px;">
                        <h3 style="margin-bottom: 12px; font-size: 14px; font-weight: 700;">Riwayat Pesanan</h3>
                        ${pesanans.length > 0 ? `
                            <div style="max-height: 300px; overflow-y: auto;">
                                ${pesanans.map(p => `
                                    <div style="padding: 10px; background: var(--light-gray); border-radius: 6px; margin-bottom: 8px; font-size: 13px;">
                                        <div><strong>#${p.id_pesanan}</strong> - ${new Date(p.tgl_pesan).toLocaleDateString('id-ID')}</div>
                                        <div style="color: var(--dark-gray); margin-top: 4px;">Rp. ${parseInt(p.total_bayar || 0).toLocaleString('id-ID')}</div>
                                    </div>
                                `).join('')}
                            </div>
                        ` : '<p style="color: var(--dark-gray); font-size: 13px;">Belum ada pesanan</p>'}
                    </div>
                `;
                document.getElementById('modalDetailContent').innerHTML = content;
                openModal('modalDetail');
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Gagal memuat detail pelanggan', 'error');
            });
        }
    });

    // Edit Pelanggan
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-edit')) {
            const pelangganId = e.target.closest('.btn-edit').dataset.id;
            fetch(`${API_BASE_URL}/pelanggans/${pelangganId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const pelanggan = data.pelanggan;
                document.getElementById('pelangganId').value = pelanggan.id_pelanggan;
                document.getElementById('inputNama').value = pelanggan.nama;
                document.getElementById('inputNoTlp').value = pelanggan.no_tlp;
                document.getElementById('inputEmail').value = pelanggan.email || '';
                document.getElementById('inputAlamat').value = pelanggan.alamat;
                document.getElementById('inputStatus').value = pelanggan.status;
                document.getElementById('modalTitle').textContent = 'Edit Pelanggan';
                openModal('modalPelanggan');
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Gagal memuat data pelanggan', 'error');
            });
        }
    });

    // Delete Pelanggan
    let deleteId = null;

    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-delete')) {
            deleteId = e.target.closest('.btn-delete').dataset.id;
            const row = e.target.closest('tr');
            const name = row.querySelector('.pelanggan-name').textContent;
            document.getElementById('deletePelangganName').textContent = name;
            openModal('modalDelete');
        }
    });

    function confirmDelete() {
        if (!deleteId) return;

        fetch(`${API_BASE_URL}/pelanggans/${deleteId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value || document.querySelector('input[name="csrf-token"]')?.value,
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                closeModal('modalDelete');
                setTimeout(() => location.reload(), 500);
            } else {
                showToast(data.message || 'Terjadi kesalahan', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Gagal menghapus pelanggan', 'error');
        });
    }

    // Close modal on overlay click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this.id);
            }
        });
    });

    // Auto-refresh stats every 30 seconds
    setInterval(function() {
        fetch(`${API_BASE_URL}/pelanggans-stats`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalPelanggan').textContent = data.total_pelanggan;
            document.getElementById('pelangganOnline').textContent = data.pelanggan_online;
            document.getElementById('pelangganOffline').textContent = data.pelanggan_offline;
            document.getElementById('totalPesananHariIni').textContent = data.total_pesanan_hari_ini;
        })
        .catch(error => console.error('Error:', error));
    }, 30000);

    // Profile Menu Functionality
    const profileMenuButton = document.getElementById('profileMenuButton');
    const profileDropdown = document.getElementById('profileDropdown');

    if (profileMenuButton && profileDropdown) {
        const closeProfileDropdown = () => {
            profileDropdown.classList.remove('show');
            profileMenuButton.setAttribute('aria-expanded', 'false');
        };

        profileMenuButton.addEventListener('click', function(event) {
            event.stopPropagation();
            const isOpen = profileDropdown.classList.toggle('show');
            profileMenuButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        profileDropdown.addEventListener('click', function(event) {
            event.stopPropagation();
        });

        document.addEventListener('click', closeProfileDropdown);
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeProfileDropdown();
            }
        });
    }

    // Sidebar Menu Toggle (if included sidebar)
    function toggleSubmenu(button) {
        const submenu = button.nextElementSibling;
        const arrow = button.querySelector('.toggle-arrow');

        if (submenu && arrow) {
            submenu.classList.toggle('open');
            arrow.classList.toggle('open');
        }
    }
</script>
@endsection
