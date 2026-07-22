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
            
            'Kabupaten Bangka',
            'Kabupaten Bangka Barat',
            'Kabupaten Bangka Tengah',
            'Kabupaten Bangka Selatan',
            'Kabupaten Belitung',
            'Kabupaten Belitung Timur',
            'Kota Pangkalpinang',

           
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

           
            'Kabupaten Sumba Tengah',
            'Kabupaten Sumba Barat Daya',
            'Kabupaten Sumba Timur',
            'Kabupaten Timor Tengah Selatan',
            'Kabupaten Manggarai Timur',

            
            'Kabupaten Maluku Tenggara Barat',
            'Kabupaten Kepulauan Aru',

         
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