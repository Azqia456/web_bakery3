# 📝 Dokumentasi Fitur Lupa Kata Sandi - Three D Bakery

## 📌 Ringkasan
Fitur "Lupa Kata Sandi" telah berhasil diimplementasikan dengan sistem OTP 6 digit. User dapat mereset password mereka melalui 3 langkah mudah:
1. Masukkan email terdaftar
2. Verifikasi OTP 6 digit yang dikirim ke email
3. Buat password baru

---

## 🔄 Flow Aplikasi

### **Step 1: Minta OTP**
- User klik "Lupa Kata Sandi?" di halaman login
- Masukkan email yang terdaftar
- Email divalidasi
- Jika email ditemukan:
  - Generate OTP 6 digit random
  - Simpan ke database tabel `password_reset_otps`
  - Kirim OTP ke email user
  - Redirect ke halaman verifikasi OTP

### **Step 2: Verifikasi OTP**
- User memasukkan kode OTP 6 digit
- Validasi:
  - Cek apakah OTP valid (belum kadaluarsa)
  - Cek apakah sudah melebihi 5 kali percobaan salah
  - Cek apakah OTP cocok dengan database
- Jika OTP benar: Hapus OTP dari database, tandai verifikasi sukses, redirect ke halaman reset password
- Jika salah: Tampilkan error dengan sisa percobaan, increment attempt counter
- Tombol "Kirim Ulang" memungkinkan user request OTP baru tanpa harus mengulang dari awal

### **Step 3: Reset Password**
- User memasukkan password baru
- User confirm password baru
- Validasi:
  - Password minimal 8 karakter
  - Konfirmasi password harus sesuai
- Jika valid:
  - Update password di tabel `users` menggunakan `Hash::make()`
  - Hapus session reset password
  - Tampilkan notifikasi sukses
  - Redirect ke halaman login untuk login dengan password baru

---

## 📂 File yang Dibuat/Dimodifikasi

### **Database**
```
database/migrations/2024_06_04_create_password_reset_otps_table.php
```
Tabel `password_reset_otps` dengan kolom:
- `id` - Primary key
- `id_user` - Foreign key ke users
- `email` - Email user
- `otp` - Kode OTP 6 digit
- `attempts` - Jumlah percobaan (max 5)
- `expires_at` - Waktu kadaluarsa (10 menit)

### **Model**
```
app/Models/PasswordResetOtp.php
```
- Method `isValid()` - Cek apakah OTP belum kadaluarsa
- Method `isLocked()` - Cek apakah sudah melebihi 5 percobaan

### **Controller**
```
app/Http/Controllers/PasswordResetController.php
```
Methods:
1. `showForgotPasswordForm()` - Tampilkan halaman input email
2. `requestPasswordReset()` - Process request OTP
3. `showVerifyOtpForm()` - Tampilkan halaman verifikasi OTP
4. `verifyOtp()` - Process verifikasi OTP
5. `showResetPasswordForm()` - Tampilkan halaman reset password
6. `resetPassword()` - Process update password
7. `resendOtp()` - Resend OTP

### **Mailable**
```
app/Mail/SendOtpMail.php
```
- Class untuk mengirim email OTP dengan template profesional

### **Views**
Tiga halaman baru dengan design konsisten dengan login existing:

1. **forgot-password.blade.php** - Input email
   - Form dengan label, input email, submit button
   - Link kembali ke login
   - Alert success/error

2. **verify-otp.blade.php** - Verifikasi OTP
   - Tampilkan email yang telah diinput
   - Input OTP 6 digit (hanya angka, auto-format)
   - Tombol "Verifikasi" dan "Kirim Ulang"
   - Display kode OTP berlaku 10 menit
   - Link "Mulai Dari Awal" untuk restart process

3. **reset-password.blade.php** - Buat password baru
   - Input password baru
   - Input konfirmasi password
   - Password requirements indicator
   - Submit button

### **Email Template**
```
resources/views/emails/send-otp.blade.php
```
- Email template profesional dengan design Three D Bakery
- Menampilkan OTP 6 digit dengan format besar
- Instruksi penggunaan
- Warning tentang keamanan

### **Routes**
```
routes/web.php
```
- `GET /forgot-password` - Halaman input email
- `POST /forgot-password` - Process request OTP
- `GET /verify-otp` - Halaman verifikasi OTP
- `POST /verify-otp` - Process verifikasi OTP
- `POST /resend-otp` - Resend OTP
- `GET /reset-password` - Halaman reset password
- `POST /reset-password` - Process update password

### **Login Page Update**
```
resources/views/login.blade.php
```
- Ubah link "Lupa Kata Sandi?" dari alert menjadi route('forgot-password')

---

## 🎨 Design Konsistensi

Semua halaman baru menggunakan design yang sama dengan halaman login existing:
- **Warna**: Cream, soft brown, pastel pink, light orange, warm yellow
- **Font**: Playfair Display (heading), Poppins (body)
- **Layout**: Responsive, mobile-friendly
- **Theme**: Three D Bakery (same bakery elements, gradients, shadows)
- **Animations**: Smooth fade-in dan hover effects

---

## ⚙️ Konfigurasi

