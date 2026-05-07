@extends('layouts.app')

@section('content')
<style>
    * {
        font-family: 'Poppins', sans-serif;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        border-radius: 12px;
        border: 1px solid #E8DFD5;
        overflow: hidden;
    }
    
    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 32px rgba(134, 111, 71, 0.12);
        border-color: #D4BFA8;
    }
    
    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .btn-transition {
        transition: all 0.3s ease;
    }
    
    .btn-transition:active {
        transform: scale(0.98);
    }
    
    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 20px;
        border: 1px solid #D4BFA8;
        background: white;
        color: #6B5F54;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .filter-badge.active {
        background: #C69C6D;
        color: white;
        border-color: #C69C6D;
    }
    
    .filter-badge:hover:not(.active) {
        border-color: #A0815A;
    }
</style>

<div class="min-h-screen bg-[#F7F3E9] px-6 md:px-10 py-8 md:py-12">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header Section -->
        <div class="mb-8 md:mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-[#42352A] mb-2">
                Produk
            </h1>
            <p class="text-[#8B7355] text-base md:text-lg font-light">
                Kelola semua produk roti dan varian rasa
            </p>
        </div>

        <!-- Control Bar -->
        <div class="flex flex-col gap-4 md:flex-row md:gap-6 md:items-center md:justify-between mb-10">
            
            <!-- Filter Buttons (Left) -->
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

            <!-- Search Input (Center/Right) -->
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

                <!-- Add Product Button -->
                <button class="btn-transition flex items-center justify-center gap-2 px-4 py-2.5 bg-[#C69C6D] hover:bg-[#B38A5C] text-white rounded-lg font-semibold text-sm shadow-sm whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Produk</span>
                </button>
            </div>
        </div>

        <!-- Products Grid -->
        <div id="produkGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            <!-- Products will be rendered here -->
        </div>

        <!-- Empty State -->
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
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <!-- Modal Header -->
        <div class="border-b border-[#E5D5C0] p-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-[#42352A]">Tambah Produk Baru</h2>
                <button type="button" id="closeModal" class="text-[#8B7355] hover:text-[#42352A] text-2xl leading-none">
                    ×
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <form id="addProductForm" class="p-6 space-y-4">
            <!-- Product Name -->
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

            <!-- Product Description -->
            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    Deskripsi
                </label>
                <textarea
                    id="productDescription"
                    placeholder="Deskripsi produk..."
                    rows="3"
                    class="w-full px-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent resize-none"
                    required
                ></textarea>
            </div>

            <!-- Product Price -->
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

            <!-- Product Image URL -->
            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    URL Gambar
                </label>
                <input
                    type="text"
                    id="productImage"
                    placeholder="/image/produk.jpg"
                    class="w-full px-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent text-sm"
                    required
                />
            </div>

            <!-- Modal Footer -->
            <div class="flex gap-3 pt-4 border-t border-[#E5D5C0]">
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

<!-- Edit Product Modal -->
<div id="editProductModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <!-- Modal Header -->
        <div class="border-b border-[#E5D5C0] p-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-[#42352A]">Edit Produk</h2>
                <button type="button" id="closeEditModal" class="text-[#8B7355] hover:text-[#42352A] text-2xl leading-none">
                    ×
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <form id="editProductForm" class="p-6 space-y-4">
            <input type="hidden" id="editProductId" />

            <!-- Product Name -->
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

            <!-- Product Description -->
            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    Deskripsi
                </label>
                <textarea
                    id="editProductDescription"
                    rows="3"
                    class="w-full px-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent resize-none"
                    required
                ></textarea>
            </div>

            <!-- Product Price -->
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

            <!-- Product Image URL -->
            <div>
                <label class="block text-sm font-semibold text-[#42352A] mb-2">
                    URL Gambar
                </label>
                <input
                    type="text"
                    id="editProductImage"
                    class="w-full px-4 py-2.5 border border-[#D4BFA8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent text-sm"
                    required
                />
            </div>

            <!-- Modal Footer -->
            <div class="flex gap-3 pt-4 border-t border-[#E5D5C0]">
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

