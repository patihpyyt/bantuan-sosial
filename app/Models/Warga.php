<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $table = 'warga';

    protected $fillable = [
        'nik',
        'no_kk',
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'desa',
        'kecamatan',
        'kabupaten',
        'pekerjaan',
        'penghasilan',
        'rt',
        'rw'
    ];

    public function penerimaBansos()
{
    return $this->hasMany(PenerimaBansos::class, 'warga_id');
}

public function laporanSanggahan()
{
    return $this->hasMany(LaporanSanggahan::class,'warga_id');
}
}