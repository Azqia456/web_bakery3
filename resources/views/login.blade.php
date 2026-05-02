<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three D Bakery - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --cream: #FFF5E1;
            --soft-brown: #C69C6D;
            --pastel-pink: #FFD1DC;
            --light-orange: #F5B384;
            --warm-yellow: #FDE4A6;
            --dark-brown: #8B6F47;
            --text-dark: #42352A;
            --text-light: #6B5F54;
            --shadow-soft: 0 10px 40px rgba(107, 95, 84, 0.08);
            --shadow-medium: 0 20px 60px rgba(134, 111, 71, 0.12);
            --shadow-hover: 0 25px 80px rgba(134, 111, 71, 0.15);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--cream) 0%, #FFF9F0 50%, var(--warm-yellow) 100%);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            cursor: url('/image/kursor.cur') 16 16, pointer;
        }

        /* Animated background elements */
        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .floating-element {
            position: absolute;
            opacity: 0.4;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 20%;
            right: 10%;
            animation-delay: 1s;
        }

        .floating-element:nth-child(3) {
            width: 100px;
            height: 100px;
            bottom: 15%;
            left: 8%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(4) {
            width: 70px;
            height: 70px;
            bottom: 25%;
            right: 5%;
            animation-delay: 1.5s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-30px) rotate(5deg);
            }
        }

        .container {
            width: 100%;
            max-width: 1200px;
            height: 90vh;
            max-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            position: relative;
            z-index: 1;
            box-shadow: var(--shadow-medium);
            border-radius: 30px;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        /* Left Section - Branding */
        .branding-section {
            background: linear-gradient(135deg, #FFF9F0 0%, var(--warm-yellow) 100%);
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .branding-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 209, 220, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse-glow 4s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% {
                transform: scale(1);
                opacity: 0.3;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.5;
            }
        }

        .branding-content {
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .brand-illustration {
            width: 280px;
            height: 280px;
            margin: 0 auto 40px;
            animation: float-illustration 5s ease-in-out infinite;
        }

        @keyframes float-illustration {
            0%, 100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-20px) scale(1.02);
            }
        }

        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 10px;
            letter-spacing: -1px;
            animation: slide-in-left 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .brand-subtitle {
            font-size: 1.1rem;
            color: var(--soft-brown);
            font-weight: 400;
            line-height: 1.6;
            margin-bottom: 30px;
            animation: fade-in 1s ease-out 0.3s backwards;
        }

        .brand-tagline {
            font-size: 0.95rem;
            color: var(--text-light);
            font-style: italic;
            opacity: 0.8;
            animation: fade-in 1s ease-out 0.5s backwards;
        }

        /* Right Section - Login Form */
        .login-section {
            background: rgba(255, 255, 255, 0.98);
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: stretch;
            position: relative;
        }

        .login-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 30%, rgba(255, 209, 220, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(245, 179, 132, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        .form-container {
            position: relative;
            z-index: 2;
        }

        .form-header {
            margin-bottom: 40px;
            animation: fade-in 0.8s ease-out;
        }

        .form-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-header p {
            font-size: 0.95rem;
            color: var(--text-light);
            font-weight: 300;
        }

        .form-group {
            margin-bottom: 25px;
            animation: fade-in 0.8s ease-out;
        }

        .form-group:nth-child(1) {
            animation-delay: 0.1s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.2s;
        }

        label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 10px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid transparent;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            background: linear-gradient(135deg, #FFFBF7 0%, #FFF9F0 100%);
            color: var(--text-dark);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: inset 0 2px 8px rgba(107, 95, 84, 0.05);
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus {
            outline: none;
            border-color: var(--soft-brown);
            background: linear-gradient(135deg, #FFFAF5 0%, #FFF8F0 100%);
            box-shadow: 
                inset 0 2px 8px rgba(107, 95, 84, 0.08),
                0 0 0 4px rgba(198, 156, 109, 0.1);
            transform: translateY(-2px);
        }

        input::placeholder {
            color: var(--text-light);
            opacity: 0.6;
        }

        .forgot-password {
            display: inline-block;
            font-size: 0.85rem;
            color: var(--soft-brown);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .forgot-password::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--soft-brown);
            transition: width 0.3s ease;
        }

        .forgot-password:hover::after {
            width: 100%;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--soft-brown);
            cursor: pointer;
        }

        .remember-me label {
            margin: 0;
            color: var(--text-light);
            font-weight: 400;
            text-transform: none;
            cursor: pointer;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            background: linear-gradient(135deg, var(--soft-brown) 0%, #B8935F 100%);
            color: white;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            letter-spacing: 0.5px;
            box-shadow: var(--shadow-soft);
            text-transform: uppercase;
            margin-bottom: 15px;
            animation: fade-in 0.8s ease-out 0.3s backwards;
        }

        .login-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: var(--shadow-hover);
            background: linear-gradient(135deg, #B8935F 0%, #A27F52 100%);
        }

        .login-btn:active {
            transform: translateY(-1px) scale(0.99);
        }

        /* Auth Links */
        .auth-links {
            display: flex;
            justify-content: center;
            gap: 10px;
            font-size: 0.9rem;
            animation: fade-in 0.8s ease-out 0.5s backwards;
        }

        .auth-links a {
            color: var(--soft-brown);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .auth-links a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--soft-brown);
            transition: width 0.3s ease;
        }

        .auth-links a:hover::after {
            width: 100%;
        }

        .divider {
            color: var(--text-light);
            margin: 0 8px;
            opacity: 0.3;
        }

        /* Animations */
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slide-in-left {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                max-height: none;
                height: auto;
                border-radius: 0;
                box-shadow: none;
            }

            .branding-section {
                padding: 40px 30px;
                min-height: 300px;
            }

            .brand-illustration {
                width: 200px;
                height: 200px;
            }

            .brand-title {
                font-size: 2.5rem;
            }

            .login-section {
                padding: 40px 30px;
                min-height: 500px;
            }

            .form-header h2 {
                font-size: 1.5rem;
            }

            .floating-elements {
                display: none;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 20px;
            }

            .container {
                border-radius: 20px;
            }

            .branding-section {
                padding: 30px 20px;
            }

            .brand-illustration {
                width: 150px;
                height: 150px;
            }

            .brand-title {
                font-size: 2rem;
            }

            .brand-subtitle {
                font-size: 0.9rem;
            }

            .login-section {
                padding: 30px 20px;
            }

            .form-header h2 {
                font-size: 1.3rem;
            }

            input[type="email"],
            input[type="password"],
            input[type="text"] {
                padding: 12px 16px;
                font-size: 0.9rem;
            }

            .login-btn {
                padding: 13px;
                font-size: 0.9rem;
            }

            label {
                font-size: 0.85rem;
            }

            .form-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--soft-brown);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--dark-brown);
        }
    </style>
