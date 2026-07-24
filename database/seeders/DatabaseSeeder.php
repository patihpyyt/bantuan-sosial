<?php

namespace Database\Seeders;

use Database\Seeders\AdminSeeder;
use Database\Seeders\JenisBansosSeeder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      $this->call([
    ProvinsiSeeder::class,
    AnggaranSeeder::class,
    KabupatenTambahanSeeder::class,
    KecamatanSeeder::class,
    KelurahanSeeder::class,
    AdminSeeder::class,
    JenisBansosSeeder::class,
    UserSeeder::class,
   
]);
    }
}
