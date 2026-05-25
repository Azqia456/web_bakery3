// File: public/js/pesanan-offline.js
// Handle pesanan offline dengan sinkronisasi ke database

// API Base URL
const API_BASE_URL = '/api/pesanan-offline';

// Data cache
let pesananCache = {
    karyawan: [],
    pelanggan: []
};

// Initialize
document.addEventListener('DOMContentLoaded', async function() {
    await loadPesananData();
    setupSearch();
    updateStats();
});

function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    if (!container) {
        alert(message);
        return;
    }

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;

    let icon = '<i class="fas fa-check-circle toast-icon"></i>';
    if (type === 'error') {
        icon = '<i class="fas fa-exclamation-circle toast-icon"></i>';
    } else if (type === 'info') {
        icon = '<i class="fas fa-info-circle toast-icon"></i>';
    }

    toast.innerHTML = `${icon}<div class="toast-text">${message}</div>`;
    container.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3500);
}

function setButtonLoading(isLoading) {
    const btn = document.getElementById('btnSavePesanan');
    if (!btn) {
        return;
    }

    if (isLoading) {
        btn.classList.add('loading');
        btn.disabled = true;
    } else {
        btn.classList.remove('loading');
        btn.disabled = false;
    }
}

function setFieldError(id, message) {
    const el = document.getElementById(id);
    if (!el) {
        return;
    }
    el.textContent = message;
    el.classList.add('show');
}

function clearFieldError(id) {
    const el = document.getElementById(id);
    if (!el) {
        return;
    }
    el.textContent = '';
    el.classList.remove('show');
}

function renderProdukList(pesanan) {
    const details = pesanan.detail_pesanans || pesanan.detailPesanans || [];
    if (!details.length) {
        return '-';
    }

    return details.map(item => {
        const namaProduk = item.produk?.nama_produk || item.nama_produk || 'Produk';
        return `${namaProduk} x${item.jumlah_pesan}`;
    }).join(', ');
}

