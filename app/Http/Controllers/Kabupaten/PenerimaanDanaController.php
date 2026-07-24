<?php

namespace App\Http\Controllers\Kabupaten;

use App\Http\Controllers\Controller;
use App\Models\DistribusiAnggaran;
use App\Models\Anggaran;
 use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenerimaanDanaController extends Controller
{
 public function index()
{
    $kabupatenId = auth()->id();

    $distribusi = DistribusiAnggaran::where('kabupaten_id', $kabupatenId)
        ->orderBy('created_at', 'desc')
        ->get();

    $totalDana = $distribusi->sum('jumlah');
    $totalDistribusi = $distribusi->count();

    $bulanIni = DistribusiAnggaran::where('kabupaten_id', $kabupatenId)
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->count();

    // ===== TAMBAHAN: ringkasan sudah/belum didistribusikan =====
    $anggaran = Anggaran::where('kabupaten_id', $kabupatenId)
        ->where('tahun', now()->year)
        ->first();

    $sudahDidistribusikan = $anggaran->anggaran_terpakai ?? 0;
    $sisaBelumDidistribusikan = $anggaran->sisa_anggaran ?? 0;
    // ===== SELESAI TAMBAHAN =====

    return view('kabupaten.penerima.index', compact(
        'distribusi',
        'totalDana',
        'totalDistribusi',
        'bulanIni',
        'sudahDidistribusikan',
        'sisaBelumDidistribusikan'
    ));
}  

}