<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three D Bakery - Roti Premium Indonesia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-brown: #8B6F47;
            --primary-cream: #F5E6D3;
            --secondary-brown: #A0826D;
            --dark-brown: #6B5639;
            --light-cream: #FBF7F1;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* ===== NAVBAR ===== */
        .navbar-landing {
            background: linear-gradient(135deg, #fff 0%, #FAF8F4 100%);
            border-bottom: 1px solid #E8D9C4;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(139, 111, 71, 0.08);
        }

        .navbar-landing .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-brown) !important;
            letter-spacing: -0.5px;
        }

        .navbar-landing .nav-link {
            color: #555 !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
            padding: 0.5rem 0.75rem !important;
        }

        .navbar-landing .nav-link:hover {
            color: var(--primary-brown) !important;
        }

        .btn-login-nav {
            background: var(--primary-brown);
            color: white !important;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login-nav:hover {
            background: var(--dark-brown);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 111, 71, 0.3);
        }

        /* ===== HERO SECTION ===== */
        .hero-section {
            background: linear-gradient(135deg, var(--light-cream) 0%, #FFFFFF 100%);
            padding: 80px 0;
            min-height: 90vh;
            display: flex;
            align-items: center;
        }

        .hero-content {
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--dark-brown);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .btn-hero {
            padding: 0.75rem 2.5rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin-right: 1rem;
            margin-bottom: 1rem;
        }

        .btn-hero-primary {
            background: var(--primary-brown);
            color: white;
            border: 2px solid var(--primary-brown);
        }

        .btn-hero-primary:hover {
            background: var(--dark-brown);
            border-color: var(--dark-brown);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(139, 111, 71, 0.3);
            color: white;
        }

        .btn-hero-secondary {
            background: transparent;
            color: var(--primary-brown);
            border: 2px solid var(--primary-brown);
        }

        .btn-hero-secondary:hover {
            background: var(--primary-brown);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(139, 111, 71, 0.2);
        }

        .hero-image {
            text-align: center;
            z-index: 1;
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(139, 111, 71, 0.15);
        }

        /* ===== PRODUCT SECTION ===== */
        .product-section {
            background: #FFFFFF;
            padding: 100px 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark-brown);
            text-align: center;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 4rem;
            font-size: 1.1rem;
        }

        .product-card {
            background: #FFFFFF;
            border: 1px solid #E8D9C4;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.4s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(139, 111, 71, 0.15);
            border-color: var(--primary-brown);
        }

        .product-image {
            height: 250px;
            overflow: hidden;
            background: var(--light-cream);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.08);
        }

        .product-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark-brown);
            margin-bottom: 0.5rem;
        }

        .product-desc {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 1rem;
            flex-grow: 1;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #E8D9C4;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-brown);
        }

        .btn-add-cart {
            background: var(--primary-brown);
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .btn-add-cart:hover {
            background: var(--dark-brown);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 111, 71, 0.3);
            color: white;
        }

        /* ===== FEATURES SECTION ===== */
        .features-section {
            background: linear-gradient(135deg, var(--light-cream) 0%, #FFFFFF 100%);
            padding: 100px 0;
        }

        .feature-box {
            text-align: center;
            padding: 2.5rem 1.5rem;
            background: #FFFFFF;
            border-radius: 12px;
            border: 1px solid #E8D9C4;
            transition: all 0.4s ease;
            height: 100%;
        }

        .feature-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(139, 111, 71, 0.12);
            border-color: var(--primary-brown);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--primary-brown);
            margin-bottom: 1.5rem;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark-brown);
            margin-bottom: 1rem;
        }

        .feature-desc {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* ===== FOOTER ===== */
        .footer-section {
            background: var(--dark-brown);
            color: var(--light-cream);
            padding: 4rem 0 1rem;
        }

        .footer-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #FFFFFF;
        }

        .footer-link {
            color: var(--light-cream);
            text-decoration: none;
            transition: all 0.3s ease;
            display: block;
            margin-bottom: 0.75rem;
        }

        .footer-link:hover {
            color: var(--primary-cream);
            padding-left: 0.5rem;
        }

        .social-icons {
            display: flex;
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: var(--primary-brown);
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background: var(--primary-cream);
            color: var(--dark-brown);
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 2rem;
            padding-top: 2rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 0;
                min-height: auto;
            }

            .hero-title {
                font-size: 2.2rem;
                margin-bottom: 1rem;
            }

            .hero-subtitle {
                font-size: 1rem;
                margin-bottom: 1.5rem;
            }

            .btn-hero {
                padding: 0.6rem 2rem;
                font-size: 0.9rem;
                width: 100%;
                margin-right: 0;
                margin-bottom: 0.75rem;
            }

            .hero-image {
                margin-top: 2rem;
            }

            .hero-image img {
                border-radius: 10px;
            }

            .section-title {
                font-size: 2rem;
            }

            .product-section,
            .features-section {
                padding: 60px 0;
            }

            .product-card {
                margin-bottom: 1.5rem;
            }

            .feature-box {
                margin-bottom: 1.5rem;
            }

            .navbar-landing .navbar-brand {
                font-size: 1.3rem;
            }

            .navbar-landing .nav-link {
                margin: 0.25rem 0;
                padding: 0.5rem 0 !important;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 1.8rem;
            }

            .hero-subtitle {
                font-size: 0.95rem;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .product-price {
                font-size: 1.2rem;
            }

            .feature-icon {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg navbar-landing">
        <div class="container">
            <a class="navbar-brand" href="#">🍰 Three D Bakery</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#produk">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimoni">Testimoni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                    <li class="nav-item ms-2">
                        @auth
                            @if(auth()->user()->role === 'owner')
                                <a href="{{ route('dashboard') }}" class="btn btn-login-nav">Dashboard</a>
                            @else
                                <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-login-nav">Dashboard</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-login-nav">Login</a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ===== HERO SECTION ===== -->
    <section class="hero-section" id="beranda">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title">Three D Bakery</h1>
                    <p class="hero-subtitle">Roti premium dengan cita rasa internasional dan bahan berkualitas terbaik. Dipanggang segar setiap hari untuk kepuasan Anda.</p>
                    <div>
                        @auth
                            @if(auth()->user()->role === 'owner')
                                <a href="{{ route('dashboard') }}" class="btn btn-hero btn-hero-primary">📊 Dashboard</a>
                            @else
                                <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-hero btn-hero-primary">🛒 Belanja Sekarang</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-hero btn-hero-primary">🛒 Belanja Sekarang</a>
                        @endauth
                        <a href="#produk" class="btn btn-hero btn-hero-secondary">📋 Lihat Produk</a>
                    </div>
                </div>
                <div class="col-lg-6 hero-image">
                    <img src="{{ asset('image/strawberry.jpg') }}" alt="Roti Premium Three D Bakery">
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PRODUCT SECTION ===== -->
    <section class="product-section" id="produk">
        <div class="container">
            <h2 class="section-title">Our Best Selection</h2>
            <p class="section-subtitle">Koleksi roti premium pilihan kami yang paling dicintai pelanggan</p>
            
            <div class="row g-4">
                @forelse($produks as $produk)
                <div class="col-lg-4 col-md-6">
                    <div class="product-card">
                        <div class="product-image">
                            @if($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}">
                            @else
                                <img src="{{ asset('image/rotibulat.png') }}" alt="{{ $produk->nama_produk }}">
                            @endif
                        </div>
                        <div class="product-body">
                            <h5 class="product-name">{{ $produk->nama_produk }}</h5>
                            <p class="product-desc">{{ $produk->deskripsi ?? 'Roti premium dengan cita rasa terbaik.' }}</p>
                            <div class="product-footer">
                                <span class="product-price">Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</span>
                                @auth
                                    @if(auth()->user()->role === 'owner')
                                        <a href="{{ route('dashboard') }}" class="btn-add-cart">Dashboard</a>
                                    @else
                                        <a href="{{ route('pelanggan.dashboard') }}" class="btn-add-cart">
                                            <i class="bi bi-bag-plus"></i> Pesan
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn-add-cart">
                                        <i class="bi bi-bag-plus"></i> Pesan
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada produk tersedia saat ini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ===== FEATURES SECTION ===== -->
    <section class="features-section" id="tentang">
        <div class="container">
            <h2 class="section-title">Kenapa Pilih Three D Bakery?</h2>
            <p class="section-subtitle">Kami berkomitmen untuk memberikan yang terbaik</p>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="bi bi-gem"></i>
                        </div>
                        <h5 class="feature-title">Bahan Premium</h5>
                        <p class="feature-desc">Menggunakan bahan-bahan pilihan terbaik dari supplier terpercaya untuk kualitas maksimal.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h5 class="feature-title">Fresh Setiap Hari</h5>
                        <p class="feature-desc">Dipanggang fresh setiap pagi untuk memastikan kesegaran dan kelezatan optimal.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h5 class="feature-title">Rasa Terjamin</h5>
                        <p class="feature-desc">Resep rahasia yang telah teruji menghasilkan rasa yang konsisten dan lezat.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="bi bi-lightning-fill"></i>
                        </div>
                        <h5 class="feature-title">Pengiriman Cepat</h5>
                        <p class="feature-desc">Sistem logistik efisien untuk memastikan produk sampai dalam kondisi terbaik.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="footer-section" id="kontak">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="footer-title">🍰 Three D Bakery</h5>
                    <p style="line-height: 1.8;">Roti premium dengan cita rasa internasional. Dibuat dengan cinta dan bahan terbaik untuk keluarga Indonesia.</p>
                    <div class="social-icons">
                        <a href="#" class="social-icon" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-icon" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-icon" title="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="footer-title">Menu</h5>
                    <a href="#beranda" class="footer-link">Beranda</a>
                    <a href="#produk" class="footer-link">Produk</a>
                    <a href="#tentang" class="footer-link">Tentang Kami</a>
                    <a href="#kontak" class="footer-link">Kontak</a>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-title">Kontak</h5>
                    <p style="margin-bottom: 1rem;">
                        <i class="bi bi-telephone"></i> +62 812-3456-7890
                    </p>
                    <p style="margin-bottom: 1rem;">
                        <i class="bi bi-envelope"></i> info@3dbakery.com
                    </p>
                    <p>
                        <i class="bi bi-geo-alt"></i> Jl. Roti Premium No. 123, Jakarta
                    </p>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-title">Jam Operasional</h5>
                    <p>
                        <strong>Senin - Jumat</strong><br>
                        07:00 - 19:00 WIB
                    </p>
                    <p>
                        <strong>Sabtu - Minggu</strong><br>
                        08:00 - 20:00 WIB
                    </p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2024 Three D Bakery. Semua hak cipta dilindungi. | Dibuat dengan ❤️ untuk Anda</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
