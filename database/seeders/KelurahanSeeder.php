<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KelurahanSeeder extends Seeder
{
    public function run(): void
    {
        // key = username kecamatan (harus sudah ada di tabel users)
        $data = [
            'kec_sungailiat' => [
                'Kenanga', 'Rebo', 'Parit Padang', 'Srimenanti', 'Sungailiat',
                'Kudai', 'Sinar Baru', 'Lubuk Kelik', 'Surya Timur',
                'Jelitik', 'Bukit Betung', 'Sinar Jaya Jelutung', 'Matras',
            ],
        ];

        foreach ($data as $usernameKecamatan => $listKelurahan) {

            $kecamatan = User::where('username', $usernameKecamatan)->first();

            if (!$kecamatan) {
                continue; // skip kalau akun kecamatannya belum ada
            }

            foreach ($listKelurahan as $namaKelurahan) {
                $usernameKelurahan = 'kel_' . strtolower(str_replace(' ', '_', $namaKelurahan));

                User::firstOrCreate(
                    ['username' => $usernameKelurahan],
                    [
                        'nama_lengkap' => 'Kelurahan ' . $namaKelurahan,
                        'password'     => Hash::make('12345678'),
                        'role'         => 'kelurahan',
                        'kecamatan_id' => $kecamatan->id,
                    ]
                );
            }
        }
    }
}