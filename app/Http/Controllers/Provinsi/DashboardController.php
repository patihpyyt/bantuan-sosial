<?php

namespace App\Http\Controllers\Provinsi;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Warga;
use App\Models\Anggaran;
use App\Models\JenisBansos;
use App\Models\PenerimaBansos;
use App\Models\Penyaluran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);

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

        // Sumber kebenaran tunggal: tabel `anggaran` (alokasi per Kabupaten/Kota, tahun berjalan)
        $totalAnggaranNilai = Anggaran::where('tahun', $tahun)->sum('total_anggaran');
        $totalTerpakaiNilai = Anggaran::where('tahun', $tahun)->sum('anggaran_terpakai');
        $totalSisaNilai     = $totalAnggaranNilai - $totalTerpakaiNilai;

        return view('provinsi.dashboard-provinsi', [
            'totalKabupaten' => User::where('role', 'kabupaten')->count(),
            'totalKecamatan' => User::where('role', 'kecamatan')->count(),
            'totalKelurahan' => User::where('role', 'kelurahan')->count(),

            'totalWarga'     => Warga::count(),
            'totalPenerima'  => PenerimaBansos::count(),
            'totalProgram'   => JenisBansos::count(),

            'totalAnggaran'  => $totalAnggaranNilai,
            'totalTerpakai'  => $totalTerpakaiNilai,
            'totalSisa'      => $totalSisaNilai,

            'totalDana'      => Penyaluran::sum('nominal'),

            'grafikPenyaluran'    => $grafikPenyaluran,
            'distribusiKabupaten' => $distribusiKabupaten,

            'tahun' => $tahun,
        ]);
    }
}