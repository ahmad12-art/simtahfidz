<?php

namespace Database\Factories;

use App\Models\Guru;
use App\Models\Santri;
use App\Models\Surah;
use Illuminate\Database\Eloquent\Factories\Factory;

class TargetHafalanFactory extends Factory
{
    public function definition(): array
    {
        $ayatAwal = fake()->numberBetween(1, 20);

        return [
            'santri_id' => Santri::factory(),
            'guru_id' => Guru::factory(),
            'surah_id' => Surah::factory(),
            'ayat_awal' => $ayatAwal,
            'ayat_akhir' => $ayatAwal + fake()->numberBetween(5, 20),
            'tanggal_mulai' => fake()->dateTimeBetween('-2 months', 'now'),
            'deadline' => fake()->dateTimeBetween('now', '+2 months'),
            'status' => fake()->randomElement(['berjalan', 'selesai']),
            'persentase_progress' => fake()->randomFloat(2, 0, 100),
        ];
    }
}
