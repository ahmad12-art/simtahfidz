<?php

namespace Database\Factories;

use App\Models\Santri;
use App\Models\Semester;
use App\Services\PenilaianService;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenilaianFactory extends Factory
{
    public function definition(): array
    {
        $kelancaran = fake()->numberBetween(70, 100);
        $tajwid = fake()->numberBetween(70, 100);
        $makhraj = fake()->numberBetween(70, 100);
        $adab = fake()->numberBetween(70, 100);
        $kehadiran = fake()->numberBetween(80, 100);

        $service = app(PenilaianService::class);
        $nilaiAkhir = $service->hitungNilaiSemester($kelancaran, $tajwid, $makhraj, $adab, $kehadiran);

        return [
            'santri_id' => Santri::factory(),
            'semester_id' => Semester::factory(),
            'kelancaran' => $kelancaran,
            'tajwid' => $tajwid,
            'makhraj' => $makhraj,
            'adab' => $adab,
            'kehadiran' => $kehadiran,
            'nilai_akhir' => $nilaiAkhir,
            'predikat' => $service->tentukanPredikat($nilaiAkhir),
        ];
    }
}
