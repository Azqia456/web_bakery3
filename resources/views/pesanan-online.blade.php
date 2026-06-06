@extends('layouts.app')

@section('content')
<div class="dashboard">
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
                    <button class="sidebar-menu-toggle active" onclick="toggleSubmenu(this)" style="justify-content: flex-start; gap: 12px;">
                        <i class="fas fa-shopping-cart"></i>
                        <span style="font-weight:700;">Pesanan</span>
                        <i class="fas fa-chevron-down toggle-arrow open"></i>
                    </button>
                    <div class="sidebar-submenu open">
                        <a href="/pesanan-online" class="sidebar-submenu-item">Pesanan Online</a>
                        <a href="/pesanan-offline" class="sidebar-submenu-item">Pesanan Offline</a>
                    </div>
                </div>

                <div class="sidebar-menu-item">
                    <a href="/produk" style="justify-content: flex-start; gap: 12px;">
                        <i class="fas fa-box"></i>
                        <span style="font-weight:700;">Produk</span>
                    </a>
                </div>

                <div class="sidebar-menu-item">
                    <a href="/riwayat-transaksi" style="justify-content: flex-start; gap: 12px;">
                        <i class="fas fa-credit-card"></i>
                        <span style="font-weight:700;">Riwayat Transaksi</span>
                    </a>
                </div>

                <div class="sidebar-menu-item">
                    <button class="sidebar-menu-toggle" onclick="toggleSubmenu(this)" style="justify-content: flex-start; gap: 12px;">
                        <i class="fas fa-chart-line"></i>
                        <span style="font-weight:700;">Laporan</span>
                        <i class="fas fa-chevron-down toggle-arrow"></i>
                    </button>
                    <div class="sidebar-submenu">
                        <a href="/laporan-pesanan-online" class="sidebar-submenu-item">Laporan Pesanan Online</a>
                    </div>
                </div>
            </nav>
        </aside>

        <div class="main-content">
            @include('layouts.header', ['title' => 'Pesanan Online', 'showSearch' => true, 'showAddButton' => false, 'totalNotifikasi' => 0])

            <main class="dashboard-content" x-data="pesananOnline()">
            <!-- Content -->
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

                <!-- 5 Summary Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 mb-6">
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                        <div class="text-sm text-gray-500">Semua Pesanan</div>
                        <div class="text-2xl font-bold text-gray-800 mt-2" x-text="summary.semua"></div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                        <div class="text-sm text-gray-500">Menunggu Konfirmasi</div>
                        <div class="text-2xl font-bold text-gray-800 mt-2" x-text="summary.menunggu"></div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                        <div class="text-sm text-gray-500">Diproses</div>
                        <div class="text-2xl font-bold text-gray-800 mt-2" x-text="summary.diproses"></div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                        <div class="text-sm text-gray-500">Siap Diambil / Dikirim</div>
                        <div class="text-2xl font-bold text-gray-800 mt-2" x-text="summary.siap"></div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                        <div class="text-sm text-gray-500">Selesai</div>
                        <div class="text-2xl font-bold text-gray-800 mt-2" x-text="summary.selesai"></div>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 flex flex-col">
                    <!-- Toolbar -->
                    <div class="p-5 flex flex-col xl:flex-row items-center justify-between gap-4 border-b">
                        <div class="flex items-center gap-3 w-full xl:w-auto">
                            <label class="text-sm text-gray-600 mr-2">Pilih Tanggal:</label>
                            <input type="date" x-model="filterDate" class="px-3 py-2 border rounded-md text-sm">
                        </div>

                        <div class="flex items-center gap-3 w-full max-w-lg">
                            <input type="text" x-model="searchQuery" placeholder="Cari pesanan, pelanggan, produk" class="flex-1 px-4 py-2 border rounded-full text-sm" />
                            <select x-model="filterStatus" class="px-3 py-2 border rounded-md text-sm">
                                <option value="">Semua Pesanan</option>
                                <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                                <option value="Diproses">Diproses</option>
                                <option value="Siap Diambil">Siap Diambil</option>
                                <option value="Dikirim">Siap Dikirim</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-2 w-full xl:w-auto justify-end">
                            <button @click="refreshData" class="px-4 py-2 bg-white border rounded-md text-sm">Refresh</button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left whitespace-nowrap">
                            <thead class="bg-gray-50 text-sm text-gray-600">
                                <tr>
                                    <th class="px-4 py-3">No. Pesanan</th>
                                    <th class="px-4 py-3">Pelanggan</th>
                                    <th class="px-4 py-3">Produk</th>
                                    <th class="px-4 py-3">Total</th>
                                    <th class="px-4 py-3">Pembayaran</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Tenggat Waktu</th>
                                    <th class="px-4 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-gray-700 divide-y">
                                <template x-if="filteredOrders.length === 0">
                                    <tr>
                                        <td colspan="8" class="px-4 py-6 text-center text-gray-500">Belum ada data pesanan.</td>
                                    </tr>
                                </template>

                                <template x-for="(order, index) in filteredOrders" :key="order.id">
                                    <tr>
                                        <td class="px-4 py-3" x-text="order.id ?? ('#' + (index+1))"></td>
                                        <td class="px-4 py-3" x-text="order.pelanggan?.nama ?? '-' "></td>
                                        <td class="px-4 py-3" x-text="order.products ? order.products.length + ' item' : '-' "></td>
                                        <td class="px-4 py-3" x-text="formatRupiah(order.total ?? 0)"></td>
                                        <td class="px-4 py-3">Lunas</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 rounded-md text-xs" :class="statusClass(order.status)" x-text="order.status ?? '-' "></span>
                                        </td>
                                        <td class="px-4 py-3" x-text="order.tenggat ?? '-' "></td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2">
                                                <button @click="openDetail(order)" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">Detail</button>
                                                <button x-show="!order.submitted && order.status === 'Selesai'" @click="submitOrder(order)" class="px-3 py-1 bg-emerald-600 text-white rounded text-sm">Submit</button>
                                                <span x-show="order.submitted" class="text-sm text-gray-500">Terkirim</span>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <!-- Info Bottom -->
                    <div class="p-4 bg-[#FFF9F2] rounded-b-2xl border-t border-[#F2E5D5] flex items-start gap-3 mt-auto text-sm">
                        <div class="text-gray-700">Catatan: </div>
                        <div class="text-gray-600">Gunakan filter tanggal dan status untuk menyaring pesanan.</div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Detail Pesanan -->
    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;">
        <div class="fixed inset-0 bg-black/50" @click="modalOpen = false"></div>
        <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full z-10 p-6">
            <div class="flex items-start justify-between">
                <h3 class="text-lg font-medium">Rincian Pesanan</h3>
                <button @click="modalOpen = false" class="text-gray-500">Tutup</button>
            </div>
            <div class="mt-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-gray-500">Nama Pelanggan</div>
                        <div class="text-gray-800 font-semibold" x-text="selectedOrder.pelanggan?.nama ?? '-' "></div>

                        <div class="text-sm text-gray-500 mt-3">No. Telepon</div>
                        <div class="text-gray-800" x-text="selectedOrder.pelanggan?.telepon ?? '-' "></div>

                        <div class="text-sm text-gray-500 mt-3">Alamat</div>
                        <div class="text-gray-800" x-text="selectedOrder.pelanggan?.alamat ?? '-' "></div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Tgl Pesan</div>
                        <div class="text-gray-800" x-text="selectedOrder.tanggal ?? '-' "></div>

                        <div class="text-sm text-gray-500 mt-3">Tenggat Waktu</div>
                        <div class="text-gray-800" x-text="selectedOrder.tenggat ?? '-' "></div>

                        <div class="text-sm text-gray-500 mt-3">Bukti Pembayaran</div>
                        <div class="mt-2">
                            <img x-show="selectedOrder.bukti" :src="selectedOrder.bukti" alt="Bukti" class="max-h-40 object-contain" />
                            <div x-show="!selectedOrder.bukti" class="text-gray-500">Tidak ada bukti.</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="text-sm text-gray-500">Produk</div>
                    <ul class="mt-2 space-y-2">
                        <template x-for="p in selectedOrder.products ?? []" :key="p.name">
                            <li class="flex justify-between border rounded p-2">
                                <div>
                                    <div class="font-medium" x-text="p.name"></div>
                                    <div class="text-xs text-gray-500" x-text="p.qty + ' x ' + formatRupiah(p.price)"></div>
                                </div>
                                <div class="font-semibold" x-text="formatRupiah((p.qty||0) * (p.price||0))"></div>
                            </li>
                        </template>
                        <template x-if="(selectedOrder.products ?? []).length === 0">
                            <li class="text-gray-500">Belum ada produk.</li>
                        </template>
                    </ul>
                </div>

                <div class="mt-4 flex justify-end gap-2">
                    <button @click="modalOpen = false" class="px-4 py-2 border rounded">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div x-show="toast.show" x-transition class="fixed top-6 right-6 bg-emerald-500 text-white px-5 py-3 rounded-lg" style="display:none;" x-text="toast.message"></div>