### **Email Configuration**
File `.env`:
```
MAIL_MAILER=smtp
MAIL_HOST=mailpit          # atau smtp.gmail.com, dll
MAIL_PORT=1025             # atau 587, dll
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_ENCRYPTION=...        # null atau tls
MAIL_FROM_ADDRESS=...
MAIL_FROM_NAME=Three D Bakery
```

Untuk development testing, bisa gunakan Mailpit (sudah dikonfigurasi).

### **OTP Settings** (di dalam PasswordResetController)
- **OTP Validity**: 10 menit (bisa diubah di line `addMinutes(10)`)
- **Max Attempts**: 5 kali (bisa diubah di line `$this->attempts >= 5`)
- **OTP Length**: 6 digit (bisa diubah di `random_int(0, 999999)`)

---

## 🔐 Keamanan

1. **OTP tidak disimpan di session** - Disimpan di database dengan enkripsi
2. **OTP time-limited** - Hanya berlaku 10 menit
3. **Rate limiting** - Max 5 kali percobaan salah
4. **Password Hashing** - Menggunakan Laravel `Hash::make()`
5. **CSRF Protection** - Semua form menggunakan `@csrf`
6. **Email Verification** - Cek email terdaftar sebelum generate OTP
7. **Session-based** - State management menggunakan Laravel session

---

## 🧪 Testing Manual

### **Test Case 1: Email Tidak Terdaftar**
```
1. Klik "Lupa Kata Sandi?"
2. Masukkan email yang tidak terdaftar
3. Klik "Kirim Kode OTP"
✓ Harus tampil error: "Email tidak terdaftar di sistem kami."
```

### **Test Case 2: OTP Benar**
```
1. Klik "Lupa Kata Sandi?"
2. Masukkan email yang terdaftar
3. Klik "Kirim Kode OTP"
✓ Email dikirim ke inbox
4. Masukkan OTP 6 digit
5. Klik "Verifikasi"
✓ Harus redirect ke halaman reset password
```

### **Test Case 3: OTP Salah**
```
1. Lakukan step 1-4 dari Test Case 2
2. Masukkan OTP yang salah
3. Klik "Verifikasi"
✓ Error tampil dengan sisa percobaan
4. Ulangi step 2-3 sampai 5 kali
✓ Harus error: "Percobaan terlalu banyak. Silahkan mulai dari awal."
```

### **Test Case 4: OTP Kadaluarsa**
```
1. Lakukan step 1-3 dari Test Case 2
2. Tunggu 10+ menit
3. Masukkan OTP
4. Klik "Verifikasi"
✓ Harus error: "Kode OTP telah kadaluarsa. Silahkan mulai dari awal."
```

### **Test Case 5: Resend OTP**
```
1. Lakukan step 1-3 dari Test Case 2
2. Klik "Kirim Ulang"
✓ OTP baru dikirim ke email
✓ Success message tampil
3. Masukkan OTP baru
4. Klik "Verifikasi"
✓ Verifikasi berhasil
```

### **Test Case 6: Password Baru**
```
1. Lakukan step 1-5 dari Test Case 2 & complete verifikasi
2. Masukkan password "test1234" (8 karakter)
3. Confirm password "test1234"
4. Klik "Simpan Password Baru"
✓ Redirect ke login dengan success message
5. Login dengan password baru
✓ Login berhasil
```

### **Test Case 7: Password Tidak Cocok**
```
1. Lakukan step 1-5 dari Test Case 2 & complete verifikasi
2. Masukkan password "test1234"
3. Confirm password "test5678" (berbeda)
4. Klik "Simpan Password Baru"
✓ Error tampil: "Konfirmasi password tidak sesuai."
```

---

## 🐛 Troubleshooting

### **Email Tidak Dikirim**
- Pastikan `MAIL_MAILER`, `MAIL_HOST`, dll sudah benar di `.env`
- Jika development, pastikan Mailpit sudah running
- Check log di `storage/logs/laravel.log`

### **OTP Tidak Masuk Database**
- Pastikan migration sudah dijalankan: `php artisan migrate`
- Check table `password_reset_otps` sudah ada di database

### **Link "Lupa Kata Sandi?" Tidak Bekerja**
- Pastikan route sudah benar di `routes/web.php`
- Clear route cache: `php artisan route:clear`

### **Password Lama Masih Bisa Login**
- Password baru harus di-hash dengan `Hash::make()`
- Check kode di line update password

---

## 📦 Dependencies
- Laravel 11+
- PHP 8.0+
- Database: MySQL
- Mailer: SMTP atau Mailpit (development)

---

## ✅ Status: PRODUCTION READY
Fitur sudah tested dan siap untuk deployment. Semua requirements sudah terpenuhi:
- ✅ Halaman input email dengan validasi
- ✅ Generate OTP 6 digit random
- ✅ Kirim OTP via email
- ✅ Halaman verifikasi OTP dengan resend option
- ✅ Halaman reset password dengan validasi
- ✅ Design konsisten dengan login existing
- ✅ Responsive layout
- ✅ Security best practices
- ✅ Flow end-to-end lengkap

---

## 📞 Kontak Support
Jika ada pertanyaan atau issue, cek `app/Http/Controllers/PasswordResetController.php` untuk logic lengkap atau `storage/logs/laravel.log` untuk error details.

**Dibuat: 4 Juni 2026**
**Version: 1.0**
