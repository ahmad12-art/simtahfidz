<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SurahFactory extends Factory
{
    private static int $nomor = 1;

    public function definition(): array
    {
        return [
            'nomor_surah' => self::$nomor++,
            'nama_surah' => fake()->unique()->word(),
            'jumlah_ayat' => fake()->numberBetween(3, 286),
            'juz' => fake()->numberBetween(1, 30),
            'kategori' => fake()->randomElement(['Makkiyah', 'Madaniyah']),
        ];
    }
}
