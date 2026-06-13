# Rumus Total Revenue

## 1. Revenue Offline

### Query SQL

**Karyawan:**
```sql
SELECT COALESCE(SUM(total_bayar), 0)
FROM pesanans
WHERE sumber_pesanan = 'offline'
  AND id_karyawan IS NOT NULL
  AND status_bayar = 'lunas';
```

**Pelanggan:**
```sql
SELECT COALESCE(SUM(total_bayar), 0)
FROM pesanans
WHERE sumber_pesanan = 'offline'
  AND id_pelanggan IS NOT NULL
  AND status_pembayaran = 'lunas';
```

**Total Offline = Revenue Karyawan + Revenue Pelanggan**

### Laravel Eloquent

```php
$revenueKaryawan = Pesanan::where('sumber_pesanan', 'offline')
    ->whereNotNull('id_karyawan')
    ->where('status_bayar', 'lunas')
    ->sum('total_bayar');

$revenuePelanggan = Pesanan::where('sumber_pesanan', 'offline')
    ->whereNotNull('id_pelanggan')
    ->where('status_pembayaran', 'lunas')
    ->sum('total_bayar');

$totalOfflineRevenue = $revenueKaryawan + $revenuePelanggan;
```

---

## 2. Revenue Online

### Query SQL

```sql
SELECT COALESCE(SUM(total_bayar), 0)
FROM pesanans
WHERE sumber_pesanan = 'online'
  AND status_pembayaran = 'lunas';
```

### Laravel Eloquent

```php
$revenueOnline = Pesanan::where('sumber_pesanan', 'online')
    ->where('status_pembayaran', 'lunas')
    ->sum('total_bayar');
```

---

## 3. Ringkasan

| Sumber | Kondisi | Kolom Status |
|--------|---------|-------------|
| Offline — Karyawan | `id_karyawan IS NOT NULL` | `status_bayar = 'lunas'` |
| Offline — Pelanggan | `id_pelanggan IS NOT NULL` | `status_pembayaran = 'lunas'` |
| Online | — | `status_pembayaran = 'lunas'` |
