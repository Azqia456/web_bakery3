<?php

namespace Database\Seeders;

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
    }
}
