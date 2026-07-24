<?php

namespace App\Http\Controllers\Kelurahan;

use App\Http\Controllers\Controller;
use App\Exports\LaporanBansosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Penyaluran;
use Illuminate\Http\Request;

class LaporanController extends Controller
{

    public function exportExcel(Request $request)
{

    $bulan = $request->bulan ?? date('m');

    $tahun = $request->tahun ?? date('Y');


    return Excel::download(
        new LaporanBansosExport($bulan,$tahun),
        'laporan-bansos-'.$bulan.'-'.$tahun.'.xlsx'
    );

}

public function index(Request $request)
{
    $bulan = $request->bulan ?? date('m');
    $tahun = $request->tahun ?? date('Y');

    $laporan = Penyaluran::with([
            'penerima.warga',
            'penerima.jenisBansos'
        ])
        ->whereHas('penerima.warga', function ($q) {
            $q->where('kelurahan_id', auth()->id());
        })
        ->where('periode_bulan', $bulan)
        ->where('periode_tahun', $tahun)
        ->get();

    // jumlah data
    $total = $laporan->count();

    // status
    $tersalur = $laporan->where('status', 'tersalur')->count();
    $proses   = $laporan->where('status', 'proses')->count();
    $gagal    = $laporan->where('status', 'gagal')->count();

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