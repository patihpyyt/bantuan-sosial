<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distribusi_kelurahan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelurahan_id');
            $table->unsignedBigInteger('kecamatan_id');
            $table->year('tahun');
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal_distribusi');
            $table->string('keterangan')->nullable();
            $table->enum('status', ['terkirim', 'diterima', 'dibatalkan'])->default('terkirim');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distribusi_kelurahan');
    }
};