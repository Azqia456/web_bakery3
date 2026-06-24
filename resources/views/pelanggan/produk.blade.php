@extends('layouts.pelanggan')

@section('content')
            <div>
                <div class="welcome-section">
                    <div class="welcome-greeting">Produk Kami 🍞</div>
                    <div class="welcome-subtitle">Pilih roti favorit kamu hari ini</div>
                    <button id="cartBtn" style="position: absolute; top: 0; right: 0; width: 48px; height: 48px; border-radius: 50%; background: #4b2f1c; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 20px; color: var(--white); box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                        <i class="fas fa-shopping-cart"></i>
                        <span id="cartBadge" style="position: absolute; top: -4px; right: -4px; width: 20px; height: 20px; background: #EF4444; color: white; border-radius: 50%; font-size: 11px; display: flex; align-items: center; justify-content: center; font-weight: bold;">0</span>
                    </button>
                </div>

                <!-- Products Section -->
                <div class="products-section">
                    <h2 class="section-title">
                        {{-- <i class="fas fa-star"></i> --}}
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
            const imageMap = {
                'Roti Cokelat': '{{ asset("image/coklat.jpg") }}',
                'Roti Coklat Premium': '{{ asset("image/coklat.jpg") }}',
                'Roti Stroberi': '{{ asset("image/strawberry.jpg") }}',
                'Roti Bluberi': '{{ asset("image/bluberry.jpg") }}',
                'Roti Kelapa': '{{ asset("image/kelapa.jpg") }}',
                'Roti Kacang Ijo': '{{ asset("image/kacanghiaju.jpg") }}',
            };

            const normalizedName = normalizeProductName(name);
            for (const [key, value] of Object.entries(imageMap)) {
                if (normalizedName.includes(normalizeProductName(key))) {
                    return value;
                }
            }

            return '{{ asset("image/rotibulat.png") }}';
        }

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
                    const imagePath = product.gambar ? `/storage/${product.gambar}` : getProductImagePath(productName);
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
                            {{-- <button class="product-fav" type="button" aria-label="Favorit">
                                <i class="far fa-heart"></i>
                            </button> --}}
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

        // Cart Management
        let cart = [];

        function initializeCart() {
            const cartBtn = document.getElementById('cartBtn');
            const cartModal = document.getElementById('cartModal');
            const cartModalClose = document.getElementById('cartModalClose');
            const continueShopping = document.getElementById('continueShopping');
            const checkoutBtn = document.getElementById('checkoutBtn');

            const savedCart = localStorage.getItem('bakery_cart');
            if (savedCart) {
                cart = JSON.parse(savedCart);
                updateCartBadge();
            }

            cartBtn.addEventListener('click', () => {
                cartModal.classList.add('show');
                renderCart();
            });

            cartModalClose.addEventListener('click', () => {
                cartModal.classList.remove('show');
            });

            continueShopping.addEventListener('click', () => {
                cartModal.classList.remove('show');
            });

            cartModal.addEventListener('click', (e) => {
                if (e.target === cartModal) {
                    cartModal.classList.remove('show');
                }
            });

            checkoutBtn.addEventListener('click', () => {
                if (cart.length === 0) {
                    alert('Keranjang masih kosong!');
                    return;
                }
                const lowQtyItem = cart.find(item => (item.quantity || 1) < 100);
                if (lowQtyItem) {
                    showNotification('Minimal pembelian 100 unit per produk. "' + lowQtyItem.nama_produk + '" hanya ' + (lowQtyItem.quantity || 1) + ' unit.', 'error');
                    return;
                }
                cartModal.classList.remove('show');
                setTimeout(() => {
                    document.getElementById('paymentModal').classList.add('show');
                    updatePaymentTotal();
                    resetMetodePengambilanGlobal();
                }, 300);
            });
        }

        function addToCart(product, quantity = 1) {
            const existingItem = cart.find(item => item.id_produk === product.id_produk);
            if (existingItem) {
                existingItem.quantity = (existingItem.quantity || 1) + quantity;
            } else {
                cart.push({ ...product, quantity: quantity });
            }
            saveCart();
            updateCartBadge();
            showNotification('Produk ditambahkan ke keranjang!');
        }

        function removeFromCart(productId) {
            cart = cart.filter(item => item.id_produk !== productId);
            saveCart();
            updateCartBadge();
            renderCart();
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
                        <img src="${itemImage}" alt="${item.nama_produk}" onload="this.parentElement.classList.remove('no-image')" onerror="this.style.display='none'; this.parentElement.classList.add('no-image');" />
                        <span class="cart-emoji">${item.emoji || '🍞'}</span>
                    </div>
                    <div class="cart-item-info">
                        <div class="cart-item-name">${item.nama_produk}</div>
                        <div class="cart-item-price">Rp ${parseInt(item.harga_produk).toLocaleString('id-ID')}</div>
                    </div>
                    <div class="cart-item-qty">
                        <button class="qty-btn" onclick="updateQuantity(${item.id_produk}, -1)">-</button>
                        <span class="qty-display">${item.quantity}</span>
                        <button class="qty-btn" onclick="updateQuantity(${item.id_produk}, 1)">+</button>
                    </div>
                    <button class="cart-remove" onclick="removeFromCart(${item.id_produk})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            }).join('');

            const subtotal = cart.reduce((sum, item) => sum + (item.harga_produk * item.quantity), 0);
            const shipping = typeof selectedOngkir !== 'undefined' ? selectedOngkir : 0;
            const total = subtotal + shipping;
            document.getElementById('subtotal').textContent = `Rp ${parseInt(subtotal).toLocaleString('id-ID')}`;
            document.getElementById('shipping').textContent = `Rp ${parseInt(shipping).toLocaleString('id-ID')}`;
            document.getElementById('total').textContent = `Rp ${parseInt(total).toLocaleString('id-ID')}`;
        }

        function updateCartBadge() {
            const badge = document.getElementById('cartBadge');
            const total = cart.length;
            badge.textContent = total > 0 ? total : '0';
        }

        function saveCart() {
            localStorage.setItem('bakery_cart', JSON.stringify(cart));
        }



        function resetMetodePengambilan() {
            resetMetodePengambilanGlobal();
        }

        function updatePaymentTotal() {
            const subtotal = cart.reduce((sum, item) => sum + (item.harga_produk * item.quantity), 0);
            const shipping = typeof selectedOngkir !== 'undefined' ? selectedOngkir : 0;
            const total = subtotal + shipping;
            const formattedTotal = `Rp ${parseInt(total).toLocaleString('id-ID')}`;
            const formattedSubtotal = `Rp ${parseInt(subtotal).toLocaleString('id-ID')}`;
            document.getElementById('paymentTotal').textContent = formattedTotal;
            document.getElementById('paymentSubtotal').textContent = formattedSubtotal;
            const ongkirRow = document.getElementById('paymentOngkirRow');
            const ongkirAmount = document.getElementById('paymentOngkirAmount');
            if (ongkirRow && ongkirAmount) {
                if (shipping > 0) {
                    ongkirRow.style.display = 'flex';
                    ongkirAmount.textContent = `Rp ${parseInt(shipping).toLocaleString('id-ID')}`;
                } else {
                    ongkirRow.style.display = 'none';
                }
            }

            const orderDate = new Date();
            const datePart = orderDate.toISOString().slice(0, 10);
            const orderSuffix = String(Math.floor(Math.random() * 9000) + 1000);
            const orderReference = `#TRX-${datePart}-${orderSuffix}`;
            document.getElementById('paymentOrderId').textContent = orderReference;

            const paymentOrderItems = document.getElementById('paymentOrderItems');
            if (!paymentOrderItems) return;
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

        async function submitXenditPayment() {
            const lowQtyItem = cart.find(item => (item.quantity || 1) < 100);
            if (lowQtyItem) {
                showNotification('Minimal pembelian 100 unit per produk. "' + lowQtyItem.nama_produk + '" hanya ' + (lowQtyItem.quantity || 1) + ' unit.', 'error');
                return;
            }
            const metodePengambilan = document.querySelector('input[name="metode_pengambilan"]:checked');
            const metode = metodePengambilan ? metodePengambilan.value : 'pickup';
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const minDate = new Date(today);
            minDate.setDate(today.getDate() + 2);
            const minDateStr = minDate.toISOString().slice(0, 10);
            const tglPickup = document.getElementById('tglPickupInput')?.value || '';
            const tglDelivery = document.getElementById('tglDeliveryInput')?.value || '';
            const tglValue = metode === 'pickup' ? tglPickup : tglDelivery;
            if (!tglValue) {
                showNotification('Silakan pilih tanggal ' + (metode === 'pickup' ? 'pickup' : 'delivery') + '.', 'error');
                return;
            }
            if (tglValue < minDateStr) {
                showNotification('Tanggal ' + (metode === 'pickup' ? 'pickup' : 'delivery') + ' minimal ' + minDate.toLocaleDateString('id-ID') + '.', 'error');
                return;
            }

            if (metode === 'delivery') {
                const kabSelect = document.getElementById('kabupatenSelect');
                const kecSelect = document.getElementById('kecamatanSelect');
                const alamatDetail = document.getElementById('alamatDetailInput')?.value.trim();

                if (!kabSelect || !kabSelect.value) {
                    showNotification('Silakan pilih Kabupaten / Kota.', 'error');
                    return;
                }
                if (!kecSelect || !kecSelect.value) {
                    showNotification('Silakan pilih Kecamatan.', 'error');
                    return;
                }
                if (!alamatDetail) {
                    showNotification('Silakan isi Alamat Detail.', 'error');
                    return;
                }
            }

            const xenditBtn = document.getElementById('payWithXenditBtn');
            const originalBtnHtml = xenditBtn ? xenditBtn.innerHTML : '';
            if (xenditBtn) {
                xenditBtn.disabled = true;
                xenditBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses pembayaran...';
            }

            try {
                const idKecamatan = document.getElementById('kecamatanSelect')?.value || '';
                const alamatDetail = document.getElementById('alamatDetailInput')?.value || '';
                const tglDelivery = document.getElementById('tglDeliveryInput')?.value || '';
                const tglPickup = document.getElementById('tglPickupInput')?.value || '';
                const alamatDelivery = generateAlamatDelivery();

                const payload = {
                    items: JSON.stringify(cart.map(item => ({
                        id_produk: item.id_produk,
                        nama_produk: item.nama_produk,
                        harga_produk: Number(item.harga_produk),
                        quantity: Number(item.quantity || 1),
                    }))),
                    metode_pengambilan: metode,
                    id_kecamatan: idKecamatan || '',
                    alamat_detail: alamatDetail,
                    alamat_delivery: alamatDelivery,
                    tgl_delivery: tglDelivery,
                    tgl_pickup: tglPickup,
                };

                const response = await fetch('/api/xendit/invoice', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Gagal membuat pembayaran');
                }

                if (result.success && result.data.invoice_url) {
                    window.location.href = result.data.invoice_url;
                } else {
                    throw new Error('URL pembayaran tidak ditemukan');
                }
            } catch (error) {
                if (xenditBtn) {
                    xenditBtn.disabled = false;
                    xenditBtn.innerHTML = originalBtnHtml;
                }
                showNotification('Gagal memproses pembayaran: ' + error.message, 'error');
            }
        }

        function initializePaymentModal() {
            const paymentModal = document.getElementById('paymentModal');
            const paymentModalClose = document.getElementById('paymentModalClose');
            const backToCartBtn = document.getElementById('backToCartBtn');
            const submitPaymentBtn = document.getElementById('submitPaymentBtn');

            paymentModalClose.addEventListener('click', () => paymentModal.classList.remove('show'));
            backToCartBtn.addEventListener('click', () => {
                paymentModal.classList.remove('show');
                setTimeout(() => document.getElementById('cartModal').classList.add('show'), 300);
            });
            paymentModal.addEventListener('click', (e) => { if (e.target === paymentModal) paymentModal.classList.remove('show'); });

            const xenditBtn = document.getElementById('payWithXenditBtn');
            if (xenditBtn) {
                xenditBtn.addEventListener('click', () => {
                    submitXenditPayment();
                });
            }

            if (submitPaymentBtn) submitPaymentBtn.style.display = 'none';
        }

        function showNotification(message, type = 'info') {
            alert(message);
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
                    qtyInput.value = Math.max(1, parseInt(qtyInput.value || '1', 10));
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

        document.addEventListener('DOMContentLoaded', () => {
            loadProducts();
            initializeCart();
            initializePaymentModal();
        });
</script>
@endpush
