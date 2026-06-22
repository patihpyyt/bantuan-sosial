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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('nama_lengkap', 100);
        $table->string('username', 50)->unique();
        $table->string('password');
        $table->enum('role', ['admin', 'petugas'])->default('petugas');
        $table->string('kode_desa', 20);
        $table->boolean('aktif')->default(true);
        $table->timestamp('terakhir_login')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
