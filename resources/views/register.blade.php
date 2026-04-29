<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three D Bakery - Daftar</title>
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
            cursor: auto;
            padding: 20px;
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
            max-width: 1000px;
            position: relative;
            z-index: 1;
            box-shadow: var(--shadow-medium);
            border-radius: 30px;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .register-section {
            background: rgba(255, 255, 255, 0.98);
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: stretch;
            min-height: auto;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
        }

        .register-section::before {
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
            margin-top: 30px;
            margin-bottom: 35px;
            text-align: center;
            animation: fade-in 0.8s ease-out;
        }

        .form-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-header p {
            font-size: 0.95rem;
            color: var(--text-light);
            font-weight: 300;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-row.full {
            grid-template-columns: 1fr;
        }

        .form-group {
            margin-bottom: 20px;
            animation: fade-in 0.8s ease-out;
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.15s; }
        .form-group:nth-child(4) { animation-delay: 0.25s; }

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

        .password-strength {
            font-size: 0.8rem;
            margin-top: 8px;
            font-weight: 500;
            color: var(--text-light);
        }

        .strength-bar {
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            margin-top: 6px;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .strength-weak { background: #FF6B6B; }
        .strength-fair { background: #FFA500; }
        .strength-good { background: #FFD700; }
        .strength-strong { background: #90EE90; }

        .terms-agreement {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 25px 0;
            animation: fade-in 0.8s ease-out 0.3s backwards;
        }

        .terms-agreement input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            accent-color: var(--soft-brown);
            cursor: pointer;
            flex-shrink: 0;
        }

        .terms-text {
            font-size: 0.85rem;
            color: var(--text-light);
            line-height: 1.5;
        }

        .terms-text a {
            color: var(--soft-brown);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .terms-text a:hover {
            text-decoration: underline;
        }

        .register-btn {
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
            margin-top: 10px;
            margin-bottom: 15px;
            animation: fade-in 0.8s ease-out 0.4s backwards;
        }

        .register-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: var(--shadow-hover);
            background: linear-gradient(135deg, #B8935F 0%, #A27F52 100%);
        }

        .register-btn:active {
            transform: translateY(-1px) scale(0.99);
        }

        .register-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none;
        }

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

        /* Error Message */
        .error-message {
            color: #C69C6D;
            font-size: 0.85rem;
            margin-top: 6px;
            display: block;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .register-section {
                padding: 40px 30px;
            }

            .form-header h2 {
                font-size: 1.8rem;
            }

            .floating-elements {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .container {
                border-radius: 20px;
            }

            .register-section {
                padding: 30px 20px;
            }

            .form-header h2 {
                font-size: 1.5rem;
            }

            .form-header p {
                font-size: 0.9rem;
            }

            input[type="email"],
            input[type="password"],
            input[type="text"] {
                padding: 12px 16px;
                font-size: 0.9rem;
            }

            .register-btn {
                padding: 13px;
                font-size: 0.9rem;
            }

            label {
                font-size: 0.85rem;
            }

            .terms-text {
                font-size: 0.8rem;
            }
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
        <!-- Register Section -->
        <div class="register-section">
            <div class="form-container">
                <div class="form-header">
                    <h2>Bergabung dengan Three D Bakery</h2>
                    <p>Buat akun Anda untuk mulai memesan makanan lezat</p>
                </div>

                <form id="registerForm" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" placeholder="Masukkan username Anda" required value="{{ old('username') }}">
                            @error('username')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required value="{{ old('email') }}">
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Kata Sandi</label>
                            <input type="password" id="password" name="password" placeholder="Buat kata sandi yang kuat" required>
                            <div class="password-strength">
                                <div class="strength-bar">
                                    <div class="strength-fill"></div>
                                </div>
                                <span id="strengthText">Kekuatan: Tidak Ada</span>
                            </div>
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi kata sandi Anda" required>
                            @error('password_confirmation')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row full">
                        <!-- Nomor Telepon dihapus sesuai permintaan -->
                    </div>

                    <div class="terms-agreement">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms" class="terms-text">
                            Saya setuju dengan <a href="#">Syarat Layanan</a> dan <a href="#">Kebijakan Privasi</a>
                        </label>
                    </div>

                    <button type="submit" class="register-btn">Daftar Akun</button>
                </form>

                <div class="auth-links">
                    <span>Sudah punya akun?</span>
                    <a href="{{ route('login') }}">Masuk</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthFill = document.querySelector('.strength-fill');
        const strengthText = document.getElementById('strengthText');

        function checkPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;
            return strength;
        }

        passwordInput.addEventListener('input', function () {
            const strength = checkPasswordStrength(this.value);
            const percentage = (strength / 5) * 100;
            strengthFill.style.width = percentage + '%';

            const strengthLevels = ['Tidak Ada', 'Lemah', 'Cukup', 'Baik', 'Kuat', 'Sangat Kuat'];
            strengthText.textContent = 'Kekuatan: ' + strengthLevels[strength];

            strengthFill.className = 'strength-fill';
            if (strength === 1) strengthFill.classList.add('strength-weak');
            else if (strength === 2) strengthFill.classList.add('strength-fair');
            else if (strength === 3) strengthFill.classList.add('strength-good');
            else if (strength >= 4) strengthFill.classList.add('strength-strong');
        });

        // Form submission
        const registerForm = document.getElementById('registerForm');
        if (registerForm) {
            registerForm.addEventListener('submit', function (e) {
                const btn = this.querySelector('.register-btn');
                btn.style.opacity = '0.8';
                btn.style.pointerEvents = 'none';
                btn.textContent = 'Mendaftarkan Akun...';
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

        // Form field validation feedback
        document.addEventListener('DOMContentLoaded', function () {
            inputs.forEach(input => {
                input.addEventListener('change', function () {
                    if (this.value) {
                        this.style.borderColor = 'rgba(198, 156, 109, 0.3)';
                    }
                });
            });
        });

        // Redirect ke halaman home setelah register sukses
        @if (session('registered'))
            window.location.href = '/';
        @endif
    </script>
</body>

</html>
