<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KabupatenSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(

            [
                'username' => 'kabupaten'
            ],

            [
                'nama_lengkap' => 'Admin Kabupaten',
                'password' => Hash::make('12345678'),
                'role' => 'kabupaten',
                'kode_desa' => 'KAB001',
                'aktif' => 1
            ]

        );
    }
}