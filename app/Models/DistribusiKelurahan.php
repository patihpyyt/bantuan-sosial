<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistribusiKelurahan extends Model
{
    protected $table = 'distribusi_kelurahan';

    protected $fillable = [
        'kelurahan_id', 'kecamatan_id', 'tahun', 'jumlah',
        'tanggal_distribusi', 'keterangan', 'status', 'created_by',
    ];

    public function kelurahan()
    {
        return $this->belongsTo(User::class, 'kelurahan_id');
    }
}