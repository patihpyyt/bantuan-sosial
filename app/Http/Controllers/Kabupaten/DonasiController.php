<?php

namespace App\Http\Controllers\Kabupaten;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DonasiController extends Controller
{
    public function index()
    {
        // 1. KUNCINYA DI SINI: Hanya jumlahkan dana yang statusnya 'tersalurkan' dari Provinsi
        $totalDonasi = \App\Models\Donasi::where('status', 'tersalurkan')->sum('jumlah'); 

        // 2. Hanya hitung jumlah transaksi donasi yang sudah disalurkan
        $totalTransaksi = \App\Models\Donasi::where('status', 'tersalurkan')->count(); 

        // 3. Hanya ambil list data donasi yang sudah sukses disalurkan untuk tabel riwayat
        $donasi = \App\Models\Donasi::where('status', 'tersalurkan')->get(); 

        // Angka dummy untuk distribusi bulanan kabupaten
        $distribusiBulanIni = 0; 

        return view('kabupaten.donasi.index', compact(
            'totalDonasi',
            'totalTransaksi',
            'distribusiBulanIni',
            'donasi'
        ));
    }
}