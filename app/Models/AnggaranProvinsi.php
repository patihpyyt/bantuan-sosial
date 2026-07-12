<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggaranProvinsi extends Model
{
    protected $table = 'anggaran_provinsi';

    protected $fillable = [
        'tahun', 'total_anggaran',
    ];
}