function clearFormErrors() {
    const tbody = document.getElementById('bodyPelanggan');

    if (pesananCache.pelanggan.length === 0) {
        tbody.innerHTML = `<tr><td colspan="10" style="text-align: center; color: var(--dark-gray); padding: 40px;">
            <i class="fas fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
            Belum ada pesanan pelanggan</td></tr>`;
        return;
    }

    tbody.innerHTML = pesananCache.pelanggan.map(p => {
        const metode = p.metode_pengambilan || p.metode || 'pickup';
        const alamat = metode === 'delivery' ? (p.pelanggan?.alamat || '-') : '-';
        const statusLabel = p.status_bayar === 'lunas' ? 'Selesai' : 'Pending';
        const paymentLabel = p.status_bayar === 'lunas' ? 'Lunas' : 'Belum Lunas';
        const produkList = renderProdukList(p);
        const noHp = p.pelanggan?.no_tlp || '-';
        const tanggal = formatDate(p.tgl_pesan);
        const metodeLabel = metode === 'delivery' ? 'Delivery' : 'Pickup';

        return `
            <tr>
                <td><strong>#${p.id_pesanan}</strong></td>
                <td>${p.pelanggan?.nama || '-'}</td>
                <td>${noHp}</td>
                <td>${produkList}</td>
                <td>Rp ${formatNumber(p.total_bayar)}</td>
                <td>${metodeLabel}</td>
                <td>${alamat}</td>
                <td>
                    <div style="display: flex; flex-direction: column; gap: 6px;">
                        <span class="status-badge ${p.status_bayar === 'lunas' ? 'selesai' : 'pending'}">${statusLabel}</span>
                        <span class="payment-badge ${p.status_bayar}">${paymentLabel}</span>
                    </div>
                </td>
                <td>${tanggal}</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-icon" onclick="viewDetail(${p.id_pesanan})">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-icon" onclick="editPesanan(${p.id_pesanan})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon delete" onclick="deletePesanan(${p.id_pesanan})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');

        if (!noHpPelanggan) {
            setFieldError('errorNoHpPelanggan', 'No HP wajib diisi');
            hasError = true;
        } else if (!/^[0-9]+$/.test(noHpPelanggan)) {
            setFieldError('errorNoHpPelanggan', 'No HP harus berupa angka');
            hasError = true;
        }

        if (metode === 'delivery' && !alamatDelivery) {
            setFieldError('errorAlamatPelanggan', 'Alamat wajib diisi untuk delivery');
            hasError = true;
        }

        if (hasError) {
            showToast('Lengkapi data pelanggan yang wajib diisi', 'error');
            return;
        }

        formData.nama_pelanggan = namaPelanggan;
        formData.no_tlp = noHpPelanggan;
        formData.alamat = metode === 'delivery' ? alamatDelivery : null;
        formData.id_pelanggan = document.getElementById('namaPelanggan').dataset.id || null;
        formData.metode = metode;
        formData.tgl_pesan = metode === 'delivery'
            ? document.getElementById('tanggalDelivery').value
            : document.getElementById('tanggalPickupPelanggan').value;
    }

    // Kumpulkan produk
    const products = [];
    const productItems = document.querySelectorAll('.product-item');
    
    productItems.forEach(item => {
        const idProduk = item.dataset.idProduk;
        const jumlah = item.querySelector('input[data-quantity]').value;
        
        if (idProduk && jumlah) {
            products.push({
                id_produk: parseInt(idProduk),
                jumlah_pesan: parseInt(jumlah),
                nama_produk: item.dataset.namaProduk
            });
        }
    });

    if (products.length === 0) {
        showToast('Silakan tambahkan minimal satu produk', 'error');
        return;
    }

    formData.products = products;
    formData.total_bayar = calculateTotal();

    try {
        setButtonLoading(true);
        const response = await fetch(API_BASE_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify(formData)
        });

        const result = await response.json();

        if (response.ok && result.success) {
            showToast('Pesanan berhasil disimpan', 'success');
            closeModal('modalAddPesanan');
            
            // Reload data dari database
            await loadPesananData();
            
            // Reset form
            resetForm();
        } else {
            showToast(result.message || 'Gagal menyimpan pesanan', 'error');
        }
    } catch (error) {
        console.error('Error saving pesanan:', error);
        showToast(error.message || 'Terjadi kesalahan saat menyimpan', 'error');
    } finally {
        setButtonLoading(false);
    }
}

/**
 * Delete pesanan dari database
 */
async function deletePesanan(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus pesanan ini?')) {
        return;
    }

    try {
        const response = await fetch(`${API_BASE_URL}/${id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });

        const result = await response.json();

        if (response.ok && result.success) {
            showToast('Pesanan berhasil dihapus', 'success');
            await loadPesananData();
        } else {
            showToast(result.message || 'Gagal menghapus pesanan', 'error');
        }
    } catch (error) {
        console.error('Error deleting pesanan:', error);
        showToast(error.message || 'Terjadi kesalahan saat menghapus', 'error');
    }
}

/**
 * Render tabel pesanan
 */
function renderTables() {
    renderKaryawanTable();
    renderPelangganTable();
    updateStats();
}

