<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'id_pelanggan',
        'id_karyawan',
        'tgl_pesan',
        'sumber_pesanan',
        'metode_pengambilan',
        'status_bayar',
        'total_bayar',
        'metode_pembayaran',
        'status_pembayaran',
        'bukti_transfer',
        'catatan_pesanan',
        'tgl_delivery',
        'alamat_delivery',
        'tgl_verifikasi',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    public function detailPesanans()
    {
        return $this->hasMany(Detail_Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_pesanan', 'id_pesanan');
    }
}
