<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\DistribusiKecamatan;
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

        // Ambil semua distribusi dana yang ditujukan ke kecamatan yang sedang login
        $distribusi = DistribusiKecamatan::where('kecamatan_id', $kecamatanId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Total dana diterima (hanya yang statusnya terkirim/diterima, bukan yang dibatalkan)
        $totalDana = DistribusiKecamatan::where('kecamatan_id', $kecamatanId)
            ->where('status', '!=', 'dibatalkan')
            ->sum('jumlah');

        // Total jumlah transaksi distribusi
        $totalDistribusi = DistribusiKecamatan::where('kecamatan_id', $kecamatanId)
            ->where('status', '!=', 'dibatalkan')
            ->count();

        // Distribusi bulan ini
        $bulanIni = DistribusiKecamatan::where('kecamatan_id', $kecamatanId)
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