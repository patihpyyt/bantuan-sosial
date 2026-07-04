<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;

class PortalPublicController extends Controller
{
    public function index()
{
    return view('bansos', [
        'totalPenerima' => \App\Models\PenerimaBansos::count(),
        'totalProgram'  => \App\Models\JenisBansos::count(),
        'totalAnggaran' => \App\Models\Penyaluran::where('status', 'tersalur')->sum('nominal'),
        'totalRTRW'     => \App\Models\Warga::distinct('desa')->count('desa'),
    ]);
}


  public function cek(Request $request)
{
    $nik = $request->nik;

    $warga = Warga::with([
        'penerimaBansos.jenisBansos',
        'penerimaBansos.penyaluran'
    ])
    ->where('nik', $nik)
    ->first();

    return view('bansos', [
        'nik'           => $nik,
        'warga'         => $warga,
        'totalPenerima' => \App\Models\PenerimaBansos::count(),
        'totalProgram'  => \App\Models\JenisBansos::count(),
        'totalAnggaran' => \App\Models\Penyaluran::where('status', 'tersalur')->sum('nominal'),
        'totalRTRW' => \App\Models\Warga::distinct('alamat')->count('alamat'),
    ]);
}
}