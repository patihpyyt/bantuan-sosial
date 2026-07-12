<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('warga', 'kelurahan_id')) {
            Schema::table('warga', function (Blueprint $table) {
                $table->unsignedBigInteger('kelurahan_id')->nullable()->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('warga', 'kelurahan_id')) {
            Schema::table('warga', function (Blueprint $table) {
                $table->dropColumn('kelurahan_id');
            });
        }
    }
};