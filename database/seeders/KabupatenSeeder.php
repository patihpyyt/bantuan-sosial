<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KabupatenSeeder extends Seeder
{
    public function run(): void
    {
        $kabupaten = [
            // Bangka Belitung (sudah ada)
            'Kabupaten Bangka',
            'Kabupaten Bangka Barat',
            'Kabupaten Bangka Tengah',
            'Kabupaten Bangka Selatan',
            'Kabupaten Belitung',
            'Kabupaten Belitung Timur',
            'Kota Pangkalpinang',

            // Papua Pegunungan & Papua Tengah — daerah kemiskinan tertinggi nasional
            'Kabupaten Nduga',
            'Kabupaten Puncak Jaya',
            'Kabupaten Puncak',
            'Kabupaten Yalimo',
            'Kabupaten Lanny Jaya',
            'Kabupaten Tolikara',
            'Kabupaten Yahukimo',
            'Kabupaten Mamberamo Tengah',
            'Kabupaten Intan Jaya',
            'Kabupaten Deiyai',
            'Kabupaten Paniai',
            'Kabupaten Dogiyai',

            // Nusa Tenggara Timur
            'Kabupaten Sumba Tengah',
            'Kabupaten Sumba Barat Daya',
            'Kabupaten Sumba Timur',
            'Kabupaten Timor Tengah Selatan',
            'Kabupaten Manggarai Timur',

            // Maluku
            'Kabupaten Maluku Tenggara Barat',
            'Kabupaten Kepulauan Aru',

            // Aceh
            'Kabupaten Gayo Lues',
            'Kabupaten Aceh Singkil',
        ];

        foreach ($kabupaten as $i => $nama) {
            User::updateOrCreate(
                ['username' => Str::slug($nama)],
                [
                    'nama_lengkap' => $nama,
                    'nik'          => '17' . str_pad($i + 1, 14, '0', STR_PAD_LEFT),
                    'password'     => Hash::make('12345678'),
                    'role'         => 'kabupaten',
                    'kode_desa'    => null,
                    'aktif'        => 1,
                ]
            );
        }
    }
}