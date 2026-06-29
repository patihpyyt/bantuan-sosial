<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Warga;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. SELESAIKAN PEMBUATAN TABEL NYA DULU
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16);
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat');
            $table->string('desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->decimal('penghasilan', 12, 2)->nullable();
            $table->timestamps();
        }); // <-- KURUNG PENUTUP SCHEMA SAKRAL DI SINI!

        // 2. BARU MASUKKAN DATA AWAL DI LUAR BLOK SCHEMA
        Warga::create([
            'no_kk'         => '1234567890123456',
            'nik'           => '1234567890123456', // buat 16 digit sesuai rule string(16)
            'nama_lengkap'  => 'Budi',
            'jenis_kelamin' => 'Laki-laki', // wajib diisi karena di tabel tidak nullable
            'alamat'        => 'Desa Contoh',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};