<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three D Bakery - Pesanan Pelanggan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-green: #8B6F47;
            --primary-brown: #8B6F47;
            --light-green: #D4A574;
            --light-brown: #D4A574;
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
            --transition: all 0.3s ease;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--cream);
            color: var(--text-dark);
            line-height: 1.6;
        }

        .dashboard { min-height: 100vh; display: flex; }

        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, var(--primary-brown), var(--light-brown));
            color: var(--white);
            position: fixed;
            inset: 0 auto 0 0;
            box-shadow: var(--shadow-lg);
            overflow-y: auto;
        }

        .sidebar-header { padding: 24px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-header h1 { font-size: 20px; margin-bottom: 4px; letter-spacing: -0.025em; }
        .sidebar-header p { font-size: 12px; opacity: 0.85; }
        .sidebar-menu { padding: 16px 0; }
        .sidebar-menu-item { margin: 4px 16px; }

        .sidebar-menu-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: var(--transition);
            font-size: 14px;
            font-weight: 500;
        }

        .sidebar-menu-item a:hover,
        .sidebar-menu-item a.active {
            background: rgba(255,255,255,0.15);
            color: var(--white);
            transform: translateX(4px);
        }

        .main-content { margin-left: 280px; width: calc(100% - 280px); }

        .header {
            background: var(--white);
            border-bottom: 1px solid var(--medium-gray);
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .header-title { font-size: 24px; font-weight: 700; }
        .header-subtitle { font-size: 13px; color: var(--dark-gray); margin-top: 2px; }

        .profile-menu { position: relative; }
        .profile-btn {
            width: 40px; height: 40px; border: none; border-radius: 50%; background: var(--light-gray);
            display: flex; align-items: center; justify-content: center; cursor: pointer; transition: var(--transition);
        }
        .profile-btn:hover { background: var(--medium-gray); transform: scale(1.05); }
        .profile-avatar {
            width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-green), #81C784);
            color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;
        }

        .profile-dropdown {
            position: absolute; top: calc(100% + 10px); right: 0; min-width: 180px; background: var(--white);
            border: 1px solid var(--medium-gray); border-radius: var(--border-radius); box-shadow: var(--shadow-lg); padding: 8px; display: none;
        }
        .profile-dropdown.show { display: block; }
        .profile-dropdown a,
        .profile-dropdown button {
            width: 100%; display: flex; align-items: center; gap: 10px; padding: 10px 12px; border: none; border-radius: 10px;
            background: transparent; color: var(--text-dark); text-decoration: none; font-size: 14px; font-weight: 500; cursor: pointer; text-align: left; transition: var(--transition);
        }
        .profile-dropdown a:hover,
        .profile-dropdown button:hover { background: var(--light-gray); }
        .profile-dropdown .logout-action { color: #EF4444; }

        .content { padding: 24px; }
        .card { background: var(--white); border: 1px solid var(--medium-gray); border-radius: 16px; box-shadow: var(--shadow-md); overflow: hidden; }
        .card-header {
            padding: 18px 20px; border-bottom: 1px solid var(--medium-gray); background: var(--light-gray);
            display: flex; justify-content: space-between; align-items: center; gap: 12px;
        }
        .card-title { font-size: 16px; font-weight: 700; }
        .btn-back {
            display: inline-flex; align-items: center; gap: 8px; padding: 10px 14px; border-radius: 10px; text-decoration: none;
            background: linear-gradient(135deg, var(--light-brown), var(--primary-brown)); color: white; font-size: 13px; font-weight: 600; box-shadow: var(--shadow-sm);
        }

        .btn-order,
        .btn-payment {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .btn-order {
            background: linear-gradient(135deg, var(--light-brown), var(--primary-brown));
            color: white;
        }

        .btn-payment {
            background: linear-gradient(135deg, #22C55E, #16A34A);
            color: white;
        }

        .btn-order:hover,
        .btn-payment:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 50;
            padding: 16px;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-card {
            width: min(720px, 100%);
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .modal-header {
            padding: 18px 20px;
            border-bottom: 1px solid var(--medium-gray);
            background: var(--light-gray);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .modal-title {
            font-size: 16px;
            font-weight: 700;
        }

        .modal-close {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 50%;
            background: var(--white);
            cursor: pointer;
        }

        .modal-body {
            padding: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 6px;
            text-transform: uppercase;
            color: var(--dark-gray);
            letter-spacing: 0.5px;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--medium-gray);
            border-radius: 10px;
            font: inherit;
            background: var(--white);
            color: var(--text-dark);
        }

        .form-textarea {
            min-height: 96px;
            resize: vertical;
        }

        .modal-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--medium-gray);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            background: #fffdf9;
        }

        .btn-cancel,
        .btn-submit {
            border: none;
            border-radius: 10px;
            padding: 11px 16px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-cancel {
            background: var(--light-gray);
            color: var(--dark-gray);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--light-brown), var(--primary-brown));
            color: white;
        }

        .btn-cancel:hover,
        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-top: 8px;
        }

        .payment-method {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px;
            border: 1px solid var(--medium-gray);
            border-radius: 12px;
            background: var(--white);
            cursor: pointer;
            transition: var(--transition);
        }

        .payment-method:hover {
            border-color: var(--primary-brown);
            box-shadow: var(--shadow-sm);
            transform: translateY(-1px);
        }

        .payment-method input {
            margin-top: 4px;
            accent-color: var(--primary-brown);
        }

        .payment-method.active {
            border-color: var(--primary-brown);
            background: #fffdf8;
            box-shadow: var(--shadow-sm);
        }

        .payment-method-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .payment-method-desc {
            font-size: 12px;
            color: var(--dark-gray);
            margin-top: 3px;
        }

        .payment-summary {
            margin-top: 16px;
            padding: 14px;
            border-radius: 12px;
            background: var(--light-gray);
            border: 1px solid var(--medium-gray);
            font-size: 13px;
            color: var(--text-dark);
        }

        .payment-summary strong {
            color: var(--primary-brown);
        }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 720px; }
        th, td { padding: 14px 16px; border-bottom: 1px solid var(--medium-gray); text-align: left; font-size: 14px; }
        th { text-transform: uppercase; letter-spacing: 0.5px; font-size: 12px; color: var(--dark-gray); }
        .badge {
            display: inline-flex; align-items: center; padding: 5px 10px; border-radius: 999px; font-size: 12px; font-weight: 600;
        }
        .badge-proses { background: rgba(59, 130, 246, 0.12); color: #1D4ED8; }
        .badge-selesai { background: rgba(34, 197, 94, 0.12); color: #166534; }
        .badge-lunas { background: rgba(34, 197, 94, 0.12); color: #166534; }
        .badge-belum { background: rgba(239, 68, 68, 0.12); color: #B91C1C; }
        .actions { display: flex; gap: 8px; align-items: center; }
        .btn-icon,
        .btn-confirm {
            width: 36px; height: 36px; border: none; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; transition: var(--transition);
        }
        .btn-icon { background: var(--light-gray); color: var(--dark-gray); }
        .btn-confirm { background: var(--primary-green); color: white; }
        .btn-icon:hover,
        .btn-confirm:hover { transform: translateY(-1px); }

        @media (max-width: 900px) {
            .sidebar { position: static; width: 100%; height: auto; }
            .main-content { margin-left: 0; width: 100%; }
            .dashboard { display: block; }
        }

        @media (max-width: 768px) {
            .header { padding: 12px 16px; flex-direction: column; align-items: flex-start; }
            .content { padding: 16px; }
            .card-header { flex-direction: column; align-items: flex-start; }
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
                    <a href="{{ route('pelanggan.dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard Pelanggan</a>
                </div>
                <div class="sidebar-menu-item">
                    <a href="{{ url('/pelanggan/pesanan') }}" class="active"><i class="fas fa-shopping-cart"></i>Pesanan Saya</a>
                </div>
            </nav>
        </aside>

        <main class="main-content">
            <header class="header">
                <div>
                    <h1 class="header-title">Pesanan Pelanggan</h1>
                    <p class="header-subtitle">Halaman daftar pesanan dan konfirmasi pembayaran</p>
                </div>

                <div class="profile-menu">
                    <button type="button" class="profile-btn" id="profileMenuButton" aria-haspopup="true" aria-expanded="false" title="Akun">
                        <div class="profile-avatar">P</div>
                    </button>
                    <div class="profile-dropdown" id="profileDropdown">
                        <a href="{{ route('profile.edit') }}"><i class="fas fa-user"></i>Profil</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="logout-action"><i class="fas fa-right-from-bracket"></i>Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-title">Daftar Pesanan Saya</h2>
                            <p style="font-size: 13px; color: var(--dark-gray); margin-top: 4px;">Gunakan halaman ini untuk memantau status pesanan Anda.</p>
                        </div>
                            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                                <a href="{{ route('pelanggan.dashboard') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>
                                <button type="button" class="btn-payment" onclick="openPaymentModal()"><i class="fas fa-credit-card"></i> Konfirmasi Pembayaran</button>
                                <button type="button" class="btn-order" onclick="openOrderModal()"><i class="fas fa-bag-shopping"></i> Pesan</button>
                            </div>
                    </div>

                    <div class="table-wrap">
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
                            <tbody>
                                <tr>
                                    <td>ORD-260401</td>
                                    <td>2026-04-24</td>
                                    <td>Roti Coklat Premium</td>
                                    <td>Rp 350.000</td>
                                    <td><span class="badge badge-proses">Diproses</span></td>
                                </tr>
                                <tr>
                                    <td>ORD-260395</td>
                                    <td>2026-04-22</td>
                                    <td>Cake Ulang Tahun</td>
                                    <td>Rp 650.000</td>
                                    <td><span class="badge badge-selesai">Selesai</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <div class="modal-overlay" id="orderModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Pesan Sekarang</h3>
                <button type="button" class="modal-close" onclick="closeOrderModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nama</label>
                        <input class="form-input" type="text" placeholder="Nama pemesan">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tipe Pesanan</label>
                        <select class="form-select">
                            <option>Pelanggan</option>
                            <option>Karyawan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Produk</label>
                    <input class="form-input" type="text" placeholder="Contoh: Roti Coklat Premium">
                </div>
                <div class="form-group">
                    <label class="form-label">Catatan</label>
                    <textarea class="form-textarea" placeholder="Catatan tambahan untuk pesanan"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeOrderModal()">Batal</button>
                <button type="button" class="btn-submit" onclick="submitOrder()">Pesan Sekarang</button>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="paymentModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Konfirmasi Pembayaran</h3>
                <button type="button" class="modal-close" onclick="closePaymentModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Pilih Metode Pembayaran Online</label>
                    <div class="payment-methods" id="paymentMethods">
                        <label class="payment-method active">
                            <input type="radio" name="payment_method" value="transfer_bank" checked>
                            <div>
                                <div class="payment-method-title">Transfer Bank</div>
                                <div class="payment-method-desc">BCA, BRI, Mandiri, dan rekening lainnya.</div>
                            </div>
                        </label>
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="qris">
                            <div>
                                <div class="payment-method-title">QRIS</div>
                                <div class="payment-method-desc">Scan QR dan bayar lewat mobile banking atau e-wallet.</div>
                            </div>
                        </label>
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="e_wallet">
                            <div>
                                <div class="payment-method-title">E-Wallet</div>
                                <div class="payment-method-desc">DANA, OVO, GoPay, dan ShopeePay.</div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nomor Pesanan</label>
                        <input class="form-input" type="text" placeholder="Contoh: ORD-260401">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nominal Pembayaran</label>
                        <input class="form-input" type="text" placeholder="Rp 350.000">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Bukti / Catatan</label>
                    <textarea class="form-textarea" placeholder="Isi nomor referensi, nama pengirim, atau catatan pembayaran"></textarea>
                </div>

                <div class="payment-summary" id="paymentSummary">
                    Metode terpilih: <strong>Transfer Bank</strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closePaymentModal()">Batal</button>
                <button type="button" class="btn-submit" onclick="submitPayment()">Kirim Konfirmasi</button>
            </div>
        </div>
    </div>

    <script>
        const profileMenuButton = document.getElementById('profileMenuButton');
        const profileDropdown = document.getElementById('profileDropdown');
        const orderModal = document.getElementById('orderModal');
        const paymentModal = document.getElementById('paymentModal');

        const paymentMethodLabels = {
            transfer_bank: 'Transfer Bank',
            qris: 'QRIS',
            e_wallet: 'E-Wallet'
        };

        function openOrderModal() {
            orderModal.classList.add('show');
        }

        function closeOrderModal() {
            orderModal.classList.remove('show');
        }

        function submitOrder() {
            alert('Pesanan pelanggan siap diproses. Jika kamu mau, saya bisa sambungkan ke penyimpanan database berikutnya.');
            closeOrderModal();
        }

        function openPaymentModal() {
            paymentModal.classList.add('show');
        }

        function closePaymentModal() {
            paymentModal.classList.remove('show');
        }

        function submitPayment() {
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
            const methodLabel = selectedMethod ? paymentMethodLabels[selectedMethod.value] : 'Transfer Bank';
            const paymentSummary = document.getElementById('paymentSummary');

            if (paymentSummary) {
                paymentSummary.innerHTML = `Metode terpilih: <strong>${methodLabel}</strong>`;
            }

            alert(`Konfirmasi pembayaran dikirim dengan metode ${methodLabel}.`);
            closePaymentModal();
        }

        if (orderModal) {
            orderModal.addEventListener('click', (event) => {
                if (event.target === orderModal) {
                    closeOrderModal();
                }
            });
        }

        if (paymentModal) {
            paymentModal.addEventListener('click', (event) => {
                if (event.target === paymentModal) {
                    closePaymentModal();
                }
            });

            const paymentMethods = document.querySelectorAll('#paymentMethods .payment-method');
            paymentMethods.forEach((method) => {
                method.addEventListener('click', () => {
                    paymentMethods.forEach((item) => item.classList.remove('active'));
                    method.classList.add('active');
                    const radio = method.querySelector('input[type="radio"]');
                    if (radio) {
                        radio.checked = true;
                        const paymentSummary = document.getElementById('paymentSummary');
                        if (paymentSummary) {
                            paymentSummary.innerHTML = `Metode terpilih: <strong>${paymentMethodLabels[radio.value]}</strong>`;
                        }
                    }
                });
            });
        }

        if (profileMenuButton && profileDropdown) {
            profileMenuButton.addEventListener('click', () => {
                profileDropdown.classList.toggle('show');
                profileMenuButton.setAttribute('aria-expanded', profileDropdown.classList.contains('show') ? 'true' : 'false');
            });

            document.addEventListener('click', (event) => {
                if (!profileMenuButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.remove('show');
                    profileMenuButton.setAttribute('aria-expanded', 'false');
                }
            });
        }
    </script>
</body>
</html>