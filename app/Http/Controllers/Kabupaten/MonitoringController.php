<?php

namespace App\Http\Controllers\Kabupaten;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AnggaranKecamatan;
use App\Models\DistribusiKecamatan;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    /**
     * Monitoring ringkasan & tabel status anggaran seluruh Kecamatan.
     */
    public function index(Request $request)
    {
        $kabupatenId = auth()->id();
        $tahun       = $request->input('tahun', now()->year);

        $kecamatanList = User::where('role', 'kecamatan')->get();

        // Gabungkan data kecamatan dengan data anggarannya (jadi object, bukan array,
        // supaya bisa dipanggil pakai -> di view)
        $monitoring = $kecamatanList->map(function ($kecamatan) use ($tahun) {

            $anggaran = AnggaranKecamatan::where('kecamatan_id', $kecamatan->id)
                ->where('tahun', $tahun)
                ->first();

            return (object) [
                'id'                => $kecamatan->id,
                'nama_lengkap'      => $kecamatan->name,
                'total_anggaran'    => $anggaran->total_anggaran ?? 0,
                'anggaran_terpakai' => $anggaran->anggaran_terpakai ?? 0,
                'sisa_anggaran'     => $anggaran->sisa_anggaran ?? 0,
            ];
        });

        // Ringkasan atas
        $totalKecamatan = $kecamatanList->count();
        $totalDana      = $monitoring->sum('total_anggaran');
        $totalTerpakai  = $monitoring->sum('anggaran_terpakai');
        $totalSisa      = $monitoring->sum('sisa_anggaran');

        // Data buat grafik (chart.js)
        $chartLabel = $monitoring->pluck('nama_lengkap');
        $chartData  = $monitoring->pluck('total_anggaran');

        return view('kabupaten.monitoring.index', [
            'monitoring'     => $monitoring,
            'totalKecamatan' => $totalKecamatan,
            'totalDana'      => $totalDana,
            'totalTerpakai'  => $totalTerpakai,
            'totalSisa'      => $totalSisa,
            'chartLabel'     => $chartLabel,
            'chartData'      => $chartData,
            'tahun'          => $tahun,
        ]);
    }

    /**
     * Detail monitoring untuk satu Kecamatan tertentu.
     */
    public function show($id, Request $request)
    {
        $tahun     = $request->input('tahun', now()->year);
        $kecamatan = User::where('role', 'kecamatan')->findOrFail($id);

        $anggaran = AnggaranKecamatan::where('kecamatan_id', $id)
            ->where('tahun', $tahun)
            ->first();

        $riwayat = DistribusiKecamatan::where('kecamatan_id', $id)
            ->where('kabupaten_id', auth()->id())
            ->where('tahun', $tahun)
            ->orderByDesc('tanggal_distribusi')
            ->get();

        return view('kabupaten.monitoring.show', compact(
            'kecamatan', 'anggaran', 'riwayat', 'tahun'
        ));
    }
}