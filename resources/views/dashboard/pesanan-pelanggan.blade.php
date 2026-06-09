@extends('layouts.pelanggan')

@push('styles')
<style>
.section.content {
    max-width: 1400px;
    margin: 0 auto;
}

.card {
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-md);
    overflow: hidden;
}

.card-header {
    padding: 24px;
    border-bottom: 1px solid var(--medium-gray);
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.card-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
}

.btn-action {
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
    background: linear-gradient(135deg, var(--light-brown, #C9A877), var(--primary-brown, #8B6F47));
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

.orders-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(420px, 1fr));
    gap: 16px;
    padding: 24px;
}

.order-card {
    background: var(--white);
    border: 1px solid var(--medium-gray);
    border-radius: var(--border-radius);
    padding: 20px;
    box-shadow: var(--shadow-sm);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 14px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--medium-gray);
}

.order-code {
    font-size: 13px;
    color: var(--dark-gray);
    font-weight: 500;
}

.order-date {
    font-size: 12px;
    color: var(--dark-gray);
    margin-top: 2px;
}

.order-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.order-status-badge.menunggu { background: #FEF3C7; color: #92400E; }
.order-status-badge.diproses { background: #DBEAFE; color: #1E40AF; }
.order-status-badge.siap { background: #F3E8FF; color: #6B21A8; }
.order-status-badge.dikirim { background: #FCE7F3; color: #9D174D; }
.order-status-badge.selesai { background: #DCFCE7; color: #166534; }

.order-items {
    margin-bottom: 14px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--medium-gray);
}

.order-item {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}

.order-item:last-child {
    margin-bottom: 0;
}

.order-item-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: linear-gradient(135deg, #E8DCC8 0%, #F5EFE7 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
    overflow: hidden;
}

.order-item-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.order-item-icon.no-image img {
    display: none;
}

.order-item-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-dark);
}

.order-item-qty {
    font-size: 12px;
    color: var(--dark-gray);
}

.order-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.order-total-label {
    font-size: 13px;
    color: var(--dark-gray);
    font-weight: 500;
}

.order-total-value {
    font-size: 16px;
    font-weight: 700;
    color: var(--primary-brown);
}

.timeline-container {
    padding-top: 4px;
}

.timeline-steps {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
}

.timeline-step {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    min-width: 0;
}

.timeline-dot {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: var(--medium-gray);
    border: 2px solid var(--white);
    box-shadow: 0 0 0 1px var(--medium-gray);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    color: var(--dark-gray);
    margin-bottom: 6px;
    z-index: 2;
    position: relative;
    flex-shrink: 0;
}

.timeline-dot.active {
    background: var(--primary-brown);
    color: var(--white);
    box-shadow: 0 0 0 1px var(--primary-brown);
}

.timeline-dot.completed {
    background: #22C55E;
    color: var(--white);
    box-shadow: 0 0 0 1px #22C55E;
}

.timeline-dot i {
    font-size: 9px;
}

.timeline-label {
    font-size: 10px;
    color: var(--dark-gray);
    text-align: center;
    font-weight: 500;
    white-space: nowrap;
}

.timeline-line-wrapper {
    position: absolute;
    top: 11px;
    left: 50%;
    width: 100%;
    z-index: 1;
}

.timeline-line {
    height: 2px;
    background: var(--medium-gray);
    width: 100%;
}

.timeline-line.active {
    background: var(--primary-brown);
}

.timeline-line.completed {
    background: #22C55E;
}

.timeline-step:last-child .timeline-line-wrapper {
    display: none;
}

.empty-state {
    text-align: center;
    padding: 64px;
    color: var(--dark-gray);
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.3;
}

.empty-state p {
    font-size: 16px;
    margin: 0;
}

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 100;
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
    max-height: 90vh;
    overflow-y: auto;
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
    color: var(--text-dark);
}

.modal-close {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 50%;
    background: var(--white);
    cursor: pointer;
    font-size: 14px;
    color: var(--dark-gray);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
}

.modal-close:hover {
    background: var(--medium-gray);
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
    font-size: 14px;
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
    background: linear-gradient(135deg, var(--light-brown, #C9A877), var(--primary-brown, #8B6F47));
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

.filter-bar {
    display: flex;
    gap: 8px;
    padding: 0 24px 24px;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 6px 14px;
    border: 1px solid var(--medium-gray);
    background: var(--white);
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    color: var(--dark-gray);
    cursor: pointer;
    transition: var(--transition);
}

.filter-btn:hover {
    border-color: var(--primary-brown);
    color: var(--primary-brown);
}

.filter-btn.active {
    background: var(--primary-brown);
    color: var(--white);
    border-color: var(--primary-brown);
}

@media (max-width: 768px) {
    .orders-grid {
        grid-template-columns: 1fr;
        padding: 16px;
    }
    .card-header {
        flex-direction: column;
        gap: 12px;
    }
    .timeline-label {
        font-size: 9px;
    }
}
</style>
@endpush

@section('content')
    <main class="main-content" style="padding:0;">
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h2 class="card-title">Daftar Pesanan Saya</h2>
                        <p style="font-size: 13px; color: var(--dark-gray); margin-top: 4px;">Pantau status pesanan Anda melalui timeline di bawah ini.</p>
                    </div>
                    {{-- <div style="display:flex; gap:10px; flex-wrap:wrap;">
                        <button type="button" class="btn-action btn-payment" onclick="openPaymentModal()"><i class="fas fa-credit-card"></i> Konfirmasi Pembayaran</button>
                        <button type="button" class="btn-action btn-order" onclick="openOrderModal()"><i class="fas fa-bag-shopping"></i> Pesan</button>
                    </div> --}}
                </div>

                <div class="filter-bar">
                    <button class="filter-btn active" data-filter="all">Semua</button>
                    <button class="filter-btn" data-filter="menunggu_konfirmasi">Menunggu Konfirmasi</button>
                    <button class="filter-btn" data-filter="diproses">Diproses</button>
                    <button class="filter-btn" data-filter="siap_diambil">Siap Diambil</button>
                    <button class="filter-btn" data-filter="dikirim">Dikirim</button>
                    <button class="filter-btn" data-filter="selesai">Selesai</button>
                </div>

                <div class="orders-grid" id="ordersGrid">
                    @forelse($pesanans ?? [] as $order)
                        @php
                            $status = $order->status_pesanan ?: 'menunggu_konfirmasi';
                            $statusLabel = match($status) {
                                'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                                'diproses' => 'Diproses',
                                'siap_diambil' => 'Siap Diambil',
                                'dikirim' => 'Dikirim',
                                'selesai' => 'Selesai',
                                default => ucfirst($status),
                            };
                            $statusClass = match($status) {
                                'menunggu_konfirmasi' => 'menunggu',
                                'diproses' => 'diproses',
                                'siap_diambil' => 'siap',
                                'dikirim' => 'dikirim',
                                'selesai' => 'selesai',
                                default => 'menunggu',
                            };
                            $steps = ['Menunggu', 'Diproses', 'Siap', 'Dikirim', 'Selesai'];
                            $stepMap = ['menunggu_konfirmasi'=>0, 'diproses'=>1, 'siap_diambil'=>2, 'dikirim'=>3, 'selesai'=>4];
                            $currentStep = $stepMap[$status] ?? 0;
                            $isDone = $status === 'selesai';
                            $tgl = $order->tgl_pesan ? $order->tgl_pesan->locale('id')->isoFormat('D MMM YYYY') : '-';
                        @endphp
                        <div class="order-card" data-status="{{ $status }}">
                            <div class="order-header">
                                <div>
                                    <div class="order-code">#ORD-{{ $order->id_pesanan }}</div>
                                    <div class="order-date"><i class="far fa-calendar-alt"></i> {{ $tgl }}</div>
                                </div>
                                <span class="order-status-badge {{ $statusClass }}">
                                    <i class="fas {{ $status === 'selesai' ? 'fa-check-circle' : ($status === 'dikirim' ? 'fa-truck' : ($status === 'diproses' ? 'fa-spinner' : 'fa-clock')) }}"></i>
                                    {{ $statusLabel }}
                                </span>
                            </div>
                            <div class="order-items">
                                @foreach($order->detailPesanans as $item)
                                    <div class="order-item">
                                        <div class="order-item-icon">
                                            <span>🍞</span>
                                        </div>
                                        <div>
                                            <div class="order-item-name">{{ $item->produk->nama_produk ?? 'Produk' }}</div>
                                            <div class="order-item-qty">{{ $item->jumlah_pesan ?? 1 }} item</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="order-total">
                                <span class="order-total-label">Total Pesanan</span>
                                <span class="order-total-value">Rp {{ number_format($order->total_bayar ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="timeline-container">
                                <div class="timeline-steps">
                                    @foreach($steps as $i => $step)
                                        @php $completed = $isDone ? $i <= $currentStep : $i < $currentStep; @endphp
                                        <div class="timeline-step">
                                            <div class="timeline-dot {{ $completed ? 'completed' : ($i === $currentStep ? 'active' : '') }}">
                                                {{ $completed ? '✓' : $i + 1 }}
                                            </div>
                                            <div class="timeline-label">{{ $step }}</div>
                                            @if(!$loop->last)
                                            <div class="timeline-line-wrapper">
                                                <div class="timeline-line {{ $completed || $i === $currentStep ? 'active' : '' }}"></div>
                                            </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state" style="display:block; grid-column: 1 / -1;">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada pesanan</p>
                        </div>
                    @endforelse
                </div>
                <div class="empty-state" id="ordersEmptyState" style="display:none;">
                    <i class="fas fa-inbox"></i>
                    <p>Belum ada pesanan</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Order Modal -->
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
                        <input class="form-input" type="text" id="orderNama" placeholder="Nama pemesan" value="{{ $pelanggan->nama ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">No HP</label>
                        <input class="form-input" type="tel" id="orderNoHp" placeholder="Nomor telepon" value="{{ $pelanggan->no_tlp ?? '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Produk</label>
                    <input class="form-input" type="text" id="orderProduk" placeholder="Contoh: Roti Coklat Premium">
                </div>
                <div class="form-group">
                    <label class="form-label">Catatan</label>
                    <textarea class="form-textarea" id="orderCatatan" placeholder="Catatan tambahan untuk pesanan"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeOrderModal()">Batal</button>
                <button type="button" class="btn-submit" onclick="submitOrder()">Pesan Sekarang</button>
            </div>
        </div>
    </div>

    <!-- Payment Confirmation Modal -->
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
                        <input class="form-input" type="text" id="paymentOrderNumber" placeholder="Contoh: ORD-260401">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nominal Pembayaran</label>
                        <input class="form-input" type="text" id="paymentNominal" placeholder="Rp 350.000">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nama Pengirim</label>
                        <input class="form-input" type="text" id="paymentNamaPengirim" placeholder="Nama pemilik rekening" value="{{ $pelanggan->nama ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Bank Pengirim</label>
                        <input class="form-input" type="text" id="paymentBankPengirim" placeholder="Contoh: BCA">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Bukti / Catatan</label>
                    <textarea class="form-textarea" id="paymentCatatan" placeholder="Isi nomor referensi, nama pengirim, atau catatan pembayaran"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Upload Bukti Transfer</label>
                    <input type="file" class="form-input" id="paymentBukti" accept=".jpg,.jpeg,.png,.pdf">
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
@endsection

@push('scripts')
<script>
    let allOrders = @json($pesanans ?? []);
    let currentFilter = 'all';

    const statusLabels = {
        'menunggu_konfirmasi': 'Menunggu Konfirmasi',
        'diproses': 'Diproses',
        'siap_diambil': 'Siap Diambil',
        'dikirim': 'Dikirim',
        'selesai': 'Selesai',
    };

    const statusClasses = {
        'menunggu_konfirmasi': 'menunggu',
        'diproses': 'diproses',
        'siap_diambil': 'siap',
        'dikirim': 'dikirim',
        'selesai': 'selesai',
    };

    const timelineSteps = ['Menunggu', 'Diproses', 'Siap', 'Dikirim', 'Selesai'];
    const statusStepIndex = {
        'menunggu_konfirmasi': 0,
        'diproses': 1,
        'siap_diambil': 2,
        'dikirim': 3,
        'selesai': 4,
    };

    function getProductImagePath(name) {
        const imageMap = {
            'Roti Cokelat': '/image/coklat.jpg',
            'Roti Coklat Premium': '/image/coklat.jpg',
            'Roti Stroberi': '/image/strawberry.jpg',
            'Roti Bluberi': '/image/bluberry.jpg',
            'Roti Kelapa': '/image/kelapa.jpg',
            'Roti Kacang Ijo': '/image/kacanghiaju.jpg',
        };
        const key = Object.keys(imageMap).find(k => name && name.toLowerCase().includes(k.toLowerCase()));
        return key ? imageMap[key] : `{{ asset('image/rotibulat.png') }}`;
    }

    function renderOrders() {
        const grid = document.getElementById('ordersGrid');
        const emptyState = document.getElementById('ordersEmptyState');

        const filtered = currentFilter === 'all'
            ? allOrders
            : allOrders.filter(o => o.status_pesanan === currentFilter);

        if (!filtered.length) {
            grid.innerHTML = '';
            emptyState.style.display = 'block';
            return;
        }

        emptyState.style.display = 'none';

        grid.innerHTML = filtered.map(order => {
            const status = order.status_pesanan || 'menunggu_konfirmasi';
            const statusLabel = statusLabels[status] || status;
            const statusClass = statusClasses[status] || 'menunggu';
            const currentStep = statusStepIndex[status] || 0;
            const isDone = status === 'selesai';

            const timeline = timelineSteps.map((step, index) => {
                const completed = isDone ? index <= currentStep : index < currentStep;
                const active = index === currentStep;

                return `
                    <div class="timeline-step">
                        <div class="timeline-dot ${completed ? 'completed' : active ? 'active' : ''}">
                            ${completed ? '<i class="fas fa-check"></i>' : index + 1}
                        </div>
                        <div class="timeline-label">${step}</div>
                        <div class="timeline-line-wrapper">
                            <div class="timeline-line ${completed ? 'completed' : active ? 'active' : ''}"></div>
                        </div>
                    </div>
                `;
            }).join('');

            const products = order.detail_pesanans || [];
            const itemsHTML = products.slice(0, 3).map(item => {
                const produk = item.produk || {};
                const name = produk.nama_produk || 'Produk';
                const img = produk.gambar || getProductImagePath(name);
                return `
                    <div class="order-item">
                        <div class="order-item-icon ${img ? '' : 'no-image'}">
                            ${img ? `<img src="${img}" alt="${name}" onerror="this.parentElement.classList.add('no-image')" />` : ''}
                            ${!img ? `<span>🍞</span>` : ''}
                        </div>
                        <div>
                            <div class="order-item-name">${name}</div>
                            <div class="order-item-qty">${item.jumlah_pesan || 1} item</div>
                        </div>
                    </div>
                `;
            }).join('');

            const remainingItems = products.length > 3 ? `<div class="order-item-qty" style="margin-top:4px;">+${products.length - 3} produk lainnya</div>` : '';

            const date = order.tgl_pesan ? new Date(order.tgl_pesan).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : '-';

            return `
                <div class="order-card" data-status="${status}">
                    <div class="order-header">
                        <div>
                            <div class="order-code">#ORD-${order.id_pesanan}</div>
                            <div class="order-date"><i class="far fa-calendar-alt"></i> ${date}</div>
                        </div>
                        <span class="order-status-badge ${statusClass}">
                            <i class="fas ${status === 'selesai' ? 'fa-check-circle' : status === 'dikirim' ? 'fa-truck' : status === 'diproses' ? 'fa-spinner' : 'fa-clock'}"></i>
                            ${statusLabel}
                        </span>
                    </div>

                    <div class="order-items">
                        ${itemsHTML}
                        ${remainingItems}
                    </div>

                    <div class="order-total">
                        <span class="order-total-label">Total Pesanan</span>
                        <span class="order-total-value">Rp ${parseInt(order.total_bayar || 0).toLocaleString('id-ID')}</span>
                    </div>

                    <div class="timeline-container">
                        <div class="timeline-steps">
                            ${timeline}
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    async function loadOrders() {
        try {
            const response = await fetch('/pelanggan/pesanan/data');
            if (!response.ok) throw new Error('Failed to load orders');
            const data = await response.json();
            allOrders = Array.isArray(data) ? data : (data.data || []);
            renderOrders();
        } catch (error) {
            console.error('Error loading orders:', error);
        }
    }

    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            renderOrders();
        });
    });

    document.addEventListener('DOMContentLoaded', loadOrders);

    // Payment & Order Modal Functions
    const orderModal = document.getElementById('orderModal');
    const paymentModalEl = document.getElementById('paymentModal');

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

    async function submitOrder() {
        const nama = document.getElementById('orderNama').value.trim();
        const noHp = document.getElementById('orderNoHp').value.trim();
        const produk = document.getElementById('orderProduk').value.trim();
        const catatan = document.getElementById('orderCatatan').value.trim();

        if (!nama || !noHp || !produk) {
            alert('Silakan isi Nama, No HP, dan Produk');
            return;
        }

        try {
            const response = await fetch('/pelanggan/pesanan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ nama, no_hp: noHp, produk, catatan }),
            });
            const result = await response.json();
            if (result.success) {
                alert(result.message);
                closeOrderModal();
                location.reload();
            } else {
                alert(result.message || 'Gagal membuat pesanan');
            }
        } catch (error) {
            console.error('Error submitting order:', error);
            alert('Gagal membuat pesanan. Silakan coba lagi.');
        }
    }

    function openPaymentModal() {
        paymentModalEl.classList.add('show');
    }

    function closePaymentModal() {
        paymentModalEl.classList.remove('show');
    }

    async function submitPayment() {
        const orderReference = document.getElementById('paymentOrderNumber').value.trim();
        const namaPengirim = document.getElementById('paymentNamaPengirim').value.trim();
        const bankPengirim = document.getElementById('paymentBankPengirim').value.trim();
        const nominalTransfer = document.getElementById('paymentNominal').value.trim();
        const catatan = document.getElementById('paymentCatatan').value.trim();
        const buktiFile = document.getElementById('paymentBukti').files[0];

        if (!orderReference || !buktiFile) {
            alert('Silakan isi Nomor Pesanan dan upload Bukti Transfer');
            return;
        }

        const formData = new FormData();
        formData.append('order_reference', orderReference);
        formData.append('nama_pengirim', namaPengirim);
        formData.append('bank_pengirim', bankPengirim);
        formData.append('nominal_transfer', nominalTransfer.replace(/[^0-9]/g, ''));
        formData.append('catatan_pembayaran', catatan);
        formData.append('bukti_transfer', buktiFile);

        const cartItems = localStorage.getItem('bakery_cart');
        if (cartItems) {
            formData.append('items', cartItems);
        }

        try {
            const response = await fetch('/pelanggan/pembayaran/konfirmasi', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData,
            });
            const result = await response.json();
            if (result.success) {
                alert('Konfirmasi pembayaran berhasil dikirim!');
                closePaymentModal();
            } else {
                alert(result.message || 'Gagal mengirim konfirmasi');
            }
        } catch (error) {
            console.error('Error submitting payment:', error);
            alert('Gagal mengirim konfirmasi. Silakan coba lagi.');
        }
    }

    if (orderModal) {
        orderModal.addEventListener('click', (e) => {
            if (e.target === orderModal) closeOrderModal();
        });
    }

    if (paymentModalEl) {
        paymentModalEl.addEventListener('click', (e) => {
            if (e.target === paymentModalEl) closePaymentModal();
        });

        const paymentMethods = document.querySelectorAll('#paymentMethods .payment-method');
        paymentMethods.forEach((method) => {
            method.addEventListener('click', () => {
                paymentMethods.forEach((item) => item.classList.remove('active'));
                method.classList.add('active');
                const radio = method.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                    const summary = document.getElementById('paymentSummary');
                    if (summary) {
                        summary.innerHTML = `Metode terpilih: <strong>${paymentMethodLabels[radio.value]}</strong>`;
                    }
                }
            });
        });
    }
</script>
@endpush
