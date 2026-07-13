<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    protected $table = 'donasi';

    protected $fillable = [
        'kode_referensi', 'nama_donatur', 'email', 'jumlah',
        'metode_pembayaran', 'status', 'bukti_transfer',
        'pesan', 'verified_by', 'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}