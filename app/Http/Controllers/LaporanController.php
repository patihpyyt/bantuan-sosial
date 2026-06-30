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



        $total = $laporan->count();


        $tersalur = $laporan
            ->where('status','tersalur')
            ->count();


        $proses = $laporan
            ->where('status','proses')
            ->count();


        $gagal = $laporan
            ->where('status','gagal')
            ->count();



       return view('laporan.laporan', compact(
    'laporan',
    'bulan',
    'tahun',
    'total',
    'tersalur',
    'proses',
    'gagal'
));
    }
}