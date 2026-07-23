<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distribusi_donasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donasi_id')->constrained('donasi')->cascadeOnDelete();
            $table->foreignId('kabupaten_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('program_id')->constrained('jenis_bansos')->cascadeOnDelete();
            $table->decimal('jumlah_dana', 15, 2);
            $table->date('tanggal_penyaluran');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distribusi_donasi');
    }
};