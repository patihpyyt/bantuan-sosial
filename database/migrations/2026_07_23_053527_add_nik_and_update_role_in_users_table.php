<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
 public function up(): void
{
    if (!Schema::hasColumn('users', 'nik')) {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik', 16)->unique()->nullable()->after('nama_lengkap');
        });
    }

    DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'petugas', 'warga', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi') DEFAULT 'petugas'");
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        if (Schema::hasColumn('users', 'nik')) {
            $table->dropColumn('nik');
        }
    });

    DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'petugas', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi') DEFAULT 'petugas'");
}
};