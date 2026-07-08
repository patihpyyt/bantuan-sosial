<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanSanggahan extends Model
{
    protected $table = 'laporan_sanggahan';

    protected $fillable = [

        'pelapor_id',
        'warga_id',
        'alasan',
        'bukti',
        'status',
        'catatan_petugas',
        'ditangani_oleh'

    ];

    public function pelapor()
    {
        return $this->belongsTo(User::class,'pelapor_id');
    }

    public function warga()
    {
        return $this->belongsTo(Warga::class,'warga_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class,'ditangani_oleh');
    }
}