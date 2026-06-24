<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisBansos;

class JenisBansosSeeder extends Seeder
{
    public function run(): void
    {
        JenisBansos::create([
            'nama_bansos' => 'Program Keluarga Harapan (PKH)',
            'deskripsi' => 'Bantuan sosial untuk keluarga miskin.',
            'jumlah_bantuan' => 600000
        ]);

        JenisBansos::create([
            'nama_bansos' => 'Bantuan Langsung Tunai (BLT)',
            'deskripsi' => 'Bantuan tunai masyarakat.',
            'jumlah_bantuan' => 300000
        ]);

        JenisBansos::create([
            'nama_bansos' => 'Bantuan Sembako',
            'deskripsi' => 'Bantuan kebutuhan pokok.',
            'jumlah_bantuan' => 200000
        ]);
    }
}