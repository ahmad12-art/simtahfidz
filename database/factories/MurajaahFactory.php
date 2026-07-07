<?php

namespace Database\Factories;

use App\Models\Guru;
use App\Models\Santri;
use App\Models\Surah;
use App\Services\PenilaianService;
use Illuminate\Database\Eloquent\Factories\Factory;

class MurajaahFactory extends Factory
{
    public function definition(): array
    {
        $kelancaran = fake()->numberBetween(60, 100);
        $tajwid = fake()->numberBetween(60, 100);
        $makhraj = fake()->numberBetween(60, 100);
        $ayatAwal = fake()->numberBetween(1, 20);

        return [
            'santri_id' => Santri::factory(),
            'guru_id' => Guru::factory(),
            'surah_id' => Surah::factory(),
            'tanggal' => fake()->dateTimeBetween('-3 months', 'now'),
            'ayat_awal' => $ayatAwal,
            'ayat_akhir' => $ayatAwal + fake()->numberBetween(1, 10),
            'nilai_kelancaran' => $kelancaran,
            'nilai_tajwid' => $tajwid,
            'nilai_makhraj' => $makhraj,
            'nilai_akhir' => app(PenilaianService::class)->hitungNilaiAkhir($kelancaran, $tajwid, $makhraj),
            'status' => fake()->randomElement(['lancar', 'mengulang', 'belum_lancar']),
        ];
    }
}
