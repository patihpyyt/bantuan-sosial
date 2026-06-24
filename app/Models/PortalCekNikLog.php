<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortalCekNikLog extends Model
{
    public $timestamps = false;

    protected $table = 'portal_cek_nik_log';

    protected $fillable = ['nik', 'ip_address', 'ditemukan'];
}