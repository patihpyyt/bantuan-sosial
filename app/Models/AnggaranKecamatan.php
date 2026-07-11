<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggaranKecamatan extends Model
{
    protected $table = 'anggaran_kecamatan';

    protected $fillable = [
        'kecamatan_id',
        'kabupaten_id',
        'tahun',
        'total_anggaran',
        'anggaran_terpakai',
        'sisa_anggaran',
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