<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_bansos', function (Blueprint $table) {

            $table->id();

            $table->string('nama_bansos');

            $table->text('deskripsi')
                  ->nullable();

            $table->decimal('jumlah_bantuan', 12, 2)
                  ->nullable();

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('jenis_bansos');
    }
};