<?php

namespace Database\Factories;

use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelasFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tahun_ajaran_id' => TahunAjaran::factory(),
            'nama_kelas' => fake()->randomElement(['7A', '7B', '8A', '8B', '9A', '9B']),
            'tingkat' => fake()->randomElement(['7', '8', '9']),
        ];
    }
}
