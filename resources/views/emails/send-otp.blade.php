<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $purpose === 'reset' ? 'Kode OTP Reset Password' : 'Kode OTP Verifikasi Email' }} - Three D Bakery</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #FFF5E1 0%, #FFF9F0 50%, #FDE4A6 100%);
            color: #42352A; line-height: 1.6;
        }
        .email-container {
            max-width: 600px; margin: 20px auto; background: white;
            border-radius: 12px; box-shadow: 0 10px 40px rgba(107, 95, 84, 0.1); overflow: hidden;
        }
        .email-header {
            background: linear-gradient(135deg, #C69C6D 0%, #B8935F 100%);
            color: white; padding: 40px 30px; text-align: center;
        }
        .email-header h1 { font-size: 28px; margin-bottom: 10px; font-weight: 700; }
        .email-header p { opacity: 0.95; font-size: 14px; }
        .email-body { padding: 40px 30px; }
        .greeting { font-size: 16px; margin-bottom: 20px; color: #42352A; }
        .greeting strong { color: #8B6F47; }
        .otp-container {
            background: linear-gradient(135deg, #FFF5E1 0%, #FFF9F0 100%);
            border: 2px solid #C69C6D; border-radius: 12px; padding: 30px;
            margin: 30px 0; text-align: center;
        }
        .otp-label { font-size: 12px; color: #6B5F54; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block; }
        .otp-code {
            font-size: 36px; font-weight: 700; color: #8B6F47;
            letter-spacing: 6px; font-family: 'Courier New', monospace; word-break: break-all;
        }
        .otp-expiry { font-size: 13px; color: #C69C6D; margin-top: 15px; font-weight: 500; }
        .email-info {
            background: rgba(198, 156, 109, 0.05); border-left: 4px solid #C69C6D;
            padding: 15px; margin: 25px 0; border-radius: 4px; font-size: 14px; color: #6B5F54;
        }
        .email-info strong { color: #42352A; }
        .instructions { margin: 25px 0; font-size: 14px; color: #6B5F54; }
        .instructions ol { margin: 15px 0 0 25px; padding: 0; }
        .instructions li { margin: 10px 0; line-height: 1.7; }
        .warning {
            background: #FFE8E8; border: 1px solid #FFD1DC; border-radius: 8px;
            padding: 15px; margin: 25px 0; font-size: 13px; color: #C69C6D; line-height: 1.6;
        }
        .warning strong { color: #8B6F47; }
        .email-footer {
            background: rgba(107, 95, 84, 0.02); border-top: 1px solid #f0f0f0;
            padding: 25px 30px; text-align: center; font-size: 12px; color: #6B5F54;
        }
        .email-footer p { margin: 5px 0; }
        .company-name { color: #8B6F47; font-weight: 600; }
        a { color: #C69C6D; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>{{ $purpose === 'reset' ? 'Kode OTP Reset Password' : 'Kode OTP Verifikasi Email' }}</h1>
            <p>Three D Bakery - Sistem Manajemen Toko</p>
        </div>

        <div class="email-body">
            <div class="greeting">
                Halo <strong>{{ $userName }}</strong>,
            </div>

            @if ($purpose === 'reset')
            <p>Anda telah meminta untuk mereset password akun Anda. Gunakan kode OTP di bawah ini untuk melanjutkan proses reset password.</p>
            @else
            <p>Terima kasih telah mendaftar di Three D Bakery. Gunakan kode OTP di bawah ini untuk memverifikasi alamat email Anda.</p>
            @endif

            <div class="otp-container">
                <span class="otp-label">Kode OTP Anda</span>
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-expiry">⏱️ Kode ini berlaku selama 10 menit</div>
            </div>

            <div class="email-info">
                <strong>📧 Email Terdaftar:</strong>
                @if ($purpose === 'reset')
                Permintaan reset password ini dikirim ke email Anda yang terdaftar di sistem.
                @else
                Kode verifikasi ini dikirim dalam rangka pendaftaran akun Three D Bakery.
                @endif
            </div>

            <div class="instructions">
                <strong>{{ $purpose === 'reset' ? 'Langkah-langkah untuk reset password:' : 'Langkah-langkah untuk verifikasi email:' }}</strong>
                <ol>
                    @if ($purpose === 'reset')
                    <li>Masuk ke halaman reset password Three D Bakery</li>
                    <li>Masukkan kode OTP 6 digit di atas</li>
                    <li>Buat password baru yang aman</li>
                    <li>Konfirmasi password Anda</li>
                    <li>Klik tombol "Simpan Password Baru"</li>
                    @else
                    <li>Masuk ke halaman verifikasi email Three D Bakery</li>
                    <li>Masukkan kode OTP 6 digit di atas</li>
                    <li>Klik tombol "Verifikasi Email"</li>
                    <li>Akun Anda akan aktif dan siap digunakan</li>
                    @endif
                </ol>
            </div>

            <div class="warning">
                <strong>⚠️ Penting:</strong> Jangan bagikan kode OTP ini kepada siapa pun. Three D Bakery tidak akan pernah meminta kode OTP Anda melalui email atau telepon.
                @if ($purpose === 'reset')
                Jika Anda tidak melakukan permintaan ini, abaikan email ini atau segera ubah password Anda.
                @else
                Jika Anda tidak melakukan pendaftaran, abaikan email ini.
                @endif
            </div>

            <p style="margin: 20px 0; font-size: 14px; color: #6B5F54;">
                @if ($purpose === 'reset')
                Jika Anda mengalami kesulitan, hubungi tim support kami atau kembali ke halaman login untuk mencoba lagi.
                @else
                Jika Anda mengalami kesulitan, hubungi tim support kami untuk bantuan verifikasi email.
                @endif
            </p>
        </div>

        <div class="email-footer">
            <p>© 2024 <span class="company-name">Three D Bakery</span>. Semua hak dilindungi.</p>
            <p style="margin-top: 10px; color: #A0938D;">
                @if ($purpose === 'reset')
                Email ini dikirim karena adanya permintaan reset password. Jika ini bukan Anda, abaikan email ini.
                @else
                Email ini dikirim karena adanya pendaftaran akun baru. Jika ini bukan Anda, abaikan email ini.
                @endif
            </p>
        </div>
    </div>
</body>
</html>
