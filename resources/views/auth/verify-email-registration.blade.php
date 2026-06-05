<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three D Bakery - Verifikasi Email</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --cream: #FFF5E1; --soft-brown: #C69C6D; --pastel-pink: #FFD1DC;
            --light-orange: #F5B384; --warm-yellow: #FDE4A6; --dark-brown: #8B6F47;
            --text-dark: #42352A; --text-light: #6B5F54;
            --shadow-soft: 0 10px 40px rgba(107, 95, 84, 0.08);
            --shadow-medium: 0 20px 60px rgba(134, 111, 71, 0.12);
            --shadow-hover: 0 25px 80px rgba(134, 111, 71, 0.15);
        }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--cream) 0%, #FFF9F0 50%, var(--warm-yellow) 100%);
            color: var(--text-dark); min-height: 100vh; display: flex;
            align-items: center; justify-content: center; position: relative;
            overflow-x: hidden; padding: 20px;
        }
        .floating-elements {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; z-index: 0; overflow: hidden;
        }
        .floating-element {
            position: absolute; opacity: 0.4; animation: float 6s ease-in-out infinite;
        }
        .floating-element:nth-child(1) { width: 80px; height: 80px; top: 10%; left: 5%; animation-delay: 0s; }
        .floating-element:nth-child(2) { width: 60px; height: 60px; top: 20%; right: 10%; animation-delay: 1s; }
        .floating-element:nth-child(3) { width: 100px; height: 100px; bottom: 15%; left: 8%; animation-delay: 2s; }
        .floating-element:nth-child(4) { width: 70px; height: 70px; bottom: 25%; right: 5%; animation-delay: 1.5s; }
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(5deg); }
        }
        .container {
            width: 100%; max-width: 600px; position: relative; z-index: 1;
            box-shadow: var(--shadow-medium); border-radius: 30px; overflow: hidden;
            backdrop-filter: blur(10px);
        }
        .reset-section {
            background: rgba(255, 255, 255, 0.98); padding: 60px 50px;
            display: flex; flex-direction: column; justify-content: center;
            align-items: stretch; min-height: auto; position: relative;
        }
        .reset-section::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 20% 30%, rgba(255, 209, 220, 0.05) 0%, transparent 50%),
                        radial-gradient(circle at 80% 70%, rgba(245, 179, 132, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }
        .form-container { position: relative; z-index: 2; }
        .form-header { margin-bottom: 40px; animation: fade-in 0.8s ease-out; text-align: center; }
        .form-header h2 {
            font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700;
            color: var(--text-dark); margin-bottom: 8px;
        }
        .form-header p { font-size: 0.95rem; color: var(--text-light); font-weight: 300; line-height: 1.5; }
        .email-info {
            background: rgba(198, 156, 109, 0.08); padding: 12px 16px;
            border-radius: 8px; margin-bottom: 25px; font-size: 0.9rem;
            color: var(--text-dark); text-align: center;
        }
        .email-info .email { font-weight: 600; color: var(--soft-brown); }
        .form-group { margin-bottom: 25px; animation: fade-in 0.8s ease-out; }
        .form-group:nth-child(1) { animation-delay: 0.1s; }
        label {
            display: block; font-size: 0.9rem; font-weight: 500;
            color: var(--text-dark); margin-bottom: 10px; letter-spacing: 0.3px; text-transform: uppercase;
        }
        input[type="text"] {
            width: 100%; padding: 14px 18px; border: 2px solid transparent;
            border-radius: 12px; font-family: 'Poppins', sans-serif; font-size: 0.95rem;
            background: linear-gradient(135deg, #FFFBF7 0%, #FFF9F0 100%);
            color: var(--text-dark); transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: inset 0 2px 8px rgba(107, 95, 84, 0.05);
            letter-spacing: 2px; text-align: center; font-weight: 600;
        }
        input[type="text"]:focus {
            outline: none; border-color: var(--soft-brown);
            background: linear-gradient(135deg, #FFFAF5 0%, #FFF8F0 100%);
            box-shadow: inset 0 2px 8px rgba(107, 95, 84, 0.08), 0 0 0 4px rgba(198, 156, 109, 0.1);
            transform: translateY(-2px);
        }
        input::placeholder { color: var(--text-light); opacity: 0.6; letter-spacing: normal; font-weight: 400; }
        .alert {
            padding: 14px; border-radius: 12px; margin-bottom: 20px;
            font-size: 0.9rem; animation: fade-in 0.6s ease-out;
        }
        .alert-success { background: #E8F5E9; border-left: 4px solid #4CAF50; color: #2E7D32; }
        .alert-error { background: #FFE8E8; border-left: 4px solid #C69C6D; color: #C69C6D; }
        .error-message { color: #C69C6D; font-size: 0.85rem; margin-top: 5px; display: block; }
        .button-group {
            display: flex; gap: 12px; margin-bottom: 20px;
            animation: fade-in 0.8s ease-out 0.2s backwards;
        }
        .submit-btn, .resend-btn {
            flex: 1; padding: 15px; border: none; border-radius: 12px;
            font-family: 'Poppins', sans-serif; font-size: 0.95rem; font-weight: 600;
            cursor: pointer; transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            letter-spacing: 0.5px; text-transform: uppercase;
        }
        .submit-btn {
            background: linear-gradient(135deg, var(--soft-brown) 0%, #B8935F 100%);
            color: white; box-shadow: var(--shadow-soft);
        }
        .submit-btn:hover {
            transform: translateY(-3px) scale(1.02); box-shadow: var(--shadow-hover);
            background: linear-gradient(135deg, #B8935F 0%, #A27F52 100%);
        }
        .submit-btn:active { transform: translateY(-1px) scale(0.99); }
        .submit-btn:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }
        .resend-btn {
            background: transparent; color: var(--soft-brown); border: 2px solid var(--soft-brown);
        }
        .resend-btn:hover { background: rgba(198, 156, 109, 0.08); transform: translateY(-2px); }
        .resend-btn:disabled { opacity: 0.5; cursor: not-allowed; }
        .auth-links {
            display: flex; justify-content: center; gap: 10px;
            font-size: 0.9rem; animation: fade-in 0.8s ease-out 0.5s backwards;
        }
        .auth-links a {
            color: var(--soft-brown); text-decoration: none; font-weight: 500;
            transition: all 0.3s ease; position: relative;
        }
        .auth-links a::after {
            content: ''; position: absolute; bottom: -2px; left: 0;
            width: 0; height: 2px; background: var(--soft-brown); transition: width 0.3s ease;
        }
        .auth-links a:hover::after { width: 100%; }
        .timer {
            text-align: center; font-size: 0.85rem; color: var(--text-light);
            margin-bottom: 20px; padding: 12px;
            background: rgba(198, 156, 109, 0.05); border-radius: 8px;
        }
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 768px) {
            .container { max-height: none; height: auto; border-radius: 20px; }
            .reset-section { padding: 40px 30px; }
            .form-header h2 { font-size: 1.5rem; }
            .button-group { flex-direction: column; }
            .submit-btn, .resend-btn { width: 100%; }
            input[type="text"] { padding: 12px 16px; font-size: 0.9rem; }
            label { font-size: 0.85rem; }
            .floating-elements { display: none; }
        }
        @media (max-width: 480px) {
            body { padding: 15px; }
            .reset-section { padding: 30px 20px; }
            .form-header h2 { font-size: 1.3rem; }
            .form-header p { font-size: 0.9rem; }
        }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--soft-brown); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--dark-brown); }
    </style>
</head>

<body>
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
        <div class="reset-section">
            <div class="form-container">
                <div class="form-header">
                    <h2>Verifikasi Email</h2>
                    <p>Masukkan kode OTP 6 digit yang telah dikirim ke email Anda untuk verifikasi.</p>
                </div>

                <div class="email-info">
                    Kode OTP dikirim ke <span class="email">{{ $email }}</span>
                </div>

                @if ($errors->any())
                <div class="alert alert-error">
                    <ul style="margin: 0; padding: 0; list-style: none;">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <form id="verifyOtpForm" method="POST" action="{{ route('register.verify.submit') }}">
                    @csrf

                    <div class="form-group">
                        <label for="otp">Kode OTP</label>
                        <input type="text" id="otp" name="otp" placeholder="000000" maxlength="6" inputmode="numeric" required pattern="\d{6}" autofocus value="{{ old('otp') }}">
                        @error('otp')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="button-group">
                        <button type="submit" class="submit-btn">Verifikasi Email</button>
                        <button type="button" class="resend-btn" onclick="document.getElementById('resendOtpForm').submit();">Kirim Ulang</button>
                    </div>
                </form>

                <form id="resendOtpForm" method="POST" action="{{ route('register.verify.resend') }}" style="display: none;">
                    @csrf
                </form>

                <div class="timer">
                    Kode OTP berlaku selama 10 menit
                </div>

                <div class="auth-links">
                    <a href="{{ route('login') }}">Kembali ke Login</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('otp').addEventListener('keypress', function(e) {
            if (!/^\d$/.test(e.key)) e.preventDefault();
        });
        document.getElementById('otp').addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 6);
        });
        const form = document.getElementById('verifyOtpForm');
        if (form) {
            form.addEventListener('submit', function() {
                const btn = this.querySelector('.submit-btn');
                if (btn) {
                    btn.style.opacity = '0.8';
                    btn.style.pointerEvents = 'none';
                    btn.textContent = 'Verifikasi...';
                }
            });
        }
    </script>
</body>

</html>
