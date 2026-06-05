# Konfigurasi SMTP Email

## 1. SMTP Gmail (`.env`)

Mengubah konfigurasi mail dari Mailpit (development) ke Gmail SMTP.

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=**********
MAIL_PASSWORD=*****
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="*********"
MAIL_FROM_NAME="${APP_NAME}"
```

## 2. Fitur Forgot Password (OTP)

Sistem sudah ada sebelum perubahan — menggunakan OTP 6 digit yang dikirim via email. Flow:

1. `GET /forgot-password` — form input email
2. `POST /forgot-password` — generate OTP + kirim email
3. `GET /verify-otp` — form input OTP
4. `POST /verify-otp` — verifikasi OTP
5. `GET /reset-password` — form password baru
6. `POST /reset-password` — simpan password baru

Controller: `app/Http/Controllers/PasswordResetController.php`\
View: `resources/views/auth/forgot-password.blade.php`, `verify-otp.blade.php`, `reset-password.blade.php`

## 3. Verifikasi Email setelah Registrasi (Baru)

Setiap user yang daftar wajib verifikasi email sebelum bisa login.

### Perubahan File

| File | Deskripsi |
|------|-----------|
| `database/migrations/*_add_email_verified_at_to_users_table.php` | Migrasi baru: add kolom `email_verified_at` ke tabel `users` |
| `app/Models/User.php` | Tambah `email_verified_at` ke `$fillable` dan `$casts` |
| `app/Http/Controllers/AuthController.php` | Modifikasi `register()` dan `login()` + 3 method baru |
| `resources/views/auth/verify-email-registration.blade.php` | Halaman input OTP verifikasi (baru) |
| `routes/web.php` | 3 route baru untuk verifikasi registrasi |
| `app/Mail/SendOtpMail.php` | Subject jadi parameter dinamis (via constructor) |

### Flow Registrasi + Verifikasi

```
POST /register
  → Buat user (role: pelanggan)
  → Generate OTP 6 digit, simpan di tabel password_reset_otps
  → Kirim email OTP
  → Session: register_verify_email
  → Redirect ke GET /register/verify

GET /register/verify
  → Form input OTP 6 digit
  → Cek session register_verify_email

POST /register/verify
  → Validasi OTP (max 5x percobaan, expired 10 menit)
  → Jika benar: set email_verified_at = now()
  → Redirect ke /login

POST /register/verify/resend
  → Generate ulang OTP
  → Kirim email baru
  → Back ke form verifikasi
```

### Cek Email di Login

`POST /login` sekarang ngecek:
- Kalau `email_verified_at` null → kirim ulang OTP → redirect ke `/register/verify`
- Kalau sudah verified → login normal

### User Existing

Semua user yang sudah ada di database langsung di-set `email_verified_at = now()` agar tidak terkunci.

## 4. Mailable `SendOtpMail`

Subject email sekarang dikirim sebagai parameter constructor ke-3:

```php
new SendOtpMail($otp, $userName, 'Kode OTP Verifikasi Email - Three D Bakery')
```

Subject berbeda untuk konteks berbeda:
- **Registrasi**: `Kode OTP Verifikasi Email - Three D Bakery`
- **Reset Password**: `Kode OTP Reset Kata Sandi - Three D Bakery`
