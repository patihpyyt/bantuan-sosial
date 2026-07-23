<?php

namespace App\Http\Controllers\Provinsi;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\User;
use Illuminate\Http\Request;

class DanaController extends Controller
{
  
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
 
    $donasi = \App\Models\Donasi::findOrFail($id);

    $request->validate([
        'kabupaten_id' => 'required',
    ]);


    $donasi->update([
        'status' => 'tersalurkan',
        'kabupaten_id' => $request->kabupaten_id
    ]);

   
    return redirect()->route('provinsi.donasi.index')->with('success', 'Dana donasi berhasil disalurkan ke Kabupaten tujuan.');
}
}