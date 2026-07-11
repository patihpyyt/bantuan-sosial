<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KabupatenTambahanSeeder extends Seeder
{
    public function run(): void
    {
        $kabupatenList = [
            'Kabupaten Bangka Barat'   => 'kab_bangka_barat',
            'Kabupaten Bangka Tengah'  => 'kab_bangka_tengah',
            'Kabupaten Bangka Selatan' => 'kab_bangka_selatan',
            'Kabupaten Belitung'       => 'kab_belitung',
            'Kabupaten Belitung Timur' => 'kab_belitung_timur',
            'Kota Pangkalpinang'       => 'kota_pangkalpinang',
        ];

        foreach ($kabupatenList as $namaLengkap => $username) {
            User::firstOrCreate(
                ['username' => $username],
                [
                    'nama_lengkap' => $namaLengkap,
                    'password' => Hash::make('12345678'),
                    'role' => 'kabupaten',
                ]
            );
        }
    }
}