<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{

    public function run(): void
    {

       User::updateOrCreate(
    ['username' => 'petugas'],
    [
        'nama_lengkap' => 'Petugas Desa',
        'username'     => 'petugas',  
        'password'     => Hash::make('123456'),
        'role'         => 'petugas',
        'kode_desa'    => 'DESA01',
        'aktif'        => true,
    ]
);

    }
}