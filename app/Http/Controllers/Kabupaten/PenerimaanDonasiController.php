<?php

namespace App\Http\Controllers\Kabupaten;

use App\Http\Controllers\Controller;
use App\Models\DistribusiAnggaran;
use Illuminate\Http\Request;

class PenerimaanDonasiController extends Controller
{
    public function index()
    {
        $donasi = DistribusiAnggaran::where('kabupaten_id', auth()->id())
            ->where('status', 'terkirim') // hanya yang sudah dikirim
            ->latest('tanggal_distribusi')
            ->get();

        return view('kabupaten.penerimaan.index', compact('donasi'));
    }
}