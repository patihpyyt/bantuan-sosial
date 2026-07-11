<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use Notifiable;


   protected $fillable = [
    'nama_lengkap',
    'username',
    'nik',
    'password',
    'role',
    'kode_desa',
    'aktif',
];


    protected $hidden = [

        'password',
        'remember_token',

    ];


    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function laporanSanggahan()
{
    return $this->hasMany(LaporanSanggahan::class,'pelapor_id');
}

public function isProvinsi()
{
    return $this->role == 'provinsi';
}

public function isKabupaten()
{
    return $this->role == 'kabupaten';
}

public function isKecamatan()
{
    return $this->role == 'kecamatan';
}

public function isKelurahan()
{
    return $this->role == 'kelurahan';
}

public function isWarga()
{
    return $this->role == 'warga';
}

public function anggaran()
{
    return $this->hasMany(Anggaran::class,'kabupaten_id');
}


public function distribusiDiterima()
{
    return $this->hasMany(DistribusiAnggaran::class, 'kabupaten_id');
}
}