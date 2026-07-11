<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistribusiAnggaran extends Model
{
    protected $table = 'distribusi_anggaran';

    protected $fillable = [
        'kabupaten_id',
        'tahun',
        'jumlah',
        'tanggal_distribusi',
        'keterangan',
        'status',
        'created_by',
    ];

    protected $casts = [
        'tanggal_distribusi' => 'date',
    ];

    public function kabupaten()
    {
        return $this->belongsTo(User::class, 'kabupaten_id');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}