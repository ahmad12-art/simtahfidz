<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Santri;
use App\Models\Setoran;
use App\Models\Surah;
use App\Models\TahunAjaran;
use App\Models\TargetHafalan;
use App\Services\PenilaianService;
use Illuminate\Database\Seeder;

/**
 * Seeder data contoh (dummy) untuk keperluan demo/portofolio.
 * Tidak dijalankan otomatis di produksi (jalankan manual jika perlu).
 */
class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAjaran = TahunAjaran::first() ?? TahunAjaran::factory()->create(['aktif' => true]);

        $guru = Guru::factory()->count(5)->create();

        $kelas = collect(['7A', '7B', '8A', '8B'])->map(
            fn ($nama) => Kelas::create([
                'nama_kelas' => $nama,
                'tingkat' => substr($nama, 0, 1),
                'tahun_ajaran_id' => $tahunAjaran->id,
                'wali_kelas_id' => $guru->random()->id,
            ])
        );

        $santri = $kelas->flatMap(
            fn ($k) => Santri::factory()->count(10)->create(['kelas_id' => $k->id])
        );

        $surah = Surah::inRandomOrder()->take(15)->get();
        $service = app(PenilaianService::class);

        $santri->each(function (Santri $s) use ($guru, $surah, $service) {
            $target = TargetHafalan::factory()->create([
                'santri_id' => $s->id,
                'guru_id' => $guru->random()->id,
                'surah_id' => $surah->random()->id,
                'status' => 'berjalan',
            ]);

            foreach (range(1, rand(3, 8)) as $i) {
                $kelancaran = rand(65, 100);
                $tajwid = rand(65, 100);
                $makhraj = rand(65, 100);
                $adab = rand(70, 100);

                Setoran::create([
                    'target_hafalan_id' => $target->id,
                    'santri_id' => $s->id,
                    'guru_id' => $target->guru_id,
                    'surah_id' => $target->surah_id,
                    'tanggal' => now()->subDays(rand(0, 90)),
                    'ayat_awal' => $target->ayat_awal,
                    'ayat_akhir' => min($target->ayat_akhir, $target->ayat_awal + $i * 2),
                    'nilai_kelancaran' => $kelancaran,
                    'nilai_tajwid' => $tajwid,
                    'nilai_makhraj' => $makhraj,
                    'nilai_adab' => $adab,
                    'nilai_akhir' => $service->hitungNilaiAkhir($kelancaran, $tajwid, $makhraj, $adab),
                    'status' => 'lancar',
                ]);
            }
        });
    }
}
