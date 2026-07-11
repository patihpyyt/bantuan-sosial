<?php

namespace App\Http\Controllers\Kabupaten;

use App\Http\Controllers\Controller;
use App\Models\Anggaran;
use App\Models\DistribusiAnggaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard utama Kabupaten/Kota — ringkasan dana yang diterima dari Provinsi.
     */
    public function index(Request $request)
    {
        $kabupatenId = auth()->id();
        $tahun       = $request->input('tahun', now()->year);

        // Ringkasan anggaran tahun berjalan
        $anggaran = Anggaran::where('kabupaten_id', $kabupatenId)
            ->where('tahun', $tahun)
            ->first();

        // Riwayat dana masuk dari Provinsi
        $distribusi = DistribusiAnggaran::where('kabupaten_id', $kabupatenId)
            ->where('tahun', $tahun)
            ->orderByDesc('tanggal_distribusi')
            ->get();

        // Daftar tahun yang punya data, buat dropdown filter
        $tahunTersedia = DistribusiAnggaran::where('kabupaten_id', $kabupatenId)
            ->select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        // Total dana yang pernah diterima (semua tahun, status terkirim saja)
        $totalDiterimaKeseluruhan = DistribusiAnggaran::where('kabupaten_id', $kabupatenId)
            ->where('status', 'terkirim')
            ->sum('jumlah');

        return view('kabupaten.dashboard-kabupaten', [
            'anggaran'                 => $anggaran,
            'distribusi'                => $distribusi,
            'tahun'                     => $tahun,
            'tahunTersedia'             => $tahunTersedia,
            'totalDiterimaKeseluruhan'  => $totalDiterimaKeseluruhan,
        ]);
    }

    /**
     * Detail satu transaksi dana masuk (opsional, kalau butuh detail per-transaksi).
     */
    public function show($id)
    {
        $distribusi = DistribusiAnggaran::where('kabupaten_id', auth()->id())
            ->findOrFail($id);

        return view('kabupaten.distribusi-detail', compact('distribusi'));
    }
}