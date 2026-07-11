<?php

namespace App\Http\Controllers\Provinsi;

use App\Http\Controllers\Controller;   // <-- TAMBAHKAN BARIS INI
use App\Models\User;
use App\Models\Warga;
use App\Models\Anggaran;
use App\Models\JenisBansos;
use App\Models\PenerimaBansos;
use App\Models\Penyaluran;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $grafikPenyaluran = Penyaluran::select(
                DB::raw('MONTH(tanggal_salur) as bulan'),
                DB::raw('SUM(nominal) as total')
            )
            ->whereYear('tanggal_salur', now()->year)
            ->groupBy(DB::raw('MONTH(tanggal_salur)'))
            ->orderBy(DB::raw('MONTH(tanggal_salur)'))
            ->get();

        $distribusiKabupaten = Penyaluran::join(
                'penerima_bansos',
                'penyaluran.penerima_id',
                '=',
                'penerima_bansos.id'
            )
            ->join(
                'warga',
                'penerima_bansos.warga_id',
                '=',
                'warga.id'
            )
            ->selectRaw("
                warga.kabupaten,
                SUM(penyaluran.nominal) as total_dana,
                COUNT(penyaluran.id) as jumlah_penyaluran
            ")
            ->groupBy('warga.kabupaten')
            ->orderByDesc('total_dana')
            ->get();

      return view('provinsi.dashboard-provinsi', [
            'totalKabupaten' => User::where('role', 'kabupaten')->count(),
            'totalKecamatan' => User::where('role', 'kecamatan')->count(),
            'totalKelurahan' => User::where('role', 'kelurahan')->count(),

            'totalWarga'     => Warga::count(),
            'totalPenerima'  => PenerimaBansos::count(),
            'totalProgram'   => JenisBansos::count(),
            'totalAnggaran'  => Anggaran::sum('total_anggaran'),
            'totalTerpakai'  => Anggaran::sum('anggaran_terpakai'),
            'totalSisa'      => Anggaran::sum('sisa_anggaran'),

            'totalDana'      => Penyaluran::sum('nominal'),

            'grafikPenyaluran'    => $grafikPenyaluran,
            'distribusiKabupaten' => $distribusiKabupaten,
        ]);
    }
}