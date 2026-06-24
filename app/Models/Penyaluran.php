<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyaluran extends Model
{
    protected $table = 'penyaluran';

    protected $fillable = [
        'penerima_id', 'periode_bulan', 'periode_tahun',
        'nominal', 'status', 'tanggal_salur',
        'metode', 'no_referensi', 'catatan', 'diupdate_oleh',
    ];

    protected $casts = [
        'tanggal_salur' => 'date',
        'nominal'       => 'decimal:2',
    ];

    public function penerima()
    {
        return $this->belongsTo(PenerimaBansos::class, 'penerima_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'diupdate_oleh');
    }

    public function scopePeriode($query, $bulan, $tahun)
    {
        return $query->where('periode_bulan', $bulan)->where('periode_tahun', $tahun);
    }

    public function scopeBelumTersalur($query)
    {
        return $query->whereIn('status', ['belum', 'proses']);
    }
}