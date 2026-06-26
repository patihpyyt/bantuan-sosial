<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penyaluran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penerima_id')
                ->constrained('penerima_bansos')
                ->onDelete('cascade');
            $table->tinyInteger('periode_bulan');   
            $table->year('periode_tahun');
            $table->decimal('nominal', 12, 2);
            $table->enum('status', ['belum', 'proses', 'tersalur', 'gagal'])->default('belum');
            $table->date('tanggal_salur')->nullable();
            $table->enum('metode', ['transfer_bank', 'tunai', 'kantor_pos'])->nullable();
            $table->string('no_referensi', 50)->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('diupdate_oleh')->nullable()->constrained('users');
            $table->timestamps();

            $table->unique(['penerima_id', 'periode_bulan', 'periode_tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyaluran');
    }
};