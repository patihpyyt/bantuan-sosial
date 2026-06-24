<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penerima_bansos', function (Blueprint $table) {

            $table->id();

            // relasi ke tabel warga
            $table->foreignId('warga_id')
                  ->constrained('warga')
                  ->cascadeOnDelete();

            // relasi ke tabel jenis bansos
            $table->foreignId('jenis_bansos_id')
                  ->constrained('jenis_bansos')
                  ->cascadeOnDelete();

            $table->date('tanggal_menerima')
                  ->nullable();

            $table->enum('status', [
                'diajukan',
                'diterima',
                'ditolak'
            ])->default('diajukan');

            $table->text('keterangan')
                  ->nullable();

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('penerima_bansos');
    }
};