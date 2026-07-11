<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distribusi_kecamatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kabupaten_id')->constrained('users')->onDelete('cascade');
            $table->year('tahun');
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal_distribusi');
            $table->string('keterangan')->nullable();
            $table->enum('status', ['terkirim', 'dibatalkan'])->default('terkirim');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distribusi_kecamatan');
    }

    public function index()
{
    $user=auth()->user();

    $distribusi=Distribusi::where('kabupaten_id',$user->id)
                    ->latest()
                    ->get();

    return view(
        'kabupaten.penerimaan.index',
        compact('distribusi')
    );
}
};