<?php

namespace App\Http\Controllers\Kelurahan;

use App\Http\Controllers\Controller;
use App\Models\DistribusiKelurahan;
use App\Models\AnggaranKelurahan;
use Illuminate\Http\Request;

class DanaController extends Controller
{
    public function index(Request $request)
    {
        $kelurahanId = auth()->id();
        $tahun       = $request->input('tahun', now()->year);

        $distribusi = DistribusiKelurahan::where('kelurahan_id', $kelurahanId)
            ->orderBy('tanggal_distribusi', 'desc')
            ->get();

        $anggaran = AnggaranKelurahan::where('kelurahan_id', $kelurahanId)
            ->where('tahun', $tahun)
            ->first();

        $totalDana = DistribusiKelurahan::where('kelurahan_id', $kelurahanId)
            ->where('status', '!=', 'dibatalkan')
            ->sum('jumlah');

        $totalTransaksi = DistribusiKelurahan::where('kelurahan_id', $kelurahanId)
            ->where('status', '!=', 'dibatalkan')
            ->count();

        return view('kelurahan.dana.index', compact(
            'distribusi', 'anggaran', 'totalDana', 'totalTransaksi', 'tahun'
        ));
    }
}