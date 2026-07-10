<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProvinsiSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'provinsi'],
            [
                'nama_lengkap' => 'Admin Provinsi',
                'username' => 'provinsi',
                'password' => Hash::make('12345678'),
                'role' => 'provinsi',
                'kode_desa' => '-',
                'aktif' => 1,
            ]
        );
    }
}