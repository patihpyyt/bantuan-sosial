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
}