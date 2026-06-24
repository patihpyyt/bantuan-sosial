<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\PortalCekNikLog;
use Illuminate\Http\Request;

class PortalPublikController extends Controller
{
    public function index()
    {
        return view('portal.index');
    }

    public function cek(Request $request)
    {
        $request->validate([
            'nik' => ['required', 'digits:16'],
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits'   => 'NIK harus 16 digit angka.',
        ]);

        $nik = $request->input('nik');

        $warga = Warga::where('nik', $nik)
            ->with([
                'penerimaBansos.jenisBansos',
                'penerimaBansos.penyaluran' => fn($q) => $q
                    ->orderBy('periode_tahun', 'desc')
                    ->orderBy('periode_bulan', 'desc'),
            ])
            ->first();

        PortalCekNikLog::create([
            'nik'        => $nik,
            'ip_address' => $request->ip(),
            'ditemukan'  => $warga !== null,
        ]);

        return view('portal.hasil', compact('warga', 'nik'));
    }
}