</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('pesananOnline', () => ({
            profileOpen: false,
            modalOpen: false,
            searchQuery: '',
            filterStatus: '',
            filterDate: '',
            toast: { show: false, message: '' },
            selectedOrder: { products: [] },
            summary: { semua: 0, menunggu: 0, diproses: 0, siap: 0, selesai: 0 },
            orders: [], // kosong sesuai permintaan

            get filteredOrders() {
                return this.orders.filter(o => {
                    const q = this.searchQuery.trim().toLowerCase();
                    const matchesSearch = q === '' || (o.pelanggan && ((o.pelanggan.nama||'').toLowerCase().includes(q))) || (o.products && o.products.some(p => (p.name||'').toLowerCase().includes(q)) );
                    const matchesStatus = this.filterStatus === '' || o.status === this.filterStatus;
                    const matchesDate = this.filterDate === '' || (o.tanggal && o.tanggal.startsWith(this.filterDate));
                    return matchesSearch && matchesStatus && matchesDate;
                });
            },

            // Helpers
            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number || 0);
            },

            statusClass(status) {
                switch(status) {
                    case 'Menunggu Konfirmasi': return 'bg-amber-50 text-amber-700 border border-amber-200';
                    case 'Diproses': return 'bg-indigo-50 text-indigo-700 border border-indigo-200';
                    case 'Siap Diambil': return 'bg-emerald-50 text-emerald-700 border border-emerald-200';
                    case 'Dikirim': return 'bg-purple-50 text-purple-700 border border-purple-200';
                    case 'Selesai': return 'bg-green-50 text-green-700 border border-green-200';
                    default: return 'bg-gray-50 text-gray-700 border border-gray-100';
                }
            },

            openDetail(order) {
                this.selectedOrder = order || { products: [] };
                this.modalOpen = true;
            },

            submitOrder(order) {
                if(!order || order.status !== 'Selesai') return;
                order.submitted = true;
                this.toast.message = 'Pesanan berhasil disubmit ke Laporan!';
                this.toast.show = true;
                setTimeout(() => { this.toast.show = false }, 3000);
            },

            resetFilters() {
                this.searchQuery = '';
                this.filterStatus = '';
                this.filterDate = '';
            },

            refreshData() {
                // placeholder: di masa depan bisa fetch via AJAX
                this.toast.message = 'Data disegarkan';
                this.toast.show = true;
                setTimeout(() => { this.toast.show = false }, 2000);
            }
        }))
    })
</script>
<script>
    // Load Font Awesome if not present (for sidebar icons)
    (function loadFA(){
        if(!document.querySelector('link[href*="font-awesome"]') && !document.querySelector('link[href*="fontawesome"]')){
            const l = document.createElement('link');
            l.rel = 'stylesheet';
            l.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css';
            document.head.appendChild(l);
        }
    })();

    // sidebar toggle for submenu
    function toggleSubmenu(btn){
        try{
            const submenu = btn.nextElementSibling;
            const arrow = btn.querySelector('.toggle-arrow');
            if(submenu){
                submenu.classList.toggle('open');
                arrow && arrow.classList.toggle('open');
            }
        }catch(e){console.warn(e)}
    }
</script>
@endpush

@endsection
