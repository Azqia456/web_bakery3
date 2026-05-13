# Dokumentasi Sistem Sinkronisasi Data Produk dan Pesanan

## Ringkasan Implementasi

Sistem ini telah diimplementasikan untuk menyinkronkan data produk dan pesanan secara otomatis ke database. Ketika owner membuat pesanan untuk karyawan atau pelanggan, datanya akan langsung disimpan ke database `pesanans`.

## Komponen yang Dibuat

### 1. Services (Backend Logic)

#### `app/Services/ProdukSyncService.php`
Service untuk mengelola sinkronisasi data produk:
- `syncAll()` - Sinkronkan semua produk dan hapus duplikat
- `removeDuplicates()` - Hapus produk dengan nama yang sama
- `createProduct()` - Buat produk baru dengan pengecekan duplikat
- `syncProduct()` - Update produk yang sudah ada

#### `app/Services/PesananSyncService.php`
Service untuk mengelola sinkronisasi data pesanan:
- `createPesanan()` - Buat pesanan baru (karyawan atau pelanggan)
- `createPesananKaryawan()` - Buat pesanan untuk karyawan dengan sinkronisasi otomatis
- `createPesananPelanggan()` - Buat pesanan untuk pelanggan dengan sinkronisasi otomatis
- `addDetailPesanan()` - Tambah produk ke pesanan
- `updatePesanan()` - Update pesanan yang sudah ada
- `getAllPesanan()` - Dapatkan semua pesanan dengan relasi lengkap
- `getPesananByType()` - Dapatkan pesanan berdasarkan tipe (karyawan/pelanggan)
- `deletePesanan()` - Hapus pesanan dan detailnya

### 2. Controllers (API Endpoints)

#### `app/Http/Controllers/ProdukController.php`
- Updated untuk menggunakan `ProdukSyncService`
- Mencegah duplikat data produk
- Sinkronisasi otomatis saat index dan store

#### `app/Http/Controllers/PesananController.php`
- Updated untuk menggunakan `PesananSyncService`
- Menangani index, show, update, destroy dengan sinkronisasi

#### `app/Http/Controllers/PesananOfflineController.php` (NEW)
Controller untuk menangani pesanan offline dengan API endpoints:
- `POST /api/pesanan-offline` - Buat pesanan offline
- `GET /api/pesanan-offline` - Dapatkan semua pesanan
- `GET /api/pesanan-offline/type/{type}` - Dapatkan pesanan berdasarkan tipe
- `PUT /api/pesanan-offline/{id}` - Update pesanan
- `DELETE /api/pesanan-offline/{id}` - Hapus pesanan

### 3. Frontend (Client-side Synchronization)

#### `public/js/pesanan-offline.js` (NEW)
JavaScript file yang mengelola:
- Load data pesanan dari API
- Save pesanan offline ke database
- Delete pesanan dari database
- Update stats dan tampilan tabel secara real-time
- Integrasi dengan modal form

## Alur Kerja Sinkronisasi

### Untuk Produk:

```
1. Owner mengakses halaman Produk
2. Data produk di-load dari database via API
3. Ketika owner menambah produk baru:
   - Service cek apakah produk dengan nama sama sudah ada
   - Jika sudah ada, gunakan yang existing
   - Jika belum ada, buat produk baru
   - Hapus duplikat jika ada
   - Data tersimpan di database `produks`
```

### Untuk Pesanan Offline:

```
1. Owner buka halaman "Pesanan Offline"
2. Frontend load semua pesanan dari API (`/api/pesanan-offline`)
3. Data ditampilkan di tabel (pisah untuk karyawan dan pelanggan)
4. Ketika owner mengklik "Tambah Pesanan":
   - Modal form muncul
   - Owner pilih tipe (Karyawan atau Pelanggan)
   - Owner isi form (nama, tanggal, produk, jumlah)
   - Owner klik "Simpan"
5. Frontend mengirim POST request ke `/api/pesanan-offline`
6. Backend melalui `PesananSyncService::createPesanan()`:
   - Cari atau validasi karyawan/pelanggan
   - Buat pesanan baru di database `pesanans`
   - Tambah detail pesanan di `detail_pesanans` untuk setiap produk
   - Return pesanan dengan relasi lengkap
7. Frontend menerima response dan:
   - Menampilkan alert sukses
   - Reload data pesanan dari database
   - Update tampilan tabel
   - Update stats (total pesanan, revenue, dll)
```

## Database Schema

### Tabel yang Digunakan

#### `produks`
```
- id_produk (PK)
- nama_produk
- harga_produk
- timestamps
```

#### `pesanans`
```
- id_pesanan (PK)
- id_pelanggan (FK)
- id_karyawan (FK)
- tgl_pesan (datetime)
- sumber_pesanan (enum: 'offline', 'online')
- status_bayar (enum: 'belum_lunas', 'lunas')
- total_bayar (decimal)
- timestamps
```

#### `detail_pesanans`
```
- id_pesanan (FK, PK)
- id_produk (FK, PK)
- jumlah_pesan (integer)
- timestamps
```

## API Routes

Tambahan route di `routes/api.php`:

