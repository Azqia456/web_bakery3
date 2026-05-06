<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three D Bakery - Dashboard Pelanggan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-brown: #8B6F47;
            --light-brown: #C9A877;
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
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header with Navigation */
        .header {
            background: linear-gradient(135deg, #A0815A 0%, #8B6F47 100%);
            color: var(--white);
            padding: 12px 30px;
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: 700;
            text-decoration: none;
            color: var(--white);
        }

        .header-logo i {
            font-size: 24px;
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
            background: rgba(255, 255, 255, 0.2);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            color: var(--white);
            font-size: 16px;
        }

        .notification-btn:hover,
        .profile-btn:hover {
            background: rgba(255, 255, 255, 0.3);
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

        .profile-menu {
            position: relative;
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

        /* Cart Button */
        .cart-btn {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            color: var(--white);
            font-size: 16px;
        }

        .cart-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        .cart-badge {
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
            min-width: 18px;
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: flex-end;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .modal.show {
            opacity: 1;
            visibility: visible;
        }

        .modal.fullscreen {
            align-items: stretch;
        }

        .modal.fullscreen .modal-content {
            max-width: 100%;
            max-height: 100vh;
            height: 100vh;
            border-radius: 0;
            animation: none;
        }

        .modal-content {
            background: var(--white);
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            border-radius: var(--border-radius-xl) var(--border-radius-xl) 0 0;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
            }
            to {
                transform: translateY(0);
            }
        }

        .modal-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--medium-gray);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            background: var(--white);
            z-index: 1;
        }

        .modal-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: var(--dark-gray);
            transition: var(--transition);
        }

        .modal-close:hover {
            color: var(--text-dark);
        }

        .modal-body {
            padding: 16px 20px;
        }

        .modal-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--medium-gray);
            background: var(--light-gray);
            position: sticky;
            bottom: 0;
        }

        .modal.center {
            align-items: center;
            padding: 16px;
        }

        .modal-content.small {
            max-width: 360px;
            border-radius: var(--border-radius-xl);
        }

        .qty-picker {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 12px;
        }

        .qty-picker-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid var(--medium-gray);
            background: var(--white);
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
        }

        .qty-picker-btn:hover {
            border-color: var(--primary-brown);
            color: var(--primary-brown);
        }

        .qty-picker-input {
            width: 64px;
            text-align: center;
            border: 1px solid var(--medium-gray);
            border-radius: 8px;
            padding: 8px 6px;
            font-size: 14px;
            font-weight: 600;
        }

        /* Cart Items */
        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .cart-item {
            display: flex;
            gap: 12px;
            padding: 12px;
            background: var(--light-gray);
            border-radius: var(--border-radius);
            align-items: center;
        }

        .cart-item-image {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #E8DCC8 0%, #F5EFE7 100%);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .cart-item-price {
            font-size: 12px;
            color: var(--primary-brown);
            font-weight: 600;
        }

        .cart-item-qty {
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--white);
            border: 1px solid var(--medium-gray);
            border-radius: 4px;
            padding: 2px;
        }

        .qty-btn {
            width: 24px;
            height: 24px;
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 12px;
            color: var(--text-dark);
            transition: var(--transition);
        }

        .qty-btn:hover {
            color: var(--primary-brown);
        }

        .qty-display {
            width: 24px;
            text-align: center;
            font-size: 12px;
            font-weight: 600;
        }

        .cart-remove {
            background: none;
            border: none;
            color: #EF4444;
            cursor: pointer;
            font-size: 16px;
            transition: var(--transition);
        }

        .cart-remove:hover {
            color: #DC2626;
        }

        /* Cart Summary */
        .cart-summary {
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 12px;
            background: var(--light-gray);
            border-radius: var(--border-radius);
            margin-bottom: 16px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
        }

        .summary-row.total {
            font-size: 16px;
            font-weight: 700;
            color: var(--primary-brown);
            padding-top: 8px;
            border-top: 1px solid var(--medium-gray);
        }

        /* Payment Form */
        .payment-form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-input,
        .form-select {
            padding: 10px;
            border: 1px solid var(--medium-gray);
            border-radius: 6px;
            font-size: 13px;
            font-family: inherit;
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--primary-brown);
            box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
        }

        /* Action Buttons */
        .btn {
            padding: 12px 16px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-primary {
            background: var(--primary-brown);
            color: var(--white);
            width: 100%;
        }

        .btn-primary:hover {
            background: #7a5d3a;
        }

        .btn-secondary {
            background: var(--light-gray);
            color: var(--text-dark);
            width: 100%;
        }

        .btn-secondary:hover {
            background: var(--medium-gray);
        }

        /* Navigation Tabs */
        .nav-tabs {
            background: var(--white);
            border-bottom: 2px solid var(--medium-gray);
            padding: 0;
            margin: 0;
            display: flex;
            overflow-x: auto;
        }

        .nav-tab {
            padding: 16px 24px;
            text-decoration: none;
            color: var(--dark-gray);
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            border: none;
            background: transparent;
            border-bottom: 3px solid transparent;
            transition: var(--transition);
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-tab:hover {
            color: var(--primary-brown);
        }

        .nav-tab.active {
            color: var(--primary-brown);
            border-bottom-color: var(--primary-brown);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        /* Welcome Section */
        .welcome-section {
            margin-bottom: 30px;
        }

        .welcome-greeting {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .welcome-subtitle {
            color: var(--dark-gray);
            font-size: 14px;
        }

        /* Promotional Banner */
        .promo-banner {
            background: linear-gradient(135deg, #A0815A 0%, #8B6F47 100%);
            color: var(--white);
            border-radius: var(--border-radius-xl);
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: var(--shadow-md);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .promo-content h3 {
            font-size: 18px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .promo-content p {
            font-size: 14px;
            opacity: 0.9;
        }

        .promo-btn {
            background: var(--white);
            color: var(--primary-brown);
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .promo-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Summary Cards */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: var(--white);
            padding: 18px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--medium-gray);
            text-align: center;
        }

        .summary-card-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 22px;
            background: linear-gradient(135deg, #E8DCC8 0%, #F5EFE7 100%);
            color: var(--primary-brown);
        }

        .summary-card-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .summary-card-label {
            font-size: 12px;
            color: var(--dark-gray);
            font-weight: 500;
        }

        /* Products Grid */
        .products-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: var(--white);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            cursor: default;
            border: 1px solid var(--medium-gray);
            text-decoration: none;
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .product-media {
            position: relative;
        }

        .product-image {
            width: 100%;
            height: 170px;
            background: linear-gradient(135deg, #E8DCC8 0%, #F5EFE7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 46px;
        }

        .product-fav {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid var(--medium-gray);
            background: var(--white);
            color: #d97706;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .product-fav:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .product-info {
            padding: 12px 14px 14px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .product-name {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 2px;
            line-height: 1.3;
        }

        .product-desc {
            font-size: 12px;
            color: var(--dark-gray);
            line-height: 1.4;
        }

        .product-price {
            font-size: 13px;
            color: var(--primary-brown);
            font-weight: 700;
        }

        .product-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 6px;
        }

        .qty-stepper {
            display: inline-flex;
            align-items: center;
            border: 1px solid var(--medium-gray);
            border-radius: 8px;
            padding: 4px;
            gap: 8px;
            background: var(--white);
        }

        .qty-stepper-btn {
            width: 24px;
            height: 24px;
            border: none;
            background: transparent;
            color: var(--text-dark);
            font-weight: 700;
            cursor: pointer;
        }

        .qty-stepper-input {
            width: 28px;
            text-align: center;
            border: none;
            outline: none;
            font-size: 12px;
            font-weight: 600;
            background: transparent;
        }

        .product-add-btn {
            flex: 1;
            border: none;
            background: var(--primary-brown);
            color: var(--white);
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: var(--transition);
        }

        .product-add-btn:hover {
            background: #7a5d3a;
        }

        /* Orders Section */
        .orders-filter {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 16px;
            border: 2px solid var(--medium-gray);
            background: var(--white);
            color: var(--text-dark);
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 13px;
            transition: var(--transition);
        }

        .filter-btn:hover {
            border-color: var(--primary-brown);
            color: var(--primary-brown);
        }

        .filter-btn.active {
            background: var(--primary-brown);
            color: var(--white);
            border-color: var(--primary-brown);
        }

        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .order-card {
            background: var(--white);
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            padding: 16px;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--medium-gray);
        }

        .order-info {
            flex: 1;
        }

        .order-code {
            font-size: 13px;
            color: var(--dark-gray);
            font-weight: 500;
        }

        .order-date {
            font-size: 12px;
            color: var(--dark-gray);
            margin-top: 2px;
        }

        .order-status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .order-status-badge.pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .order-status-badge.processing {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .order-status-badge.shipped {
            background: #F3E8FF;
            color: #6B21A8;
        }

        .order-status-badge.completed {
            background: #DCFCE7;
            color: #166534;
        }

        .order-items {
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--medium-gray);
        }

        .order-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .order-item-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: linear-gradient(135deg, #E8DCC8 0%, #F5EFE7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .order-item-details {
            flex: 1;
        }

        .order-item-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .order-item-qty {
            font-size: 12px;
            color: var(--dark-gray);
        }

        .order-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--medium-gray);
        }

        .order-total-label {
            font-size: 13px;
            color: var(--dark-gray);
            font-weight: 500;
        }

        .order-total-value {
            font-size: 16px;
            font-weight: 700;
            color: var(--primary-brown);
        }

        /* Timeline Progress */
        .timeline-container {
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--medium-gray);
        }

        .timeline-steps {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .timeline-step {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .timeline-dot {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--medium-gray);
            border: 2px solid var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            margin-bottom: 6px;
            z-index: 2;
            position: relative;
        }

        .timeline-dot.active {
            background: var(--primary-brown);
            color: var(--white);
        }

        .timeline-dot.completed {
            background: #22C55E;
            color: var(--white);
        }

        .timeline-dot i {
            font-size: 11px;
        }

        .timeline-label {
            font-size: 11px;
            color: var(--dark-gray);
            text-align: center;
            font-weight: 500;
        }

        .timeline-line {
            position: absolute;
            top: 12px;
            left: 50%;
            width: 100%;
            height: 2px;
            background: var(--medium-gray);
            z-index: 1;
        }

        .timeline-step:not(:last-child) .timeline-line {
            display: block;
        }

        .timeline-step:last-child .timeline-line {
            display: none;
        }

        .timeline-line.active {
            background: var(--primary-brown);
        }

        .timeline-line.completed {
            background: #22C55E;
        }

        /* Order Actions */
        .order-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .order-action-btn {
            padding: 8px 12px;
            border: 1px solid var(--medium-gray);
            background: var(--white);
            color: var(--text-dark);
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .order-action-btn:hover {
            background: var(--light-gray);
            border-color: var(--primary-brown);
            color: var(--primary-brown);
        }

        .order-action-btn.primary {
            background: var(--primary-brown);
            color: var(--white);
            border-color: var(--primary-brown);
        }

        .order-action-btn.primary:hover {
            background: #7a5d3a;
        }

        /* Tabs Content */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-content {
                padding: 16px;
            }

            .header-container {
                flex-wrap: wrap;
                gap: 12px;
            }

            .header-logo {
                font-size: 16px;
            }

            .nav-tabs {
                overflow-x: auto;
            }

            .nav-tab {
                padding: 12px 16px;
                font-size: 13px;
            }

            .promo-banner {
                flex-direction: column;
                text-align: center;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }

            .summary-cards {
                grid-template-columns: 1fr;
            }

            .orders-filter {
                gap: 8px;
            }

            .filter-btn {
                padding: 6px 12px;
                font-size: 12px;
            }

            .order-actions {
                grid-template-columns: 1fr;
            }

            .timeline-steps {
                flex-wrap: wrap;
            }

            .timeline-label {
                font-size: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Header -->
        <header class="header">
            <div class="header-container">
                <a href="{{ route('pelanggan.dashboard') }}" class="header-logo">
                    <i class="fas fa-bread-slice"></i>
                    <span>Three D Bakery</span>
                </a>
                <div class="header-right">
                    <button class="notification-btn" type="button" aria-label="Notifikasi">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">1</span>
                    </button>
                    <button class="cart-btn" id="cartBtn" type="button" aria-label="Keranjang">
                        <i class="fas fa-shopping-basket"></i>
                        <span class="cart-badge" id="cartBadge">0</span>
                    </button>
                    <div class="profile-menu">
                        <button type="button" class="profile-btn" id="profileMenuButton" aria-haspopup="true" aria-expanded="false" title="Akun">
                            <i class="fas fa-user"></i>
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
            </div>
        </header>

        <!-- Navigation Tabs -->
        <nav class="nav-tabs" role="tablist">
            <button class="nav-tab active" data-tab="home" role="tab">
                <i class="fas fa-home"></i>
                Beranda
            </button>
            <button class="nav-tab" data-tab="orders" role="tab">
                <i class="fas fa-shopping-cart"></i>
                Pesanan Saya
            </button>
            <button class="nav-tab" data-tab="profile" role="tab">
                <i class="fas fa-id-card"></i>
                Profil
            </button>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Home Tab -->
            <div class="tab-content active" id="home-tab">
                <div class="welcome-section">
                    <div class="welcome-greeting">Selamat datang, Pelanggan 👋</div>
                    <div class="welcome-subtitle">Pilih roti favorit kamu hari ini</div>
                </div>

                <!-- Promotional Banner -->
                <div class="promo-banner">
                    <div class="promo-content">
                        <h3>Roti segar setiap hari!</h3>
                        <p>Pesan sekarang, siap dalam 2-3 jam</p>
                    </div>
                    <button class="promo-btn">
                        <i class="fas fa-arrow-right"></i> Lihat Keranjang
                    </button>
                </div>

                <!-- Summary Cards -->
                <div class="summary-cards">
                    <div class="summary-card">
                        <div class="summary-card-icon">
                            <i class="fas fa-bag-shopping"></i>
                        </div>
                        <div class="summary-card-value" id="totalOrders">2</div>
                        <div class="summary-card-label">Total pesanan</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-card-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="summary-card-value" id="totalSpent">Rp 1jt</div>
                        <div class="summary-card-label">Pengeluaran</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-card-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="summary-card-value" id="completedOrders">1</div>
                        <div class="summary-card-label">Selesai</div>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="products-section">
                    <h2 class="section-title">
                        <i class="fas fa-star"></i>
                        Pilihan Produk
                    </h2>
                    <div class="products-grid" id="productsGrid">
                        <!-- Products will be loaded here -->
                    </div>
                </div>
            </div>

            <!-- Orders Tab -->
            <div class="tab-content" id="orders-tab">
                <h2 class="section-title">
                    <i class="fas fa-list"></i>
                    Pesanan Saya
                </h2>

                <!-- Filter Buttons -->
                <div class="orders-filter">
                    <button class="filter-btn active" data-filter="all">Semua</button>
                    <button class="filter-btn" data-filter="pending">Menunggu</button>
                    <button class="filter-btn" data-filter="processing">Diproses</button>
                    <button class="filter-btn" data-filter="shipped">Dikirim</button>
                    <button class="filter-btn" data-filter="completed">Selesai</button>
                </div>

                <!-- Orders List -->
                <div class="orders-list" id="ordersList">
                    <!-- Orders will be loaded here -->
                </div>
            </div>

            <!-- Cart Tab -->
            <div class="tab-content" id="cart-tab">
                <h2 class="section-title">
                    <i class="fas fa-basket-shopping"></i>
                    Keranjang
                </h2>
                <div id="cartContent">
                    <!-- Cart will be loaded here -->
                </div>
            </div>

            <!-- Payment Tab -->
            <div class="tab-content" id="payment-tab">
                <h2 class="section-title">
                    <i class="fas fa-credit-card"></i>
                    Pembayaran
                </h2>
                <div id="paymentContent">
                    <!-- Payment info will be loaded here -->
                </div>
            </div>

            <!-- Profile Tab -->
            <div class="tab-content" id="profile-tab">
                <h2 class="section-title">
                    <i class="fas fa-id-card"></i>
                    Profil Saya
                </h2>
                <div id="profileContent">
                    <!-- Profile will be loaded here -->
                </div>
            </div>
        </main>
    </div>

    <!-- Quantity Modal -->
    <div class="modal center" id="quantityModal">
        <div class="modal-content small">
            <div class="modal-header">
                <h2 class="modal-title" id="quantityProductTitle">Tambah ke Keranjang</h2>
                <button class="modal-close" id="quantityModalClose">&times;</button>
            </div>
            <div class="modal-body">
                <div style="text-align: center; color: var(--dark-gray); font-size: 13px;">
                    Pilih jumlah produk
                </div>
                <div class="qty-picker">
                    <button class="qty-picker-btn" id="qtyDecrease">-</button>
                    <input type="number" min="1" value="1" class="qty-picker-input" id="qtyInput" />
                    <button class="qty-picker-btn" id="qtyIncrease">+</button>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="confirmQtyBtn">
                    <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                </button>
            </div>
        </div>
    </div>

    <!-- Cart Modal -->
    <div class="modal fullscreen" id="cartModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">
                    <i class="fas fa-shopping-basket"></i>
                    Keranjang Belanja
                </h2>
                <button class="modal-close" id="cartModalClose">&times;</button>
            </div>
            <div class="modal-body">
                <div class="cart-items" id="cartItems">
                    <!-- Cart items will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <div class="cart-summary">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span id="subtotal">Rp 0</span>
                    </div>
                    <div class="summary-row">
                        <span>Ongkir:</span>
                        <span id="shipping">Rp 0</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total:</span>
                        <span id="total">Rp 0</span>
                    </div>
                </div>
                <button class="btn btn-primary" id="checkoutBtn">
                    <i class="fas fa-credit-card"></i> Lanjut Pembayaran
                </button>
                <button class="btn btn-secondary" id="continueShopping" style="margin-top: 8px;">
                    <i class="fas fa-arrow-left"></i> Lanjut Belanja
                </button>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal" id="paymentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">
                    <i class="fas fa-credit-card"></i>
                    Pembayaran
                </h2>
                <button class="modal-close" id="paymentModalClose">&times;</button>
            </div>
            <div class="modal-body">
                <div class="cart-summary" style="margin-bottom: 20px;">
                    <div class="summary-row">
                        <span>Total Belanja:</span>
                        <span id="paymentTotal">Rp 0</span>
                    </div>
                </div>
                <form class="payment-form" id="paymentForm">
                    <div class="form-group">
                        <label class="form-label">Metode Pembayaran</label>
                        <select class="form-select" name="payment_method" required>
                            <option value="">Pilih metode pembayaran</option>
                            <option value="bank_transfer">Transfer Bank</option>
                            <option value="e_wallet">E-Wallet</option>
                            <option value="cod">Bayar di Tempat</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-input" name="full_name" required placeholder="Masukkan nama lengkap">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-input" name="phone" required placeholder="Masukkan nomor telepon">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat Pengiriman</label>
                        <textarea class="form-input" name="address" required placeholder="Masukkan alamat lengkap" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="submitPaymentBtn">
                    <i class="fas fa-check"></i> Konfirmasi Pembayaran
                </button>
                <button class="btn btn-secondary" id="backToCartBtn" style="margin-top: 8px;">
                    <i class="fas fa-arrow-left"></i> Kembali
                </button>
            </div>
        </div>
    </div>

    <script>
        // Tab Navigation
        const navTabs = document.querySelectorAll('.nav-tab');
        const tabContents = document.querySelectorAll('.tab-content');

        navTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const tabName = tab.getAttribute('data-tab');

                // Remove active class from all tabs and contents
                navTabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                // Add active class to clicked tab and corresponding content
                tab.classList.add('active');
                document.getElementById(`${tabName}-tab`).classList.add('active');
            });
        });

        // Profile Menu Toggle
        const profileMenuButton = document.getElementById('profileMenuButton');
        const profileDropdown = document.getElementById('profileDropdown');

        if (profileMenuButton && profileDropdown) {
            profileMenuButton.addEventListener('click', () => {
                profileDropdown.classList.toggle('show');
            });

            document.addEventListener('click', (event) => {
                if (!profileMenuButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.remove('show');
                }
            });
        }

        function getProductDescription(name) {
            const descriptions = {
                'Roti Kelapa': 'Roti lembut dengan taburan kelapa parut manis dan aroma wangi.',
                'Roti Kacang Ijo': 'Isian kacang ijo legit, cocok untuk camilan pagi hari.',
                'Roti Stroberi': 'Roti manis dengan selai stroberi segar dan creamy.',
                'Roti Bluberi': 'Roti empuk dengan selai bluberi asam-manis yang seimbang.',
                'Roti Cokelat': 'Roti lembut dengan isian cokelat lumer favorit semua orang.'
            };

            return descriptions[name] || 'Roti fresh harian dengan bahan berkualitas.';
        }

        // Load Products
        async function loadProducts() {
            try {
                const response = await fetch('/api/produks');
                if (!response.ok) throw new Error('Failed to load products');

                const data = await response.json();
                const products = Array.isArray(data) ? data : (data.data || []);
                const productsGrid = document.getElementById('productsGrid');

                if (!products || products.length === 0) {
                    productsGrid.innerHTML = '<p>Tidak ada produk</p>';
                    return;
                }

                productsGrid.innerHTML = products.map(product => {
                    const productName = product.nama_produk || 'Produk';
                    const description = getProductDescription(productName);
                    return `
                    <div
                        class="product-card"
                        data-id="${product.id_produk}"
                        data-name="${productName}"
                        data-price="${parseInt(product.harga_produk || 0)}"
                        data-emoji="${product.emoji || '🍞'}"
                        data-desc="${description}"
                    >
                        <div class="product-media">
                            <div class="product-image">
                                ${product.emoji || '🍞'}
                            </div>
                            <button class="product-fav" type="button" aria-label="Favorit">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <div class="product-info">
                            <div class="product-name">${productName}</div>
                            <div class="product-desc">${description}</div>
                            <div class="product-price">Rp ${parseInt(product.harga_produk || 0).toLocaleString('id-ID')}</div>
                            <div class="product-actions">
                                <div class="qty-stepper">
                                    <button class="qty-stepper-btn" type="button" data-step="down">-</button>
                                    <input class="qty-stepper-input" type="number" min="1" value="1" />
                                    <button class="qty-stepper-btn" type="button" data-step="up">+</button>
                                </div>
                                <button class="product-add-btn" type="button">
                                    <i class="fas fa-cart-plus"></i>
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                }).join('');
            } catch (error) {
                console.error('Error loading products:', error);
                document.getElementById('productsGrid').innerHTML = '<p>Gagal memuat produk: ' + error.message + '</p>';
            }
        }

        // Load Dashboard Stats
        async function loadDashboardStats() {
            try {
                const response = await fetch('/api/pelanggan/dashboard_pelanggan/stats');
                if (!response.ok) throw new Error('Failed to load stats');

                const data = await response.json();
                
                // Update summary cards with actual data if available
                if (data.summary_cards && data.summary_cards[0]) {
                    document.getElementById('totalOrders').textContent = data.summary_cards[0].value || '0';
                }
            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }

        // Get order status badge class
        function getOrderStatusClass(status) {
            const statusLower = status?.toLowerCase() || 'pending';
            if (statusLower.includes('selesai') || statusLower.includes('completed')) return 'completed';
            if (statusLower.includes('dikirim') || statusLower.includes('shipped')) return 'shipped';
            if (statusLower.includes('proses') || statusLower.includes('processing')) return 'processing';
            return 'pending';
        }

        // Get order status label
        function getOrderStatusLabel(status) {
            const statusLower = status?.toLowerCase() || 'pending';
            if (statusLower.includes('selesai') || statusLower.includes('completed')) return 'Selesai';
            if (statusLower.includes('dikirim') || statusLower.includes('shipped')) return 'Dikirim';
            if (statusLower.includes('proses') || statusLower.includes('processing')) return 'Diproses';
            return 'Menunggu';
        }

        // Load Orders
        async function loadOrders() {
            try {
                const response = await fetch('/api/pesanans');
                if (!response.ok) throw new Error('Failed to load orders');

                const data = await response.json();
                const orders = Array.isArray(data) ? data : (data.data || []);
                const ordersList = document.getElementById('ordersList');

                if (!orders || orders.length === 0) {
                    ordersList.innerHTML = '<p>Tidak ada pesanan</p>';
                    return;
                }

                // Group items by order
                const orderGroups = {};
                orders.forEach(order => {
                    const orderId = order.id_pesanan;
                    if (!orderGroups[orderId]) {
                        orderGroups[orderId] = {
                            ...order,
                            items: []
                        };
                    }
                    if (order.detail_pesanan || order.nama_produk) {
                        orderGroups[orderId].items.push(order);
                    }
                });

                // Render orders
                const orderCardsHTML = Object.values(orderGroups).map(order => {
                    const statusClass = getOrderStatusClass(order.status_pesanan);
                    const statusLabel = getOrderStatusLabel(order.status_pesanan);
                    
                    // Get timeline progress
                    const steps = ['Diproses', 'Dikirim', 'Selesai'];
                    const currentStepIndex = steps.findIndex(step => 
                        statusLabel.toLowerCase().includes(step.toLowerCase())
                    );

                    const timelineHTML = steps.map((step, index) => {
                        const isCompleted = index < currentStepIndex;
                        const isActive = index === currentStepIndex;
                        const isDone = statusClass === 'completed';

                        return `
                            <div class="timeline-step">
                                <div class="timeline-dot ${isCompleted || (isDone && index < steps.length) ? 'completed' : isActive ? 'active' : ''}">
                                    ${isCompleted || (isDone && index < steps.length) ? '<i class="fas fa-check"></i>' : index + 1}
                                </div>
                                <div class="timeline-label">${step}</div>
                                ${index < steps.length - 1 ? `<div class="timeline-line ${isCompleted || (isDone && index < steps.length) ? 'completed' : isActive ? 'active' : ''}"></div>` : ''}
                            </div>
                        `;
                    }).join('');

                    // Render items
                    const itemsHTML = (order.items || []).slice(0, 3).map(item => `
                        <div class="order-item">
                            <div class="order-item-icon">
                                ${item.emoji || '🍞'}
                            </div>
                            <div class="order-item-details">
                                <div class="order-item-name">${item.nama_produk || 'Produk'}</div>
                                <div class="order-item-qty">${item.jumlah || item.quantity || 1} item${(item.jumlah || item.quantity || 1) > 1 ? 's' : ''}</div>
                            </div>
                        </div>
                    `).join('');

                    return `
                        <div class="order-card" data-status="${statusClass}">
                            <div class="order-header">
                                <div class="order-info">
                                    <div class="order-code">${order.id_pesanan || 'ORD-????'}</div>
                                    <div class="order-date">${new Date(order.tanggal_pesanan || order.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })}</div>
                                </div>
                                <span class="order-status-badge ${statusClass}">${statusLabel}</span>
                            </div>

                            <div class="order-items">
                                ${itemsHTML}
                            </div>

                            <div class="order-total">
                                <span class="order-total-label">Total pembayaran</span>
                                <span class="order-total-value">Rp ${parseInt(order.total_harga || 0).toLocaleString('id-ID')}</span>
                            </div>

                            <div class="timeline-container">
                                <div class="timeline-steps">
                                    ${timelineHTML}
                                </div>
                            </div>

                            <div class="order-actions">
                                <button class="order-action-btn">
                                    <i class="fas fa-phone"></i> Hubungi Toko
                                </button>
                                <a href="/pelanggan/pesanan/${order.id_pesanan}" class="order-action-btn primary">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    `;
                }).join('');

                ordersList.innerHTML = orderCardsHTML;

                // Add filter functionality
                const filterButtons = document.querySelectorAll('.orders-filter .filter-btn');
                filterButtons.forEach(btn => {
                    btn.addEventListener('click', () => {
                        filterButtons.forEach(b => b.classList.remove('active'));
                        btn.classList.add('active');

                        const filter = btn.getAttribute('data-filter');
                        const orderCards = document.querySelectorAll('.order-card');

                        orderCards.forEach(card => {
                            const status = card.getAttribute('data-status');
                            if (filter === 'all' || status === filter) {
                                card.style.display = 'block';
                            } else {
                                card.style.display = 'none';
                            }
                        });
                    });
                });

            } catch (error) {
                console.error('Error loading orders:', error);
                document.getElementById('ordersList').innerHTML = '<p>Gagal memuat pesanan</p>';
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', () => {
            loadProducts();
            loadDashboardStats();
            loadOrders();
            initializeCart();
            initializePaymentModal();
            initializeQuantityModal();
        });

        // Cart Management
        let cart = [];

        function initializeCart() {
            const cartBtn = document.getElementById('cartBtn');
            const cartModal = document.getElementById('cartModal');
            const cartModalClose = document.getElementById('cartModalClose');
            const continueShopping = document.getElementById('continueShopping');
            const checkoutBtn = document.getElementById('checkoutBtn');

            // Load cart from localStorage
            const savedCart = localStorage.getItem('bakery_cart');
            if (savedCart) {
                cart = JSON.parse(savedCart);
                updateCartBadge();
                renderCart();
            }

            // Open cart modal
            cartBtn.addEventListener('click', () => {
                cartModal.classList.add('show');
                renderCart();
            });

            // Close cart modal
            cartModalClose.addEventListener('click', () => {
                cartModal.classList.remove('show');
            });

            // Continue shopping
            continueShopping.addEventListener('click', () => {
                cartModal.classList.remove('show');
            });

            // Close modal when clicking outside
            cartModal.addEventListener('click', (e) => {
                if (e.target === cartModal) {
                    cartModal.classList.remove('show');
                }
            });

            // Checkout
            checkoutBtn.addEventListener('click', () => {
                if (cart.length === 0) {
                    alert('Keranjang masih kosong!');
                    return;
                }
                cartModal.classList.remove('show');
                setTimeout(() => {
                    document.getElementById('paymentModal').classList.add('show');
                    updatePaymentTotal();
                }, 300);
            });
        }

        function addToCart(product, quantity = 1) {
            const existingItem = cart.find(item => item.id_produk === product.id_produk);
            
            if (existingItem) {
                existingItem.quantity = (existingItem.quantity || 1) + quantity;
            } else {
                cart.push({
                    ...product,
                    quantity: quantity
                });
            }
            
            saveCart();
            updateCartBadge();
            showNotification('Produk ditambahkan ke keranjang!');
        }

        // Quantity Modal
        let selectedProduct = null;

        function initializeQuantityModal() {
            const quantityModal = document.getElementById('quantityModal');
            const quantityModalClose = document.getElementById('quantityModalClose');
            const qtyDecrease = document.getElementById('qtyDecrease');
            const qtyIncrease = document.getElementById('qtyIncrease');
            const qtyInput = document.getElementById('qtyInput');
            const confirmQtyBtn = document.getElementById('confirmQtyBtn');

            quantityModalClose.addEventListener('click', () => {
                quantityModal.classList.remove('show');
            });

            qtyDecrease.addEventListener('click', () => {
                const value = Math.max(1, parseInt(qtyInput.value || 1) - 1);
                qtyInput.value = value;
            });

            qtyIncrease.addEventListener('click', () => {
                const value = Math.max(1, parseInt(qtyInput.value || 1) + 1);
                qtyInput.value = value;
            });

            qtyInput.addEventListener('input', () => {
                const value = Math.max(1, parseInt(qtyInput.value || 1));
                qtyInput.value = value;
            });

            quantityModal.addEventListener('click', (e) => {
                if (e.target === quantityModal) {
                    quantityModal.classList.remove('show');
                }
            });

            confirmQtyBtn.addEventListener('click', () => {
                if (!selectedProduct) return;
                const qty = Math.max(1, parseInt(qtyInput.value || 1));
                addToCart(selectedProduct, qty);
                quantityModal.classList.remove('show');
                selectedProduct = null;
            });
        }

        function openQuantityModal(product) {
            selectedProduct = product;
            document.getElementById('quantityProductTitle').textContent = `Tambah ${product.nama_produk}`;
            document.getElementById('qtyInput').value = 1;
            document.getElementById('quantityModal').classList.add('show');
        }

        function updateQuantity(productId, change) {
            const item = cart.find(i => i.id_produk === productId);
            if (!item) return;

            item.quantity += change;
            if (item.quantity <= 0) {
                removeFromCart(productId);
            } else {
                saveCart();
                renderCart();
                updateCartBadge();
            }
        }

        function removeFromCart(productId) {
            cart = cart.filter(item => item.id_produk !== productId);
            saveCart();
            updateCartBadge();
            renderCart();
        }

        function renderCart() {
            const cartItems = document.getElementById('cartItems');
            
            if (cart.length === 0) {
                cartItems.innerHTML = '<p style="text-align: center; padding: 20px; color: var(--dark-gray);">Keranjang kosong</p>';
                document.getElementById('checkoutBtn').disabled = true;
                return;
            }

            document.getElementById('checkoutBtn').disabled = false;

            cartItems.innerHTML = cart.map(item => `
                <div class="cart-item">
                    <div class="cart-item-image">${item.emoji || '🍞'}</div>
                    <div class="cart-item-info">
                        <div class="cart-item-name">${item.nama_produk}</div>
                        <div class="cart-item-price">Rp ${parseInt(item.harga_produk).toLocaleString('id-ID')}</div>
                    </div>
                    <div class="cart-item-qty">
                        <button class="qty-btn" onclick="updateQuantity(${item.id_produk}, -1)">−</button>
                        <span class="qty-display">${item.quantity}</span>
                        <button class="qty-btn" onclick="updateQuantity(${item.id_produk}, 1)">+</button>
                    </div>
                    <button class="cart-remove" onclick="removeFromCart(${item.id_produk})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `).join('');

            // Update summary
            const subtotal = cart.reduce((sum, item) => sum + (item.harga_produk * item.quantity), 0);
            const shipping = 0;
            const total = subtotal + shipping;

            document.getElementById('subtotal').textContent = `Rp ${parseInt(subtotal).toLocaleString('id-ID')}`;
            document.getElementById('shipping').textContent = `Rp ${parseInt(shipping).toLocaleString('id-ID')}`;
            document.getElementById('total').textContent = `Rp ${parseInt(total).toLocaleString('id-ID')}`;
        }

        function updateCartBadge() {
            const badge = document.getElementById('cartBadge');
            const total = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
            badge.textContent = total > 0 ? total : '0';
        }

        function saveCart() {
            localStorage.setItem('bakery_cart', JSON.stringify(cart));
        }

        // Payment Modal
        function initializePaymentModal() {
            const paymentModal = document.getElementById('paymentModal');
            const paymentModalClose = document.getElementById('paymentModalClose');
            const backToCartBtn = document.getElementById('backToCartBtn');
            const submitPaymentBtn = document.getElementById('submitPaymentBtn');

            paymentModalClose.addEventListener('click', () => {
                paymentModal.classList.remove('show');
            });

            backToCartBtn.addEventListener('click', () => {
                paymentModal.classList.remove('show');
                setTimeout(() => {
                    document.getElementById('cartModal').classList.add('show');
                }, 300);
            });

            paymentModal.addEventListener('click', (e) => {
                if (e.target === paymentModal) {
                    paymentModal.classList.remove('show');
                }
            });

            submitPaymentBtn.addEventListener('click', () => {
                const form = document.getElementById('paymentForm');
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                submitPayment();
            });
        }

        function updatePaymentTotal() {
            const total = cart.reduce((sum, item) => sum + (item.harga_produk * item.quantity), 0);
            document.getElementById('paymentTotal').textContent = `Rp ${parseInt(total).toLocaleString('id-ID')}`;
        }

        async function submitPayment() {
            try {
                const form = document.getElementById('paymentForm');
                const formData = new FormData(form);

                const paymentData = {
                    items: cart,
                    payment_method: formData.get('payment_method'),
                    full_name: formData.get('full_name'),
                    phone: formData.get('phone'),
                    address: formData.get('address'),
                    total: cart.reduce((sum, item) => sum + (item.harga_produk * item.quantity), 0)
                };

                const response = await fetch('/api/pesanans', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(paymentData)
                });

                if (!response.ok) throw new Error('Gagal memproses pembayaran');

                const result = await response.json();
                
                // Clear cart
                cart = [];
                saveCart();
                updateCartBadge();

                // Close modal
                document.getElementById('paymentModal').classList.remove('show');

                // Show success message
                showNotification('Pesanan berhasil dibuat! Silakan tunggu konfirmasi dari toko.', 'success');

                // Reload orders
                setTimeout(() => {
                    loadOrders();
                }, 1000);

            } catch (error) {
                console.error('Error submitting payment:', error);
                showNotification('Gagal memproses pembayaran: ' + error.message, 'error');
            }
        }

        function showNotification(message, type = 'info') {
            alert(message); // Simple notification, bisa diganti dengan toast
        }

        // Add to cart from product cards
        function makeProductsAddToCart() {
            const productCards = document.querySelectorAll('.product-card');
            productCards.forEach(card => {
                const addBtn = card.querySelector('.product-add-btn');
                const qtyInput = card.querySelector('.qty-stepper-input');
                const stepperBtns = card.querySelectorAll('.qty-stepper-btn');

                stepperBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        const current = parseInt(qtyInput.value || '1', 10);
                        const next = btn.dataset.step === 'up' ? current + 1 : Math.max(1, current - 1);
                        qtyInput.value = next;
                    });
                });

                qtyInput.addEventListener('input', () => {
                    const value = Math.max(1, parseInt(qtyInput.value || '1', 10));
                    qtyInput.value = value;
                });

                addBtn.addEventListener('click', (e) => {
                    const productData = {
                        id_produk: parseInt(card.dataset.id, 10),
                        nama_produk: card.dataset.name,
                        harga_produk: parseInt(card.dataset.price, 10),
                        emoji: card.dataset.emoji || card.querySelector('.product-image').textContent.trim()
                    };
                    const qty = Math.max(1, parseInt(qtyInput.value || '1', 10));
                    addToCart(productData, qty);
                    e.preventDefault();
                });
            });
        }

        // Promo banner button functionality
        document.querySelector('.promo-btn').addEventListener('click', () => {
            document.getElementById('cartBtn').click();
        });

        // Update product cards after loading
        const originalLoadProducts = loadProducts;
        window.loadProducts = async function() {
            await originalLoadProducts();
            makeProductsAddToCart();
        };
    </script>
</body>
</html>
