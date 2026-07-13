<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\AnggaranKecamatan;
use App\Models\DistribusiAnggaran;
use App\Models\DistribusiKelurahan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $kecamatanId = auth()->id();
        $tahun       = $request->input('tahun', now()->year);

        $anggaran = AnggaranKecamatan::where('kecamatan_id', $kecamatanId)
            ->where('tahun', $tahun)
            ->first();

        $totalAnggaran = $anggaran->total_anggaran ?? 0;
        $totalTerpakai = $anggaran->anggaran_terpakai ?? 0;
        $totalSisa     = $anggaran->sisa_anggaran ?? 0;

        $totalKelurahan = User::where('role', 'kelurahan')->count();

        // Dana yang DITERIMA kecamatan ini dari Kabupaten
        // (disimpan Kabupaten di kolom kabupaten_id = ID kecamatan penerima)
        $riwayatDiterima = DistribusiAnggaran::where('kabupaten_id', $kecamatanId)
            ->where('tahun', $tahun)
            ->where('status', 'terkirim')
            ->orderByDesc('tanggal_distribusi')
            ->get();

        $totalDanaDiterima = $riwayatDiterima->sum('jumlah');
        $totalTransaksiDiterima = $riwayatDiterima->count();
        $transaksiBulanIni = $riwayatDiterima
            ->where('tanggal_distribusi', '>=', now()->startOfMonth())
            ->count();

        // Dana yang DIKELUARKAN kecamatan ini ke Kelurahan
        $totalDistribusi = DistribusiKelurahan::where('kecamatan_id', $kecamatanId)
            ->where('tahun', $tahun)
            ->sum('jumlah');

        $distribusiKelurahan = DistribusiKelurahan::select(
                'kelurahan_id',
                DB::raw('count(*) as jumlah_penyaluran'),
                DB::raw('sum(jumlah) as total_dana')
            )
            ->where('kecamatan_id', $kecamatanId)
            ->where('tahun', $tahun)
            ->groupBy('kelurahan_id')
            ->with('kelurahan:id,nama_lengkap')
            ->get()
            ->map(function ($item) {
                return (object) [
                    'kelurahan'         => $item->kelurahan->nama_lengkap ?? '-',
                    'jumlah_penyaluran' => $item->jumlah_penyaluran,
                    'total_dana'        => $item->total_dana,
                ];
            });

        return view('kecamatan.dashboard-kecamatan', [
            'totalAnggaran'          => $totalAnggaran,
            'totalTerpakai'          => $totalTerpakai,
            'totalSisa'              => $totalSisa,
            'totalKelurahan'         => $totalKelurahan,
            'totalDistribusi'        => $totalDistribusi,
            'distribusiKelurahan'    => $distribusiKelurahan,
            'riwayatDiterima'        => $riwayatDiterima,
            'totalDanaDiterima'      => $totalDanaDiterima,
            'totalTransaksiDiterima' => $totalTransaksiDiterima,
            'transaksiBulanIni'      => $transaksiBulanIni,
            'tahun'                  => $tahun,
        ]);
    }
}