<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pelanggan';

    protected $fillable = [
        'id_user',
        'nama',
        'no_tlp',
        'email',
        'alamat',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_pelanggan', 'id_pelanggan');
    }

    /**
     * Get total number of orders for this customer
     */
    public function getTotalPesananAttribute()
    {
        return $this->pesanans()->count();
    }

    /**
     * Get last order date
     */
    public function getLastPesananAttribute()
    {
        return $this->pesanans()->latest('tgl_pesan')->first()?->tgl_pesan;
    }

    /**
     * Find or create customer by phone number
     * Used for offline orders to prevent duplicates
     */
    public static function findOrCreateByPhoneNumber($phoneNumber, $name, $email = null, $address = 'Offline Order', $userId = null, $status = 'Offline')
    {
        $pelanggan = self::where('no_tlp', $phoneNumber)->first();

        if ($pelanggan) {
            return $pelanggan;
        }

        return self::create([
            'id_user' => $userId ?? auth()->id(),
            'nama' => $name,
            'no_tlp' => $phoneNumber,
            'email' => $email,
            'alamat' => $address,
            'status' => $status,
        ]);
    }
}
