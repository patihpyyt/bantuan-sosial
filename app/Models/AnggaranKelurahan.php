<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggaranKelurahan extends Model
{
    protected $table = 'anggaran_kelurahan';

    protected $fillable = [
        'kelurahan_id', 'kecamatan_id', 'tahun',
        'total_anggaran', 'anggaran_terpakai', 'sisa_anggaran',
    ];
}