function renderKaryawanTable() {
    const tbody = document.getElementById('bodyKaryawan');
    
    if (pesananCache.karyawan.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5" style="text-align: center; color: var(--dark-gray); padding: 40px;">
            <i class="fas fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
            Belum ada pesanan karyawan</td></tr>`;
        return;
    }

    tbody.innerHTML = pesananCache.karyawan.map(p => `
        <tr>
            <td><strong>#${p.id_pesanan}</strong></td>
            <td>${p.karyawan?.nama || '-'}</td>
            <td><span class="status-badge belum_stor">Belum Stor</span></td>
            <td>Rp ${formatNumber(p.total_bayar)}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-icon" onclick="viewDetail(${p.id_pesanan})">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-icon" onclick="editPesanan(${p.id_pesanan})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-icon delete" onclick="deletePesanan(${p.id_pesanan})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function renderProdukList(pesanan) {
    const details = pesanan.detail_pesanans || pesanan.detailPesanans || [];
    if (!details.length) {
        return '-';
    }

    return details.map(item => {
        const namaProduk = item.produk?.nama_produk || item.nama_produk || 'Produk';
        return `${namaProduk} x${item.jumlah_pesan}`;
    }).join(', ');
}

function renderPelangganTable() {
    const tbody = document.getElementById('bodyPelanggan');

    if (pesananCache.pelanggan.length === 0) {
        tbody.innerHTML = `<tr><td colspan="10" style="text-align: center; color: var(--dark-gray); padding: 40px;">
            <i class="fas fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
            Belum ada pesanan pelanggan</td></tr>`;
        return;
    }

    tbody.innerHTML = pesananCache.pelanggan.map(p => {
        const metode = p.metode_pengambilan || p.metode || 'pickup';
        const alamat = metode === 'delivery' ? (p.pelanggan?.alamat || '-') : '-';
        const statusLabel = p.status_bayar === 'lunas' ? 'Selesai' : 'Pending';
        const paymentLabel = p.status_bayar === 'lunas' ? 'Lunas' : 'Belum Lunas';
        const produkList = renderProdukList(p);
        const noHp = p.pelanggan?.no_tlp || '-';
        const tanggal = formatDate(p.tgl_pesan);
        const metodeLabel = metode === 'delivery' ? 'Delivery' : 'Pickup';

        return `
            <tr>
                <td><strong>#${p.id_pesanan}</strong></td>
                <td>${p.pelanggan?.nama || '-'}</td>
                <td>${noHp}</td>
                <td>${produkList}</td>
                <td>Rp ${formatNumber(p.total_bayar)}</td>
                <td>${metodeLabel}</td>
                <td>${alamat}</td>
                <td>
                    <div style="display: flex; flex-direction: column; gap: 6px;">
                        <span class="status-badge ${p.status_bayar === 'lunas' ? 'selesai' : 'pending'}">${statusLabel}</span>
                        <span class="payment-badge ${p.status_bayar}">${paymentLabel}</span>
                    </div>
                </td>
                <td>${tanggal}</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-icon" onclick="viewDetail(${p.id_pesanan})">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-icon" onclick="editPesanan(${p.id_pesanan})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon delete" onclick="deletePesanan(${p.id_pesanan})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
}

/**
 * Update stats
 */
function updateStats() {
    const all = [...pesananCache.karyawan, ...pesananCache.pelanggan];
    
    document.getElementById('total-pesanan').textContent = all.length;
    document.getElementById('pesanan-selesai').textContent = all.filter(p => p.status_bayar === 'lunas').length;
    document.getElementById('pesanan-pending').textContent = all.filter(p => p.status_bayar === 'belum_lunas').length;
    
    const total = all.reduce((sum, p) => sum + (parseFloat(p.total_bayar) || 0), 0);
    document.getElementById('total-revenue').textContent = 'Rp ' + formatNumber(total);
}

/**
 * Format number to Indonesian currency
 */
function formatNumber(num) {
    return parseInt(num || 0).toLocaleString('id-ID');
}

/**
 * Setup search functionality
 */
function setupSearch() {
    const searchKaryawan = document.getElementById('searchKaryawan');
    const searchPelanggan = document.getElementById('searchPelanggan');
    
    if (searchKaryawan) {
        searchKaryawan.addEventListener('input', function() {
            searchAndFilter('karyawan', this.value);
        });
    }
    
    if (searchPelanggan) {
        searchPelanggan.addEventListener('input', function() {
            searchAndFilter('pelanggan', this.value);
        });
    }
}

/**
 * Search and filter
 */
function searchAndFilter(type, query) {
    const tbody = type === 'karyawan' ? document.getElementById('bodyKaryawan') : document.getElementById('bodyPelanggan');
    const data = type === 'karyawan' ? pesananCache.karyawan : pesananCache.pelanggan;
    
    const filtered = data.filter(p => {
        const name = type === 'karyawan' ? (p.karyawan?.nama || '') : (p.pelanggan?.nama || '');
        const id = p.id_pesanan.toString();
        const phone = type === 'karyawan' ? '' : (p.pelanggan?.no_tlp || '');
        const normalizedQuery = query.toLowerCase();
        return name.toLowerCase().includes(normalizedQuery)
            || id.includes(normalizedQuery)
            || phone.toLowerCase().includes(normalizedQuery);
    });
    
    if (filtered.length === 0) {
        tbody.innerHTML = `<tr><td colspan="${type === 'karyawan' ? 5 : 10}" style="text-align: center;">Tidak ada data</td></tr>`;
        return;
    }
    
    // Render filtered
    const isKaryawan = type === 'karyawan';
    tbody.innerHTML = filtered.map(p => {
        if (isKaryawan) {
            return `
                <tr>
                    <td><strong>#${p.id_pesanan}</strong></td>
                    <td>${p.karyawan?.nama || '-'}</td>
                    <td><span class="status-badge belum_stor">Belum Stor</span></td>
                    <td>Rp ${formatNumber(p.total_bayar)}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" onclick="viewDetail(${p.id_pesanan})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="editPesanan(${p.id_pesanan})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon delete" onclick="deletePesanan(${p.id_pesanan})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }

        const metode = p.metode_pengambilan || p.metode || 'pickup';
        const alamat = metode === 'delivery' ? (p.pelanggan?.alamat || '-') : '-';
        const statusLabel = p.status_bayar === 'lunas' ? 'Selesai' : 'Pending';
        const paymentLabel = p.status_bayar === 'lunas' ? 'Lunas' : 'Belum Lunas';
        const produkList = renderProdukList(p);
        const noHp = p.pelanggan?.no_tlp || '-';
        const tanggal = formatDate(p.tgl_pesan);
        const metodeLabel = metode === 'delivery' ? 'Delivery' : 'Pickup';

        return `
            <tr>
                <td><strong>#${p.id_pesanan}</strong></td>
                <td>${p.pelanggan?.nama || '-'}</td>
                <td>${noHp}</td>
                <td>${produkList}</td>
                <td>Rp ${formatNumber(p.total_bayar)}</td>
                <td>${metodeLabel}</td>
                <td>${alamat}</td>
                <td>
                    <div style="display: flex; flex-direction: column; gap: 6px;">
                        <span class="status-badge ${p.status_bayar === 'lunas' ? 'selesai' : 'pending'}">${statusLabel}</span>
                        <span class="payment-badge ${p.status_bayar}">${paymentLabel}</span>
                    </div>
                </td>
                <td>${tanggal}</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-icon" onclick="viewDetail(${p.id_pesanan})">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-icon" onclick="editPesanan(${p.id_pesanan})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon delete" onclick="deletePesanan(${p.id_pesanan})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
}

/**
 * View detail pesanan
 */
function viewDetail(id) {
    alert('Fitur detail pesanan akan ditampilkan di modal');
}

/**
 * Edit pesanan
 */
function editPesanan(id) {
    alert('Fitur edit pesanan akan ditampilkan di modal');
}

/**
 * Modal functions
 */
function openAddModal() {
    document.getElementById('modalAddPesanan').classList.add('show');
    resetForm();
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('show');
}

/**
 * Toggle pesanan type
 */
function changePesananType() {
    const type = document.querySelector('input[name="tipePesanan"]:checked').value;
    document.getElementById('formKaryawan').style.display = type === 'karyawan' ? 'block' : 'none';
    document.getElementById('formPelanggan').style.display = type === 'pelanggan' ? 'block' : 'none';
    if (type === 'karyawan') {
        document.getElementById('tanggalDeliveryGroup').style.display = 'none';
        document.getElementById('alamatDeliveryGroup').classList.remove('is-visible');
        clearFormErrors();
    }
}

/**
 * Toggle metode pengambilan
 */
function changeMetode() {
    const metode = document.querySelector('input[name="metodeMetode"]:checked').value;
    const tanggalGroup = document.getElementById('tanggalDeliveryGroup');
    const alamatGroup = document.getElementById('alamatDeliveryGroup');

    if (metode === 'delivery') {
        tanggalGroup.style.display = 'block';
        alamatGroup.classList.add('is-visible');
    } else {
        tanggalGroup.style.display = 'none';
        alamatGroup.classList.remove('is-visible');
        document.getElementById('alamatDelivery').value = '';
        clearFieldError('errorAlamatPelanggan');
    }
}

/**
 * Add product row
 */
function addProductRow() {
    const productList = document.getElementById('productList');
    const html = `
        <div class="product-item" data-id-produk="">
            <div class="product-item-controls" style="flex: 1;">
                <label>Pilih Produk</label>
                <select class="product-select" onchange="updateProductInfo(this)" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #E9ECEF;">
                    <option value="">-- Pilih Produk --</option>
                </select>
            </div>
            <div class="product-item-controls">
                <label>Jumlah</label>
                <input type="number" class="product-quantity" data-quantity="1" value="1" min="1" onchange="updateTotal()">
            </div>
            <button type="button" class="btn-delete-product" onclick="removeProductRow(this)">Hapus</button>
        </div>
    `;
    productList.insertAdjacentHTML('beforeend', html);
    loadProductOptions();
}

/**
 * Remove product row
 */
function removeProductRow(button) {
    button.parentElement.remove();
    updateTotal();
}

/**
 * Load product options
 */
async function loadProductOptions() {
    try {
        const response = await fetch('/api/produks', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });

        if (response.ok) {
            const result = await response.json();
            const produks = result.data || result;

            document.querySelectorAll('.product-select').forEach(select => {
                select.innerHTML = '<option value="">-- Pilih Produk --</option>' + 
                    produks.map(p => `<option value="${p.id_produk}" data-nama="${p.nama_produk}" data-harga="${p.harga_produk}">${p.nama_produk} (Rp ${formatNumber(p.harga_produk)})</option>`).join('');
            });
        }
    } catch (error) {
        console.error('Error loading products:', error);
    }
}

/**
 * Update product info
 */
function updateProductInfo(select) {
    const item = select.closest('.product-item');
    const option = select.options[select.selectedIndex];
    
    if (option.value) {
        item.dataset.idProduk = option.value;
        item.dataset.namaProduk = option.dataset.nama;
        updateTotal();
    }
}

/**
 * Calculate total
 */
function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.product-item').forEach(item => {
        const select = item.querySelector('.product-select');
        const quantity = parseInt(item.querySelector('.product-quantity').value) || 0;
        const option = select.options[select.selectedIndex];
        
        if (option && option.dataset.harga) {
            total += parseFloat(option.dataset.harga) * quantity;
        }
    });
    
    updateTotal();
    return total;
}

/**
 * Update total display
 */
function updateTotal() {
    const total = calculateTotal();
    document.getElementById('totalPesanan').textContent = 'Rp ' + formatNumber(total);
}

/**
 * Reset form
 */
function resetForm() {
    document.getElementById('productList').innerHTML = '';
    document.getElementById('namaKaryawan').value = '';
    document.getElementById('namaPelanggan').value = '';
    document.getElementById('noHpPelanggan').value = '';
    document.getElementById('alamatDelivery').value = '';
    document.getElementById('tanggalPickupKaryawan').value = '';
    document.getElementById('tanggalPickupPelanggan').value = '';
    document.getElementById('tanggalDelivery').value = '';
    document.querySelector('input[name="tipePesanan"][value="karyawan"]').checked = true;
    document.querySelector('input[name="metodeMetode"][value="pickup"]').checked = true;
    document.getElementById('formKaryawan').style.display = 'block';
    document.getElementById('formPelanggan').style.display = 'none';
    document.getElementById('tanggalDeliveryGroup').style.display = 'none';
    document.getElementById('alamatDeliveryGroup').classList.remove('is-visible');
    document.getElementById('totalPesanan').textContent = 'Rp 0';
    clearFormErrors();
}

/**
 * Switch tab
 */
function switchTab(button, tab) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));
    
    button.classList.add('active');
    document.getElementById('tab-' + tab).classList.add('active');
}

/**
 * Filter table
 */
function filterTable(type) {
    // TODO: Implement filter logic
}

/**
 * Toggle submenu
 */
function toggleSubmenu(button) {
    const arrow = button.querySelector('.toggle-arrow');
    const submenu = button.nextElementSibling;
    
    arrow.classList.toggle('open');
    submenu.classList.toggle('open');
}