<script>
    const produkData = [
        {
            id: 1,
            nama: "D'Blueberry",
            gambar: '/image/blueberry.jpg',
            deskripsi: 'Roti lembut dengan isian blueberry premium.',
            harga: 'Rp. 1.300',
            status: 'aktif',
        },
        {
            id: 2,
            nama: "D'Kacang Hijau",
            gambar: '/image/kacanghijau.jpg',
            deskripsi: 'Roti lembut dengan isian kacang hijau manis.',
            harga: 'Rp. 1.300',
            status: 'aktif',
        },
        {
            id: 3,
            nama: "D'Coklat",
            gambar: '/image/coklat.jpg',
            deskripsi: 'Roti lembut dengan isian coklat leleh premium.',
            harga: 'Rp. 1.300',
            status: 'aktif',
        },
        {
            id: 4,
            nama: "D'Strawberry",
            gambar: '/image/strawberry.jpg',
            deskripsi: 'Roti lembut dengan isian strawberry segar.',
            harga: 'Rp. 1.300',
            status: 'aktif',
        },
        {
            id: 5,
            nama: "D'Kelapa",
            gambar: '/image/kelapa.jpg',
            deskripsi: 'Roti lembut dengan isian kelapa gurih manis.',
            harga: 'Rp. 1.300',
            status: 'aktif',
        },
    ];

    let currentFilter = 'semua';
    let currentSearch = '';

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

        grid.innerHTML = filtered.map(produk => `
            <div class="product-card bg-white rounded-lg border border-[#E8DFD5]">
                <!-- Image Container -->
                <div class="relative h-48 overflow-hidden bg-[#F5F1EB]">
                    <img
                        src="${produk.gambar}"
                        alt="${produk.nama}"
                        class="product-image w-full h-full"
                        onerror="this.src='https://via.placeholder.com/400x300?text=${encodeURIComponent(produk.nama)}'"
                    />
                    <!-- Status Badge (Top Right) -->
                    <div class="absolute top-3 right-3">
                        <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-500 text-white text-xs font-bold rounded-full shadow-md">
                            <span class="w-1.5 h-1.5 bg-emerald-200 rounded-full"></span>
                            Aktif
                        </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <!-- Product Name -->
                    <h3 class="text-base font-bold text-[#42352A] mb-2 line-clamp-1">
                        ${produk.nama}
                    </h3>

                    <!-- Description -->
                    <p class="text-sm text-[#8B7355] mb-3 line-clamp-2">
                        ${produk.deskripsi}
                    </p>

                    <!-- Price -->
                    <p class="text-base font-bold text-[#A0815A] mb-3">
                        ${produk.harga}
                    </p>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <button class="btn-transition edit-btn flex-1 flex items-center justify-center gap-1.5 px-3 py-2 bg-[#F9D79B] hover:bg-[#F6C878] text-[#42352A] rounded-lg font-semibold text-sm shadow-sm" data-product-id="${produk.id}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Edit</span>
                        </button>
                        <button class="btn-transition delete-btn flex-1 flex items-center justify-center gap-1.5 px-3 py-2 bg-[#FFD1DC] hover:bg-[#FFBBD4] text-[#C41E3A] rounded-lg font-semibold text-sm shadow-sm" data-product-id="${produk.id}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');

        // Attach event listeners to edit and delete buttons
        attachButtonListeners();
    }

    // Function to attach event listeners to product buttons
    function attachButtonListeners() {
        // Edit button listeners
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const productId = parseInt(e.currentTarget.dataset.productId);
                const product = produkData.find(p => p.id === productId);
                
                if (product) {
                    document.getElementById('editProductId').value = product.id;
                    document.getElementById('editProductName').value = product.nama;
                    document.getElementById('editProductDescription').value = product.deskripsi;
                    document.getElementById('editProductPrice').value = product.harga.replace('Rp. ', '');
                    document.getElementById('editProductImage').value = product.gambar;
                    
                    document.getElementById('editProductModal').classList.remove('hidden');
                }
            });
        });

        // Delete button listeners
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const productId = parseInt(e.currentTarget.dataset.productId);
                const product = produkData.find(p => p.id === productId);
                
                if (product && confirm(`Hapus produk "${product.nama}"?`)) {
                    produkData.splice(produkData.indexOf(product), 1);
                    renderProducts();
                    alert('Produk berhasil dihapus!');
                }
            });
        });
    }

    // Event Listeners
    document.getElementById('searchInput').addEventListener('input', (e) => {
        currentSearch = e.target.value;
        renderProducts();
    });

    document.querySelectorAll('.filter-badge').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const filter = e.currentTarget.dataset.filter;
            currentFilter = filter;
            
            // Update UI
            document.querySelectorAll('.filter-badge').forEach(b => {
                b.classList.remove('active');
            });
            e.currentTarget.classList.add('active');
            
            renderProducts();
        });
    });

    // Add Product Modal functionality
    const modal = document.getElementById('addProductModal');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const addProductForm = document.getElementById('addProductForm');

    // Find and attach click listener to tambah produk button
    setTimeout(() => {
        const tambahBtn = Array.from(document.querySelectorAll('button')).find(btn => {
            return btn.textContent.includes('Tambah Produk');
        });

        if (tambahBtn) {
            tambahBtn.addEventListener('click', () => {
                modal.classList.remove('hidden');
            });
        }
    }, 100);

    closeModal.addEventListener('click', () => {
        modal.classList.add('hidden');
        addProductForm.reset();
    });

    cancelBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        addProductForm.reset();
    });

    // Close modal when clicking outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            addProductForm.reset();
        }
    });

    // Handle add form submission
    addProductForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const newProduct = {
            id: produkData.length + 1,
            nama: document.getElementById('productName').value,
            deskripsi: document.getElementById('productDescription').value,
            harga: 'Rp. ' + document.getElementById('productPrice').value,
            gambar: document.getElementById('productImage').value,
            status: 'aktif'
        };

        produkData.push(newProduct);
        renderProducts();
        
        // Close modal and reset form
        modal.classList.add('hidden');
        addProductForm.reset();
        
        // Show success message
        alert('Produk berhasil ditambahkan!');
    });

    // Edit Product Modal functionality
    const editModal = document.getElementById('editProductModal');
    const closeEditModal = document.getElementById('closeEditModal');
    const cancelEditBtn = document.getElementById('cancelEditBtn');
    const editProductForm = document.getElementById('editProductForm');

    closeEditModal.addEventListener('click', () => {
        editModal.classList.add('hidden');
        editProductForm.reset();
    });

    cancelEditBtn.addEventListener('click', () => {
        editModal.classList.add('hidden');
        editProductForm.reset();
    });

    // Close edit modal when clicking outside
    editModal.addEventListener('click', (e) => {
        if (e.target === editModal) {
            editModal.classList.add('hidden');
            editProductForm.reset();
        }
    });

    // Handle edit form submission
    editProductForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const productId = parseInt(document.getElementById('editProductId').value);
        const product = produkData.find(p => p.id === productId);
        
        if (product) {
            product.nama = document.getElementById('editProductName').value;
            product.deskripsi = document.getElementById('editProductDescription').value;
            product.harga = 'Rp. ' + document.getElementById('editProductPrice').value;
            product.gambar = document.getElementById('editProductImage').value;
            
            renderProducts();
            
            // Close modal and reset form
            editModal.classList.add('hidden');
            editProductForm.reset();
            
            // Show success message
            alert('Produk berhasil diperbarui!');
        }
    });

    // Initial render
    renderProducts();
</script>
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
