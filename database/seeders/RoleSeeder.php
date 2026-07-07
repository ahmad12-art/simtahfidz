<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['slug' => 'admin'], ['nama' => 'Administrator']);
        Role::firstOrCreate(['slug' => 'guru'], ['nama' => 'Guru Tahfidz']);
    }
}
