# 🍞 Sistem Sinkronisasi Data Produk & Pesanan - Web Bakery

## ✅ Apa yang Sudah Diimplementasikan

Sistem sinkronisasi lengkap telah dibangun untuk memastikan semua data pesanan yang dibuat oleh owner langsung tersimpan ke database.

### 📋 Fitur Utama

1. **Sinkronisasi Produk Otomatis**
   - Produk di-load dari database
   - Mencegah duplikat produk dengan nama yang sama
   - Data tersimpan konsisten di database `produks`

2. **Sinkronisasi Pesanan Otomatis**
   - Ketika owner membuat pesanan (offline), data langsung ke database
   - Pesanan bisa untuk karyawan atau pelanggan
   - Semua detail produk dalam pesanan tersimpan di `detail_pesanans`

3. **Real-time UI Update**
   - Setelah save pesanan, tabel update otomatis
   - Stats (total pesanan, revenue) update real-time
   - Search dan filter bekerja dengan data terbaru

## 🚀 Cara Menggunakan

### Untuk Pesanan Karyawan:

```
1. Buka halaman "Pesanan Offline" dari menu
2. Klik tombol "Tambah Pesanan"
3. Pilih "Karyawan" di tipe pesanan
4. Isi nama karyawan dan tanggal pickup
5. Klik "Tambah Produk" untuk menambah produk yang dipesan
6. Pilih produk dan jumlah
7. Klik "Simpan" - Data langsung tersimpan ke database
```

### Untuk Pesanan Pelanggan:

```
1. Buka halaman "Pesanan Offline" dari menu
2. Klik tombol "Tambah Pesanan"
3. Pilih "Pelanggan" di tipe pesanan
4. Isi nama pelanggan dan metode pengambilan (Delivery/Pickup)
5. Isi tanggal pickup/delivery
6. Klik "Tambah Produk" untuk menambah produk yang dipesan
7. Pilih produk dan jumlah
8. Klik "Simpan" - Data langsung tersimpan ke database
```

## 📁 File-File yang Dibuat/Diupdate

### Backend (Laravel)

#### Service Layer (NEW):
- `app/Services/ProdukSyncService.php` - Sinkronisasi produk
- `app/Services/PesananSyncService.php` - Sinkronisasi pesanan

#### Controllers:
- `app/Http/Controllers/PesananOfflineController.php` (NEW) - API untuk pesanan offline
- `app/Http/Controllers/ProdukController.php` (UPDATED) - Menggunakan ProdukSyncService
- `app/Http/Controllers/PesananController.php` (UPDATED) - Menggunakan PesananSyncService

#### Routes:
- `routes/api.php` (UPDATED) - Tambah route `/api/pesanan-offline`

### Frontend (JavaScript & Blade)

- `public/js/pesanan-offline.js` (NEW) - Handle sinkronisasi pesanan dari frontend
- `resources/views/pesanan-offline.blade.php` (UPDATED) - Tambah csrf token dan link ke JS

## 🔌 API Endpoints

### Pesanan Offline

```
POST   /api/pesanan-offline              - Buat pesanan baru
GET    /api/pesanan-offline              - Dapatkan semua pesanan
GET    /api/pesanan-offline/type/{type}  - Dapatkan pesanan by tipe (karyawan/pelanggan)
PUT    /api/pesanan-offline/{id}         - Update pesanan
DELETE /api/pesanan-offline/{id}         - Hapus pesanan
```

## 💾 Database Schema

Data tersimpan di 3 tabel:

### Tabel `produks`
- id_produk (PK)
- nama_produk
- harga_produk
- timestamps

### Tabel `pesanans`
- id_pesanan (PK)
- id_pelanggan (FK) - NULL jika pesanan karyawan
- id_karyawan (FK)
- tgl_pesan (datetime)
- sumber_pesanan (enum: 'offline', 'online')
- status_bayar (enum: 'belum_lunas', 'lunas')
- total_bayar (decimal)
- timestamps

### Tabel `detail_pesanans`
- id_pesanan (FK, PK)
- id_produk (FK, PK)
- jumlah_pesan (integer)
- timestamps

## ⚙️ Cara Kerja

### Alur Pesanan:

```
1. User (Owner) buka form pesanan
2. User isi form pesanan + produk
3. User klik Simpan
   ↓
4. Frontend kirim POST request ke /api/pesanan-offline
   ↓
5. Backend (PesananOfflineController) terima request
   ↓
6. PesananSyncService.createPesanan() dijalankan:
   - Cari/validasi karyawan atau pelanggan
   - Buat record di tabel `pesanans`
   - Tambah detail di tabel `detail_pesanans` untuk setiap produk
   - Return pesanan dengan relasi lengkap
   ↓
7. Frontend terima response OK
   ↓
8. Frontend tampilkan alert sukses
9. Frontend reload data pesanan dari database
10. Tabel update dengan data terbaru
11. Stats update (total pesanan, revenue, dll)
```

## 🧪 Testing

### Test Pesanan Karyawan dengan cURL:

```bash
curl -X POST http://localhost:8000/api/pesanan-offline \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: YOUR_CSRF_TOKEN" \
  -d '{
    "tipe_pesanan": "karyawan",
    "nama_karyawan": "Budi",
    "id_karyawan": 1,
    "tgl_pesan": "2026-05-13",
    "status_bayar": "belum_lunas",
    "total_bayar": 100000,
    "products": [
      {"id_produk": 1, "jumlah_pesan": 2}
    ]
  }'
```

### Test Pesanan Pelanggan dengan cURL:

```bash
curl -X POST http://localhost:8000/api/pesanan-offline \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: YOUR_CSRF_TOKEN" \
  -d '{
    "tipe_pesanan": "pelanggan",
    "nama_pelanggan": "Ani",
    "id_pelanggan": 1,
    "tgl_pesan": "2026-05-13",
    "status_bayar": "belum_lunas",
    "total_bayar": 250000,
    "products": [
      {"id_produk": 1, "jumlah_pesan": 1},
      {"id_produk": 2, "jumlah_pesan": 2}
    ]
  }'
```

## ⚠️ Requirements

- Pastikan karyawan exist di tabel `karyawans`
- Pastikan pelanggan exist di tabel `pelanggans`
- Pastikan produk exist di tabel `produks`
- Database connection harus aktif

## 🐛 Troubleshooting

| Problem | Solution |
|---------|----------|
| "Karyawan tidak ditemukan" | Cek apakah id_karyawan exist di tabel karyawans |
| "Produk tidak ditemukan" | Cek apakah id_produk exist di tabel produks |
| Data tidak tersimpan | Cek server log untuk error details |
| CSRF Token error | Pastikan form punya csrf_token() di meta tag |

## 📚 Dokumentasi Lengkap

Untuk dokumentasi lebih detail, lihat file: `SINKRONISASI_DOKUMENTASI.md`

Dokumentasi mencakup:
- Penjelasan setiap service method
- Response format lengkap
- Performance considerations
- Next steps untuk development lebih lanjut

## 🎯 Kesimpulan

✅ Data produk dan pesanan sekarang **100% tersinkronkan** ke database  
✅ Owner bisa membuat pesanan dengan interface yang user-friendly  
✅ Semua data **tersimpan dengan aman** di database  
✅ UI **update real-time** setelah data tersimpan  

Happy Baking! 🥖🍰
