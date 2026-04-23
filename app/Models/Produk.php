<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'nama_produk',
        'harga_produk',
    ];

    public function detailPesanans()
    {
        return $this->hasMany(Detail_Pesanan::class, 'id_produk', 'id_produk');
    }
}
