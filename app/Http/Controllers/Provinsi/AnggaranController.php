<?php

namespace App\Http\Controllers\Provinsi;

use App\Http\Controllers\Controller;
use App\Models\Anggaran;
use Illuminate\Http\Request;
use App\Models\User;

class AnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    $anggaran = Anggaran::with('kabupaten')->latest()->get();
    return view('provinsi.anggaran.index', compact('anggaran'));
}

public function create()
{
    $kabupaten = User::where('role', 'kabupaten')->get();
    return view('provinsi.anggaran.create', compact('kabupaten'));
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{

    $request->validate([

        'kabupaten_id'=>'required|exists:users,id',

        'tahun'=>'required',

        'total_anggaran'=>'required|numeric|min:1'

    ]);

    if(
        Anggaran::where('kabupaten_id',$request->kabupaten_id)
        ->where('tahun',$request->tahun)
        ->exists()
    ){

        return back()->withErrors([
            'tahun'=>'Kabupaten ini sudah memiliki anggaran pada tahun tersebut.'
        ]);

    }

    Anggaran::create([

        'kabupaten_id'=>$request->kabupaten_id,

        'tahun'=>$request->tahun,

        'total_anggaran'=>$request->total_anggaran,

        'anggaran_terpakai'=>0,

        'sisa_anggaran'=>$request->total_anggaran

    ]);

    return redirect()->route('anggaran.index')
    ->with('success','Anggaran berhasil ditambahkan');

}

    /**
     * Display the specified resource.
     */
    public function show(Anggaran $anggaran)
{
    return view('provinsi.anggaran.show', compact('anggaran'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anggaran $anggaran)
{

    $kabupaten=User::where('role','kabupaten')->get();

    return view('anggaran.edit',compact(
        'anggaran',
        'kabupaten'
    ));

}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request,Anggaran $anggaran)
{

    $request->validate([

        'kabupaten_id'=>'required',

        'tahun'=>'required',

        'total_anggaran'=>'required|numeric|min:1'

    ]);

    $terpakai=$anggaran->anggaran_terpakai;

    $anggaran->update([

        'kabupaten_id'=>$request->kabupaten_id,

        'tahun'=>$request->tahun,

        'total_anggaran'=>$request->total_anggaran,

        'sisa_anggaran'=>$request->total_anggaran-$terpakai

    ]);

    return redirect()->route('anggaran.index')
    ->with('success','Data berhasil diubah');

}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggaran $anggaran)
{

    $anggaran->delete();

    return redirect()->route('anggaran.index')
    ->with('success','Data berhasil dihapus');

}


}
