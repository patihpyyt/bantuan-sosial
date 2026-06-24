<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisBansos;

class JenisBansosSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_bansos' => 'Program Keluarga Harapan (PKH)',   'deskripsi' => 'Bantuan sosial untuk keluarga miskin.',              'jumlah_bantuan' => 600000],
            ['nama_bansos' => 'Bantuan Langsung Tunai (BLT)',      'deskripsi' => 'Bantuan tunai langsung kepada masyarakat.',          'jumlah_bantuan' => 300000],
            ['nama_bansos' => 'Bantuan Pangan Non Tunai (BPNT)',   'deskripsi' => 'Bantuan pangan berupa sembako melalui e-warong.',    'jumlah_bantuan' => 200000],
            ['nama_bansos' => 'Bantuan Sembako',                   'deskripsi' => 'Bantuan kebutuhan pokok langsung.',                  'jumlah_bantuan' => 200000],
        ];

        foreach ($data as $item) {
            JenisBansos::firstOrCreate(
                ['nama_bansos' => $item['nama_bansos']],
                $item
            );
        }
    }
}