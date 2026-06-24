<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pesanan';

    protected $casts = [
        'tgl_pesan' => 'datetime',
        'tgl_delivery' => 'date',
        'tgl_pickup' => 'date',
        'tgl_verifikasi' => 'datetime',
        'total_bayar' => 'decimal:2',
        'ongkir' => 'decimal:2',
        'checkout_expired_at' => 'datetime',
    ];

    protected $fillable = [
        'id_pelanggan',
        'id_karyawan',
        'id_kecamatan',
        'tgl_pesan',
        'sumber_pesanan',
        'metode_pengambilan',
        'status_bayar',
        'total_bayar',
        'ongkir',
        'metode_pembayaran',
        'status_pembayaran',
        'status_pesanan',
        'bukti_transfer',
        'catatan_pesanan',
        'tgl_delivery',
        'tgl_pickup',
        'alamat_delivery',
        'alamat_detail',
        'tgl_verifikasi',
        'checkout_url',
        'checkout_expired_at',
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

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_pesanan', 'id_pesanan');
    }
}
