<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;

class WargaController extends Controller
{

    public function index()
    {
        $warga = Warga::all();

        return view('warga.index', compact('warga'));
    }


    public function create()
    {
        return view('warga.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'nik'=>'required|unique:warga',
            'no_kk'=>'required',
            'nama_lengkap'=>'required',
            'jenis_kelamin'=>'required',
            'alamat'=>'required',
            'rt'=>'required|string|max:5',
            'rw'=>'required|string|max:5',
        ]);


        Warga::create($data);


        return redirect()
            ->route('warga.index')
            ->with('success','Data warga berhasil ditambahkan');
    }


    public function show(Warga $warga)
    {
        return view('warga.show', compact('warga'));
    }


    public function edit(Warga $warga)
    {
        return view('warga.edit', compact('warga'));
    }


    public function update(Request $request,Warga $warga)
    {
        $data=$request->validate([
            'nik'=>'required',
            'no_kk'=>'required',
            'nama_lengkap'=>'required',
            'jenis_kelamin'=>'required',
            'alamat'=>'required',
            'rt'=>'required|string|max:5',
            'rw'=>'required|string|max:5',
        ]);


        $warga->update($data);


        return redirect()
        ->route('warga.index');
    }


    public function destroy(Warga $warga)
    {
        $warga->delete();

        return redirect()
        ->route('warga.index');
    }
}