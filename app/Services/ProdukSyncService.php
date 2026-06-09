<?php

namespace App\Services;

use App\Models\Produk;

class ProdukSyncService
{
    /**
     * Sinkronkan data produk dari sumber eksternal atau validasi data yang ada
     */
    public static function syncAll()
    {
        // Pastikan semua data produk konsisten dan tidak ada duplikat
        self::removeDuplicates();
        
        return Produk::all();
    }

    /**
     * Hapus duplikat data produk berdasarkan nama
     */
    public static function removeDuplicates()
    {
        $produks = Produk::all()->groupBy('nama_produk');
        
        foreach ($produks as $nama => $items) {
            if ($items->count() > 1) {
                // Simpan yang pertama, hapus yang lain
                $first = $items->first();
                $items->slice(1)->each(function($item) {
                    $item->delete();
                });
            }
        }
    }

    /**
     * Sinkronkan produk individual
     */
    public static function syncProduct($id_produk, $data)
    {
        $produk = Produk::find($id_produk);
        
        if ($produk) {
            $produk->update($data);
            return $produk;
        }
        
        return null;
    }

    /**
     * Tambah produk dan sinkronisasi
     */
    public static function createProduct($data)
    {
        return Produk::create($data);
    }
}