```php
Route::prefix('pesanan-offline')->group(function () {
    Route::get('/', [PesananOfflineController::class, 'index']);
    Route::post('/', [PesananOfflineController::class, 'store']);
    Route::put('/{id_pesanan}', [PesananOfflineController::class, 'update']);
    Route::delete('/{id_pesanan}', [PesananOfflineController::class, 'destroy']);
    Route::get('/type/{type}', [PesananOfflineController::class, 'getByType']);
});
```

## Contoh Request/Response

### Create Pesanan (Karyawan)

**Request:**
```json
POST /api/pesanan-offline
{
  "tipe_pesanan": "karyawan",
  "nama_karyawan": "Budi Santoso",
  "id_karyawan": 1,
  "tgl_pesan": "2026-05-13",
  "status_bayar": "belum_lunas",
  "total_bayar": 150000,
  "products": [
    {
      "id_produk": 1,
      "jumlah_pesan": 2
    },
    {
      "id_produk": 2,
      "jumlah_pesan": 3
    }
  ]
}
```

**Response (201 Created):**
```json
{
  "success": true,
  "message": "Pesanan berhasil disimpan ke database",
  "data": {
    "id_pesanan": 5,
    "id_pelanggan": null,
    "id_karyawan": 1,
    "tgl_pesan": "2026-05-13",
    "sumber_pesanan": "offline",
    "status_bayar": "belum_lunas",
    "total_bayar": "150000.00",
    "created_at": "2026-05-13T10:30:00.000000Z",
    "updated_at": "2026-05-13T10:30:00.000000Z",
    "karyawan": {
      "id_karyawan": 1,
      "nama": "Budi Santoso",
      "no_tlp": "08123456789",
      "alamat": "Jl. Merdeka 123"
    },
    "pelanggan": null,
    "detailPesanans": [
      {
        "id_pesanan": 5,
        "id_produk": 1,
        "jumlah_pesan": 2,
        "created_at": "2026-05-13T10:30:00.000000Z"
      },
      {
        "id_pesanan": 5,
        "id_produk": 2,
        "jumlah_pesan": 3,
        "created_at": "2026-05-13T10:30:00.000000Z"
      }
    ]
  }
}
```

## Fitur Utama

### 1. Sinkronisasi Otomatis
- Data pesanan otomatis tersimpan ke database saat owner membuat pesanan
- Tidak ada data yang hilang atau hanya tersimpan di client-side

### 2. Pencegahan Duplikat Produk
- Service otomatis mendeteksi duplikat produk berdasarkan nama
- Hanya menyimpan 1 record untuk setiap produk unik

### 3. Relasi Database Sempurna
- Pesanan terhubung ke Karyawan dan/atau Pelanggan
- Detail pesanan mencatat semua produk dalam pesanan
- Mudah untuk query laporan dan analisis

### 4. Transaction Safety
- Semua operasi pesanan menggunakan database transaction
- Jika ada error, semua perubahan akan di-rollback

### 5. Real-time UI Update
- Setelah save, tampilan tabel update otomatis dari database
- Stats (total pesanan, revenue) update real-time
- Search dan filter berfungsi dengan data terbaru

## Testing Sinkronisasi

### Test dengan cURL:

```bash
# Create Pesanan Karyawan
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
    "products": [{"id_produk": 1, "jumlah_pesan": 2}]
  }'

# Get All Pesanan
curl http://localhost:8000/api/pesanan-offline

# Get Pesanan by Type
curl http://localhost:8000/api/pesanan-offline/type/karyawan

# Delete Pesanan
curl -X DELETE http://localhost:8000/api/pesanan-offline/5 \
  -H "X-CSRF-TOKEN: YOUR_CSRF_TOKEN"
```

## Troubleshooting

### Error: Karyawan tidak ditemukan
- Pastikan `id_karyawan` ada di database `karyawans`
- Atau gunakan `nama_karyawan` yang sesuai dengan data di database

### Error: Produk tidak ditemukan
- Pastikan `id_produk` ada di database `produks`
- Atau gunakan `nama_produk` yang sesuai

### Error: CSRF Token mismatch
- Pastikan meta tag `<meta name="csrf-token">` ada di head
- Pastikan JavaScript mengirim header `X-CSRF-TOKEN`

### Data tidak tersimpan
- Cek browser console untuk error message
- Cek server logs untuk error details
- Pastikan database connection aktif

## Performance Considerations

1. **Database Queries**: Menggunakan eager loading dengan `with()` untuk menghindari N+1 queries
2. **Transaction**: Semua operasi pesanan dalam 1 transaction untuk konsistensi data
3. **Validation**: Server-side validation mencegah data invalid masuk ke database
4. **Caching**: Bisa tambahkan cache untuk data produk yang jarang berubah

## Next Steps (Optional)

1. **Pesanan Online**: Implementasi sinkronisasi untuk pesanan online
2. **Batch Operations**: Tambah fitur untuk edit/delete multiple pesanan
3. **Export Data**: Tambah fitur export ke Excel/PDF
4. **Real-time Notification**: Gunakan WebSocket untuk real-time update
5. **Payment Integration**: Integrasikan dengan payment gateway

## Kontribusi

Jika ada bug atau improvement, silakan update service files:
- `app/Services/ProdukSyncService.php`
- `app/Services/PesananSyncService.php`
- `app/Http/Controllers/PesananOfflineController.php`
- `public/js/pesanan-offline.js`
