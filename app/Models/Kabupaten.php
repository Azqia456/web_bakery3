<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $primaryKey = 'id_kabupaten';

    protected $fillable = [
        'nama_kabupaten',
    ];

    public function kecamatans()
    {
        return $this->hasMany(Kecamatan::class, 'id_kabupaten', 'id_kabupaten');
    }
}
