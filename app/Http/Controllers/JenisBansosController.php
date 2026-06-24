<?php

namespace App\Http\Controllers;

use App\Models\JenisBansos;
use Illuminate\Http\Request;

class JenisBansosController extends Controller
{
    public function index()
    {
        $jenisBansos = JenisBansos::all();

        return view('jenis_bansos.index', compact('jenisBansos'));
    }


    public function create()
    {
        return view('jenis_bansos.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_bansos' => 'required',
            'deskripsi' => 'nullable',
            'jumlah_bantuan' => 'nullable|numeric'
        ]);


        JenisBansos::create($data);


        return redirect()
            ->route('jenis-bansos.index')
            ->with('success','Jenis bansos berhasil ditambahkan');
    }


    public function show(JenisBansos $jenisBansos)
    {
        return view('jenis_bansos.show', compact('jenisBansos'));
    }


    public function edit(JenisBansos $jenisBansos)
    {
        return view('jenis_bansos.edit', compact('jenisBansos'));
    }


    public function update(Request $request, JenisBansos $jenisBansos)
    {
        $data = $request->validate([
            'nama_bansos' => 'required',
            'deskripsi' => 'nullable',
            'jumlah_bantuan' => 'nullable|numeric'
        ]);


        $jenisBansos->update($data);


        return redirect()
            ->route('jenis-bansos.index')
            ->with('success','Jenis bansos berhasil diperbarui');
    }


    public function destroy(JenisBansos $jenisBansos)
    {
        $jenisBansos->delete();


        return redirect()
            ->route('jenis-bansos.index')
            ->with('success','Jenis bansos berhasil dihapus');
    }
}