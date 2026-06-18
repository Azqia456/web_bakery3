<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three D Bakery - Roti Premium Indonesia</title>
    
    <!-- Google Fonts: Playfair Display for elegant headings, Inter for modern body text -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#FBF7F1',  // --light-cream
                            100: '#F5E6D3', // --primary-cream
                            400: '#A0826D', // --secondary-brown
                            500: '#8B6F47', // --primary-brown
                            800: '#6B5639', // --dark-brown
                            900: '#333333', // Body text
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    boxShadow: {
                        'soft': '0 20px 40px -15px rgba(139, 111, 71, 0.1)',
                        'float': '0 30px 60px -20px rgba(139, 111, 71, 0.25)',
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom Utilities for extra polish */
        .glass-nav {
            background: rgba(251, 247, 241, 0.85); /* brand-50 with opacity */
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(245, 230, 211, 0.5); /* brand-100 */
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #6B5639 0%, #8B6F47 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .blob-shape {
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            animation: morph 8s ease-in-out infinite both alternate;
        }

        @keyframes morph {
            0% { border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; }
            100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
        }
    </style>
</head>
<body class="font-sans text-brand-900 bg-brand-50 antialiased selection:bg-brand-500 selection:text-white">

    <!-- ===== NAVBAR ===== -->
    <nav class="fixed w-full z-50 glass-nav transition-all duration-300 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="#" class="flex items-center gap-2 group">
                    <span class="text-2xl transition-transform group-hover:scale-110">🍞</span>
                    <span class="font-serif font-bold text-xl tracking-tight text-brand-800">Three D <span class="text-brand-500">Bakery</span></span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-gray-600 hover:text-brand-500 font-medium text-sm transition-colors">Beranda</a>
                    <a href="#produk" class="text-gray-600 hover:text-brand-500 font-medium text-sm transition-colors">Produk</a>
                    <a href="#tentang" class="text-gray-600 hover:text-brand-500 font-medium text-sm transition-colors">Tentang Kami</a>
                    <a href="#kontak" class="text-gray-600 hover:text-brand-500 font-medium text-sm transition-colors">Kontak</a>
                    
                    <!-- BLADE: Auth Logic Here -->
                <div class="pl-4 border-l border-brand-100">
                   @auth
                     @if(auth()->user()->role === 'owner')
                     <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white transition-all bg-brand-500 rounded-full hover:bg-brand-800 hover:shadow-lg hover:-translate-y-0.5">
                     <i class="bi bi-speedometer2 mr-2"></i> Dashboard
                  </a>
                      @else
                 <a href="{{ route('pelanggan.dashboard') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white transition-all bg-brand-500 rounded-full hover:bg-brand-800 hover:shadow-lg hover:-translate-y-0.5">
                    <i class="bi bi-speedometer2 mr-2"></i> Dashboard
                 </a>
                      @endif
                      @else
                      <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white transition-all bg-brand-500 rounded-full hover:bg-brand-800 hover:shadow-lg hover:-translate-y-0.5">
                          <i class="bi bi-person-circle mr-2"></i> Login
                      </a>
                 @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button class="text-brand-800 hover:text-brand-500 focus:outline-none">
                        <i class="bi bi-list text-3xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- ===== HERO SECTION ===== -->
    <section id="beranda" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <!-- Background Decorative Elements -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[500px] h-[500px] bg-brand-100/50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[400px] h-[400px] bg-white rounded-full blur-3xl opacity-60 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">
                <!-- Text Content -->
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-100 text-brand-800 text-sm font-semibold mb-6">
                        <span class="relative flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-brand-500"></span>
                        </span>
                        Dipanggang Setiap Hari
                    </div>
                    <h1 class="font-serif text-5xl lg:text-7xl font-bold leading-tight mb-6 text-brand-800">
                        Three <span class="text-gradient">D Bakery.
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-lg">
                        Nikmati roti hangat dengan cita rasa yang khas dan bahan berkualitas terbaik. 
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#produk" class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white transition-all duration-300 bg-brand-500 rounded-full hover:bg-brand-800 shadow-float hover:-translate-y-1">
                            <i class="bi bi-cart3 mr-2"></i> Belanja Sekarang
                        </a>
                    </div>
                </div>
                <div class="relative lg:ml-auto w-full mt-8 lg:mt-0">
                    <div class="absolute inset-0 bg-brand-500 blob-shape transform translate-x-4 translate-y-4 opacity-20"></div>
                    
                    <div class="relative rounded-[2rem] overflow-hidden shadow-2xl z-10 aspect-[4/3] lg:aspect-video w-full mx-auto">
                    <img src="{{ asset('image/coklat.jpg') }}"
                             alt="Roti Premium Three D Bakery" 
                             class="object-cover w-full h-full transform hover:scale-105 transition-transform duration-700">

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PRODUCT SECTION ===== -->
    <section id="produk" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-brand-500 font-semibold tracking-wider uppercase text-sm mb-2 block">Pilihan Favorit</span>
                <h2 class="font-serif text-4xl md:text-5xl font-bold text-brand-800 mb-4">Best Sellers</h2>
                <p class="text-gray-600 text-lg">Koleksi roti kami yang paling di Rekomendasikan, dipanggang dengan teknik khusus untuk menghasilkan tekstur dan rasa yang sempurna.</p>
            </div>
            
            <!-- BLADE: @forelse($produks as $produk) ... @empty ... @endforelse -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Product Card 1: Kelapa -->
                <div class="group bg-white rounded-[2rem] p-4 shadow-sm hover:shadow-soft transition-all duration-300 border border-brand-100/50 flex flex-col h-full">
                    <div class="relative overflow-hidden rounded-2xl aspect-[4/3] mb-6 bg-brand-50">
                        <img src="{{ asset('image/kelapa.jpg') }}" alt="Roti Kelapa" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm font-bold text-brand-800 shadow-sm border border-brand-100">
                            Rp 1.300
                        </div>
                    </div>
                    <div class="px-2 flex-grow flex flex-col">
                        <div class="mb-2">
                            <h5 class="font-serif text-xl font-bold text-brand-800">Kelapa Lumer</h5>
                        </div>
                        <p class="text-gray-500 text-sm mb-6 flex-grow leading-relaxed">Roti super lembut dengan isian krim kelapa manis yang lumer di mulut dan taburan kelapa parut gurih di atasnya.</p>
                        
                        <a href="{{ route('login') }}" class="w-full py-3.5 rounded-xl font-semibold text-brand-800 bg-brand-50 hover:bg-brand-500 hover:text-white transition-colors duration-300 flex justify-center items-center gap-2 border border-brand-100/50 hover:border-transparent">
                            <i class="bi bi-bag-plus"></i> Tambah ke Keranjang
                        </a>
                    </div>
                </div>

                <!-- Product Card 2: Strawberry -->
                <div class="group bg-white rounded-[2rem] p-4 shadow-sm hover:shadow-soft transition-all duration-300 border border-brand-100/50 flex flex-col h-full">
                    <div class="relative overflow-hidden rounded-2xl aspect-[4/3] mb-6 bg-brand-50">
                        <img src="{{ asset('image/strawberry.jpg') }}" alt="Roti Strawberry" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm font-bold text-brand-800 shadow-sm border border-brand-100">
                            Rp 1.300
                        </div>
                    </div>
                    <div class="px-2 flex-grow flex flex-col">
                        <div class="mb-2">
                            <h5 class="font-serif text-xl font-bold text-brand-800">Strawberry Lumer</h5>
                        </div>
                        <p class="text-gray-500 text-sm mb-6 flex-grow leading-relaxed">Roti manis dengan isian selai stroberi segar melimpah dan taburan bubuk stroberi yang memberikan sensasi asam manis menyegarkan.</p>
                        
                        <a href="{{ route('login') }}" class="w-full py-3.5 rounded-xl font-semibold text-brand-800 bg-brand-50 hover:bg-brand-500 hover:text-white transition-colors duration-300 flex justify-center items-center gap-2 border border-brand-100/50 hover:border-transparent">
                            <i class="bi bi-bag-plus"></i> Tambah ke Keranjang
                        </a>
                    </div>
                </div>

                <!-- Product Card 3: Blueberry -->
                <div class="group bg-white rounded-[2rem] p-4 shadow-sm hover:shadow-soft transition-all duration-300 border border-brand-100/50 flex flex-col h-full">
                    <div class="relative overflow-hidden rounded-2xl aspect-[4/3] mb-6 bg-brand-50">
                        <img src="{{ asset('image/bluberry.jpg') }}" alt="Roti Blueberry" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm font-bold text-brand-800 shadow-sm border border-brand-100">
                            Rp 1.300
                        </div>
                        <div class="absolute top-4 left-4 bg-brand-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-sm">
                            New
                        </div>
                    </div>
                    <div class="px-2 flex-grow flex flex-col">
                        <div class="mb-2">
                            <h5 class="font-serif text-xl font-bold text-brand-800">Blueberry Lumer</h5>
                        </div>
                        <p class="text-gray-500 text-sm mb-6 flex-grow leading-relaxed">Roti artisan dengan filling blueberry premium yang kaya rasa dan buah asli, memberikan ledakan rasa lezat di setiap gigitan.</p>

                        <a href="{{ route('login') }}" class="w-full py-3.5 rounded-xl font-semibold text-brand-800 bg-brand-50 hover:bg-brand-500 hover:text-white transition-colors duration-300 flex justify-center items-center gap-2 border border-brand-100/50 hover:border-transparent">
                            <i class="bi bi-bag-plus"></i> Tambah ke Keranjang
                        </a>
                    </div>
                </div>             
            </div>
        </div>
    </section>

    <!-- ===== FEATURES SECTION ===== -->
    <section id="tentang" class="py-24 bg-brand-800 text-white relative overflow-hidden">
        <!-- Abstract shape in background -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl -mt-10 -mr-10"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-brand-500 opacity-20 rounded-full blur-3xl -mb-20 -ml-20"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="font-serif text-3xl md:text-5xl font-bold mb-4">Kenapa Memilih Kami?</h2>
                <p class="text-brand-100/80 text-lg">Dedikasi kami untuk menyajikan kualitas terbaik di setiap potongan roti yang Anda nikmati.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white/5 backdrop-blur-lg border border-brand-100/10 p-8 rounded-3xl hover:-translate-y-2 transition-transform duration-300 hover:bg-white/10">
                    <div class="w-14 h-14 bg-brand-500/20 text-brand-100 rounded-2xl flex items-center justify-center text-2xl mb-6">
                        <i class="bi bi-gem"></i>
                    </div>
                    <h5 class="text-xl font-bold mb-3 text-brand-50">Bahan Premium</h5>
                    <p class="text-brand-100/70 text-sm leading-relaxed">Menggunakan tepung, mentega, dan bahan-bahan impor pilihan untuk tekstur & rasa sempurna.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white/5 backdrop-blur-lg border border-brand-100/10 p-8 rounded-3xl hover:-translate-y-2 transition-transform duration-300 hover:bg-white/10">
                    <div class="w-14 h-14 bg-brand-500/20 text-brand-100 rounded-2xl flex items-center justify-center text-2xl mb-6">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h5 class="text-xl font-bold mb-3 text-brand-50">Fresh Setiap Hari</h5>
                    <p class="text-brand-100/70 text-sm leading-relaxed">Semua produk kami panggang di hari yang sama untuk menjamin kesegaran optimal.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white/5 backdrop-blur-lg border border-brand-100/10 p-8 rounded-3xl hover:-translate-y-2 transition-transform duration-300 hover:bg-white/10">
                    <div class="w-14 h-14 bg-brand-500/20 text-brand-100 rounded-2xl flex items-center justify-center text-2xl mb-6">
                        <i class="bi bi-heart"></i>
                    </div>
                    <h5 class="text-xl font-bold mb-3 text-brand-50">Dibuat Dengan Hati</h5>
                    <p class="text-brand-100/70 text-sm leading-relaxed">Setiap roti diproses oleh artisan baker kami dengan resep tradisional dan sentuhan cinta.</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white/5 backdrop-blur-lg border border-brand-100/10 p-8 rounded-3xl hover:-translate-y-2 transition-transform duration-300 hover:bg-white/10">
                    <div class="w-14 h-14 bg-brand-500/20 text-brand-100 rounded-2xl flex items-center justify-center text-2xl mb-6">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h5 class="text-xl font-bold mb-3 text-brand-50">Pengemasan Aman</h5>
                    <p class="text-brand-100/70 text-sm leading-relaxed">Kemasan modern, higienis, dan eco-friendly untuk menjaga bentuk serta kualitas rasa.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer id="kontak" class="bg-brand-800 text-brand-50 pt-20 pb-8 border-t border-brand-500/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8 mb-16">
                
                <!-- Brand Info -->
                <div class="lg:col-span-4">
                    <a href="#" class="flex items-center gap-2 mb-6">
                        <span class="font-serif font-bold text-2xl tracking-tight text-white">Three D <span class="text-brand-400">Bakery</span></span>
                    </a>
                    <p class="text-brand-100/80 text-sm leading-relaxed mb-8 max-w-sm">
                        Menghadirkan kehangatan dan kebahagiaan ke meja makan Anda melalui kreasi roti artisan premium berkualitas tinggi.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-500 hover:text-white transition-colors duration-300 text-brand-100">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-500 hover:text-white transition-colors duration-300 text-brand-100">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-500 hover:text-white transition-colors duration-300 text-brand-100">
                            <i class="bi bi-tiktok"></i>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div class="lg:col-span-2">
                    <h4 class="text-lg font-bold mb-6 font-serif text-white">Menu Cepat</h4>
                    <ul class="space-y-4">
                        <li><a href="#beranda" class="text-brand-100/80 hover:text-white transition-colors text-sm">Beranda</a></li>
                        <li><a href="#produk" class="text-brand-100/80 hover:text-white transition-colors text-sm">Semua Produk</a></li>
                        <li><a href="#tentang" class="text-brand-100/80 hover:text-white transition-colors text-sm">Tentang Kami</a></li>
                        <li><a href="#kontak" class="text-brand-100/80 hover:text-white transition-colors text-sm">Kontak</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="lg:col-span-3">
                    <h4 class="text-lg font-bold mb-6 font-serif text-white">Hubungi Kami</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class="bi bi-geo-alt mt-1 text-brand-400"></i>
                            <span class="text-brand-100/80 text-sm leading-relaxed">Jl. Griya Mas, Cengkong, Kec. Purwasari, Karawang, Jawa Barat.</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="bi bi-telephone text-brand-400"></i>
                            <span class="text-brand-100/80 text-sm">+62 857-8003-0321</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="bi bi-envelope text-brand-400"></i>
                            <span class="text-brand-100/80 text-sm">ThreedBakery@gmail.com</span>
                        </li>
                    </ul>
                </div>

                <!-- Newsletter / Hours -->
                <div class="lg:col-span-3">
                    <h4 class="text-lg font-bold mb-6 font-serif text-white">Jam Operasional</h4>
                    <div class="bg-white/5 rounded-2xl p-5 border border-white/5">
                        <div class="flex justify-between items-center mb-3 pb-3 border-b border-white/10">
                            <span class="text-brand-100/80 text-sm">Senin - Jumat</span>
                            <span class="text-white font-medium text-sm">07:00 - 19:00</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-brand-100/80 text-sm">Sabtu - Minggu</span>
                            <span class="text-white font-medium text-sm">08:00 - 20:00</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Copyright -->
            <div class="pt-8 border-t border-brand-500/20 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-brand-100/60 text-sm">
                    &copy; 2024 Three D Bakery. Hak Cipta Dilindungi. | Dibuat dengan ❤️ untuk Anda
                </p>
                <div class="flex gap-6 text-sm text-brand-100/60">
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>