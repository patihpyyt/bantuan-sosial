<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donasi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_referensi')->unique();
            $table->string('nama_donatur');
            $table->string('email')->nullable();
            $table->decimal('jumlah', 15, 2);
            $table->enum('metode_pembayaran', ['transfer_bank', 'qris', 'ewallet']);
            $table->enum('status', ['menunggu_pembayaran', 'menunggu_verifikasi', 'terverifikasi', 'ditolak'])
                  ->default('menunggu_pembayaran');
            $table->string('bukti_transfer')->nullable();
            $table->text('pesan')->nullable(); // pesan/doa dari donatur, opsional
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donasi');
    }
};