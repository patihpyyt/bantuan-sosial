<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up(): void
{
    Schema::create('distribusi_kelurahans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kecamatan_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('kelurahan_id')->nullable();
        $table->year('tahun');
        $table->bigInteger('jumlah');
        $table->enum('status', ['pending', 'terkirim', 'dibatalkan'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusi_kelurahans');
    }
};
