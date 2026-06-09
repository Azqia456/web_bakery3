@extends('layouts.pelanggan')

@section('content')
            <div>
                <div class="welcome-section">
                    <div class="welcome-greeting">Selamat datang, Pelanggan 👋</div>
                    <div class="welcome-subtitle">Pilih roti favorit kamu hari ini</div>
                    <button id="cartBtn" style="position: absolute; top: 0; right: 0; width: 48px; height: 48px; border-radius: 50%; background: #4b2f1c; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 20px; color: var(--white); box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                        <i class="fas fa-shopping-cart"></i>
                        <span id="cartBadge" style="position: absolute; top: -4px; right: -4px; width: 20px; height: 20px; background: #EF4444; color: white; border-radius: 50%; font-size: 11px; display: flex; align-items: center; justify-content: center; font-weight: bold;">0</span>
                    </button>
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
@endsection

@push('scripts')
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

        function normalizeProductName(name) {
            return (name || '').toLowerCase().replace(/\s+/g, ' ').trim();
        }

        function getProductImagePath(name) {
            const productImageMap = {
                'roti kelapa': '/image/kelapa.png',
                'roti kacang ijo': '/image/kacanghiaju.png',
                'roti kacang hijau': '/image/kacanghiaju.png',
                'roti stroberi': '/image/strawberry.png',
                'roti strawberry': '/image/strawberry.png',
                'roti bluberi': '/image/bluberry.png',
                'roti blueberry': '/image/bluberry.png',
                'roti cokelat': '/image/coklat.png',
                'roti coklat': '/image/coklat.png',
                'roti cokelat premium': '/image/coklat.png',
                'roti coklat premium': '/image/coklat.png'
            };

            return productImageMap[normalizeProductName(name)] || '/image/rotibulat.png';
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
                    const imagePath = getProductImagePath(productName);
                    return `
                    <div
                        class="product-card"
                        data-id="${product.id_produk}"
                        data-name="${productName}"
                        data-price="${parseInt(product.harga_produk || 0)}"
                        data-emoji="${product.emoji || '🍞'}"
                        data-image="${imagePath}"
                        data-desc="${description}"
                    >
                        <div class="product-media">
                            <div class="product-image no-image">
                                <img
                                    src="${imagePath}"
                                    alt="${productName}"
                                    onload="this.parentElement.classList.remove('no-image')"
                                    onerror="this.style.display='none'; this.parentElement.classList.add('no-image');"
                                />
                                <span class="product-emoji">${product.emoji || '🍞'}</span>
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
            makeProductsAddToCart();
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
                
                if (data.summary_cards && data.summary_cards[0]) {
                    document.getElementById('totalOrders').textContent = data.summary_cards[0].value || '0';
                }
                if (data.summary_cards && data.summary_cards[1]) {
                    document.getElementById('totalSpent').textContent = data.summary_cards[1].value || 'Rp 0';
                }
                if (data.summary_cards && data.summary_cards[2]) {
                    document.getElementById('completedOrders').textContent = data.summary_cards[2].value || '0';
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
                    const itemsHTML = (order.items || []).slice(0, 3).map(item => {
                        const itemName = item.nama_produk || 'Produk';
                        const itemImage = getProductImagePath(itemName);
                        return `
                        <div class="order-item">
                            <div class="order-item-icon no-image">
                                <img
                                    src="${itemImage}"
                                    alt="${itemName}"
                                    onload="this.parentElement.classList.remove('no-image')"
                                    onerror="this.style.display='none'; this.parentElement.classList.add('no-image');"
                                />
                                <span class="order-emoji">${item.emoji || '🍞'}</span>
                            </div>
                            <div class="order-item-details">
                                <div class="order-item-name">${itemName}</div>
                                <div class="order-item-qty">${item.jumlah || item.quantity || 1} item${(item.jumlah || item.quantity || 1) > 1 ? 's' : ''}</div>
                            </div>
                        </div>
                    `;
                    }).join('');

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
                    resetMetodePengambilan();
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

            cartItems.innerHTML = cart.map(item => {
                const itemImage = item.image || getProductImagePath(item.nama_produk);
                return `
                <div class="cart-item">
                    <div class="cart-item-image no-image">
                        <img
                            src="${itemImage}"
                            alt="${item.nama_produk}"
                            onload="this.parentElement.classList.remove('no-image')"
                            onerror="this.style.display='none'; this.parentElement.classList.add('no-image');"
                        />
                        <span class="cart-emoji">${item.emoji || '🍞'}</span>
                    </div>
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
            `;
            }).join('');

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

        function toggleMetodePengambilan() {
            const metode = document.querySelector('input[name="metode_pengambilan"]:checked');
            const deliveryFields = document.getElementById('deliveryFields');
            const alamatInput = document.getElementById('alamatDeliveryInput');
            if (deliveryFields) {
                const isDelivery = metode && metode.value === 'delivery';
                deliveryFields.style.display = isDelivery ? 'block' : 'none';
                if (isDelivery && alamatInput && !alamatInput.value.trim()) {
                    alamatInput.value = deliveryFields.dataset.alamat || '';
                }
            }
        }

        function resetMetodePengambilan() {
            const pickupRadio = document.querySelector('input[name="metode_pengambilan"][value="pickup"]');
            if (pickupRadio) pickupRadio.checked = true;
            toggleMetodePengambilan();
        }

        // Payment Modal
        function initializePaymentModal() {
            const paymentModal = document.getElementById('paymentModal');
            const paymentModalClose = document.getElementById('paymentModalClose');
            const backToCartBtn = document.getElementById('backToCartBtn');
            const submitPaymentBtn = document.getElementById('submitPaymentBtn');
            const paymentForm = document.getElementById('paymentForm');
            const proofInput = document.getElementById('buktiTransferInput');
            const proofDropzone = document.getElementById('proofDropzone');
            const proofFileLabel = document.getElementById('proofFileLabel');
            const paymentConfirmCheckbox = document.getElementById('paymentConfirmCheckbox');

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

            if (proofInput && proofFileLabel && proofDropzone) {
                const updateProofLabel = () => {
                    const selectedFile = proofInput.files && proofInput.files[0];
                    proofFileLabel.textContent = selectedFile ? selectedFile.name : 'Pilih File';
                    proofDropzone.classList.toggle('has-file', !!selectedFile);
                };

                proofInput.addEventListener('change', updateProofLabel);
                updateProofLabel();
            }

            submitPaymentBtn.addEventListener('click', () => {
                if (!proofInput || !proofInput.files || !proofInput.files[0]) {
                    showNotification('Bukti pembayaran wajib diunggah.', 'error');
                    proofInput?.focus();
                    return;
                }

                const proofFile = proofInput.files[0];
                const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
                const maxSize = 2 * 1024 * 1024;

                if (!allowedTypes.includes(proofFile.type)) {
                    showNotification('Format bukti pembayaran harus JPG, PNG, atau PDF.', 'error');
                    return;
                }

                if (proofFile.size > maxSize) {
                    showNotification('Ukuran bukti pembayaran maksimal 2 MB.', 'error');
                    return;
                }

                if (paymentConfirmCheckbox && !paymentConfirmCheckbox.checked) {
                    showNotification('Silakan centang konfirmasi pembayaran.', 'error');
                    return;
                }

                submitPayment();
            });
        }

        function updatePaymentTotal() {
            const total = cart.reduce((sum, item) => sum + (item.harga_produk * item.quantity), 0);
            const formattedTotal = `Rp ${parseInt(total).toLocaleString('id-ID')}`;
            document.getElementById('paymentTotal').textContent = formattedTotal;
            document.getElementById('paymentSubtotal').textContent = formattedTotal;
            document.getElementById('nominalTransferInput').value = Math.max(0, Math.round(total));

            const orderDate = new Date();
            const datePart = orderDate.toISOString().slice(0, 10);
            const orderSuffix = String(Math.floor(Math.random() * 9000) + 1000);
            const orderReference = `#TRX-${datePart}-${orderSuffix}`;
            document.getElementById('paymentOrderId').textContent = orderReference;
            document.getElementById('paymentOrderReferenceInput').value = orderReference;

            const paymentItemsInput = document.getElementById('paymentItemsInput');
            paymentItemsInput.value = JSON.stringify(cart.map(item => ({
                id_produk: item.id_produk,
                nama_produk: item.nama_produk,
                harga_produk: Number(item.harga_produk),
                quantity: Number(item.quantity || 1),
            })));

            const paymentOrderItems = document.getElementById('paymentOrderItems');
            if (!paymentOrderItems) {
                return;
            }

            if (cart.length === 0) {
                paymentOrderItems.innerHTML = '<div style="font-size: 13px; color: var(--dark-gray);">Belum ada item di keranjang</div>';
                return;
            }

            paymentOrderItems.innerHTML = cart.map(item => {
                const itemImage = item.image || getProductImagePath(item.nama_produk);
                const quantity = item.quantity || 1;
                const itemTotal = item.harga_produk * quantity;

                return `
                    <div class="payment-order-item">
                        <div class="payment-item-thumb">
                            <img src="${itemImage}" alt="${item.nama_produk}" onerror="this.style.display='none';" />
                        </div>
                        <div class="payment-item-info">
                            <strong>${item.nama_produk}</strong>
                            <span>${quantity} x Rp ${parseInt(item.harga_produk).toLocaleString('id-ID')}</span>
                        </div>
                        <div class="payment-item-price">Rp ${parseInt(itemTotal).toLocaleString('id-ID')}</div>
                    </div>
                `;
            }).join('');
        }

        async function submitPayment() {
            try {
                const form = document.getElementById('paymentForm');
                const formData = new FormData(form);
                formData.set('items', JSON.stringify(cart.map(item => ({
                    id_produk: item.id_produk,
                    nama_produk: item.nama_produk,
                    harga_produk: Number(item.harga_produk),
                    quantity: Number(item.quantity || 1),
                }))));

                const response = await fetch(form.dataset.paymentEndpoint || '/pelanggan/pembayaran/konfirmasi', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData,
                });

                const contentType = response.headers.get('content-type') || '';
                const result = contentType.includes('application/json')
                    ? await response.json()
                    : { message: await response.text() };

                if (!response.ok) {
                    throw new Error(result.message || 'Gagal mengirim bukti pembayaran');
                }

                finalizeManualPayment(result.message || 'Bukti pembayaran berhasil dikirim. Pesanan menunggu verifikasi.', 'success');
            } catch (error) {
                console.error('Error submitting payment:', error);
                showNotification('Gagal mengirim bukti pembayaran: ' + error.message, 'error');
            }
        }

        function finalizeManualPayment(message, type) {
            cart = [];
            saveCart();
            updateCartBadge();
            renderCart();
            resetPaymentForm();
            document.getElementById('paymentModal').classList.remove('show');
            showNotification(message, type);
            setTimeout(() => {
                loadOrders();
            }, 1000);
        }

        function resetPaymentForm() {
            const form = document.getElementById('paymentForm');
            const proofInput = document.getElementById('buktiTransferInput');
            const proofDropzone = document.getElementById('proofDropzone');
            const proofFileLabel = document.getElementById('proofFileLabel');

            if (form) {
                form.reset();
            }

            if (proofInput) {
                proofInput.value = '';
            }

            if (proofDropzone) {
                proofDropzone.classList.remove('has-file');
            }

            if (proofFileLabel) {
                proofFileLabel.textContent = 'Pilih File';
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
                        image: card.dataset.image || getProductImagePath(card.dataset.name),
                        emoji: card.dataset.emoji || card.querySelector('.product-emoji')?.textContent.trim() || '🍞'
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

@endpush
