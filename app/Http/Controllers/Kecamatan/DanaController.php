<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\DistribusiAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DanaController extends Controller
{
    public function index(Request $request)
    {
        $kecamatanId = Auth::id();
        $tahun = $request->input('tahun', now()->year);

        $distribusi = DistribusiAnggaran::where('kabupaten_id', $kecamatanId)
            ->orderBy('created_at', 'desc')
            ->get();

    
        $totalDana = DistribusiAnggaran::where('kabupaten_id', $kecamatanId)
            ->where('status', '!=', 'dibatalkan')
            ->sum('jumlah');

      
        $totalDistribusi = DistribusiAnggaran::where('kabupaten_id', $kecamatanId)
            ->where('status', '!=', 'dibatalkan')
            ->count();

        
        $bulanIni = DistribusiAnggaran::where('kabupaten_id', $kecamatanId)
            ->where('status', '!=', 'dibatalkan')
            ->whereMonth('tanggal_distribusi', Carbon::now()->month)
            ->whereYear('tanggal_distribusi', Carbon::now()->year)
            ->count();

        return view('kecamatan.dana.index', compact(
            'distribusi',
            'totalDana',
            'totalDistribusi',
            'bulanIni',
            'tahun'
        ));
    }
}