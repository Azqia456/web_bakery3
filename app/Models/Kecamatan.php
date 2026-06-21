<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $primaryKey = 'id_kecamatan';

    protected $fillable = [
        'id_kabupaten',
        'nama_kecamatan',
        'ongkir',
    ];

    protected $casts = [
        'ongkir' => 'decimal:2',
    ];

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'id_kabupaten', 'id_kabupaten');
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_kecamatan', 'id_kecamatan');
    }
}
