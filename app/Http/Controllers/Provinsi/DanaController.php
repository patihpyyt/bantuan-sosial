<?php

namespace App\Http\Controllers\Provinsi;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\User;
use Illuminate\Http\Request;

class DanaController extends Controller
{
    /**
     * Tampilkan form salurkan dana untuk 1 donasi terverifikasi.
     * GET /provinsi/donasi/{id}/salurkan
     */
    public function create($id)
    {
        $donasi = Donasi::findOrFail($id);

        if ($donasi->status !== 'terverifikasi') {
            return redirect()
                ->route('provinsi.donasi.index')
                ->with('error', 'Donasi ini belum terverifikasi.');
        }

        
        $kabupatenList = User::where('role', 'kabupaten')
            ->orderBy('nama_lengkap')
            ->get();

        $programList = \App\Models\JenisBansos::orderBy('id')->get();

        return view('provinsi.donasi.create', compact('donasi', 'kabupatenList', 'programList'));
    }

  
   public function store(Request $request, $id)
{
    // 1. Cari data donasi yang mau disalurkan berdasarkan ID
    $donasi = \App\Models\Donasi::findOrFail($id);

    // 2. Validasi input dari form salurkan (pastikan admin memilih kabupaten tujuan)
    $request->validate([
        'kabupaten_id' => 'required', // Nama input form disesuaikan dengan select box milikmu
    ]);

    // 3. Ganti status donasi menjadi 'tersalurkan' dan catat kabupaten tujuannya
    $donasi->update([
        'status' => 'tersalurkan',
        'kabupaten_id' => $request->kabupaten_id
    ]);

    // 4. Redirect kembali ke halaman kelola donasi dengan pesan sukses
    return redirect()->route('provinsi.donasi.index')->with('success', 'Dana donasi berhasil disalurkan ke Kabupaten tujuan.');
}
}