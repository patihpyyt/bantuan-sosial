<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    protected $table='anggaran';

protected $fillable = [
    'kabupaten_id',
    'tahun',
    'total_anggaran',
    'anggaran_terpakai',
    'sisa_anggaran',
];

    public function kabupaten()
{
    return $this->belongsTo(User::class, 'kabupaten_id');
}
}