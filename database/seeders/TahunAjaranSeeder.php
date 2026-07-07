<?php

namespace Database\Seeders;

use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        $ta = TahunAjaran::firstOrCreate(['nama' => '2025/2026'], ['aktif' => true]);

        Semester::firstOrCreate(
            ['tahun_ajaran_id' => $ta->id, 'nama' => 'Ganjil'],
            ['aktif' => true]
        );
        Semester::firstOrCreate(
            ['tahun_ajaran_id' => $ta->id, 'nama' => 'Genap'],
            ['aktif' => false]
        );
    }
}
