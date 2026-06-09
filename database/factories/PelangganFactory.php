<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PelangganFactory extends Factory
{
    protected $model = Pelanggan::class;

    public function definition(): array
    {
        return [
            'id_user' => 1,
            'nama' => fake()->name(),
            'no_tlp' => fake()->unique()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'alamat' => fake()->address(),
            'status' => fake()->randomElement(['Online', 'Offline']),
        ];
    }
}
