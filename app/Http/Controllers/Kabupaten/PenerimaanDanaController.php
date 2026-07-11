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
    $distribusi = DistribusiAnggaran::orderBy('created_at', 'desc')->get();
    $totalDana = $distribusi->sum('jumlah'); // sesuaikan nama kolom
    $totalDistribusi = $distribusi->count();

    // Hitung distribusi bulan ini
    $bulanIni = DistribusiAnggaran::whereNull('kabupaten_id')
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->count();

    return view('kabupaten.penerima.index', compact(
        'distribusi',
        'totalDana',
        'totalDistribusi',
        'bulanIni'
    ));
}

    public function terima($id)
    {
        $data = DistribusiAnggaran::findOrFail($id);

        if ($data->status == "diterima") {
            return back()->with(
                'error',
                'Dana sudah diterima.'
            );
        }

        $data->status = "diterima";
        $data->tanggal_diterima = now();
        $data->save();

        $anggaran = Anggaran::firstOrCreate(
            [
                'kabupaten_id' => $data->kabupaten_id,
                'tahun' => $data->tahun
            ],
            [
                'total_anggaran' => 0,
                'anggaran_terpakai' => 0,
                'sisa_anggaran' => 0
            ]
        );

        $anggaran->total_anggaran += $data->jumlah;
        $anggaran->sisa_anggaran += $data->jumlah;
        $anggaran->save();

        return back()->with(
            'success',
            'Dana berhasil diterima.'
        );
    }
}