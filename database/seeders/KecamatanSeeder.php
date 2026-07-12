<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        // key = username kabupaten (harus sudah ada di tabel users)
        $data = [
            'kabupaten' => [ // Kabupaten Bangka (id 1)
                'Sungailiat', 'Pemali', 'Merawang', 'Bakam',
                'Puding Besar', 'Mendo Barat', 'Belinyu', 'Riau Silip',
            ],
            'kab_bangka_barat' => [
                'Muntok', 'Simpang Teritip', 'Jebus', 'Tempilang', 'Kelapa', 'Parittiga',
            ],
            'kab_bangka_tengah' => [
                'Koba', 'Pangkalan Baru', 'Sungai Selan', 'Simpang Katis', 'Lubuk Besar', 'Namang',
            ],
            'kab_bangka_selatan' => [
                'Toboali', 'Air Gegas', 'Payung', 'Rias', 'Simpang Rimba',
                'Tukak Sadai', 'Lepar Pongok', 'Pulau Besar',
            ],
            'kab_belitung' => [
                'Tanjung Pandan', 'Badau', 'Membalong', 'Sijuk', 'Selat Nasik',
            ],
            'kab_belitung_timur' => [
                'Manggar', 'Gantung', 'Kelapa Kampit', 'Dendang',
                'Simpang Renggiang', 'Simpang Pesak', 'Damar',
            ],
            'kota_pangkalpinang' => [
                'Pangkal Balam', 'Rangkui', 'Bukit Intan', 'Girimaya',
                'Gabek', 'Gerunggang', 'Taman Sari',
            ],
        ];

        foreach ($data as $usernameKabupaten => $listKecamatan) {

            $kabupaten = User::where('username', $usernameKabupaten)->first();

            if (!$kabupaten) {
                continue; // skip kalau akun kabupatennya belum ada
            }

            foreach ($listKecamatan as $namaKecamatan) {
                $usernameKecamatan = 'kec_' . strtolower(str_replace(' ', '_', $namaKecamatan));

                User::firstOrCreate(
                    ['username' => $usernameKecamatan],
                    [
                        'nama_lengkap' => 'Kecamatan ' . $namaKecamatan,
                        'password'     => Hash::make('12345678'),
                        'role'         => 'kecamatan',
                        'kabupaten_id' => $kabupaten->id,
                    ]
                );
            }
        }
    }
}