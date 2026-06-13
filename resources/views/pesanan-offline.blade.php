@extends('layouts.dashboard-layout', ['pageTitle' => 'Pesanan Offline', 'showAddButton' => true, 'totalNotifikasi' => 3])

@section('additional-styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<style>
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

        /* Status badges untuk Pelanggan */
        .status-badge.diproses {
            background: rgba(255, 193, 7, 0.1);
            color: #FFC107;
        }

        .status-badge.selesai {
            background: rgba(76, 175, 80, 0.1);
            color: #4CAF50;
        }

        /* Status badges untuk Karyawan */
        .status-badge.belum_setor {
            background: rgba(255, 152, 0, 0.1);
            color: #FF9800;
        }

        .status-badge.sudah_setor {
            background: rgba(76, 175, 80, 0.1);
            color: #4CAF50;
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

        /* Inline Edit */
        .inline-editable {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            padding: 2px 4px;
            border-radius: 4px;
            transition: background 0.2s;
        }
        .inline-editable:hover {
            background: rgba(0,0,0,0.04);
        }
        .inline-editable .edit-icon {
            font-size: 10px;
            color: var(--dark-gray);
            opacity: 0;
            transition: opacity 0.2s;
        }
        .inline-editable:hover .edit-icon {
            opacity: 1;
        }
        .inline-editable.editing select {
            padding: 4px 8px;
            border: 1px solid var(--primary-brown);
            border-radius: 4px;
            font-size: 12px;
            font-family: inherit;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }
        .badge-lunas { background: rgba(34, 197, 94, 0.1); color: #22C55E; }
        .badge-belum-lunas { background: rgba(239, 68, 68, 0.1); color: #EF4444; }
        .badge-menunggu { background: rgba(245, 158, 11, 0.1); color: #F59E0B; }
        .status-menunggu-konfirmasi { background: rgba(245, 158, 11, 0.1); color: #F59E0B; }
        .status-diproses { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }
        .status-siap-diambil { background: rgba(34, 197, 94, 0.1); color: #22C55E; }
        .status-dikirim { background: rgba(139, 92, 246, 0.1); color: #8B5CF6; }
        .status-selesai { background: rgba(20, 184, 166, 0.1); color: #14B8A6; }

        /* Order Number */
        .order-number {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 13px;
        }

        /* Customer Info */
        .customer-info .customer-name {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 13px;
        }
        .customer-info .customer-phone {
            font-size: 12px;
            color: var(--dark-gray);
            margin-top: 2px;
        }

        /* Time Info */
        .time-info .time-date {
            font-weight: 500;
            color: var(--text-dark);
            font-size: 13px;
        }
        .time-info .time-hour {
            font-size: 12px;
            color: var(--dark-gray);
            margin-top: 2px;
        }

        /* Action Group */
        .action-group {
            display: flex;
            gap: 8px;
        }
        .btn-action {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
            border: 1px solid var(--medium-gray);
            background: var(--white);
            color: var(--text-dark);
        }
        .btn-action:hover {
            background: var(--light-gray);
            border-color: var(--dark-gray);
        }
        .btn-action-primary {
            background: linear-gradient(135deg, var(--primary-brown), #D4A574);
            color: var(--white);
            border: none;
        }
        .btn-action-primary:hover {
            background: linear-gradient(135deg, #6B4F33, #c49557);
            box-shadow: 0 2px 6px rgba(139, 111, 71, 0.2);
        }

        /* Bukti Transfer Modal */
        #modalBuktiTransfer {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.6);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }
        #modalBuktiTransfer.show {
            display: flex;
        }
        .bukti-modal-content {
            background: var(--white);
            border-radius: var(--border-radius-xl);
            padding: 24px;
            max-width: 500px;
            width: 90%;
            text-align: center;
        }
</style>
@endsection

@section('content')

            <!-- Content -->
            <div class="content">
                <!-- Summary Stats -->
                <section class="stats-grid" id="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-icon blue">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-card-label">Total Pesanan</div>
                        <div class="stat-card-value" id="total-pesanan">{{ $stats['total'] ?? 0 }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-icon orange">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="stat-card-label">Pesanan Diproses</div>
                        <div class="stat-card-value" id="pesanan-diproses">{{ $stats['diproses'] ?? 0 }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-icon green">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-card-label">Pesanan Selesai</div>
                        <div class="stat-card-value" id="pesanan-selesai">{{ $stats['selesai'] ?? 0 }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-icon purple">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="stat-card-label">Total Revenue</div>
                        <div class="stat-card-value" id="total-revenue">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
                    </div>
                </section>

                <!-- Tabs -->
                <div class="tabs">
                    <button class="tab" onclick="switchTab('pelanggan')">
                        <i class="fas fa-user"></i> Pesanan Pelanggan
                    </button>
                    <button class="tab" onclick="switchTab('karyawan')">
                        <i class="fas fa-users"></i> Pesanan Karyawan
                    </button>
                </div>

                <!-- Pesanan Pelanggan Tab -->
                <div id="tab-pelanggan" class="tab-content active">
                    <div class="table-section">
                        <div class="table-toolbar">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="searchPelanggan" placeholder="Cari nama pelanggan, No HP...">
                            </div>
                            <div style="display: flex; gap: 12px; align-items: center;">
                                <label style="font-size: 13px; font-weight: 500;">Filter Status:</label>
                                <select class="form-control" id="filterPelanggan" onchange="filterTable('pelanggan')" style="max-width: 200px; padding: 8px 12px;">
                                    <option value="">Semua</option>
                                    <option value="menunggu_konfirmasi">Menunggu Konfirmasi</option>
                                    <option value="diproses">Diproses</option>
                                    <option value="siap_diambil">Siap Diambil</option>
                                    <option value="dikirim">Dikirim</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <table id="tablePelanggan">
                            <thead>
                                <tr>
                                    <th>No. Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Produk</th>
                                    <th>Total</th>
                                    <th>Pembayaran</th>
                                    <th>Status</th>
                                    <th>Bukti Transfer</th>
                                    <th>Waktu</th>
                                    <th style="min-width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bodyPelanggan">
                                <tr>
                                    <td colspan="9" style="text-align: center; color: var(--dark-gray); padding: 40px;">
                                        <i class="fas fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                                        Belum ada pesanan pelanggan
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="paginationPelanggan" class="pagination-container"></div>
                    </div>
                </div>

                <!-- Pesanan Karyawan Tab -->
                <div id="tab-karyawan" class="tab-content">
                    <div class="table-section">
                        <div class="table-toolbar">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="searchKaryawan" placeholder="Cari nama karyawan, ID pesanan...">
                            </div>
                            <div class="filter-group">
                                <label style="font-size: 13px; font-weight: 500;">Filter Status:</label>
                                <select class="form-control" id="filterKaryawan" onchange="filterTable('karyawan')">
                                    <option value="">Semua</option>
                                    <option value="belum_setor">Belum Setor</option>
                                    <option value="sudah_setor">Sudah Setor</option>
                                </select>
                            </div>
                        </div>
                        <table id="tableKaryawan">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Nama Karyawan</th>
                                    <th>Total Barang</th>
                                    <th>Status Setor</th>
                                    <th>Tanggal Ambil</th>
                                    <th style="min-width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bodyKaryawan">
                                <tr>
                                    <td colspan="6" style="text-align: center; color: var(--dark-gray); padding: 40px;">
                                        <i class="fas fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                                        Belum ada pesanan karyawan
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="paginationKaryawan" class="pagination-container"></div>
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
                        <label class="form-label">Nama Karyawan<span style="color: var(--red);">*</span></label>
                        <select class="form-control" id="namaKaryawan" style="width: 100%;">
                            <option value="">Cari nama karyawan...</option>
                        </select>
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
                        <select class="form-control" id="namaPelanggan" style="width: 100%;">
                            <option value="">Cari nama pelanggan...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">No HP <span style="color: var(--red);">*</span></label>
                        <input type="tel" class="form-control" id="noHpPelanggan" placeholder="Otomatis terisi" readonly>
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

    <!-- Modal Bukti Transfer -->
    <div id="modalBuktiTransfer" onclick="closeModalBuktiTransfer()">
        <div class="bukti-modal-content" onclick="event.stopPropagation()">
            <h4 style="margin-bottom: 16px;">Bukti Transfer</h4>
            <img id="buktiTransferImage" src="" alt="Bukti Transfer" style="max-width: 100%; border-radius: 8px;" />
            <button class="btn-cancel" style="margin-top: 16px;" onclick="closeModalBuktiTransfer()">Tutup</button>
        </div>
    </div>

    <!-- Pagination Styles -->
    <style>
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            border-top: 1px solid var(--medium-gray);
            margin-top: 8px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .pagination-info {
            font-size: 13px;
            color: var(--dark-gray);
        }
        .pagination-nav {
            display: flex;
            gap: 4px;
        }
        .pagination-nav .page-btn {
            min-width: 36px;
            height: 36px;
            padding: 0 10px;
            border: 1px solid var(--medium-gray);
            background: var(--white);
            color: var(--text-dark);
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            text-decoration: none;
        }
        .pagination-nav .page-btn:hover:not(.disabled):not(.active) {
            background: var(--light-cream);
            border-color: var(--light-brown);
            color: var(--primary-brown);
        }
        .pagination-nav .page-btn.active {
            background: var(--light-brown);
            border-color: var(--light-brown);
            color: var(--white);
            cursor: default;
        }
        .pagination-nav .page-btn.disabled {
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
@endsection

@section('additional-scripts')
<script>
        // Data structure untuk karyawan dan pelanggan
        let pesananData = {
            karyawan: [],
            pelanggan: []
        };
        let currentTab = new URLSearchParams(window.location.search).get('tab') || 'pelanggan';
        let productCount = 0;
        const ITEMS_PER_PAGE = 10;
        let paginationState = {
            karyawan: { currentPage: 1, perPage: ITEMS_PER_PAGE },
            pelanggan: { currentPage: 1, perPage: ITEMS_PER_PAGE }
        };
        let filteredData = {
            karyawan: null,
            pelanggan: null
        };
        let masterProduk = [];
        let editingId = null;
        let editingType = null;

        function getData(type) {
            return filteredData[type] || pesananData[type];
        }

        function formatHarga(num) {
            return Number(num).toLocaleString('id-ID');
        }

        async function loadMasterProduk() {
            try {
                const res = await fetch('/api/produks');
                const data = await res.json();
                masterProduk = Array.isArray(data) ? data : (data.data || []);
            } catch (e) {
                console.error('Gagal load master produk:', e);
            }
        }

        // Inisialisasi data dari server (database)
        pesananData.karyawan = @json($karyawanItems);
        pesananData.pelanggan = @json($pelangganItems);

        // Inisialisasi
        document.addEventListener('DOMContentLoaded', function() {
            currentTab = new URLSearchParams(window.location.search).get('tab') || 'pelanggan';
            updateTabUI();
            loadMasterProduk();
            renderTables();
            setupSearch();
            updateStats();
        });

        window.addEventListener('popstate', function() {
            const tab = new URLSearchParams(window.location.search).get('tab') || 'pelanggan';
            if (tab !== currentTab) {
                currentTab = tab;
                updateTabUI();
            }
        });

        // Render Tables
        function renderTables() {
            renderKaryawanTable();
            renderPelangganTable();
            updateStats();
        }

        function renderKaryawanTable() {
            const tbody = document.getElementById('bodyKaryawan');
            const pag = paginationState.karyawan;
            const data = getData('karyawan');
            const totalItems = data.length;
            const totalPages = Math.max(1, Math.ceil(totalItems / pag.perPage));
            if (pag.currentPage > totalPages) pag.currentPage = totalPages;

            if (totalItems === 0) {
                tbody.innerHTML = `<tr><td colspan="6" style="text-align: center; color: var(--dark-gray); padding: 40px;">
                    <i class="fas fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                    Belum ada pesanan karyawan
                </td></tr>`;
                document.getElementById('paginationKaryawan').innerHTML = '';
                return;
            }

            const start = (pag.currentPage - 1) * pag.perPage;
            const end = start + pag.perPage;
            const pageItems = data.slice(start, end);

            tbody.innerHTML = pageItems.map(item => {
                const totalBarang = item.produk ? item.produk.reduce((sum, p) => sum + (p.qty || 0), 0) : 0;
                const statusBadge = item.status === 'sudah_setor' ? 'sudah_setor' : 'belum_setor';
                const statusText = item.status === 'sudah_setor' ? 'Sudah Setor' : 'Belum Setor';
                const isSudahSetor = item.status === 'sudah_setor';

                return `
                <tr data-status="${item.status || 'belum_setor'}">
                    <td>${item.id}</td>
                    <td>${item.nama}</td>
                    <td>${totalBarang}</td>
                    <td><span class="status-badge ${statusBadge}">${statusText}</span></td>
                    <td>${item.tanggal_pickup || '-'}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="showDetail('karyawan', '${item.id}')" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            ${isSudahSetor ? '' : `
                            <button class="btn-icon" onclick="openEditModal('karyawan', '${item.id}')" title="Edit Pesanan">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button class="btn-icon" onclick="markComplete('karyawan', '${item.id}')" title="Checklist Setor">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn-icon delete" onclick="deletePesanan('karyawan', '${item.id}')" title="Hapus Pesanan">
                                <i class="fas fa-trash"></i>
                            </button>
                            `}
                            <button class="btn-icon" onclick="downloadInvoice('karyawan', '${item.id}')" title="Download Invoice">
                                <i class="fas fa-file-invoice"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `}).join('');

            renderPagination('paginationKaryawan', pag, totalItems, 'karyawan');
        }

        function renderPelangganTable() {
            const tbody = document.getElementById('bodyPelanggan');
            const pag = paginationState.pelanggan;
            const data = getData('pelanggan');
            const totalItems = data.length;
            const totalPages = Math.max(1, Math.ceil(totalItems / pag.perPage));
            if (pag.currentPage > totalPages) pag.currentPage = totalPages;

            if (totalItems === 0) {
                tbody.innerHTML = `<tr><td colspan="9" style="text-align: center; color: var(--dark-gray); padding: 40px;">
                    <i class="fas fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                    Belum ada pesanan pelanggan
                </td></tr>`;
                document.getElementById('paginationPelanggan').innerHTML = '';
                return;
            }

            const start = (pag.currentPage - 1) * pag.perPage;
            const end = start + pag.perPage;
            const pageItems = data.slice(start, end);

            const statusPesananMap = {
                'menunggu_konfirmasi': { cls: 'status-menunggu-konfirmasi', label: 'Menunggu Konfirmasi' },
                'diproses': { cls: 'status-diproses', label: 'Diproses' },
                'siap_diambil': { cls: 'status-siap-diambil', label: 'Siap Diambil' },
                'dikirim': { cls: 'status-dikirim', label: 'Dikirim' },
                'selesai': { cls: 'status-selesai', label: 'Selesai' },
            };

            const statusBayarMap = {
                'lunas': { cls: 'badge-lunas', label: 'Lunas' },
                'menunggu_verifikasi': { cls: 'badge-menunggu', label: 'Menunggu' },
                'belum_bayar': { cls: 'badge-belum-lunas', label: 'Belum Lunas' },
            };

            tbody.innerHTML = pageItems.map((item, index) => {
                const isSelesai = item.status_pesanan === 'selesai';
                const statusBayar = statusBayarMap[item.status_pembayaran] ||
                    (item.status_bayar === 'lunas' ? statusBayarMap['lunas'] : statusBayarMap['belum_bayar']);
                const statusPesanan = statusPesananMap[item.status_pesanan] || statusPesananMap['menunggu_konfirmasi'];

                const orderDate = item.tgl_transaksi || '';
                const dateParts = orderDate.split('-');
                const orderNo = `#OFF-${dateParts[2] || ''}${dateParts[1] || ''}${dateParts[0]?.slice(2) || ''}-${String(item.id_pesanan).padStart(3, '0')}`;

                const bayarHTML = isSelesai
                    ? `<div><span class="badge ${statusBayar.cls}">${statusBayar.label}</span></div>`
                    : `<div class="inline-editable" onclick="startInlineEditOffline(this, 'pembayaran', '${item.id}')">
                        <span class="badge ${statusBayar.cls}">${statusBayar.label}</span>
                        <i class="fas fa-pen edit-icon"></i>
                    </div>`;

                const statusHTML = isSelesai
                    ? `<div><span class="badge ${statusPesanan.cls}">${statusPesanan.label}</span></div>`
                    : `<div class="inline-editable" onclick="startInlineEditOffline(this, 'status', '${item.id}')">
                        <span class="badge ${statusPesanan.cls}">${statusPesanan.label}</span>
                        <i class="fas fa-pen edit-icon"></i>
                    </div>`;

                const buktiHTML = item.bukti_transfer
                    ? `<button class="btn-action btn-action-primary" onclick="showBuktiTransferOffline('${item.bukti_transfer}')">
                        <i class="fas fa-image"></i> Lihat
                    </button>`
                    : `<span style="color: var(--dark-gray); font-size: 13px;">-</span>`;

                const submitBtn = isSelesai ? '' : `<button class="btn-action btn-action-primary" onclick="submitOrderOffline('${item.id}')">Submit</button>`;

                return `
                <tr>
                    <td><span class="order-number">${orderNo}</span></td>
                    <td>
                        <div class="customer-info">
                            <div class="customer-name">${item.nama}</div>
                            <div class="customer-phone">${item.no_hp || '-'}</div>
                        </div>
                    </td>
                    <td>${item.total_item || 0} item</td>
                    <td><strong>Rp ${(item.total).toLocaleString('id-ID')}</strong></td>
                    <td>${bayarHTML}</td>
                    <td>${statusHTML}</td>
                    <td>${buktiHTML}</td>
                    <td>
                        <div class="time-info">
                            <div class="time-date">${orderDate.split('-').reverse().join('/')}</div>
                            <div class="time-hour">${item.waktu || '00:00'} WIB</div>
                        </div>
                    </td>
                    <td>
                        <div class="action-group">
                            <button class="btn-action" onclick="showDetail('pelanggan', '${item.id}')">Detail</button>
                            ${submitBtn}
                        </div>
                    </td>
                </tr>
            `}).join('');

            renderPagination('paginationPelanggan', pag, totalItems, 'pelanggan');
        }

        // Pagination Functions
        function renderPagination(containerId, pag, totalItems, type) {
            const container = document.getElementById(containerId);
            const totalPages = Math.max(1, Math.ceil(totalItems / pag.perPage));
            const currentPage = pag.currentPage;
            const startItem = totalItems === 0 ? 0 : (currentPage - 1) * pag.perPage + 1;
            const endItem = Math.min(currentPage * pag.perPage, totalItems);

            let pagesHtml = '';
            // Previous
            pagesHtml += `<button class="page-btn ${currentPage === 1 ? 'disabled' : ''}" onclick="goToPage('${type}', ${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>&laquo;</button>`;
            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                pagesHtml += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="goToPage('${type}', ${i})">${i}</button>`;
            }
            // Next
            pagesHtml += `<button class="page-btn ${currentPage === totalPages ? 'disabled' : ''}" onclick="goToPage('${type}', ${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>&raquo;</button>`;

            container.innerHTML = `
                <div class="pagination-info">
                    Menampilkan ${startItem} sampai ${endItem} dari ${totalItems} pesanan
                </div>
                <div class="pagination-nav">
                    ${pagesHtml}
                </div>
            `;
        }

        function goToPage(type, page) {
            paginationState[type].currentPage = page;
            if (type === 'karyawan') {
                renderKaryawanTable();
            } else {
                renderPelangganTable();
            }
        }

        // Tab Switching
        function switchTab(tab) {
            if (tab === currentTab) return;
            if (!['pelanggan', 'karyawan'].includes(tab)) tab = 'pelanggan';
            currentTab = tab;
            updateTabUI();
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            history.pushState({}, '', url);
        }

        function updateTabUI() {
            document.querySelectorAll('.tab').forEach(t => {
                t.classList.toggle('active', t.getAttribute('onclick').includes("'" + currentTab + "'"));
            });
            document.querySelectorAll('.tab-content').forEach(c => {
                c.classList.toggle('active', c.id === 'tab-' + currentTab);
            });
        }

        // Modal Functions
        function resetModal() {
            editingId = null;
            editingType = null;
            productCount = 0;
            document.getElementById('productList').innerHTML = '';
            document.getElementById('totalPesanan').textContent = 'Rp 0';
            document.querySelector('input[name="tipePesanan"][value="karyawan"]').checked = true;
            document.querySelector('input[name="metodeMetode"][value="pickup"]').checked = true;
            document.querySelector('input[name="metodePayment"][value="cash"]').checked = true;
            document.getElementById('buktiBayar').value = '';
            document.getElementById('noHpPelanggan').value = '';
            document.getElementById('alamatDelivery').value = '';
            document.getElementById('tanggalDelivery').value = '';
            document.getElementById('tanggalPickupKaryawan').value = '';
            document.getElementById('tanggalPickupPelanggan').value = '';
            document.getElementById('modalTitleAdd').textContent = 'Tambah Pesanan';
            document.querySelectorAll('input[name="tipePesanan"]').forEach(el => el.disabled = false);
            setTimeout(() => {
                if (typeof $ !== 'undefined') {
                    if ($('#namaKaryawan').data('select2')) $('#namaKaryawan').val(null).trigger('change');
                    if ($('#namaPelanggan').data('select2')) $('#namaPelanggan').val(null).trigger('change');
                }
            }, 200);
        }

        function openAddModal() {
            resetModal();
            document.getElementById('modalAddPesanan').classList.add('show');
            changePesananType();
            changeMetode();
            changePaymentMethod();
        }

        function openEditModal(type, pesananId) {
            const pesanan = pesananData[type].find(p => p.id === pesananId);
            if (!pesanan) return;

            editingId = pesanan.id_pesanan;
            editingType = type;
            resetModal();

            document.getElementById('modalTitleAdd').textContent = 'Edit Pesanan';
            document.getElementById('modalAddPesanan').classList.add('show');

            // Lock tipe pesanan
            document.querySelectorAll('input[name="tipePesanan"]').forEach(el => {
                el.checked = (el.value === type);
                el.disabled = true;
            });
            changePesananType();

            if (type === 'karyawan') {
                document.getElementById('tanggalPickupKaryawan').value = pesanan.tanggal_pickup || '';
                // Pre-fill Select2 karyawan
                setTimeout(() => {
                    if (typeof $ !== 'undefined' && pesanan.id_karyawan) {
                        const $sel = $('#namaKaryawan');
                        if ($sel.data('select2')) {
                            const option = new Option(pesanan.nama, pesanan.id_karyawan, true, true);
                            $sel.empty().append(option).trigger('change');
                        }
                    }
                }, 300);
            } else {
                document.getElementById('noHpPelanggan').value = pesanan.no_hp || '';
                document.getElementById('tanggalPickupPelanggan').value = pesanan.tanggal_pickup || '';

                // Metode
                const metode = pesanan.metode_pengambilan || 'pickup';
                document.querySelector(`input[name="metodeMetode"][value="${metode}"]`).checked = true;
                changeMetode();

                if (metode === 'delivery') {
                    document.getElementById('alamatDelivery').value = pesanan.alamat_delivery || '';
                    document.getElementById('tanggalDelivery').value = pesanan.tanggal_delivery || '';
                }

                // Payment
                const payment = pesanan.metode_pembayaran || 'cash';
                document.querySelector(`input[name="metodePayment"][value="${payment}"]`).checked = true;
                changePaymentMethod();

                // Pre-fill Select2 pelanggan
                setTimeout(() => {
                    if (typeof $ !== 'undefined' && pesanan.id_pelanggan) {
                        const $sel = $('#namaPelanggan');
                        if ($sel.data('select2')) {
                            const option = new Option(pesanan.nama + '_' + pesanan.no_hp, pesanan.id_pelanggan, true, true);
                            option.no_tlp = pesanan.no_hp;
                            $sel.empty().append(option).trigger('change');
                        }
                    }
                }, 300);
            }

            // Pre-fill products
            if (pesanan.produk && pesanan.produk.length > 0) {
                pesanan.produk.forEach(pr => {
                    addProductRow();
                    const lastRow = document.getElementById('productList').lastElementChild;
                    if (lastRow) {
                        const select = lastRow.querySelector('select');
                        const input = lastRow.querySelector('input[type="number"]');
                        if (select && pr.id_produk) {
                            const option = select.querySelector(`option[value^="${pr.id_produk}|"]`);
                            if (option) option.selected = true;
                        }
                        if (input) input.value = pr.qty || 1;
                    }
                });
                updateTotal();
            }
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
            resetModal();
        }

        function changePesananType() {
            const type = document.querySelector('input[name="tipePesanan"]:checked').value;
            if (type === 'karyawan') {
                document.getElementById('formKaryawan').style.display = 'block';
                document.getElementById('formPelanggan').style.display = 'none';
                setTimeout(() => {
                    if (typeof $ !== 'undefined' && !$('#namaKaryawan').data('select2')) {
                        $('#namaKaryawan').select2({
                            placeholder: 'Cari nama karyawan...',
                            allowClear: true,
                            dropdownParent: $('#modalAddPesanan'),
                            ajax: {
                                url: '/api/karyawans-autocomplete',
                                dataType: 'json',
                                delay: 300,
                                data: function(p) { return { q: p.term }; },
                                processResults: function(d) { return { results: d.results }; },
                                cache: true
                            },
                            minimumInputLength: 1,
                            width: '100%'
                        });
                    }
                }, 100);
            } else {
                document.getElementById('formKaryawan').style.display = 'none';
                document.getElementById('formPelanggan').style.display = 'block';
                setTimeout(() => {
                    if (typeof $ !== 'undefined' && !$('#namaPelanggan').data('select2')) {
                        $('#namaPelanggan').select2({
                            placeholder: 'Cari nama pelanggan...',
                            allowClear: true,
                            dropdownParent: $('#modalAddPesanan'),
                            ajax: {
                                url: '/api/pelanggans-autocomplete',
                                dataType: 'json',
                                delay: 300,
                                data: function(p) { return { q: p.term }; },
                                processResults: function(d) { return { results: d.results }; },
                                cache: true
                            },
                            minimumInputLength: 1,
                            width: '100%'
                        });
                    }
                }, 100);
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
            const options = masterProduk.length > 0
                ? masterProduk.map(p =>
                    `<option value="${p.id_produk}|${p.harga_produk}|${p.nama_produk}">${p.nama_produk} - Rp ${formatHarga(p.harga_produk)}</option>`
                  ).join('')
                : '<option value="">-- Tidak ada produk --</option>';
            productRow.innerHTML = `
                <div class="product-item-controls" style="flex: 1;">
                    <label>Pilih Produk</label>
                    <select class="form-control" onchange="updateTotal()">
                        <option value="">-- Pilih Produk --</option>
                        ${options}
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
                    const parts = select.value.split('|');
                    const price = parseInt(parts[1]);
                    total += price * parseInt(input.value);
                }
            });
            document.getElementById('totalPesanan').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        async function savePesanan() {
            const type = document.querySelector('input[name="tipePesanan"]:checked').value;
            const productCount = document.querySelectorAll('.product-item').length;

            if (productCount === 0) {
                showToast('Silakan tambahkan minimal 1 produk', 'error');
                return;
            }

            const produk = [];
            document.querySelectorAll('.product-item').forEach(p => {
                const select = p.querySelector('select');
                const input = p.querySelector('input[type="number"]');
                if (select.value && input.value) {
                    const parts = select.value.split('|');
                    produk.push({
                        id_produk: parseInt(parts[0]),
                        jumlah_pesan: parseInt(input.value)
                    });
                }
            });

            const totalAmount = produk.reduce((sum, p) => {
                const item = masterProduk.find(mp => mp.id_produk == p.id_produk);
                return sum + ((item ? item.harga_produk : 0) * p.jumlah_pesan);
            }, 0);

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

            // EDIT MODE
            if (editingId) {
                let payload = {
                    total_bayar: totalAmount,
                    products: produk
                };

                const tglPickup = document.getElementById(type === 'karyawan' ? 'tanggalPickupKaryawan' : 'tanggalPickupPelanggan').value;
                if (tglPickup) payload.tgl_pesan = tglPickup;

                if (type === 'pelanggan') {
                    const metode = document.querySelector('input[name="metodeMetode"]:checked').value;
                    const metodePayment = document.querySelector('input[name="metodePayment"]:checked').value;
                    payload.metode_pengambilan = metode;
                    payload.metode_pembayaran = metodePayment;
                    payload.status_pembayaran = metodePayment === 'cash' ? 'lunas' : 'menunggu_verifikasi';
                    payload.status_bayar = metodePayment === 'cash' ? 'lunas' : 'belum_lunas';

                    if (metode === 'delivery') {
                        const alamat = document.getElementById('alamatDelivery').value.trim();
                        const tglDelivery = document.getElementById('tanggalDelivery').value;
                        if (!alamat || !tglDelivery) {
                            showToast('Silakan isi alamat dan tanggal delivery', 'error');
                            return;
                        }
                        payload.alamat_delivery = alamat;
                        payload.tgl_delivery = tglDelivery;
                    }
                }

                try {
                    const response = await fetch(`/pesanan-offline/${editingId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    });

                    const result = await response.json();
                    if (result.success) {
                        showToast('Pesanan berhasil diperbarui', 'success');
                        closeModal('modalAddPesanan');
                        setTimeout(() => window.location.reload(), 600);
                    } else {
                        showToast(result.message || 'Gagal memperbarui pesanan', 'error');
                    }
                } catch (err) {
                    showToast('Terjadi kesalahan: ' + err.message, 'error');
                }
                return;
            }

            // CREATE MODE
            let payload = {
                tipe_pesanan: type,
                tgl_pesan: new Date().toISOString().split('T')[0],
                total_bayar: totalAmount,
                products: produk
            };

            if (type === 'karyawan') {
                const karyawanData = $('#namaKaryawan').select2('data')[0];
                const idKaryawan = karyawanData?.id;
                const nama = karyawanData?.text?.split(' (')[0] || '';

                if (!idKaryawan || !document.getElementById('tanggalPickupKaryawan').value) {
                    showToast('Silakan pilih karyawan dan tanggal pickup', 'error');
                    return;
                }

                payload.id_karyawan = parseInt(idKaryawan);
                payload.nama_karyawan = nama;
                payload.status_bayar = 'belum_lunas';
            } else {
                const metode = document.querySelector('input[name="metodeMetode"]:checked').value;
                const metodePayment = document.querySelector('input[name="metodePayment"]:checked').value;
                const pelangganData = $('#namaPelanggan').select2('data')[0];
                const idPelanggan = pelangganData?.id;
                const nama = pelangganData?.text?.split(' (')[0] || '';
                const noHp = pelangganData?.no_tlp || document.getElementById('noHpPelanggan').value;

                if (!idPelanggan || !noHp) {
                    showToast('Silakan pilih pelanggan', 'error');
                    return;
                }

                payload.id_pelanggan = parseInt(idPelanggan);
                payload.nama_pelanggan = nama;
                payload.no_tlp = noHp;
                payload.metode_pengambilan = metode;
                payload.metode_pembayaran = metodePayment;
                payload.status_pembayaran = metodePayment === 'cash' ? 'lunas' : 'menunggu_verifikasi';
                payload.status_bayar = metodePayment === 'cash' ? 'lunas' : 'belum_lunas';

                if (metode === 'delivery') {
                    const alamat = document.getElementById('alamatDelivery').value.trim();
                    const tglDelivery = document.getElementById('tanggalDelivery').value;
                    if (!alamat || !tglDelivery) {
                        showToast('Silakan isi alamat dan tanggal delivery', 'error');
                        return;
                    }
                    payload.alamat_delivery = alamat;
                    payload.tgl_delivery = tglDelivery;
                } else {
                    const tglPickup = document.getElementById('tanggalPickupPelanggan').value;
                    if (!tglPickup) {
                        showToast('Silakan isi tanggal pickup', 'error');
                        return;
                    }
                    payload.tgl_pesan = tglPickup;
                }
            }

            try {
                const response = await fetch('/pesanan-offline', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();
                if (result.success) {
                    showToast(type === 'karyawan' ? 'Pesanan karyawan berhasil dibuat' : 'Pesanan pelanggan berhasil dibuat', 'success');
                    closeModal('modalAddPesanan');
                    setTimeout(() => window.location.reload(), 600);
                } else {
                    showToast(result.message || 'Gagal menyimpan pesanan', 'error');
                }
            } catch (err) {
                showToast('Terjadi kesalahan: ' + err.message, 'error');
            }
        }

        function showDetail(type, pesananId) {
            const detailContent = document.getElementById('detailContent');

            if (type === 'pelanggan') {
                const pesanan = pesananData.pelanggan.find(p => p.id === pesananId);
                if (!pesanan) return;

                const metodePickup = pesanan.metode_pengambilan === 'delivery' ?
                    pesanan.tanggal_delivery : pesanan.tanggal_pickup;

                let produkHTML = pesanan.produk.map(p => `
                    <tr>
                        <td>${p.nama}</td>
                        <td style="text-align: center;">${p.qty}</td>
                        <td style="text-align: right;">Rp ${(p.harga * p.qty).toLocaleString('id-ID')}</td>
                    </tr>
                `).join('');

                detailContent.innerHTML = `
                    <div class="detail-section">
                        <h4 style="margin-bottom: 16px; font-size: 15px; font-weight: 600; color: var(--text-dark);">DATA PELANGGAN</h4>
                        <div class="detail-row">
                            <div class="detail-label">Nama</div>
                            <div class="detail-value">${pesanan.nama}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">No HP</div>
                            <div class="detail-value">${pesanan.no_hp || '-'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Alamat</div>
                            <div class="detail-value">${pesanan.metode_pengambilan === 'delivery' ? pesanan.alamat_delivery || '-' : '-'}</div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h4 style="margin-bottom: 16px; font-size: 15px; font-weight: 600; color: var(--text-dark);">DETAIL TRANSAKSI</h4>
                        <div class="detail-row">
                            <div class="detail-label">Metode Pembayaran</div>
                            <div class="detail-value">${pesanan.metode_pembayaran === 'cash' ? 'Cash' : 'Transfer'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Tanggal Transaksi</div>
                            <div class="detail-value">${pesanan.tgl_transaksi || '-'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Tanggal ${pesanan.metode_pengambilan === 'delivery' ? 'Delivery' : 'Pickup'}</div>
                            <div class="detail-value">${metodePickup || '-'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Status</div>
                            <div class="detail-value">
                                <span class="badge ${pesanan.status_pesanan === 'selesai' ? 'status-selesai' : (pesanan.status_pesanan === 'diproses' ? 'status-diproses' : 'status-menunggu-konfirmasi')}">
                                    ${pesanan.status_pesanan === 'selesai' ? 'Selesai' : (pesanan.status_pesanan === 'diproses' ? 'Diproses' : (pesanan.status_pesanan === 'siap_diambil' ? 'Siap Diambil' : (pesanan.status_pesanan === 'dikirim' ? 'Dikirim' : 'Menunggu Konfirmasi')))}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h4 style="margin-bottom: 16px; font-size: 15px; font-weight: 600; color: var(--text-dark);">DETAIL PRODUK</h4>
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 1px solid var(--medium-gray);">
                                    <th style="text-align: left; padding: 8px 0; font-weight: 600;">Produk</th>
                                    <th style="text-align: center; padding: 8px 0; font-weight: 600; width: 80px;">Qty</th>
                                    <th style="text-align: right; padding: 8px 0; font-weight: 600; width: 150px;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${produkHTML}
                            </tbody>
                            <tfoot style="border-top: 2px solid var(--medium-gray);">
                                <tr>
                                    <td colspan="2" style="padding: 12px 0; text-align: right; font-weight: 600;">Total Bayar:</td>
                                    <td style="text-align: right; padding: 12px 0; font-weight: 600; color: var(--primary-brown);">Rp ${pesanan.total.toLocaleString('id-ID')}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                `;
            } else {
                const pesanan = pesananData.karyawan.find(p => p.id === pesananId);
                if (!pesanan) return;

                let produkHTML = pesanan.produk.map(p => `
                    <tr>
                        <td>${p.nama}</td>
                        <td style="text-align: center;">${p.qty}</td>
                        <td style="text-align: right;">Rp ${(p.harga * p.qty).toLocaleString('id-ID')}</td>
                    </tr>
                `).join('');

                const totalBarang = pesanan.produk.reduce((sum, p) => sum + p.qty, 0);

                detailContent.innerHTML = `
                    <div class="detail-section">
                        <h4 style="margin-bottom: 16px; font-size: 15px; font-weight: 600; color: var(--text-dark);">DATA KARYAWAN</h4>
                        <div class="detail-row">
                            <div class="detail-label">Nama Karyawan</div>
                            <div class="detail-value">${pesanan.nama}</div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h4 style="margin-bottom: 16px; font-size: 15px; font-weight: 600; color: var(--text-dark);">DETAIL PRODUK</h4>
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 1px solid var(--medium-gray);">
                                    <th style="text-align: left; padding: 8px 0; font-weight: 600;">Produk</th>
                                    <th style="text-align: center; padding: 8px 0; font-weight: 600; width: 80px;">Qty</th>
                                    <th style="text-align: right; padding: 8px 0; font-weight: 600; width: 150px;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${produkHTML}
                            </tbody>
                            <tfoot style="border-top: 2px solid var(--medium-gray);">
                                <tr>
                                    <td style="padding: 12px 0; text-align: left; font-weight: 600;">Total Barang:</td>
                                    <td colspan="2" style="text-align: right; padding: 12px 0; font-weight: 600;">${totalBarang} Item</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 0; text-align: left; font-weight: 600;">Total Bayar:</td>
                                    <td colspan="2" style="text-align: right; padding: 12px 0; font-weight: 600; color: var(--primary-brown);">Rp ${(pesanan.total || 0).toLocaleString('id-ID')}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="detail-section">
                        <h4 style="margin-bottom: 16px; font-size: 15px; font-weight: 600; color: var(--text-dark);">STATUS SETORAN</h4>
                        <div class="detail-row">
                            <div class="detail-label">Tanggal Ambil</div>
                            <div class="detail-value">${pesanan.tanggal_pickup || '-'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Tanggal Setor</div>
                            <div class="detail-value">${pesanan.tanggal_setor || '-'}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Status Setor</div>
                            <div class="detail-value"><span class="status-badge ${pesanan.status === 'sudah_setor' ? 'sudah_setor' : 'belum_setor'}">${pesanan.status === 'sudah_setor' ? 'Sudah Setor' : 'Belum Setor'}</span></div>
                        </div>
                    </div>
                `;
            }

            document.getElementById('modalDetail').classList.add('show');
        }

        function downloadInvoice(type, pesananId) {
            const pesanan = type === 'pelanggan' ?
                pesananData.pelanggan.find(p => p.id === pesananId) :
                pesananData.karyawan.find(p => p.id === pesananId);

            if (!pesanan) return;

            // Implementasi sederhana - dalam praktik nyata gunakan library seperti jsPDF
            let invoiceContent = `
            Invoice ${type === 'pelanggan' ? 'Pelanggan' : 'Karyawan'}
            ================================
            ID: ${pesanan.id}
            Nama: ${pesanan.nama}
            ${type === 'pelanggan' ? 'No HP: ' + pesanan.no_hp + '\n' : ''}
            Tanggal: ${type === 'pelanggan' ? pesanan.tgl_transaksi : pesanan.tanggal_pickup}

            Produk:
            ${pesanan.produk.map(p => `${p.nama} x${p.qty} = Rp ${(p.harga * p.qty).toLocaleString('id-ID')}`).join('\n')}

            Total: Rp ${pesanan.total.toLocaleString('id-ID')}
            `;

            const blob = new Blob([invoiceContent], { type: 'text/plain' });
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `Invoice_${pesanan.id}.txt`;
            link.click();
            window.URL.revokeObjectURL(url);

            showToast('Invoice berhasil diunduh', 'success');
        }

        async function markComplete(type, pesananId) {
            const numericId = parseInt(pesananId.toString().replace(/^[KP]-/, ''));
            if (!numericId) return;

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const pesanan = type === 'pelanggan'
                ? pesananData.pelanggan.find(p => p.id === pesananId)
                : pesananData.karyawan.find(p => p.id === pesananId);
            if (!pesanan) return;

            const newStatusBayar = (type === 'pelanggan'
                ? (pesanan.status === 'selesai' ? 'belum_lunas' : 'lunas')
                : (pesanan.status === 'sudah_setor' ? 'belum_lunas' : 'lunas'));

            try {
                const response = await fetch(`/pesanan-offline/${numericId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status_bayar: newStatusBayar })
                });

                const result = await response.json();
                if (result.success) {
                    showToast('Status berhasil diperbarui', 'success');
                    setTimeout(() => window.location.reload(), 600);
                } else {
                    showToast(result.message || 'Gagal memperbarui status', 'error');
                }
            } catch (err) {
                showToast('Terjadi kesalahan: ' + err.message, 'error');
            }
        }

        async function deletePesanan(type, pesananId) {
            if (!confirm('Yakin ingin menghapus pesanan ini?')) return;
            const numericId = parseInt(pesananId.toString().replace(/^[KP]-/, ''));
            if (!numericId) return;

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            try {
                const response = await fetch(`/pesanan-offline/${numericId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();
                if (result.success) {
                    showToast('Pesanan berhasil dihapus', 'success');
                    setTimeout(() => window.location.reload(), 600);
                } else {
                    showToast(result.message || 'Gagal menghapus pesanan', 'error');
                }
            } catch (err) {
                showToast('Terjadi kesalahan: ' + err.message, 'error');
            }
        }

        // Inline Edit for Offline Pelanggan Table
        function startInlineEditOffline(el, type, pesananId) {
            if (el.classList.contains('editing')) return;

            const numericId = parseInt(pesananId.toString().replace(/^[KP]-/, ''));
            if (!numericId) return;

            const currentBadge = el.querySelector('span.badge');
            const currentText = currentBadge ? currentBadge.textContent.trim() : '';

            const paymentOptions = [
                { value: 'lunas', label: 'Lunas', cls: 'badge-lunas' },
                { value: 'menunggu_verifikasi', label: 'Menunggu', cls: 'badge-menunggu' },
                { value: 'belum_bayar', label: 'Belum Lunas', cls: 'badge-belum-lunas' },
            ];
            const statusOptions = [
                { value: 'menunggu_konfirmasi', label: 'Menunggu Konfirmasi', cls: 'status-menunggu-konfirmasi' },
                { value: 'diproses', label: 'Diproses', cls: 'status-diproses' },
                { value: 'siap_diambil', label: 'Siap Diambil', cls: 'status-siap-diambil' },
                { value: 'dikirim', label: 'Dikirim', cls: 'status-dikirim' },
                { value: 'selesai', label: 'Selesai', cls: 'status-selesai' },
            ];

            const options = type === 'pembayaran' ? paymentOptions : statusOptions;
            const field = type === 'pembayaran' ? 'status_pembayaran' : 'status_pesanan';

            el.classList.add('editing');
            el.innerHTML = '';

            const select = document.createElement('select');
            options.forEach(opt => {
                const option = document.createElement('option');
                option.value = opt.value;
                option.textContent = opt.label;
                if (opt.label === currentText) option.selected = true;
                select.appendChild(option);
            });
            el.appendChild(select);
            select.focus();

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

            const updateValue = () => {
                const newValue = select.value;
                const selected = options.find(o => o.value === newValue);

                fetch(`/api/pesanans/${numericId}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ [field]: newValue }),
                })
                .then(r => r.json())
                .then(() => {
                    el.classList.remove('editing');
                    if (type === 'status' && newValue === 'selesai') {
                        el.innerHTML = `<span class="badge ${selected.cls}">${selected.label}</span>`;
                    } else {
                        el.innerHTML = `<span class="badge ${selected.cls}">${selected.label}</span><i class="fas fa-pen edit-icon"></i>`;
                    }
                    setTimeout(() => window.location.reload(), 600);
                })
                .catch(err => {
                    el.classList.remove('editing');
                    el.innerHTML = currentBadge ? currentBadge.outerHTML + '<i class="fas fa-pen edit-icon"></i>' : '';
                    console.error(err);
                });
            };

            select.addEventListener('change', updateValue);
            select.addEventListener('blur', updateValue);
        }

        function showBuktiTransferOffline(buktiPath) {
            const baseUrl = window.location.origin;
            document.getElementById('buktiTransferImage').src = baseUrl + '/storage/' + buktiPath;
            document.getElementById('modalBuktiTransfer').classList.add('show');
        }

        function closeModalBuktiTransfer() {
            document.getElementById('modalBuktiTransfer').classList.remove('show');
        }

        async function submitOrderOffline(pesananId) {
            if (!confirm('Konfirmasi submit pesanan ini?')) return;

            const numericId = parseInt(pesananId.toString().replace(/^[KP]-/, ''));
            if (!numericId) return;

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            try {
                const response = await fetch(`/api/pesanan/${numericId}/submit`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                });

                const result = await response.json();
                if (result.success) {
                    showToast('Pesanan berhasil di-submit!', 'success');
                    setTimeout(() => window.location.reload(), 600);
                } else {
                    showToast(result.message || 'Gagal submit pesanan', 'error');
                }
            } catch (err) {
                showToast('Terjadi kesalahan: ' + err.message, 'error');
            }
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

        // Toast Notifications
        function showToast(message, type = 'info') {
            const toastContainer = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;

            let icon = 'fas fa-info-circle';
            if (type === 'success') icon = 'fas fa-check-circle';
            if (type === 'error') icon = 'fas fa-exclamation-circle';

            toast.innerHTML = `
                <div class="toast-icon"><i class="${icon}"></i></div>
                <div class="toast-text">${message}</div>
            `;

            toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        function filterTable(type) {
            if (!type) type = currentTab;
            const searchValue = type === 'karyawan' ?
                document.getElementById('searchKaryawan').value.toLowerCase() :
                document.getElementById('searchPelanggan').value.toLowerCase();
            const filterValue = type === 'karyawan' ?
                document.getElementById('filterKaryawan').value :
                document.getElementById('filterPelanggan').value;

            // Filter on original data
            const originalData = pesananData[type];
            const filtered = originalData.filter(item => {
                const text = (item.nama + ' ' + item.id + ' ' + (item.no_hp || '')).toLowerCase();
                let show = text.includes(searchValue);
                if (filterValue) {
                    if (type === 'pelanggan') {
                        show = show && (item.status_pesanan || '') === filterValue;
                    } else {
                        show = show && (item.status || '') === filterValue;
                    }
                }
                return show;
            });

            // Save filtered data (or null if no filter/search applied)
            if (!searchValue && !filterValue) {
                filteredData[type] = null;
            } else {
                filteredData[type] = filtered;
            }

            // Reset pagination to page 1
            paginationState[type].currentPage = 1;

            // Re-render table
            if (type === 'karyawan') {
                renderKaryawanTable();
            } else {
                renderPelangganTable();
            }
        }

        // Update Stats
        function updateStats() {
            // Total Pesanan = semua pesanan (pelanggan + karyawan)
            const totalPesanan = pesananData.pelanggan.length + pesananData.karyawan.length;

            // Pesanan Diproses = pelanggan belum selesai + karyawan belum setor
            const pesananDiproses = pesananData.pelanggan.filter(p => p.status_pesanan && p.status_pesanan !== 'selesai').length +
                                    pesananData.karyawan.filter(p => p.status === 'belum_setor').length;

            // Pesanan Selesai = pelanggan selesai + karyawan sudah setor
            const pesananSelesai = pesananData.pelanggan.filter(p => p.status_pesanan === 'selesai').length +
                                   pesananData.karyawan.filter(p => p.status === 'sudah_setor').length;

            // Total Revenue = karyawan lunas + pelanggan lunas
            const revenueKaryawan = pesananData.karyawan
                .filter(p => p.status_bayar === 'lunas')
                .reduce((sum, p) => sum + (p.total || 0), 0);
            const revenuePelanggan = pesananData.pelanggan
                .filter(p => p.status_pembayaran === 'lunas')
                .reduce((sum, p) => sum + (p.total || 0), 0);
            const totalRevenue = revenueKaryawan + revenuePelanggan;

            document.getElementById('total-pesanan').textContent = totalPesanan;
            document.getElementById('pesanan-diproses').textContent = pesananDiproses;
            document.getElementById('pesanan-selesai').textContent = pesananSelesai;
            document.getElementById('total-revenue').textContent = 'Rp ' + totalRevenue.toLocaleString('id-ID');
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('show');
            }
        });

</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        function initKaryawanSelect2() {
            if ($('#namaKaryawan').data('select2')) {
                $('#namaKaryawan').select2('destroy');
            }
            $('#namaKaryawan').select2({
                placeholder: 'Cari nama karyawan...',
                allowClear: true,
                dropdownParent: $('#modalAddPesanan'),
                ajax: {
                    url: '/api/karyawans-autocomplete',
                    dataType: 'json',
                    delay: 300,
                    data: function(params) { return { q: params.term }; },
                    processResults: function(data) { return { results: data.results }; },
                    cache: true
                },
                minimumInputLength: 1,
                width: '100%'
            });
        }

        function initPelangganSelect2() {
            if ($('#namaPelanggan').data('select2')) {
                $('#namaPelanggan').select2('destroy');
            }
            $('#namaPelanggan').select2({
                placeholder: 'Cari nama pelanggan...',
                allowClear: true,
                dropdownParent: $('#modalAddPesanan'),
                ajax: {
                    url: '/api/pelanggans-autocomplete',
                    dataType: 'json',
                    delay: 300,
                    data: function(params) { return { q: params.term }; },
                    processResults: function(data) { return { results: data.results }; },
                    cache: true
                },
                minimumInputLength: 1,
                width: '100%'
            });
        }

        initKaryawanSelect2();
        initPelangganSelect2();

        $('#namaPelanggan').on('select2:select', function(e) {
            const data = e.params.data;
            document.getElementById('noHpPelanggan').value = data.no_tlp || '';
            document.getElementById('alamatDelivery').value = data.alamat || '';
        });

        $('#namaPelanggan').on('select2:clear', function() {
            document.getElementById('noHpPelanggan').value = '';
            document.getElementById('alamatDelivery').value = '';
        });
    });
</script>
@endsection
