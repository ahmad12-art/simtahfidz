<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $guruRole = Role::where('slug', 'guru')->first();

        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator SIMTAHFIDZ',
                'email' => 'admin@simtahfidz.id',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'status' => 'aktif',
                'email_verified_at' => now(),
            ]
        );

        $guruUser = User::firstOrCreate(
            ['username' => 'guru1'],
            [
                'name' => 'Ustadz Ahmad Fauzi',
                'email' => 'guru1@simtahfidz.test',
                'password' => Hash::make('password'),
                'role_id' => $guruRole->id,
                'status' => 'aktif',
                'email_verified_at' => now(),
            ]
        );

        Guru::firstOrCreate(
            ['nip' => '198501012010011001'],
            [
                'user_id' => $guruUser->id,
                'nama' => 'Ustadz Ahmad Fauzi',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1985-01-01',
                'alamat' => 'Jl. Pesantren No. 1',
                'no_hp' => '081234567890',
                'email' => 'guru1@simtahfidz.test',
                'status' => 'aktif',
            ]
        );
    }
}