</head>

<body>
    <!-- Floating Background Elements -->
    <div class="floating-elements">
        <!-- Croissant SVG -->
        <svg class="floating-element" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M50 10C30 20 25 40 35 60C40 70 50 75 60 70C70 65 75 50 70 35C65 20 60 10 50 10Z" fill="#F5B384" opacity="0.6"/>
        </svg>

        <!-- Bread SVG -->
        <svg class="floating-element" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="20" y="20" width="60" height="60" rx="8" fill="#C69C6D"/>
            <line x1="30" y1="30" x2="30" y2="80" stroke="#A27F52" stroke-width="3"/>
            <line x1="50" y1="30" x2="50" y2="80" stroke="#A27F52" stroke-width="3"/>
            <line x1="70" y1="30" x2="70" y2="80" stroke="#A27F52" stroke-width="3"/>
        </svg>

        <!-- Donut SVG -->
        <svg class="floating-element" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="50" cy="50" r="35" fill="#FFD1DC"/>
            <circle cx="50" cy="50" r="20" fill="#FFF5E1"/>
            <circle cx="50" cy="50" r="35" fill="none" stroke="#C69C6D" stroke-width="2"/>
        </svg>

        <!-- Wheat SVG -->
        <svg class="floating-element" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M50 20L45 50L50 80L55 50L50 20" stroke="#C69C6D" stroke-width="2" fill="none"/>
            <circle cx="40" cy="35" r="3" fill="#C69C6D"/>
            <circle cx="60" cy="35" r="3" fill="#C69C6D"/>
            <circle cx="40" cy="55" r="3" fill="#C69C6D"/>
            <circle cx="60" cy="55" r="3" fill="#C69C6D"/>
        </svg>
    </div>

    <!-- Main Container -->
    <div class="container">
        <!-- Left Section: Branding -->
        <div class="branding-section">
            <div class="branding-content">
                <!-- Logo Roti -->
                <img class="brand-illustration" src="/image/rotibulat.png" alt="Logo Roti" style="object-fit:contain; width:400px; height:400px;" />

                <h1 class="brand-title">Three D Bakery</h1>
                <p class="brand-subtitle">Kebahagiaan yang baru dipanggang</p>
                <p class="brand-tagline">Toko roti favorit</p>
            </div>
        </div>

        <!-- Right Section: Login Form -->
        <div class="login-section">
            <div class="form-container">
                <div class="form-header">
                    <h2>Selamat Datang</h2>
                    <p>Masuk untuk mengakses akun Anda</p>
                </div>

                <form id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf

                    @if ($errors->any())
                    <div style="background: #FFE8E8; border-left: 4px solid #C69C6D; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                        <ul style="margin: 0; padding: 0; list-style: none;">
                            @foreach ($errors->all() as $error)
                                <li style="color: #C69C6D; font-size: 0.9rem;">• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="login">Email</label>
                        <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required value="{{ old('email') }}">
                        @error('email')
                            <span style="color: #C69C6D; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Kata Sandi</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan kata sandi Anda" required>
                        @error('password')
                            <span style="color: #C69C6D; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-footer">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember" value="1">
                            <label for="remember">Ingat saya</label>
                        </div>
                        <a href="#" class="forgot-password" onclick="alert('Fitur lupa password sedang dikembangkan'); return false;">Lupa Kata Sandi?</a>
                    </div>

                    <button type="submit" class="login-btn">Masuk</button>
                </form>

                <div class="auth-links">
                    <span>Belum punya?</span>
                    <a href="{{ route('register') }}">Buat akun</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Smooth page load animation
        document.addEventListener('DOMContentLoaded', function () {
            document.body.style.animation = 'fade-in 0.8s ease-out';
        });

        // Form submission handling
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', function () {
                const btn = this.querySelector('.login-btn');
                if (btn) {
                    btn.style.opacity = '0.8';
                    btn.style.pointerEvents = 'none';
                    btn.textContent = 'Sedang masuk...';
                }
            });
        }

        // Input focus animation
        const inputs = document.querySelectorAll('input[type="email"], input[type="password"], input[type="text"]');
        inputs.forEach(input => {
            input.addEventListener('focus', function () {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function () {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Custom cursor on hover of interactive elements
        const interactiveElements = document.querySelectorAll('button, a, input, label');
        interactiveElements.forEach(el => {
            el.addEventListener('mouseenter', function () {
                document.body.style.cursor = 'pointer';
            });

            el.addEventListener('mouseleave', function () {
                document.body.style.cursor = "url('/image/kursor.png'), auto";
            });
        });
    </script>
</body>

</html>
