<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'ownerbakery3@gmail.com'],
            [
                'username' => 'owner_bakery',
                'password' => Hash::make('owner123'),
                'role' => 'owner',
            ]
        );

        User::updateOrCreate(
            ['email' => 'pelangganbakery3@gmail.com'],
            [
                'username' => 'pelanggan_bakery',
                'password' => Hash::make('pelanggan123'),
                'role' => 'pelanggan',
            ]
        );

        $produkList = [
            ['nama_produk' => 'Roti Kelapa', 'harga_produk' => 30000],
            ['nama_produk' => 'Roti Kacang Ijo', 'harga_produk' => 30000],
            ['nama_produk' => 'Roti Stroberi', 'harga_produk' => 35000],
            ['nama_produk' => 'Roti Bluberi', 'harga_produk' => 38000],
            ['nama_produk' => 'Roti Cokelat', 'harga_produk' => 35000],
        ];

        foreach ($produkList as $produk) {
            Produk::updateOrCreate(
                ['nama_produk' => $produk['nama_produk']],
                ['harga_produk' => $produk['harga_produk']]
            );
        }
    }
}
