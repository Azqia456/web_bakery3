<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three D Bakery - Register</title>
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
            max-width: 500px;
            background: rgba(255, 255, 255, 0.98);
            padding: 50px;
            position: relative;
            z-index: 1;
            box-shadow: var(--shadow-medium);
            border-radius: 30px;
            backdrop-filter: blur(10px);
        }

        .form-header {
            text-align: center;
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
            margin-bottom: 20px;
            animation: fade-in 0.8s ease-out;
        }

        label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 8px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"],
        select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid transparent;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            background: linear-gradient(135deg, #FFFBF7 0%, #FFF9F0 100%);
            color: var(--text-dark);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: inset 0 2px 8px rgba(107, 95, 84, 0.05);
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus,
        select:focus {
            outline: none;
            border-color: var(--soft-brown);
            background: linear-gradient(135deg, #FFFAF5 0%, #FFF8F0 100%);
            box-shadow: inset 0 2px 8px rgba(107, 95, 84, 0.08), 0 0 0 4px rgba(198, 156, 109, 0.1);
            transform: translateY(-2px);
        }

        input::placeholder {
            color: var(--text-light);
            opacity: 0.6;
        }

        .register-btn {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
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
            margin-top: 20px;
            animation: fade-in 0.8s ease-out 0.3s backwards;
        }

        .register-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: var(--shadow-hover);
            background: linear-gradient(135deg, #B8935F 0%, #A27F52 100%);
        }

        .register-btn:active {
            transform: translateY(-1px) scale(0.99);
        }

        .auth-links {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
        }

        .auth-links a {
            color: var(--soft-brown);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }

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

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
                margin: 20px;
                border-radius: 20px;
            }

            .form-header h2 {
                font-size: 1.5rem;
            }

            .floating-elements {
                display: none;
            }
        }

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
        <svg class="floating-element" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M50 10C30 20 25 40 35 60C40 70 50 75 60 70C70 65 75 50 70 35C65 20 60 10 50 10Z" fill="#F5B384" opacity="0.6"/>
        </svg>

        <svg class="floating-element" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="20" y="20" width="60" height="60" rx="8" fill="#C69C6D"/>
            <line x1="30" y1="30" x2="30" y2="80" stroke="#A27F52" stroke-width="3"/>
            <line x1="50" y1="30" x2="50" y2="80" stroke="#A27F52" stroke-width="3"/>
            <line x1="70" y1="30" x2="70" y2="80" stroke="#A27F52" stroke-width="3"/>
        </svg>

        <svg class="floating-element" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="50" cy="50" r="35" fill="#FFD1DC"/>
            <circle cx="50" cy="50" r="20" fill="#FFF5E1"/>
            <circle cx="50" cy="50" r="35" fill="none" stroke="#C69C6D" stroke-width="2"/>
        </svg>

        <svg class="floating-element" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M50 20L45 50L50 80L55 50L50 20" stroke="#C69C6D" stroke-width="2" fill="none"/>
            <circle cx="40" cy="35" r="3" fill="#C69C6D"/>
            <circle cx="60" cy="35" r="3" fill="#C69C6D"/>
            <circle cx="40" cy="55" r="3" fill="#C69C6D"/>
            <circle cx="60" cy="55" r="3" fill="#C69C6D"/>
        </svg>
    </div>

    <div class="container">
        <div class="form-header">
            <h2>Buat Akun Baru</h2>
            <p>Daftar untuk memulai</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
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
                <label for="username">Nama Pengguna</label>
                <input type="text" id="username" name="username" placeholder="Masukkan nama pengguna" required value="{{ old('username') }}">
                @error('username')
                    <span style="color: #C69C6D; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required value="{{ old('email') }}">
                @error('email')
                    <span style="color: #C69C6D; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" placeholder="Masukkan kata sandi (minimal 8 karakter)" required>
                @error('password')
                    <span style="color: #C69C6D; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi kata sandi Anda" required>
            </div>

            <div class="form-group">
                <label for="role">Tipe Akun</label>
                <select id="role" name="role" required>
                    <option value="">-- Pilih Tipe Akun --</option>
                    <option value="pelanggan">Pelanggan</option>
                    <option value="owner">Pemilik</option>
                </select>
                @error('role')
                    <span style="color: #C69C6D; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="register-btn">Daftar</button>
        </form>

        <div class="auth-links">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>
</body>

</html>
