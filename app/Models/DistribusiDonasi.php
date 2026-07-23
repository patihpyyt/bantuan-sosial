<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistribusiDonasi extends Model
{
    protected $table = 'distribusi_donasi';

    protected $fillable = [
        'donasi_id',
        'kabupaten_id',
        'program_id',
        'jumlah_dana',
        'tanggal_penyaluran',
        'keterangan',
    ];
}