<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBansos extends Model
{
    protected $table = 'jenis_bansos';

    protected $fillable = [
        'nama_bansos',
        'deskripsi',
        'jumlah_bantuan'
    ];

    public function penerimaBansos()
{
    return $this->hasMany(PenerimaBansos::class);
}
}