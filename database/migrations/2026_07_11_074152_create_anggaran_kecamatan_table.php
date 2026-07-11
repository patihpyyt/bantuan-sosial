<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggaran_kecamatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kabupaten_id')->constrained('users')->onDelete('cascade');
            $table->year('tahun');
            $table->decimal('total_anggaran', 15, 2)->default(0);
            $table->decimal('anggaran_terpakai', 15, 2)->default(0);
            $table->decimal('sisa_anggaran', 15, 2)->default(0);
            $table->timestamps();

            $table->unique(['kecamatan_id', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggaran_kecamatan');
    }
};