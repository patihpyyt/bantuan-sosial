<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_sanggahan', function (Blueprint $table) {

            $table->id();

            $table->foreignId('pelapor_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('warga_id')
                ->constrained('warga')
                ->cascadeOnDelete();

            $table->text('alasan');

            $table->string('bukti')->nullable();

            $table->enum('status', [
                'menunggu',
                'diproses',
                'selesai',
                'ditolak'
            ])->default('menunggu');

            $table->text('catatan_petugas')->nullable();

            $table->foreignId('ditangani_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_sanggahan');
    }
};