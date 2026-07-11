<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistribusiKecamatan extends Model
{
    protected $table = 'distribusi_kecamatan';

    protected $fillable = [
        'kecamatan_id',
        'kabupaten_id',
        'tahun',
        'jumlah',
        'tanggal_distribusi',
        'keterangan',
        'status',
        'created_by',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(User::class, 'kecamatan_id');
    }

    public function kabupaten()
    {
        return $this->belongsTo(User::class, 'kabupaten_id');
    }
}