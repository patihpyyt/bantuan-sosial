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
    Schema::create('warga', function (Blueprint $table) {
        $table->id();

        $table->string('nik', 16)->unique();
        $table->string('no_kk', 16);
        $table->string('nama_lengkap');

        $table->enum('jenis_kelamin', [
            'Laki-laki',
            'Perempuan'
        ]);

        $table->date('tanggal_lahir')->nullable();

        $table->text('alamat');

        $table->string('desa')->nullable();
        $table->string('kecamatan')->nullable();
        $table->string('kabupaten')->nullable();

        $table->string('pekerjaan')->nullable();
        $table->decimal('penghasilan', 12, 2)->nullable();

        $table->timestamps();
    });
}
public function down(): void
{
    Schema::dropIfExists('warga');
}
};
