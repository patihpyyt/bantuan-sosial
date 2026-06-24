<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'aksi', 'tabel_terdampak',
        'record_id', 'nilai_lama', 'nilai_baru',
        'ip_address',
    ];

    protected $casts = [
        'nilai_lama' => 'array',
        'nilai_baru' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}