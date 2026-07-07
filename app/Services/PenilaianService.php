<?php

namespace App\Services;

/**
 * Menangani seluruh logika perhitungan nilai (dipakai oleh Setoran,
 * Murajaah, dan Penilaian semester) supaya bobot penilaian hanya
 * didefinisikan di satu tempat (Single Source of Truth).
 */
class PenilaianService
{
    /** Bobot penilaian setoran/murajaah harian */
    public const BOBOT_KELANCARAN = 0.40;
    public const BOBOT_TAJWID = 0.30;
    public const BOBOT_MAKHRAJ = 0.20;
    public const BOBOT_ADAB = 0.10;

    /**
     * Hitung nilai akhir setoran/murajaah (skala 0-100) berdasarkan
     * empat komponen: kelancaran 40%, tajwid 30%, makhraj 20%, adab 10%.
     * Jika adab tidak dinilai (murajaah), bobot adab dialihkan ke kelancaran.
     */
    public function hitungNilaiAkhir(
        float $kelancaran,
        float $tajwid,
        float $makhraj,
        ?float $adab = null
    ): float {
        if ($adab === null) {
            // Murajaah tidak menilai adab -> redistribusi bobot secara proporsional
            $total = ($kelancaran * 0.50) + ($tajwid * 0.30) + ($makhraj * 0.20);
        } else {
            $total = ($kelancaran * self::BOBOT_KELANCARAN)
                + ($tajwid * self::BOBOT_TAJWID)
                + ($makhraj * self::BOBOT_MAKHRAJ)
                + ($adab * self::BOBOT_ADAB);
        }

        return round($total, 2);
    }

    /**
     * Hitung nilai akhir rapor semester: kelancaran, tajwid, makhraj,
     * adab, dan kehadiran masing-masing memakai bobot yang sama seperti
     * setoran harian, ditambah kehadiran sebagai pelengkap 10% terakhir
     * (adab & kehadiran berbagi porsi 10% agar total tetap 100%).
     */
    public function hitungNilaiSemester(
        float $kelancaran,
        float $tajwid,
        float $makhraj,
        float $adab,
        float $kehadiran
    ): float {
        $nilai = ($kelancaran * 0.35)
            + ($tajwid * 0.30)
            + ($makhraj * 0.20)
            + ($adab * 0.10)
            + ($kehadiran * 0.05);

        return round($nilai, 2);
    }

    /**
     * Tentukan predikat huruf dari nilai akhir numerik.
     */
    public function tentukanPredikat(float $nilaiAkhir): string
    {
        return match (true) {
            $nilaiAkhir >= 90 => 'A',
            $nilaiAkhir >= 80 => 'B',
            $nilaiAkhir >= 70 => 'C',
            default => 'D',
        };
    }
}
