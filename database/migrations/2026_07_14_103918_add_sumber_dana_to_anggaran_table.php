<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anggaran', function (Blueprint $table) {
            $table->enum('sumber_dana', ['apbd', 'donasi'])->default('apbd')->after('tahun');
            $table->unsignedBigInteger('donasi_id')->nullable()->after('sumber_dana');
        });
    }

    public function down(): void
    {
        Schema::table('anggaran', function (Blueprint $table) {
            $table->dropColumn(['sumber_dana', 'donasi_id']);
        });
    }
};