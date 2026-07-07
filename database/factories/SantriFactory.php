<?php

namespace Database\Factories;

use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SantriFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kelas_id' => Kelas::factory(),
            'nis' => fake()->unique()->numerify('##########'),
            'nama' => fake()->name(),
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
            'tempat_lahir' => fake()->city(),
            'tanggal_lahir' => fake()->dateTimeBetween('-15 years', '-10 years'),
            'alamat' => fake()->address(),
            'nama_wali' => fake()->name(),
            'no_hp_wali' => fake()->numerify('08##########'),
            'status' => 'aktif',
            'qr_code' => 'SIMTAHFIDZ-'.Str::upper(Str::random(10)),
        ];
    }
}
