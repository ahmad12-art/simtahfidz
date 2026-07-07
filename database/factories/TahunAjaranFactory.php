<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TahunAjaranFactory extends Factory
{
    public function definition(): array
    {
        $year = fake()->numberBetween(2023, 2025);

        return [
            'nama' => "{$year}/".($year + 1),
            'aktif' => false,
        ];
    }
}
