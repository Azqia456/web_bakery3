<?php

namespace App\Services;

use App\Models\Pesanan;
use App\Models\Detail_Pesanan;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class PesananSyncService
{
    /**
     * Buat pesanan baru (offline/online) dan sinkronkan ke database
     */
    public static function createPesanan($tipePesanan, $data)
    {
        return DB::transaction(function () use ($tipePesanan, $data) {
            if ($tipePesanan === 'karyawan') {
                return self::createPesananKaryawan($data);
            } else {
                return self::createPesananPelanggan($data);
            }
        });
    }

    /**
     * Buat pesanan untuk karyawan
     */
    public static function createPesananKaryawan($data)
    {
        // Cari atau buat karyawan berdasarkan nama
        $karyawan = Karyawan::where('nama', $data['nama_karyawan'])
            ->orWhere('id_karyawan', $data['id_karyawan'] ?? null)
            ->first();

        if (!$karyawan && isset($data['id_karyawan'])) {
            $karyawan = Karyawan::find($data['id_karyawan']);
        }

        if (!$karyawan) {
            throw new \Exception('Karyawan tidak ditemukan');
        }

        // Buat pesanan baru
        $pesanan = Pesanan::create([
            'id_karyawan' => $karyawan->id_karyawan,
            'id_pelanggan' => $data['id_pelanggan'] ?? null,
            'tgl_pesan' => $data['tgl_pesan'] ?? now(),
            'sumber_pesanan' => $data['sumber_pesanan'] ?? 'offline',
            'status_bayar' => $data['status_bayar'] ?? 'belum_lunas',
            'total_bayar' => $data['total_bayar'] ?? 0,
        ]);

        // Tambahkan detail pesanan (produk-produk)
        if (isset($data['products']) && is_array($data['products'])) {
            foreach ($data['products'] as $product) {
                self::addDetailPesanan($pesanan->id_pesanan, $product);
            }
        }

        return $pesanan->load(['pelanggan', 'karyawan', 'detailPesanans']);
    }

    /**
     * Buat pesanan untuk pelanggan
     */
    public static function createPesananPelanggan($data)
    {
        // Cari atau buat pelanggan berdasarkan nomor HP
        $pelanggan = null;
        if (!empty($data['no_tlp'])) {
            $pelanggan = Pelanggan::findOrCreateByPhoneNumber(
                $data['no_tlp'],
                $data['nama_pelanggan'],
                $data['email'] ?? null,
                $data['alamat'] ?? null,
                $data['id_user'] ?? null,
                'Offline'
            );
        }

        if (!$pelanggan && isset($data['id_pelanggan'])) {
            $pelanggan = Pelanggan::find($data['id_pelanggan']);
        }

        if (!$pelanggan) {
            throw new \Exception('Pelanggan tidak ditemukan');
        }

        // Cari karyawan yang menangani pesanan ini (jika ada)
        $karyawan = null;
        if (isset($data['id_karyawan'])) {
            $karyawan = Karyawan::find($data['id_karyawan']);
        } else {
            // Jika tidak ada, ambil karyawan pertama atau buat dummy
            $karyawan = Karyawan::first();
        }

        if (!$karyawan) {
            throw new \Exception('Karyawan tidak ditemukan');
        }

        // Buat pesanan baru
        $pesanan = Pesanan::create([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'id_karyawan' => $karyawan->id_karyawan,
            'tgl_pesan' => $data['tgl_pesan'] ?? now(),
            'sumber_pesanan' => $data['sumber_pesanan'] ?? 'online',
            'metode_pengambilan' => $data['metode_pengambilan'] ?? $data['metode'] ?? 'pickup',
            'alamat_delivery' => $data['alamat_delivery'] ?? null,
            'tgl_delivery' => $data['tgl_delivery'] ?? null,
            'metode_pembayaran' => $data['metode_pembayaran'] ?? 'cash',
            'status_pembayaran' => $data['status_pembayaran'] ?? self::getDefaultPaymentStatus($data['metode_pembayaran'] ?? 'cash'),
            'bukti_transfer' => $data['bukti_transfer'] ?? null,
            'catatan_pesanan' => $data['catatan_pesanan'] ?? null,
            'status_bayar' => $data['status_bayar'] ?? 'belum_lunas',
            'total_bayar' => $data['total_bayar'] ?? 0,
        ]);

        // Tambahkan detail pesanan (produk-produk)
        if (isset($data['products']) && is_array($data['products'])) {
            foreach ($data['products'] as $product) {
                self::addDetailPesanan($pesanan->id_pesanan, $product);
            }
        }

        return $pesanan->load(['pelanggan', 'karyawan', 'detailPesanans']);
    }

    /**
     * Get default payment status berdasarkan metode pembayaran
     */
    private static function getDefaultPaymentStatus($metode)
    {
        if ($metode === 'transfer') {
            return 'menunggu_verifikasi';
        }
        return 'lunas'; // cash adalah lunas langsung
    }

    /**
     * Tambahkan detail pesanan (produk ke pesanan)
     */
    public static function addDetailPesanan($id_pesanan, $productData)
    {
        // Cari produk berdasarkan ID atau nama
        $produk = null;

        if (isset($productData['id_produk'])) {
            $produk = Produk::find($productData['id_produk']);
        } elseif (isset($productData['nama_produk'])) {
            $produk = Produk::where('nama_produk', $productData['nama_produk'])->first();
        }

        if (!$produk) {
            throw new \Exception('Produk tidak ditemukan: ' . ($productData['nama_produk'] ?? $productData['id_produk']));
        }

        // Cek apakah sudah ada detail pesanan dengan produk yang sama
        $existing = Detail_Pesanan::where('id_pesanan', $id_pesanan)
            ->where('id_produk', $produk->id_produk)
            ->first();

        if ($existing) {
            // Update jumlah jika sudah ada
            $existing->update([
                'jumlah_pesan' => $productData['jumlah_pesan'],
            ]);
            return $existing;
        }

        // Buat detail pesanan baru
        return Detail_Pesanan::create([
            'id_pesanan' => $id_pesanan,
            'id_produk' => $produk->id_produk,
            'jumlah_pesan' => $productData['jumlah_pesan'],
        ]);
    }

    /**
     * Update pesanan yang sudah ada
     */
    public static function updatePesanan($id_pesanan, $data)
    {
        return DB::transaction(function () use ($id_pesanan, $data) {
            $pesanan = Pesanan::findOrFail($id_pesanan);

            $updateData = [];
            if (isset($data['total_bayar'])) {
                $updateData['total_bayar'] = $data['total_bayar'];
            }
            if (isset($data['status_bayar'])) {
                $updateData['status_bayar'] = $data['status_bayar'];
            }
            if (isset($data['tgl_pesan'])) {
                $updateData['tgl_pesan'] = $data['tgl_pesan'];
            }
            if (isset($data['metode_pembayaran'])) {
                $updateData['metode_pembayaran'] = $data['metode_pembayaran'];
            }
            if (isset($data['status_pembayaran'])) {
                $updateData['status_pembayaran'] = $data['status_pembayaran'];
            }
            if (isset($data['bukti_transfer'])) {
                $updateData['bukti_transfer'] = $data['bukti_transfer'];
            }
            if (isset($data['catatan_pesanan'])) {
                $updateData['catatan_pesanan'] = $data['catatan_pesanan'];
            }
            if (isset($data['alamat_delivery'])) {
                $updateData['alamat_delivery'] = $data['alamat_delivery'];
            }
            if (isset($data['tgl_delivery'])) {
                $updateData['tgl_delivery'] = $data['tgl_delivery'];
            }
            if (isset($data['tgl_verifikasi'])) {
                $updateData['tgl_verifikasi'] = $data['tgl_verifikasi'];
            }

            if (!empty($updateData)) {
                $pesanan->update($updateData);
            }

            // Update detail pesanan jika ada
            if (isset($data['products']) && is_array($data['products'])) {
                // Hapus detail lama
                Detail_Pesanan::where('id_pesanan', $id_pesanan)->delete();

                // Tambah detail baru
                foreach ($data['products'] as $product) {
                    self::addDetailPesanan($id_pesanan, $product);
                }
            }

            return $pesanan->load(['pelanggan', 'karyawan', 'detailPesanans']);
        });
    }

    /**
     * Dapatkan semua pesanan dengan detail lengkap
     */
    public static function getAllPesanan()
    {
        return Pesanan::with(['pelanggan', 'karyawan', 'detailPesanans', 'detailPesanans.produk'])
            ->get();
    }

    /**
     * Dapatkan pesanan berdasarkan tipe
     */
    public static function getPesananByType($type)
    {
        if ($type === 'karyawan') {
            return Pesanan::with(['karyawan', 'detailPesanans'])
                ->whereNotNull('id_karyawan')
                ->get();
        } elseif ($type === 'pelanggan') {
            return Pesanan::with(['pelanggan', 'karyawan', 'detailPesanans'])
                ->whereNotNull('id_pelanggan')
                ->get();
        }

        return [];
    }

    /**
     * Hapus pesanan dan detail-detailnya
     */
    public static function deletePesanan($id_pesanan)
    {
        return DB::transaction(function () use ($id_pesanan) {
            $pesanan = Pesanan::findOrFail($id_pesanan);
            
            // Hapus detail pesanan
            Detail_Pesanan::where('id_pesanan', $id_pesanan)->delete();
            
            // Hapus pesanan
            $pesanan->delete();
            
            return true;
        });
    }
}
