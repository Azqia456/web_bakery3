@extends('layouts.dashboard-layout', ['pageTitle' => 'Data Karyawan'])

@section('additional-styles')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; margin-bottom: 24px; flex-wrap: wrap; }

    .page-header-left h1 { font-size: 32px; font-weight: 700; color: #2D3748; margin: 0; }
    .page-header-left p { font-size: 14px; color: #6C757D; margin: 8px 0 0 0; }

    .page-header-right { display: flex; gap: 10px; flex-wrap: wrap; }

    .search-input { position: relative; flex: 1; min-width: 200px; }
    .search-input input { width: 100%; padding: 10px 16px 10px 40px; border: 1px solid #E9ECEF; border-radius: 12px; background: #FFFFFF; font-size: 14px; }
    .search-input i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #D4A574; }

    .btn { padding: 10px 16px; border-radius: 12px; font-weight: 600; font-size: 14px; border: none; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; }

    .btn-export { background: #F7F3E9; color: #8B6F47; border: 1px solid #D4A574; }
    .btn-export:hover { background: #E9ECEF; }

    .btn-primary { background: #D4A574; color: #FFFFFF; }
    .btn-primary:hover { background: #C49564; transform: translateY(-2px); }

    .stat-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 24px; }

    .stat-card { background: #FFFFFF; padding: 20px; border-radius: 16px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border-top: 4px solid; transition: all 0.3s ease; }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1); }

    .stat-card.brown { border-top-color: #D4A574; }
    .stat-card.green { border-top-color: #10B981; }
    .stat-card.red { border-top-color: #EF4444; }

    .stat-card-header { display: flex; justify-content: space-between; align-items: flex-start; }
    .stat-card-info p:first-child { font-size: 13px; color: #6C757D; margin: 0; }
    .stat-card-info p:last-child { font-size: 32px; font-weight: 700; color: #2D3748; margin: 8px 0 0 0; }

    .stat-card-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }

    .stat-card.brown .stat-card-icon { background: #FFF5E6; color: #D4A574; }
    .stat-card.green .stat-card-icon { background: #ECFDF5; color: #10B981; }
    .stat-card.red .stat-card-icon { background: #FEF2F2; color: #EF4444; }

    .table-container { background: #FFFFFF; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); }
    .table-wrapper { overflow-x: auto; }

    table { width: 100%; border-collapse: collapse; }
    thead { background: #F7F3E9; border-bottom: 1px solid #E9ECEF; }
    th { padding: 16px; text-align: left; font-weight: 600; font-size: 13px; color: #2D3748; letter-spacing: 0.3px; }
    tbody tr { border-bottom: 1px solid #E9ECEF; transition: all 0.3s ease; }
    tbody tr:hover { background: #F8F9FA; }
    td { padding: 16px; font-size: 14px; color: #2D3748; }

    .status-badge { display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .status-active { background: #ECFDF5; color: #10B981; }
    .status-inactive { background: #FEF2F2; color: #EF4444; }

    .action-buttons { display: flex; gap: 8px; }
    .btn-action { width: 36px; height: 36px; border-radius: 12px; background: transparent; border: none; color: #D4A574; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; transition: all 0.3s ease; }
    .btn-action:hover { background: #F7F3E9; }

    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state i { font-size: 64px; color: #D4A574; opacity: 0.3; margin-bottom: 16px; }
    .empty-state p { font-size: 16px; color: #2D3748; margin: 8px 0; }
    .empty-state p.subtitle { color: #6C757D; font-size: 14px; }

    .modal { display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 2000; align-items: center; justify-content: center; }
    .modal.show { display: flex; }

    .modal-content { background: #FFFFFF; border-radius: 16px; width: 90%; max-width: 500px; padding: 32px; box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1); animation: slideIn 0.3s ease; }

    @keyframes slideIn {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header { margin-bottom: 24px; }
    .modal-header h3 { font-size: 20px; font-weight: 700; color: #2D3748; margin: 0; }

    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #2D3748; margin-bottom: 8px; }
    .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px 12px; border: 1px solid #E9ECEF; border-radius: 12px; font-size: 14px; font-family: inherit; color: #2D3748; }
    .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: #D4A574; box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.1); }
    .form-group textarea { resize: vertical; min-height: 80px; }

    .modal-footer { display: flex; gap: 12px; margin-top: 24px; }
    .modal-footer button { flex: 1; padding: 12px; border-radius: 12px; font-weight: 600; font-size: 14px; border: none; cursor: pointer; transition: all 0.3s ease; }
    .modal-footer .btn-cancel { background: #F7F3E9; color: #8B6F47; border: 1px solid #D4A574; }
    .modal-footer .btn-cancel:hover { background: #E9ECEF; }
    .modal-footer .btn-submit { background: #D4A574; color: #FFFFFF; }
    .modal-footer .btn-submit:hover { background: #C49564; }

    .pagination { display: flex; justify-content: flex-end; align-items: center; gap: 10px; padding: 20px; border-top: 1px solid #E9ECEF; }

    @media (max-width: 768px) {
        .page-header { flex-direction: column; }
        .page-header-right { width: 100%; }
        .stat-cards { grid-template-columns: 1fr; }
        table { font-size: 12px; }
        th, td { padding: 12px; }
    }
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <!-- Page Header -->
    <div class="page-header">
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

    <!-- Data Table -->
    <div class="table-container">
        <div class="table-wrapper">
            <table id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($karyawans->isEmpty())
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 60px 20px;">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>Belum ada data karyawan</p>
                                <p class="subtitle">Klik tombol "Tambah Karyawan" untuk menambah data</p>
                            </div>
                        </td>
                    </tr>
                    @else
                    @foreach($karyawans as $index => $karyawan)
                    <tr>
                        <td>{{ ($karyawans->currentPage() - 1) * $karyawans->perPage() + $index + 1 }}</td>
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
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action" onclick="viewKaryawan({{ $karyawan->id_karyawan }})" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action" onclick="editKaryawan({{ $karyawan->id_karyawan }})" title="Edit">
                                    <i class="fas fa-pencil"></i>
                                </button>
                                <button class="btn-action" onclick="deleteKaryawan({{ $karyawan->id_karyawan }}, '{{ $karyawan->nama }}')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="pagination">
            {{ $karyawans->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Karyawan -->
<div class="modal" id="karyawanModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Tambah Karyawan</h3>
        </div>
        <form id="karyawanForm" onsubmit="handleFormSubmit(event)">
            @csrf
            <div class="form-group">
                <label for="nama">Nama Karyawan</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="no_tlp">No HP</label>
                <input type="tel" id="no_tlp" name="no_tlp" required>
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
let editingId = null;
const modal = document.getElementById('karyawanModal');

function openAddModal() {
    editingId = null;
    document.getElementById('modalTitle').textContent = 'Tambah Karyawan';
    document.getElementById('karyawanForm').reset();
    modal.classList.add('show');
}

function closeAddModal() {
    modal.classList.remove('show');
    editingId = null;
}

function editKaryawan(id) {
    editingId = id;
    fetch(`/api/karyawans/${id}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('modalTitle').textContent = 'Edit Karyawan';
            document.getElementById('nama').value = data.nama;
            document.getElementById('no_tlp').value = data.no_tlp;
            document.getElementById('alamat').value = data.alamat;
            document.getElementById('status').value = data.status;
            modal.classList.add('show');
        });
}

function viewKaryawan(id) {
    fetch(`/api/karyawans/${id}`)
        .then(res => res.json())
        .then(data => {
            alert(`Nama: ${data.nama}\nNo HP: ${data.no_tlp}\nAlamat: ${data.alamat}\nStatus: ${data.status}`);
        });
}

function deleteKaryawan(id, nama) {
    if (confirm(`Yakin ingin menghapus karyawan "${nama}"?`)) {
        fetch(`/api/karyawans/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(res => res.json())
        .then(() => {
            location.reload();
        });
    }
}

function handleFormSubmit(event) {
    event.preventDefault();
    const formData = new FormData(document.getElementById('karyawanForm'));
    const data = {
        nama: formData.get('nama'),
        no_tlp: formData.get('no_tlp'),
        alamat: formData.get('alamat'),
        status: formData.get('status')
    };

    const method = editingId ? 'PUT' : 'POST';
    const url = editingId ? `/api/karyawans/${editingId}` : '/api/karyawans';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(() => {
        closeAddModal();
        location.reload();
    });
}

document.getElementById('searchInput').addEventListener('keyup', (e) => {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#dataTable tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

modal.addEventListener('click', (e) => {
    if (e.target === modal) closeAddModal();
});
</script>
@endsection
