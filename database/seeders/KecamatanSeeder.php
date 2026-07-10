<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(

            [
                'username' => 'kecamatan'
            ],

            [
                'nama_lengkap' => 'Admin Kecamatan',
                'password' => Hash::make('12345678'),
                'role' => 'kecamatan',
                'kode_desa' => 'KEC001',
                'aktif' => 1
            ]

        );
    }
}