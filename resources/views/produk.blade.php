@extends('layouts.dashboard-layout', ['pageTitle' => 'Produk'])

@section('additional-styles')
<style>
    .line-clamp-2 {
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .product-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white; border-radius: 12px; border: 1px solid #E8DFD5; overflow: hidden;
    }
    .product-card:hover {
        transform: translateY(-6px); box-shadow: 0 16px 32px rgba(134, 111, 71, 0.12); border-color: #D4BFA8;
    }
    .product-image {
        width: 100%; height: 200px; object-fit: cover; transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .product-card:hover .product-image { transform: scale(1.05); }
    .filter-badge {
        display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px;
        border-radius: 20px; border: 1px solid #D4BFA8; background: white; color: #6B5F54;
        font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.3s ease;
    }
    .filter-badge.active { background: #C69C6D; color: white; border-color: #C69C6D; }
    .filter-badge:hover:not(.active) { border-color: #A0815A; }
    .btn-transition { transition: all 0.3s ease; }
    .btn-transition:active { transform: scale(0.98); }

    /* Image Upload Preview Styles */
    .file-input-wrapper {
        position: relative;
        overflow: hidden;
    }

    .file-input-wrapper input[type="file"] {
        display: none;
    }

    .file-input-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 12px;
        border: 2px dashed #D4BFA8;
        border-radius: 12px;
        background: linear-gradient(135deg, #F9F6F1 0%, #F7F3E9 100%);
        cursor: pointer;
        transition: all 0.3s ease;
        min-height: 80px;
    }

    .file-input-label:hover {
        border-color: #C69C6D;
        background: linear-gradient(135deg, #FAF8F5 0%, #F8F5EC 100%);
    }

    .file-input-label.has-file {
        padding: 0;
        border: none;
        background: transparent;
        min-height: auto;
    }

    .file-input-icon {
        font-size: 24px;
        margin-bottom: 8px;
    }

    .file-input-text {
        text-align: center;
    }

    .file-input-text .file-main {
        font-weight: 600;
        color: #42352A;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .file-input-text .file-sub {
        font-size: 12px;
        color: #8B7355;
    }

    .image-preview-container {
        position: relative;
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        background: #F5F1EB;
        aspect-ratio: 16/9;
        display: none;
    }

    .image-preview-container.show {
        display: block;
    }

    .image-preview-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-preview-remove {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 32px;
        height: 32px;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .image-preview-remove:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    /* Modal Styling */
    #addProductModal.hidden,
    #editProductModal.hidden {
        display: none !important;
    }

    #addProductModal:not(.hidden),
    #editProductModal:not(.hidden) {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        background-color: rgba(0, 0, 0, 0.5) !important;
        z-index: 50 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        overflow-y: auto !important;
        padding: 24px 16px !important;
        margin: 0 !important;
    }

    #addProductForm,
    #editProductForm {
        padding: 16px !important;
    }

    .product-modal-card {
        width: min(900px, 100%);
        height: auto;
    }

    @media (min-width: 1024px) {
        #addProductModal:not(.hidden),
        #editProductModal:not(.hidden) {
            align-items: flex-start !important;
            padding: 72px 24px 24px 304px !important;
        }

        .product-modal-card {
            width: calc(100vw - 328px);
            max-width: calc(100vw - 328px);
            height: auto;
        }
    }
</style>
@endsection

@section('content')
<main class="dashboard-content">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col gap-4 md:flex-row md:gap-6 md:items-center md:justify-between mb-10">
            <div class="flex gap-2 items-center flex-wrap">
                <button class="filter-badge active" data-filter="semua">
                    <span>🎯</span>
                    <span>Semua Produk</span>
                </button>
                <button class="filter-badge" data-filter="aktif">
                    <span>🟢</span>
                    <span>Aktif</span>
                </button>
                <button class="filter-badge" data-filter="nonaktif">
                    <span>⭕</span>
                    <span>Nonaktif</span>
                </button>
            </div>

            <div class="flex gap-3 w-full md:w-auto md:flex-1 justify-end">
                <div class="relative w-full md:w-80">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-[#A0815A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Cari produk..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-lg bg-white border border-[#D4BFA8] focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent text-[#42352A] placeholder-[#A0815A] text-sm"
                    />
                </div>

                <button onclick="document.getElementById('addProductModal').classList.remove('hidden')" class="btn-transition flex items-center justify-center gap-2 px-4 py-2.5 bg-[#C69C6D] hover:bg-[#B38A5C] text-white rounded-lg font-semibold text-sm shadow-sm whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Produk</span>
                </button>
            </div>
        </div>

        <div id="produkGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            </div>

        <div id="emptyState" class="hidden text-center py-20">
            <div class="text-7xl mb-4">📦</div>
            <h3 class="text-2xl md:text-3xl font-bold text-[#42352A] mb-2">
                Tidak ada produk
            </h3>
            <p class="text-[#8B7355] text-lg">
                Coba ubah filter atau cari dengan kata kunci yang berbeda
            </p>
        </div>
    </div>
</main>

<div id="addProductModal" class="hidden">
    <div class="product-modal-card" style="background: white; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); display: flex; flex-direction: column; margin: auto;">
        <div class="border-b border-[#E5D5C0] p-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-[#42352A]">Tambah Produk Baru</h2>
                <button type="button" id="closeModal" class="text-[#8B7355] hover:text-[#42352A] text-2xl leading-none">
                    ×
                </button>
            </div>
        </div>

        <form id="addProductForm" class="p-6 space-y-2 overflow-visible flex-1" enctype="multipart/form-data">
            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    Nama Produk
                </label>
                <input
                    type="text"
                    id="productName"
                    placeholder="Contoh: D'Coklat"
                    class="w-full px-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent"
                    required
                />
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    Deskripsi
                </label>
                <textarea
                    id="productDescription"
                    placeholder="Deskripsi produk..."
                    rows="2"
                    class="w-full px-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent resize-none"
                ></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    Harga
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-[#A0815A] font-semibold">Rp. </span>
                    <input
                        type="number"
                        id="productPrice"
                        placeholder="1.300"
                        class="w-full pl-12 pr-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent"
                        required
                    />
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    Status
                </label>
                <select
                    id="productStatus"
                    class="w-full px-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent"
                >
                    <option value="Aktif" selected>Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    📸 Gambar Produk
                </label>
                <div class="file-input-wrapper">
                    <input
                        type="file"
                        id="productImage"
                        name="gambar"
                        accept="image/jpeg,image/jpg,image/png"
                        class="file-input"
                    />
                    <label for="productImage" class="file-input-label" id="productImageLabel">
                        <div class="file-input-icon">📁</div>
                        <div class="file-input-text">
                            <div class="file-main">Pilih atau drag gambar di sini</div>
                            <div class="file-sub">JPG, PNG - Max 2MB</div>
                        </div>
                    </label>
                    <div class="image-preview-container" id="productImagePreview">
                        <img id="productImagePreviewImg" alt="Preview" />
                        <button type="button" class="image-preview-remove" id="productImageRemove">✕</button>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2 border-t border-[#E5D5C0] flex-shrink-0 bg-white">
                <button
                    type="button"
                    id="cancelBtn"
                    class="flex-1 px-4 py-2.5 border border-[#D4BFA8] rounded-lg text-[#42352A] font-semibold hover:bg-[#F9F6F1] transition-colors"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="flex-1 px-4 py-2.5 bg-[#C69C6D] hover:bg-[#B38A5C] text-white rounded-lg font-semibold transition-colors"
                >
                    Tambah
                </button>
            </div>
        </form>
    </div>
</div>

<div id="editProductModal" class="hidden">
    <div class="product-modal-card" style="background: white; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); display: flex; flex-direction: column; margin: auto;">
        <div class="border-b border-[#E5D5C0] p-3">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-[#42352A]">Edit Produk</h2>
                <button type="button" id="closeEditModal" class="text-[#8B7355] hover:text-[#42352A] text-2xl leading-none">
                    ×
                </button>
            </div>
        </div>

        <form id="editProductForm" class="p-6 space-y-2 overflow-visible flex-1" enctype="multipart/form-data">
            <input type="hidden" id="editProductId" />

            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    Nama Produk
                </label>
                <input
                    type="text"
                    id="editProductName"
                    class="w-full px-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent"
                    required
                />
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    Deskripsi
                </label>
                <textarea
                    id="editProductDescription"
                    rows="2"
                    class="w-full px-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent resize-none"
                ></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    Harga
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-[#A0815A] font-semibold">Rp. </span>
                    <input
                        type="number"
                        id="editProductPrice"
                        class="w-full pl-12 pr-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent"
                        required
                    />
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    Status
                </label>
                <select
                    id="editProductStatus"
                    class="w-full px-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent"
                >
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    📸 Gambar Produk
                </label>
                <div class="file-input-wrapper">
                    <input
                        type="file"
                        id="editProductImage"
                        name="gambar"
                        accept="image/jpeg,image/jpg,image/png"
                        class="file-input"
                    />
                    <label for="editProductImage" class="file-input-label" id="editProductImageLabel">
                        <div class="file-input-icon">📁</div>
                        <div class="file-input-text">
                            <div class="file-main">Pilih atau drag gambar di sini</div>
                            <div class="file-sub">JPG, PNG - Max 2MB</div>
                        </div>
                    </label>
                    <div class="image-preview-container" id="editProductImagePreview">
                        <img id="editProductImagePreviewImg" alt="Preview" />
                        <button type="button" class="image-preview-remove" id="editProductImageRemove">✕</button>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2 border-t border-[#E5D5C0] flex-shrink-0 bg-white">
                <button
                    type="button"
                    id="cancelEditBtn"
                    class="flex-1 px-4 py-2.5 border border-[#D4BFA8] rounded-lg text-[#42352A] font-semibold hover:bg-[#F9F6F1] transition-colors"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="flex-1 px-4 py-2.5 bg-[#C69C6D] hover:bg-[#B38A5C] text-white rounded-lg font-semibold transition-colors"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('additional-scripts')
<script>
    // Move modals to body for proper fixed positioning
    setTimeout(() => {
        const addModal = document.getElementById('addProductModal');
        const editModal = document.getElementById('editProductModal');
        if (addModal && addModal.parentElement !== document.body) {
            document.body.appendChild(addModal);
        }
        if (editModal && editModal.parentElement !== document.body) {
            document.body.appendChild(editModal);
        }
    }, 0);

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

    // DATA DAN FUNGSI PRODUK - SINKRONISASI DENGAN DATABASE
    let produkData = [];
    let currentFilter = 'semua';
    let currentSearch = '';

    // Load data produk dari API
    async function loadProducts() {
        try {
            const response = await fetch('/api/produks');
            const data = await response.json();
            
            // Transform data dari database ke format UI
            produkData = data.map(produk => ({
                id: produk.id_produk,
                nama: produk.nama_produk,
                harga: produk.harga_produk,
                deskripsi: produk.deskripsi || '',
                gambar: produk.gambar ? '/storage/' + produk.gambar : null,
                status: (produk.status || 'Aktif').toLowerCase()
            }));
            
            renderProducts();
        } catch (error) {
            console.error('Error loading products:', error);
            renderProducts();
        }
    }

    function renderProducts() {
        const grid = document.getElementById('produkGrid');
        const emptyState = document.getElementById('emptyState');
        
        const filtered = produkData.filter((produk) => {
            const matchSearch = produk.nama.toLowerCase().includes(currentSearch.toLowerCase());
            const matchFilter = currentFilter === 'semua' || produk.status === currentFilter;
            return matchSearch && matchFilter;
        });

        if (filtered.length === 0) {
            grid.innerHTML = '';
            emptyState.classList.remove('hidden');
            return;
        }

        grid.innerHTML = filtered.map(produk => {
            return '<div class="product-card bg-white rounded-lg border border-[#E8DFD5]">' +
                '<div class="relative h-48 overflow-hidden bg-[#F5F1EB]">' +
                    '<img src="' + (produk.gambar || '') + '" alt="' + produk.nama + '" class="product-image w-full h-full" />' +
                    '<div class="absolute top-3 right-3">' +
                        (produk.status === 'aktif'
                            ? '<span class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-500 text-white text-xs font-bold rounded-full shadow-md"><span class="w-1.5 h-1.5 bg-emerald-200 rounded-full"></span>Aktif</span>'
                            : '<span class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-500 text-white text-xs font-bold rounded-full shadow-md"><span class="w-1.5 h-1.5 bg-red-200 rounded-full"></span>Nonaktif</span>'
                        ) +
                    '</div>' +
                '</div>' +
                '<div class="p-4">' +
                    '<h3 class="text-base font-bold text-[#42352A] mb-2 line-clamp-1">' + produk.nama + '</h3>' +
                    '<p class="text-sm text-[#8B7355] mb-3 line-clamp-2">' + (produk.deskripsi || 'Produk berkualitas dari Three D Bakery') + '</p>' +
                    '<p class="text-base font-bold text-[#A0815A] mb-3">Rp. ' + Number(produk.harga).toLocaleString('id-ID') + '</p>' +
                    '<div class="flex gap-2">' +
                        '<button class="btn-transition edit-btn flex-1 flex items-center justify-center gap-1.5 px-3 py-2 bg-[#F9D79B] hover:bg-[#F6C878] text-[#42352A] rounded-lg font-semibold text-sm shadow-sm" data-product-id="' + produk.id + '">' +
                            '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>' +
                            '<span>Edit</span>' +
                        '</button>' +
                        '<button class="btn-transition delete-btn flex-1 flex items-center justify-center gap-1.5 px-3 py-2 bg-[#FFD1DC] hover:bg-[#FFBBD4] text-[#C41E3A] rounded-lg font-semibold text-sm shadow-sm" data-product-id="' + produk.id + '">' +
                            '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>' +
                        '</button>' +
                    '</div>' +
                '</div>' +
            '</div>';
        }).join('');

        attachButtonListeners();
    }

    function attachButtonListeners() {
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const productId = parseInt(e.currentTarget.dataset.productId);
                const product = produkData.find(p => p.id === productId);
                
                if (product) {
                    document.getElementById('editProductId').value = product.id;
                    document.getElementById('editProductName').value = product.nama;
                    document.getElementById('editProductDescription').value = product.deskripsi || '';
                    document.getElementById('editProductPrice').value = product.harga;
                    document.getElementById('editProductStatus').value = product.status === 'aktif' ? 'Aktif' : 'Nonaktif';
                    
                    // Show existing image in preview if available
                    if (product.gambar) {
                        document.getElementById('editProductImagePreviewImg').src = product.gambar;
                        document.getElementById('editProductImagePreview').classList.add('show');
                        document.getElementById('editProductImageLabel').classList.add('hidden');
                    } else {
                        document.getElementById('editProductImagePreview').classList.remove('show');
                        document.getElementById('editProductImageLabel').classList.remove('hidden');
                    }
                    
                    document.getElementById('editProductModal').classList.remove('hidden');
                }
            });
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                const productId = parseInt(e.currentTarget.dataset.productId);
                const product = produkData.find(p => p.id === productId);
                
                if (product && confirm(`Hapus produk "${product.nama}"?`)) {
                    try {
                        const response = await fetch(`/api/produks/${productId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                                'Accept': 'application/json'
                            }
                        });
                        
                        if (response.ok) {
                            produkData = produkData.filter(p => p.id !== productId);
                            renderProducts();
                            alert('Produk berhasil dihapus!');
                        } else {
                            alert('Gagal menghapus produk!');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghapus produk!');
                    }
                }
            });
        });
    }

    document.getElementById('searchInput').addEventListener('input', (e) => {
        currentSearch = e.target.value;
        renderProducts();
    });

    document.querySelectorAll('.filter-badge').forEach(btn => {
        btn.addEventListener('click', (e) => {
            currentFilter = e.currentTarget.dataset.filter;
            document.querySelectorAll('.filter-badge').forEach(b => b.classList.remove('active'));
            e.currentTarget.classList.add('active');
            renderProducts();
        });
    });

    // IMAGE PREVIEW HANDLERS - ADD FORM
    const productImageInput = document.getElementById('productImage');
    const productImageLabel = document.getElementById('productImageLabel');
    const productImagePreview = document.getElementById('productImagePreview');
    const productImagePreviewImg = document.getElementById('productImagePreviewImg');
    const productImageRemove = document.getElementById('productImageRemove');

    productImageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                productImagePreviewImg.src = event.target.result;
                productImagePreview.classList.add('show');
                productImageLabel.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    productImageRemove.addEventListener('click', (e) => {
        e.preventDefault();
        productImageInput.value = '';
        productImagePreview.classList.remove('show');
        productImageLabel.classList.remove('hidden');
    });

    // Drag and drop for add form
    const fileInputWrapper = productImageLabel.parentElement;
    fileInputWrapper.addEventListener('dragover', (e) => {
        e.preventDefault();
        productImageLabel.style.borderColor = '#C69C6D';
        productImageLabel.style.backgroundColor = '#F8F5EC';
    });
    fileInputWrapper.addEventListener('dragleave', () => {
        productImageLabel.style.borderColor = '#D4BFA8';
        productImageLabel.style.backgroundColor = '';
    });
    fileInputWrapper.addEventListener('drop', (e) => {
        e.preventDefault();
        productImageLabel.style.borderColor = '#D4BFA8';
        productImageLabel.style.backgroundColor = '';
        if (e.dataTransfer.files.length > 0) {
            productImageInput.files = e.dataTransfer.files;
            const event = new Event('change', { bubbles: true });
            productImageInput.dispatchEvent(event);
        }
    });

    // IMAGE PREVIEW HANDLERS - EDIT FORM
    const editProductImageInput = document.getElementById('editProductImage');
    const editProductImageLabel = document.getElementById('editProductImageLabel');
    const editProductImagePreview = document.getElementById('editProductImagePreview');
    const editProductImagePreviewImg = document.getElementById('editProductImagePreviewImg');
    const editProductImageRemove = document.getElementById('editProductImageRemove');

    editProductImageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                editProductImagePreviewImg.src = event.target.result;
                editProductImagePreview.classList.add('show');
                editProductImageLabel.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    editProductImageRemove.addEventListener('click', (e) => {
        e.preventDefault();
        editProductImageInput.value = '';
        editProductImagePreview.classList.remove('show');
        editProductImageLabel.classList.remove('hidden');
    });

    // Drag and drop for edit form
    const editFileInputWrapper = editProductImageLabel.parentElement;
    editFileInputWrapper.addEventListener('dragover', (e) => {
        e.preventDefault();
        editProductImageLabel.style.borderColor = '#C69C6D';
        editProductImageLabel.style.backgroundColor = '#F8F5EC';
    });
    editFileInputWrapper.addEventListener('dragleave', () => {
        editProductImageLabel.style.borderColor = '#D4BFA8';
        editProductImageLabel.style.backgroundColor = '';
    });
    editFileInputWrapper.addEventListener('drop', (e) => {
        e.preventDefault();
        editProductImageLabel.style.borderColor = '#D4BFA8';
        editProductImageLabel.style.backgroundColor = '';
        if (e.dataTransfer.files.length > 0) {
            editProductImageInput.files = e.dataTransfer.files;
            const event = new Event('change', { bubbles: true });
            editProductImageInput.dispatchEvent(event);
        }
    });

    // Modals
    const modal = document.getElementById('addProductModal');
    const addProductForm = document.getElementById('addProductForm');

    setTimeout(() => {
        const tambahBtn = Array.from(document.querySelectorAll('button')).find(btn => btn.textContent.includes('Tambah Produk'));
        if (tambahBtn) tambahBtn.addEventListener('click', () => modal.classList.remove('hidden'));
    }, 100);

    document.getElementById('closeModal').addEventListener('click', () => { 
        modal.classList.add('hidden'); 
        addProductForm.reset();
        document.getElementById('productImagePreview').classList.remove('show');
        document.getElementById('productImageLabel').classList.remove('hidden');
    });
    document.getElementById('cancelBtn').addEventListener('click', () => { 
        modal.classList.add('hidden'); 
        addProductForm.reset();
        document.getElementById('productImagePreview').classList.remove('show');
        document.getElementById('productImageLabel').classList.remove('hidden');
    });
    modal.addEventListener('click', (e) => { 
        if (e.target === modal) { 
            modal.classList.add('hidden'); 
            addProductForm.reset();
            document.getElementById('productImagePreview').classList.remove('show');
            document.getElementById('productImageLabel').classList.remove('hidden');
        } 
    });

    addProductForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const productName = document.getElementById('productName').value.trim();
        const productPrice = document.getElementById('productPrice').value.trim();
        const productDescription = document.getElementById('productDescription').value.trim();
        
        // Validasi field wajib
        if (!productName) {
            alert('Nama produk harus diisi!');
            return;
        }
        
        if (!productPrice || parseFloat(productPrice) <= 0) {
            alert('Harga produk harus lebih dari 0!');
            return;
        }
        
        const formDataObj = new FormData();
        formDataObj.append('nama_produk', productName);
        formDataObj.append('harga_produk', parseFloat(productPrice));
        formDataObj.append('deskripsi', productDescription);
        formDataObj.append('status', document.getElementById('productStatus').value);
        
        if (document.getElementById('productImage').files.length > 0) {
            formDataObj.append('gambar', document.getElementById('productImage').files[0]);
        }

        try {
            const response = await fetch('/api/produks', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json'
                },
                body: formDataObj
            });

            const result = await response.json();
            console.log('Response:', response.status, result);

            if (response.ok) {
                const gambarUrl = result.gambar ? '/storage/' + result.gambar : null;
                produkData.push({
                    id: result.id_produk,
                    nama: result.nama_produk,
                    harga: result.harga_produk,
                    deskripsi: result.deskripsi || '',
                    gambar: gambarUrl,
                    status: (result.status || 'Aktif').toLowerCase()
                });
                renderProducts();
                modal.classList.add('hidden');
                addProductForm.reset();
                document.getElementById('productImagePreview').classList.remove('show');
                document.getElementById('productImageLabel').classList.remove('hidden');
                alert('Produk berhasil ditambahkan!');
            } else {
                const errorMessage = result.message || result.errors || JSON.stringify(result) || 'Unknown error';
                console.error('API Error:', errorMessage);
                alert('Gagal menambahkan produk:\n' + errorMessage);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menambahkan produk:\n' + error.message);
        }
    });

    const editModal = document.getElementById('editProductModal');
    const editProductForm = document.getElementById('editProductForm');

    document.getElementById('closeEditModal').addEventListener('click', () => { 
        editModal.classList.add('hidden'); 
        editProductForm.reset();
        document.getElementById('editProductImagePreview').classList.remove('show');
        document.getElementById('editProductImageLabel').classList.remove('hidden');
    });
    document.getElementById('cancelEditBtn').addEventListener('click', () => { 
        editModal.classList.add('hidden'); 
        editProductForm.reset();
        document.getElementById('editProductImagePreview').classList.remove('show');
        document.getElementById('editProductImageLabel').classList.remove('hidden');
    });
    editModal.addEventListener('click', (e) => { 
        if (e.target === editModal) { 
            editModal.classList.add('hidden'); 
            editProductForm.reset();
            document.getElementById('editProductImagePreview').classList.remove('show');
            document.getElementById('editProductImageLabel').classList.remove('hidden');
        } 
    });

    editProductForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const productId = parseInt(document.getElementById('editProductId').value);
        const editProductName = document.getElementById('editProductName').value.trim();
        const editProductPrice = document.getElementById('editProductPrice').value.trim();
        const editProductDescription = document.getElementById('editProductDescription').value.trim();
        
        // Validasi field wajib
        if (!editProductName) {
            alert('Nama produk harus diisi!');
            return;
        }
        
        if (!editProductPrice || parseFloat(editProductPrice) <= 0) {
            alert('Harga produk harus lebih dari 0!');
            return;
        }
        
        const formDataObj = new FormData();
        formDataObj.append('_method', 'PUT');
        formDataObj.append('nama_produk', editProductName);
        formDataObj.append('harga_produk', parseFloat(editProductPrice));
        formDataObj.append('deskripsi', editProductDescription);
        formDataObj.append('status', document.getElementById('editProductStatus').value);
        
        if (document.getElementById('editProductImage').files.length > 0) {
            formDataObj.append('gambar', document.getElementById('editProductImage').files[0]);
        }

        try {
            const response = await fetch(`/api/produks/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json'
                },
                body: formDataObj
            });

            const result = await response.json();
            console.log('Response:', response.status, result);

            if (response.ok) {
                const product = produkData.find(p => p.id === productId);
                if (product) {
                    product.nama = result.nama_produk;
                    product.harga = result.harga_produk;
                    product.deskripsi = result.deskripsi || '';
                    product.status = (result.status || 'Aktif').toLowerCase();
                    if (result.gambar) {
                        product.gambar = '/storage/' + result.gambar;
                    }
                    renderProducts();
                }
                editModal.classList.add('hidden');
                editProductForm.reset();
                document.getElementById('editProductImagePreview').classList.remove('show');
                document.getElementById('editProductImageLabel').classList.remove('hidden');
                alert('Produk berhasil diperbarui!');
            } else {
                const errorMessage = result.message || result.errors || JSON.stringify(result) || 'Unknown error';
                console.error('API Error:', errorMessage);
                alert('Gagal memperbarui produk:\n' + errorMessage);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memperbarui produk:\n' + error.message);
        }
    });

    // Load produk saat halaman dimuat
    loadProducts();

</script>
@endsection
