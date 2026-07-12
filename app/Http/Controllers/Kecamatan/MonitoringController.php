<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\AnggaranKelurahan;
use App\Models\DistribusiKelurahan;
use App\Models\User;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $kecamatanId = auth()->id();
        $tahun       = $request->input('tahun', now()->year);

        $kelurahanList = User::where('role', 'kelurahan')->get();

        $monitoring = $kelurahanList->map(function ($kelurahan) use ($tahun) {

            $anggaran = AnggaranKelurahan::where('kelurahan_id', $kelurahan->id)
                ->where('tahun', $tahun)
                ->first();

            $totalDistribusi = DistribusiKelurahan::where('kelurahan_id', $kelurahan->id)
                ->where('tahun', $tahun)
                ->sum('jumlah');

            return (object) [
                'id'                => $kelurahan->id,
                'nama_lengkap'      => $kelurahan->nama_lengkap,
                'total_anggaran'    => $anggaran->total_anggaran ?? 0,
                'anggaran_terpakai' => $anggaran->anggaran_terpakai ?? 0,
                'sisa_anggaran'     => $anggaran->sisa_anggaran ?? 0,
                'total_distribusi'  => $totalDistribusi,
            ];
        });

        $totalKelurahan = $kelurahanList->count();
        $totalDana      = $monitoring->sum('total_anggaran');
        $totalTerpakai  = $monitoring->sum('anggaran_terpakai');
        $totalSisa      = $monitoring->sum('sisa_anggaran');

        return view('kecamatan.monitoring.index', [
            'monitoring'     => $monitoring,
            'totalKelurahan' => $totalKelurahan,
            'totalDana'      => $totalDana,
            'totalTerpakai'  => $totalTerpakai,
            'totalSisa'      => $totalSisa,
            'tahun'          => $tahun,
        ]);
    }
}