<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
{
    return view('bansos', [
        'totalPenerima' => \App\Models\PenerimaBansos::count(),
        'totalProgram'  => \App\Models\JenisBansos::count(),
        'totalAnggaran' => \App\Models\Penyaluran::where('status', 'tersalur')->sum('nominal'),
        'totalRTRW'     => \App\Models\Warga::distinct('alamat')->count('alamat'), 
    ]);
}
}
