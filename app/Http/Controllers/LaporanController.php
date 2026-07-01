<?php

namespace App\Http\Controllers;

use App\Models\Penyaluran;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');


        $laporan = Penyaluran::with([
            'penerima.warga',
            'penerima.jenisBansos'
        ])
        ->where('periode_bulan', $bulan)
        ->where('periode_tahun', $tahun)
        ->get();



        // jumlah data
        $total = $laporan->count();


        // status
        $tersalur = $laporan
            ->where('status', 'tersalur')
            ->count();


        $proses = $laporan
            ->where('status', 'proses')
            ->count();


        $gagal = $laporan
            ->where('status', 'gagal')
            ->count();



        // total uang bantuan
        $totalNominal = $laporan->sum('nominal');



        return view('laporan.laporan', compact(
            'laporan',
            'bulan',
            'tahun',
            'total',
            'tersalur',
            'proses',
            'gagal',
            'totalNominal'
        ));
    }
}