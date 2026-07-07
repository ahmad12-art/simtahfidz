<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed data inti aplikasi (wajib untuk aplikasi bisa dipakai).
     * Jalankan DemoDataSeeder secara terpisah bila butuh data contoh:
     *   php artisan db:seed --class=DemoDataSeeder
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            SurahSeeder::class,
            TahunAjaranSeeder::class,
        ]);
        \App\Models\Murajaah::factory(10)->create();
        \App\Models\Setoran::factory(10)->create();
        \App\Models\TargetHafalan::factory(10)->create();
        

    }
}