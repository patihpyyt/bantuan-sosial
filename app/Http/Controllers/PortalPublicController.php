<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;

class PortalPublicController extends Controller
{
    public function index()
    {
        return view('bansos');
    }


    public function cek(Request $request)
    {
        $nik = $request->nik;

        $warga = Warga::with([
            'penerimaBansos.jenisBansos',
            'penerimaBansos.penyaluran'
        ])
        ->where('nik',$nik)
        ->first();


        return view('bansos', compact(
            'nik',
            'warga'
        ));
    }
}