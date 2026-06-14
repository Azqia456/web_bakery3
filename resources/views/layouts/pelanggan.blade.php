<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .dashboard-layout {
            display: flex;
            gap: 24px;
            padding: 24px 30px 30px;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        .sidebar {
            width: 240px;
            background: #fbf7f1;
            border: 1px solid var(--medium-gray);
            border-radius: 16px;
            padding: 18px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            position: sticky;
            top: 90px;
            align-self: flex-start;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #f2e6d5 0%, #e6d2b4 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-brown);
            font-size: 18px;
        }

        .brand-text h1 {
            font-size: 14px;
            font-weight: 700;
            margin: 0;
            color: #4b2f1c;
        }

        .brand-text span {
            font-size: 11px;
            color: var(--dark-gray);
        }

        .user-card {
            background: var(--white);
            border-radius: 14px;
            padding: 14px;
            border: 1px solid var(--medium-gray);
            text-align: center;
        }

        .user-avatar {
            width: 64px;
            height: 64px;
            margin: 0 auto 8px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f3e7d7 0%, #e1c6a1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #4b2f1c;
            font-size: 20px;
        }

        .user-name {
            font-weight: 700;
            font-size: 14px;
        }

        .user-tier {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 999px;
            background: #f7e6cf;
            color: #8b5a2b;
            font-size: 10px;
            font-weight: 600;
            margin-top: 6px;
        }

        .user-email {
            font-size: 11px;
            color: var(--dark-gray);
            margin-top: 6px;
            word-break: break-word;
        }

        .sidebar-divider {
            height: 1px;
            background: var(--medium-gray);
        }

        .sidebar-section-title {
            font-size: 11px;
            font-weight: 700;
            color: #7b5b3d;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .help-card {
            margin-top: auto;
            background: var(--white);
            border-radius: 14px;
            padding: 12px;
            border: 1px solid var(--medium-gray);
            text-align: left;
        }

        .help-card h4 {
            font-size: 12px;
            margin-bottom: 4px;
        }

        .help-card p {
            font-size: 11px;
            color: var(--dark-gray);
            margin-bottom: 10px;
        }

        .help-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #8b5a2b;
            color: var(--white);
            padding: 6px 10px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 11px;
            font-weight: 600;
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

        @media (min-width: 768px) {
            #cartModal.modal.fullscreen {
                align-items: center;
                justify-content: center;
                padding: 16px;
            }

            #cartModal.modal.fullscreen .modal-content {
                max-width: 500px;
                max-height: 90vh;
                height: auto;
                border-radius: var(--border-radius-xl);
            }
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

        .payment-modal {
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .payment-modal .modal-content {
            max-width: 1020px;
            width: min(1020px, 100%);
            max-height: calc(100vh - 48px);
            height: auto;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 30px 90px rgba(25, 20, 15, 0.28);
            animation: paymentPopIn 0.25s ease;
            display: flex;
            flex-direction: column;
        }

        @keyframes paymentPopIn {
            from {
                transform: scale(0.98) translateY(12px);
                opacity: 0;
            }
            to {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        .payment-modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid rgba(229, 231, 235, 0.9);
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            background: linear-gradient(180deg, #ffffff 0%, #fbfaf8 100%);
        }

        .payment-modal-title-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .payment-modal-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(139, 111, 71, 0.12) 0%, rgba(201, 168, 119, 0.2) 100%);
            color: var(--primary-brown);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 18px;
        }

        .payment-modal-header h2 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .payment-modal-header p {
            font-size: 13px;
            color: var(--dark-gray);
        }

        .payment-security-note {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 12px;
            background: #f3faf4;
            color: #2f6f43;
            font-size: 12px;
            font-weight: 600;
            text-align: right;
        }

        .payment-modal-grid {
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            min-height: 0;
            flex: 1;
            overflow: hidden;
        }

        .payment-panel {
            padding: 24px;
            min-height: 0;
            overflow-y: auto;
        }

        .payment-panel.methods {
            border-right: 1px solid rgba(229, 231, 235, 0.9);
            background: linear-gradient(180deg, #ffffff 0%, #fcfbf8 100%);
        }

        .payment-panel.summary {
            background: #f8f8fd;
        }

        .payment-panel-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 14px;
        }

        .payment-section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            color: var(--primary-brown);
            margin: 12px 0 10px;
        }

        .payment-section-label::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: var(--primary-brown);
        }

        .payment-method-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .payment-option {
            position: relative;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            border: 1.5px solid #e5e7eb;
            border-radius: 14px;
            background: #fff;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 1px 0 rgba(255, 255, 255, 0.7) inset;
        }

        .payment-option:hover {
            border-color: rgba(139, 111, 71, 0.35);
            box-shadow: 0 10px 24px rgba(139, 111, 71, 0.08);
            transform: translateY(-1px);
        }

        .payment-option.active {
            border-color: #8a63ff;
            box-shadow: 0 14px 30px rgba(117, 75, 255, 0.12);
        }

        .payment-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .payment-option-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #fff;
        }

        .payment-option-icon.qris {
            background: linear-gradient(135deg, #111827 0%, #374151 100%);
        }

        .payment-option-icon.dana {
            background: linear-gradient(135deg, #1d9bf0 0%, #1266d8 100%);
        }

        .payment-option-copy {
            flex: 1;
            min-width: 0;
        }

        .payment-option-copy strong {
            display: block;
            font-size: 14px;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .payment-option-copy span {
            display: block;
            font-size: 12px;
            color: var(--dark-gray);
        }

        .payment-option-tag {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(139, 111, 71, 0.12);
            color: var(--primary-brown);
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .payment-summary-card,
        .payment-detail-card,
        .payment-assurance-card,
        .payment-help-card {
            background: var(--white);
            border: 1px solid rgba(229, 231, 235, 0.95);
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        }

        .payment-summary-card {
            padding: 16px;
            margin-bottom: 14px;
        }

        .payment-summary-card h3,
        .payment-detail-card h3,
        .payment-assurance-card h3,
        .payment-help-card h3 {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .payment-summary-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            font-size: 13px;
            color: var(--dark-gray);
            padding: 9px 0;
        }

        .payment-summary-row + .payment-summary-row {
            border-top: 1px solid #f1f3f5;
        }

        .payment-summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 14px;
            margin-top: 8px;
            border-top: 1px solid #eceef3;
            font-size: 14px;
            font-weight: 700;
            color: var(--primary-brown);
        }

        .payment-order-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .payment-order-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 14px;
            background: #fff;
            border: 1px solid #eef0f4;
        }

        .payment-item-thumb {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            flex-shrink: 0;
            overflow: hidden;
            background: linear-gradient(135deg, #f4ece2 0%, #ece4d8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .payment-item-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .payment-item-info {
            flex: 1;
            min-width: 0;
        }

        .payment-item-info strong {
            display: block;
            font-size: 13px;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .payment-item-info span {
            font-size: 12px;
            color: var(--dark-gray);
        }

        .payment-item-price {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-dark);
            white-space: nowrap;
        }

        .payment-assurance-card {
            padding: 14px;
            margin-top: 14px;
            border-color: rgba(139, 111, 71, 0.18);
            background: linear-gradient(135deg, rgba(139, 111, 71, 0.05) 0%, rgba(255, 255, 255, 1) 100%);
        }

        .payment-assurance-card p,
        .payment-help-card p {
            font-size: 12px;
            color: var(--dark-gray);
        }

        .payment-trust-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin: 14px 0 2px;
        }

        .trust-chip {
            background: #fff;
            border: 1px solid #edf0f4;
            border-radius: 14px;
            padding: 10px 8px;
            text-align: center;
            font-size: 11px;
            color: var(--text-dark);
        }

        .trust-chip i {
            display: block;
            font-size: 16px;
            margin-bottom: 6px;
            color: var(--primary-brown);
        }

        .payment-help-card {
            padding: 14px;
            margin-top: 14px;
            text-align: center;
        }

        .payment-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(139, 111, 71, 0.1);
            color: var(--primary-brown);
            font-size: 11px;
            font-weight: 700;
            margin-top: 8px;
        }

        .payment-note {
            font-size: 12px;
            color: var(--dark-gray);
            margin: 8px 0 14px;
        }

        .bank-card {
            border: 1px solid rgba(139, 111, 71, 0.14);
            border-radius: 16px;
            background: linear-gradient(135deg, #fff8ec 0%, #fffdf8 100%);
            padding: 14px;
            margin-bottom: 14px;
        }

        .bank-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .bank-card-icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-brown);
            box-shadow: 0 6px 14px rgba(139, 111, 71, 0.08);
        }

        .bank-card-copy strong {
            display: block;
            font-size: 14px;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .bank-card-copy span,
        .bank-card-number,
        .bank-card-owner {
            font-size: 12px;
            color: var(--dark-gray);
        }

        .bank-card-number {
            margin-top: 12px;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 1px;
            color: var(--primary-brown);
        }

        .bank-card-owner {
            margin-top: 4px;
        }

        .bank-card-list {
            display: grid;
            gap: 10px;
            margin-bottom: 14px;
        }

        .bank-mini-card {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px;
            border: 1px solid #eef0f4;
            border-radius: 14px;
            background: var(--white);
        }

        .bank-mini-card i {
            color: var(--primary-brown);
            margin-top: 2px;
        }

        .bank-mini-card strong {
            display: block;
            font-size: 12px;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .bank-mini-card span {
            font-size: 11px;
            color: var(--dark-gray);
        }

        .upload-dropzone {
            display: flex;
            align-items: center;
            gap: 14px;
            width: 100%;
            padding: 16px;
            border: 1.5px dashed #d8c7b0;
            border-radius: 16px;
            background: #fcfaf5;
            cursor: pointer;
            margin-bottom: 14px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .upload-dropzone:hover {
            border-color: var(--primary-brown);
            background: #fffdf8;
        }

        .upload-dropzone.has-file {
            border-style: solid;
            background: linear-gradient(135deg, rgba(139, 111, 71, 0.07) 0%, rgba(255, 255, 255, 1) 100%);
        }

        .upload-dropzone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        .upload-dropzone-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: rgba(139, 111, 71, 0.1);
            color: var(--primary-brown);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .upload-dropzone-copy {
            min-width: 0;
            flex: 1;
        }

        .upload-dropzone-copy strong {
            display: block;
            font-size: 14px;
            color: var(--text-dark);
            margin-bottom: 3px;
        }

        .upload-dropzone-copy span {
            display: block;
            font-size: 12px;
            color: var(--dark-gray);
        }

        .payment-check {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 14px;
            border-radius: 14px;
            background: #faf7f2;
            border: 1px solid #eee2d1;
            margin-top: 14px;
            font-size: 12px;
            color: var(--text-dark);
        }

        .payment-check input {
            margin-top: 3px;
            accent-color: var(--primary-brown);
        }

        .payment-form .form-input {
            background: var(--white);
        }

        .payment-summary-note {
            margin-top: 10px;
            font-size: 12px;
            color: var(--dark-gray);
        }

        .payment-help-card a {
            color: var(--primary-brown);
            text-decoration: none;
            font-weight: 700;
        }

        .payment-modal-footer {
            padding: 16px 24px 24px;
            border-top: 1px solid rgba(229, 231, 235, 0.9);
            background: #fff;
            display: flex;
            gap: 14px;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .payment-modal-footer .btn {
            min-width: 180px;
            border-radius: 14px;
            padding: 14px 18px;
            font-size: 14px;
        }

        .payment-modal-footer .btn-primary {
            background: linear-gradient(135deg, #7b4fe9 0%, #5b35d3 100%);
            box-shadow: 0 14px 28px rgba(91, 53, 211, 0.18);
        }

        .payment-modal-footer .btn-primary:hover {
            background: linear-gradient(135deg, #6d41dc 0%, #4f2cc4 100%);
        }

        .payment-modal-footer .btn-secondary {
            background: #f5f6f9;
        }

        @media (max-width: 920px) {
            .payment-modal {
                padding: 14px;
            }

            .payment-modal .modal-content {
                max-height: calc(100vh - 28px);
            }

            .payment-modal-grid {
                grid-template-columns: 1fr;
                overflow-y: auto;
            }

            .payment-panel.methods {
                border-right: none;
                border-bottom: 1px solid rgba(229, 231, 235, 0.9);
            }

            .payment-modal-footer {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .payment-modal-footer .btn {
                width: 100%;
                min-width: 0;
            }
        }

        @media (max-width: 640px) {
            .payment-modal-header,
            .payment-panel,
            .payment-modal-footer {
                padding-left: 16px;
                padding-right: 16px;
            }

            .payment-modal-header {
                flex-direction: column;
            }

            .payment-security-note {
                width: 100%;
                justify-content: flex-start;
                text-align: left;
            }

            .payment-option {
                align-items: flex-start;
                padding-right: 12px;
            }

            .payment-option-tag {
                align-self: center;
            }

            .payment-trust-row {
                grid-template-columns: 1fr;
            }
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
            overflow: hidden;
            position: relative;
        }

        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .cart-item-image .cart-emoji {
            font-size: 24px;
        }

        .cart-item-image:not(.no-image) .cart-emoji {
            display: none;
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
            gap: 0;
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

        .nav-tab {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            width: 100%;
            border-radius: 12px;
            border: 1px solid transparent;
            background: transparent;
            color: #5b4530;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: var(--transition);
            text-align: left;
            text-decoration: none;
        }

        .nav-tab i {
            width: 18px;
            text-align: center;
            font-size: 13px;
        }

        .nav-tab:hover {
            background: #8b5a2b;
            color: var(--white);
        }

        .nav-tab.active {
            background: #8b5a2b;
            color: var(--white);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 0;
            width: 100%;
        }

        /* Welcome Section */
        .welcome-section {
            margin-bottom: 30px;
            position: relative;
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
            overflow: hidden;
            position: relative;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .product-image .product-emoji {
            font-size: 46px;
        }

        .product-image:not(.no-image) .product-emoji {
            display: none;
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
            width: 48px;
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
            overflow: hidden;
            position: relative;
        }

        .order-item-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .order-item-icon .order-emoji {
            font-size: 16px;
        }

        .order-item-icon:not(.no-image) .order-emoji {
            display: none;
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
            .dashboard-layout {
                flex-direction: column;
                padding: 16px;
            }

            .sidebar {
                width: 100%;
                position: static;
            }

            .header-container {
                flex-wrap: wrap;
                gap: 12px;
            }

            .header-logo {
                font-size: 16px;
            }

            .nav-tab {
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
    @stack('styles')
    </style>
</head>
<body>
    <div class="dashboard">
        {{-- @include('layouts.header', ['title' => 'Dashboard Pelanggan', 'showSearch' => false, 'showAddButton' => false, 'totalNotifikasi' => 1]) --}}

        <div class="dashboard-layout">
            <aside class="sidebar">
                <div class="sidebar-brand">
                  
                    <div class="brand-text">
                        <h1>Three D Bakery</h1>
                        <span>Freshly Baked Happiness</span>
                    </div>
                </div>

                <div class="user-card">
                    <div class="user-avatar">
                        @if(auth()->user()->foto_profil)
                            <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Avatar" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
                        @else
                            {{ strtoupper(substr(auth()->user()->username ?? 'P', 0, 1)) }}
                        @endif
                    </div>
                    <div class="user-name">{{ auth()->user()->username ?? 'Pelanggan' }}</div>
                    <div class="user-tier">
                        <i class="fas fa-crown"></i>
                        Sweet Member
                    </div>
                    <div class="user-email">{{ auth()->user()->email ?? '' }}</div>
                </div>

                <div class="sidebar-divider"></div>
                <div class="sidebar-section-title">Menu Pelanggan</div>

                <nav class="sidebar-nav">
                    <a href="{{ route('pelanggan.dashboard') }}" class="nav-tab {{ request()->routeIs('pelanggan.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        Beranda
                    </a>
                    <a href="{{ route('pelanggan.produk') }}" class="nav-tab {{ request()->routeIs('pelanggan.produk') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        Produk
                    </a>
                    <a href="/pelanggan/pesanan" class="nav-tab {{ request()->is('pelanggan/pesanan*') && request('status') !== 'selesai' ? 'active' : '' }}">
                        <i class="fas fa-shopping-bag"></i>
                        Pesanan Saya
                    </a>
                    <a href="{{ route('pelanggan.profile.edit') }}" class="nav-tab {{ request()->routeIs('pelanggan.profile.edit') ? 'active' : '' }}">
                        <i class="fas fa-user"></i>
                        Profil
                    </a>
                </nav>

                <div class="help-card">
                    <h4>Butuh Bantuan?</h4>
                    <p>Kami siap membantu setiap pertanyaanmu.</p>
                    <a class="help-btn" href="https://wa.me/" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-whatsapp"></i>
                        Hubungi Kami
                    </a>
                    <div class="user-email" style="margin-top: 8px;">08:00 - 20:00 WIB</div>
                </div>

                <div style="margin-top: auto;">
                    <x-logout-form buttonClass="nav-tab" style="width:100%;">
                        <span>Logout</span>
                    </x-logout-form>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="main-content">

                @yield('content')
        </main>
    </div>
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
    <div class="modal payment-modal" id="paymentModal">
        <div class="modal-content">
            <div class="payment-modal-header">
                <div class="payment-modal-title-wrap">
                    <div class="payment-modal-icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div>
                        <h2>Konfirmasi Pembayaran</h2>
                        <p>Silakan transfer lalu unggah bukti pembayaran agar pesanan diproses.</p>
                    </div>
                </div>
                <div class="payment-security-note">
                    <i class="fas fa-shield-alt"></i>
                    Verifikasi manual toko
                </div>
                <button class="modal-close" id="paymentModalClose" aria-label="Tutup modal">&times;</button>
            </div>

            <div class="payment-modal-grid">
                <div class="payment-panel methods">
                    <div class="payment-panel-title">Informasi Pembayaran</div>
                    <p class="payment-note">Bayar melalui rekening di bawah ini, lalu kirim bukti transfer untuk diverifikasi oleh tim kami.</p>

                    <div class="bank-card">
                        <div class="bank-card-header">
                            <div class="bank-card-icon"><i class="fas fa-landmark"></i></div>
                            <div class="bank-card-copy">
                                <strong>BCA</strong>
                                <span>Rekening tujuan Three D Bakery</span>
                            </div>
                        </div>
                        <div class="bank-card-number">1234 5678 90</div>
                        <div class="bank-card-owner">a.n. Three D Bakery</div>
                    </div>

                    <div class="bank-card-list">
                        <div class="bank-mini-card">
                            <i class="fas fa-circle-info"></i>
                            <div>
                                <strong>Wajib sesuai nominal</strong>
                                <span>Transfer harus sama dengan total tagihan agar cepat diverifikasi.</span>
                            </div>
                        </div>
                        <div class="bank-mini-card">
                            <i class="fas fa-clock"></i>
                            <div>
                                <strong>Verifikasi manual</strong>
                                <span>Bukti pembayaran akan dicek oleh admin pada jam operasional.</span>
                            </div>
                        </div>
                    </div>

                    <form class="payment-form" id="paymentForm" enctype="multipart/form-data" data-payment-endpoint="{{ route('pelanggan.pembayaran.konfirmasi') }}">
                        <input type="hidden" name="items" id="paymentItemsInput">
                        <input type="hidden" name="order_reference" id="paymentOrderReferenceInput">

                        <label class="upload-dropzone" id="proofDropzone" for="buktiTransferInput">
                            <input type="file" name="bukti_transfer" id="buktiTransferInput" accept=".jpg,.jpeg,.png,.pdf" required>
                            <div class="upload-dropzone-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                            <div class="upload-dropzone-copy">
                                <strong id="proofFileLabel">Pilih File</strong>
                                <span>JPG, PNG, atau PDF. Maksimal 2 MB.</span>
                            </div>
                        </label>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Nama Pengirim</label>
                                <input class="form-input" type="text" name="nama_pengirim" id="namaPengirimInput" placeholder="Masukkan nama pengirim">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Bank / E-Wallet Pengirim</label>
                                <input class="form-input" type="text" name="bank_pengirim" id="bankPengirimInput" placeholder="Contoh: BCA, Mandiri, ShopeePay">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Metode Pengambilan</label>
                            <div style="display: flex; gap: 16px; margin-top: 4px;">
                                <label style="display: flex; align-items: center; gap: 8px; font-weight: 400; cursor: pointer;">
                                    <input type="radio" name="metode_pengambilan" value="pickup" onchange="toggleMetodePengambilan()" checked>
                                    Pickup
                                </label>
                                <label style="display: flex; align-items: center; gap: 8px; font-weight: 400; cursor: pointer;">
                                    <input type="radio" name="metode_pengambilan" value="delivery" onchange="toggleMetodePengambilan()">
                                    Delivery
                                </label>
                            </div>
                        </div>

                        <div id="deliveryFields" style="display: none;" data-alamat="{{ auth()->user()->pelanggan->alamat ?? '' }}">
                            <div class="form-group">
                                <label class="form-label">Alamat Delivery</label>
                                <input class="form-input" type="text" name="alamat_delivery" id="alamatDeliveryInput" placeholder="Masukkan alamat lengkap pengiriman">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal Delivery</label>
                                <input class="form-input" type="date" name="tgl_delivery" id="tglDeliveryInput">
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Nominal Transfer</label>
                                <input class="form-input" type="number" name="nominal_transfer" id="nominalTransferInput" min="0" readonly>
                                <div class="payment-summary-note">Sesuai total tagihan yang tampil di ringkasan.</div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Catatan (Opsional)</label>
                                <input class="form-input" type="text" name="catatan_pembayaran" id="catatanPembayaranInput" placeholder="Contoh: transfer pagi, atas nama saya">
                            </div>
                        </div>

                        <label class="payment-check">
                            <input type="checkbox" id="paymentConfirmCheckbox">
                            <span>Saya telah melakukan transfer sesuai total tagihan dan mengunggah bukti pembayaran yang valid.</span>
                        </label>
                    </form>
                </div>

                <div class="payment-panel summary">
                    <div class="payment-summary-card">
                        <h3>Ringkasan Pesanan</h3>
                        <div class="payment-status-pill"><i class="fas fa-hourglass-half"></i> Menunggu verifikasi</div>
                        <div class="payment-summary-row">
                            <span>Order ID</span>
                            <strong id="paymentOrderId">#TRX-0000</strong>
                        </div>
                        <div class="payment-summary-row">
                            <span>Total Belanja</span>
                            <strong id="paymentSubtotal">Rp 0</strong>
                        </div>
                        <div class="payment-summary-total">
                            <span>Total Pembayaran</span>
                            <strong id="paymentTotal">Rp 0</strong>
                        </div>
                    </div>

                    <div class="payment-detail-card">
                        <h3>Detail Pesanan</h3>
                        <div class="payment-order-list" id="paymentOrderItems">
                            <div style="font-size: 13px; color: var(--dark-gray);">Belum ada item di keranjang</div>
                        </div>
                    </div>

                    <div class="payment-assurance-card">
                        <h3>Keamanan & Verifikasi</h3>
                        <p>Bukti pembayaran disimpan dengan aman dan hanya digunakan untuk pengecekan manual oleh admin toko.</p>
                        <div class="payment-trust-row">
                            <div class="trust-chip"><i class="fas fa-shield-alt"></i>Data Aman</div>
                            <div class="trust-chip"><i class="fas fa-bolt"></i>Respon Cepat</div>
                            <div class="trust-chip"><i class="fas fa-user-check"></i>Verifikasi Manual</div>
                        </div>
                    </div>

                    <div class="payment-help-card">
                        <h3>Butuh bantuan?</h3>
                        <p>Hubungi kami di 0822-xxxx-xxxx atau email <a href="mailto:support@threedbakery.com">support@threedbakery.com</a> jika bukti transfer bermasalah.</p>
                    </div>
                </div>
            </div>

            <div class="payment-modal-footer">
                <button class="btn btn-secondary" id="backToCartBtn">
                    <i class="fas fa-arrow-left"></i> Kembali Belanja
                </button>
                <button class="btn btn-primary" id="submitPaymentBtn" type="button">
                    <i class="fas fa-paper-plane"></i> Kirim Bukti Pembayaran
                </button>
            </div>
        </div>
    </div>

    <script>
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

        @stack('scripts')
    </script>
</body>
</html>
