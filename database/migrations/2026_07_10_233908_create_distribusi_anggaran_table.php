<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('distribusi_anggaran', function (Blueprint $table) {

    $table->id();

    $table->foreignId('kabupaten_id')
          ->constrained('users')
          ->onDelete('cascade');

    $table->year('tahun');

    $table->decimal('jumlah',15,2);

    $table->date('tanggal_distribusi');

    $table->date('tanggal_diterima')->nullable();

    $table->string('keterangan')->nullable();

    $table->enum('status',[
        'terkirim',
        'diterima',
        'dibatalkan'
    ])->default('terkirim');

    $table->foreignId('created_by')
          ->nullable()
          ->constrained('users')
          ->nullOnDelete();

    $table->timestamps();

});
    }

    public function down(): void
    {
        Schema::dropIfExists('distribusi_anggaran');
    }
};