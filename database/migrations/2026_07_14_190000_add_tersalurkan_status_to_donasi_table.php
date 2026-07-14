<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE donasi MODIFY COLUMN status ENUM('menunggu_pembayaran','menunggu_verifikasi','terverifikasi','ditolak','tersalurkan') NOT NULL DEFAULT 'menunggu_pembayaran'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE donasi MODIFY COLUMN status ENUM('menunggu_pembayaran','menunggu_verifikasi','terverifikasi','ditolak') NOT NULL DEFAULT 'menunggu_pembayaran'");
    }
};