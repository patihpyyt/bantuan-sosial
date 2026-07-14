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
        $donasi = Donasi::findOrFail($id);

        if ($donasi->status !== 'terverifikasi') {
            return redirect()
                ->route('provinsi.donasi.index')
                ->with('error', 'Donasi ini belum terverifikasi.');
        }

        $validated = $request->validate([
            'kabupaten_id'       => 'required|exists:users,id',
            'program_id'         => 'required',
            'jumlah_dana'        => 'required|numeric|min:1|max:' . $donasi->jumlah,
            'tanggal_penyaluran' => 'required|date',
            'keterangan'         => 'nullable|string|max:1000',
        ]);

        return redirect()
            ->route('provinsi.donasi.index')
            ->with('success', 'Dana berhasil disalurkan ke kabupaten/kota tujuan.');
    }
}