<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenerimaBansos extends Model
{
    protected $table = 'penerima_bansos';

    protected $fillable = [
        'warga_id',
        'jenis_bansos_id',
        'tanggal_menerima',
        'status',
        'keterangan'
    ];


    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }


    public function jenisBansos()
    {
        return $this->belongsTo(JenisBansos::class);
    }
}