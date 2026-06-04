<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three D Bakery - Data Karyawan</title>
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

        .dashboard { display: flex; min-height: 100vh; }

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

        .sidebar-header { padding: 24px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); text-align: center; }
        .sidebar-header h1 { font-size: 20px; font-weight: 700; margin-bottom: 4px; }
        .sidebar-header p { font-size: 12px; opacity: 0.8; font-weight: 500; }

        .sidebar-menu { padding: 16px 0; }
        .sidebar-menu-item { margin: 4px 16px; }

        .sidebar-menu-item > a, .sidebar-menu-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: var(--transition);
            font-weight: 600;
            font-size: 14px;
            background: none;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: left;
        }

        .sidebar-menu-item > a:hover, .sidebar-menu-item > a.active, .sidebar-menu-toggle:hover, .sidebar-menu-toggle.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: var(--white);
        }

        .sidebar-menu-item > a.active { background-color: rgba(255, 255, 255, 0.2); }

        .sidebar-menu-item i, .sidebar-menu-toggle i { width: 20px; min-width: 20px; margin-right: 12px; text-align: center; font-size: 16px; }
        .sidebar-menu-item .toggle-arrow { font-size: 12px; transition: transform 0.3s ease; margin-left: auto; flex-shrink: 0; }
        .sidebar-menu-item .toggle-arrow.open { transform: rotate(180deg); }

        .sidebar-submenu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; background: rgba(0, 0, 0, 0.1); border-radius: var(--border-radius); margin: 0 8px; }
        .sidebar-submenu.open { max-height: 500px; }

        .sidebar-submenu-item { padding: 10px 16px 10px 48px; color: rgba(255, 255, 255, 0.8); text-decoration: none; display: flex; align-items: center; font-size: 13px; transition: var(--transition); }
        .sidebar-submenu-item:hover, .sidebar-submenu-item.active { color: var(--white); padding-left: 52px; }

        .main-content { flex: 1; margin-left: 280px; background-color: var(--cream); }

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

        .header-left { display: flex; align-items: center; gap: 16px; }
        .header-title { font-size: 24px; font-weight: 700; color: var(--text-dark); margin: 0; }
        .header-right { display: flex; align-items: center; gap: 16px; }

        .notification-btn, .profile-btn {
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

        .notification-btn:hover, .profile-btn:hover { background: var(--medium-gray); transform: scale(1.05); }

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

        .profile-avatar { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-brown), #81C784); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 14px; }

        .dashboard-content { padding: 24px; }

        .page-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; margin-bottom: 24px; flex-wrap: wrap; }

        .page-header-left h1 { font-size: 32px; font-weight: 700; color: var(--text-dark); margin: 0; }
        .page-header-left p { font-size: 14px; color: var(--dark-gray); margin: 8px 0 0 0; }

        .page-header-right { display: flex; gap: 10px; flex-wrap: wrap; }

        .search-input { position: relative; flex: 1; min-width: 200px; }
        .search-input input { width: 100%; padding: 10px 16px 10px 40px; border: 1px solid var(--medium-gray); border-radius: var(--border-radius); background: var(--white); font-size: 14px; }
        .search-input i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--light-brown); }

        .btn { padding: 10px 16px; border-radius: var(--border-radius); font-weight: 600; font-size: 14px; border: none; cursor: pointer; transition: var(--transition); display: inline-flex; align-items: center; gap: 8px; }

        .btn-export { background: var(--cream); color: var(--primary-brown); border: 1px solid var(--light-brown); }
        .btn-export:hover { background: var(--medium-gray); }

        .btn-primary { background: var(--light-brown); color: var(--white); }
        .btn-primary:hover { background: #C49564; transform: translateY(-2px); }

        .stat-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 24px; }

        .stat-card { background: var(--white); padding: 20px; border-radius: var(--border-radius-xl); box-shadow: var(--shadow-sm); border-top: 4px solid; transition: var(--transition); }
        .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }

        .stat-card.brown { border-top-color: var(--light-brown); }
        .stat-card.green { border-top-color: #10B981; }
        .stat-card.red { border-top-color: #EF4444; }

        .stat-card-header { display: flex; justify-content: space-between; align-items: flex-start; }
        .stat-card-info p:first-child { font-size: 13px; color: var(--dark-gray); margin: 0; }
        .stat-card-info p:last-child { font-size: 32px; font-weight: 700; color: var(--text-dark); margin: 8px 0 0 0; }

        .stat-card-icon { width: 48px; height: 48px; border-radius: var(--border-radius); display: flex; align-items: center; justify-content: center; font-size: 20px; }

        .stat-card.brown .stat-card-icon { background: #FFF5E6; color: var(--light-brown); }
        .stat-card.green .stat-card-icon { background: #ECFDF5; color: #10B981; }
        .stat-card.red .stat-card-icon { background: #FEF2F2; color: #EF4444; }

        .table-container { background: var(--white); border-radius: var(--border-radius-xl); overflow: hidden; box-shadow: var(--shadow-sm); }
        .table-wrapper { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; }
        thead { background: var(--cream); border-bottom: 1px solid var(--medium-gray); }
        th { padding: 16px; text-align: left; font-weight: 600; font-size: 13px; color: var(--text-dark); letter-spacing: 0.3px; }
        tbody tr { border-bottom: 1px solid var(--medium-gray); transition: var(--transition); }
        tbody tr:hover { background: var(--light-gray); }
        td { padding: 16px; font-size: 14px; color: var(--text-dark); }

        .status-badge { display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-active { background: #ECFDF5; color: #10B981; }
        .status-inactive { background: #FEF2F2; color: #EF4444; }

        .action-buttons { display: flex; gap: 8px; }
        .btn-action { width: 36px; height: 36px; border-radius: var(--border-radius); background: transparent; border: none; color: var(--light-brown); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; transition: var(--transition); }
        .btn-action:hover { background: var(--cream); }

        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state i { font-size: 64px; color: var(--light-brown); opacity: 0.3; margin-bottom: 16px; }
        .empty-state p { font-size: 16px; color: var(--text-dark); margin: 8px 0; }
        .empty-state p.subtitle { color: var(--dark-gray); font-size: 14px; }

        .modal { display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 2000; align-items: center; justify-content: center; }
        .modal.show { display: flex; }

        .modal-content { background: var(--white); border-radius: var(--border-radius-xl); width: 90%; max-width: 500px; padding: 32px; box-shadow: var(--shadow-lg); animation: slideIn 0.3s ease; }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header { margin-bottom: 24px; }
        .modal-header h3 { font-size: 20px; font-weight: 700; color: var(--text-dark); margin: 0; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px 12px; border: 1px solid var(--medium-gray); border-radius: var(--border-radius); font-size: 14px; font-family: inherit; color: var(--text-dark); }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: var(--light-brown); box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.1); }
        .form-group textarea { resize: vertical; min-height: 80px; }

        .modal-footer { display: flex; gap: 12px; margin-top: 24px; }
        .modal-footer button { flex: 1; padding: 12px; border-radius: var(--border-radius); font-weight: 600; font-size: 14px; border: none; cursor: pointer; transition: var(--transition); }
        .modal-footer .btn-cancel { background: var(--cream); color: var(--primary-brown); border: 1px solid var(--light-brown); }
        .modal-footer .btn-cancel:hover { background: var(--medium-gray); }
        .modal-footer .btn-submit { background: var(--light-brown); color: var(--white); }
        .modal-footer .btn-submit:hover { background: #C49564; }

        .pagination { display: flex; justify-content: flex-end; align-items: center; gap: 10px; padding: 20px; border-top: 1px solid var(--medium-gray); }

        @media (max-width: 768px) {
            .sidebar { width: 250px; }
            .main-content { margin-left: 250px; }
            .page-header { flex-direction: column; }
            .page-header-right { width: 100%; }
            .stat-cards { grid-template-columns: 1fr; }
            table { font-size: 12px; }
            th, td { padding: 12px; }
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
                    <a href="/dashboard">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle" onclick="toggleMenu(this)">
                        <span><i class="fas fa-shopping-cart"></i> Pesanan</span>
                        <i class="fas fa-chevron-down toggle-arrow"></i>
                    </button>
                    <div class="sidebar-submenu">
                        <a href="/pesanan-online" class="sidebar-submenu-item">Pesanan Online</a>
                        <a href="/pesanan-offline" class="sidebar-submenu-item">Pesanan Offline</a>
                    </div>
                </div>
                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle active" onclick="toggleMenu(this)">
                        <span><i class="fas fa-database"></i> Data</span>
                        <i class="fas fa-chevron-down toggle-arrow open"></i>
                    </button>
                    <div class="sidebar-submenu open">
                        <a href="/data-karyawan" class="sidebar-submenu-item active">Data Karyawan</a>
                        <a href="/data-pelanggan" class="sidebar-submenu-item">Data Pelanggan</a>
                    </div>
                </div>
                <div class="sidebar-menu-item">
                    <a href="/produk">
                        <i class="fas fa-box"></i>
                        <span>Produk</span>
                    </a>
                </div>
                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle" onclick="toggleMenu(this)">
                        <span><i class="fas fa-money-bill-wave"></i> Pembayaran</span>
                        <i class="fas fa-chevron-down toggle-arrow"></i>
                    </button>
                    <div class="sidebar-submenu">
                        <a href="/stor-karyawan" class="sidebar-submenu-item">Stor Karyawan</a>
                        <a href="/riwayat-transaksi" class="sidebar-submenu-item">Riwayat Transaksi</a>
                    </div>
                </div>
                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle" onclick="toggleMenu(this)">
                        <span><i class="fas fa-file-alt"></i> Laporan</span>
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
        <main class="main-content">
            <!-- Header -->
            @include('layouts.header', ['title' => 'Data Karyawan', 'showSearch' => false, 'showAddButton' => false, 'totalNotifikasi' => 0])

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="page-header-left">
                        <h1>Data Karyawan</h1>
                        <p>Kelola data karyawan Three D Bakery</p>
                    </div>
                    <div class="page-header-right">
                        <div class="search-input">
                            <input type="text" id="searchInput" placeholder="Cari karyawan...">
                            <i class="fas fa-search"></i>
                        </div>
                        <button class="btn btn-export">
                            <i class="fas fa-download"></i> Export
                        </button>
                        <button class="btn btn-primary" onclick="openAddModal()">
                            <i class="fas fa-plus"></i> Tambah Karyawan
                        </button>
                    </div>
                </div>

                <!-- Statistic Cards -->
                <div class="stat-cards">
                    <!-- Total Karyawan Card -->
                    <div class="stat-card brown">
                        <div class="stat-card-header">
                            <div class="stat-card-info">
                                <p>Total Karyawan</p>
                                <p>{{ $total }}</p>
                            </div>
                            <div class="stat-card-icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Karyawan Aktif Card -->
                    <div class="stat-card green">
                        <div class="stat-card-header">
                            <div class="stat-card-info">
                                <p>Karyawan Aktif</p>
                                <p>{{ $aktif }}</p>
                            </div>
                            <div class="stat-card-icon">
                                <i class="fas fa-badge-check"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Karyawan Nonaktif Card -->
                    <div class="stat-card red">
                        <div class="stat-card-header">
                            <div class="stat-card-info">
                                <p>Karyawan Nonaktif</p>
                                <p>{{ $nonaktif }}</p>
                            </div>
                            <div class="stat-card-icon">
                                <i class="fas fa-user-slash"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="table-container">
                    @if($karyawans->count() > 0)
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>No HP</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($karyawans as $key => $karyawan)
                                <tr>
                                    <td>{{ ($karyawans->currentPage() - 1) * $karyawans->perPage() + $key + 1 }}</td>
                                    <td>{{ $karyawan->nama }}</td>
                                    <td>{{ $karyawan->no_tlp }}</td>
                                    <td>{{ $karyawan->alamat }}</td>
                                    <td>
                                        @if($karyawan->status === 'Aktif')
                                            <span class="status-badge status-active">✓ Aktif</span>
                                        @else
                                            <span class="status-badge status-inactive">✕ Nonaktif</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="action-buttons">
                                            <button class="btn-action" onclick="viewKaryawan({{ $karyawan->id_karyawan }})" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-action" onclick="editKaryawan({{ $karyawan->id_karyawan }})" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-action" onclick="deleteKaryawan({{ $karyawan->id_karyawan }}, '{{ $karyawan->nama }}')" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination">
                        {{ $karyawans->links('pagination::bootstrap-4') }}
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>Belum ada data karyawan</p>
                        <p class="subtitle">Tambahkan karyawan untuk memulai</p>
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Tambah/Edit Karyawan -->
    <div id="modalKaryawan" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Tambah Karyawan</h3>
            </div>
            
            <form id="formKaryawan" method="POST" onsubmit="handleFormSubmit(event)">
                @csrf
                
                <div class="form-group">
                    <label for="nama">Nama Karyawan</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                
                <div class="form-group">
                    <label for="no_tlp">No HP</label>
                    <input type="text" id="no_tlp" name="no_tlp" required>
                </div>
                
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeAddModal()">Batal</button>
                    <button type="submit" class="btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleMenu(button) {
            const submenu = button.nextElementSibling;
            const arrow = button.querySelector('.toggle-arrow');
            submenu.classList.toggle('open');
            arrow.classList.toggle('open');
        }

        function openAddModal() {
            document.getElementById('modalKaryawan').classList.add('show');
            document.getElementById('formKaryawan').reset();
            document.getElementById('modalTitle').textContent = 'Tambah Karyawan';
            document.getElementById('formKaryawan').removeAttribute('data-id');
        }

        function closeAddModal() {
            document.getElementById('modalKaryawan').classList.remove('show');
        }

        function editKaryawan(id) {
            fetch(`/api/karyawans/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('nama').value = data.nama;
                    document.getElementById('no_tlp').value = data.no_tlp;
                    document.getElementById('alamat').value = data.alamat;
                    document.getElementById('status').value = data.status;
                    document.getElementById('formKaryawan').setAttribute('data-id', id);
                    document.getElementById('modalTitle').textContent = 'Edit Karyawan';
                    document.getElementById('modalKaryawan').classList.add('show');
                })
                .catch(err => alert('Gagal memuat data karyawan'));
        }

        function viewKaryawan(id) {
            fetch(`/api/karyawans/${id}`)
                .then(response => response.json())
                .then(data => {
                    alert(`Nama: ${data.nama}\nNo HP: ${data.no_tlp}\nAlamat: ${data.alamat}\nStatus: ${data.status}`);
                })
                .catch(err => alert('Gagal memuat data karyawan'));
        }

        function deleteKaryawan(id, nama) {
            if (confirm(`Apakah Anda yakin ingin menghapus karyawan "${nama}"?`)) {
                fetch(`/api/karyawans/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Gagal menghapus karyawan');
                    }
                })
                .catch(err => alert('Gagal menghapus karyawan'));
            }
        }

        function handleFormSubmit(event) {
            event.preventDefault();
            const id = document.getElementById('formKaryawan').getAttribute('data-id');
            const method = id ? 'PUT' : 'POST';
            const url = id ? `/api/karyawans/${id}` : '/api/karyawans';
            
            const formData = new FormData(document.getElementById('formKaryawan'));
            
            fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Gagal menyimpan data');
                }
            })
            .catch(err => alert('Gagal menyimpan data'));
        }

        // Close modal when clicking outside
        document.getElementById('modalKaryawan').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddModal();
            }
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Add CSRF token to meta if not present
        if (!document.querySelector('meta[name="csrf-token"]')) {
            const meta = document.createElement('meta');
            meta.name = 'csrf-token';
            meta.content = '{{ csrf_token() }}';
            document.head.appendChild(meta);
        }
    </script>
</body>
</html>
