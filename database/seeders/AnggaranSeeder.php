<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Anggaran;
use Illuminate\Database\Seeder;

class AnggaranSeeder extends Seeder
{
    public function run(): void
    {
        $kabupaten = User::where('role','kabupaten')->get();

        foreach($kabupaten as $item){

            Anggaran::create([

                'kabupaten_id'=>$item->id,

                'tahun'=>date('Y'),

                'total_anggaran'=>5000000000,

                'anggaran_terpakai'=>0,

                'sisa_anggaran'=>5000000000

            ]);

        }
    }
}