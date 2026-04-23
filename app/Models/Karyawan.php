<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_karyawan';

    protected $fillable = [
        'nama',
        'no_tlp',
        'alamat',
    ];

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_karyawan', 'id_karyawan');
    }
}
