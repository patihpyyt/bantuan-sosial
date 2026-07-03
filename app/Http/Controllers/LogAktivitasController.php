<?php

namespace App\Http\Controllers;

use App\Models\JenisBansos;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index()
    {
        $jenisBansos = JenisBansos::all();
        return view('jenis-bansos.jenis', compact('jenisBansos'));
    }

    public function create()
    {
        return view('jenis-bansos.create-jenis');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_bansos' => 'required',
            'deskripsi' => 'nullable',
            'jumlah_bantuan' => 'nullable|numeric'
        ]);

        JenisBansos::create($data);

        return redirect('/jenis-bansos')->with('success', 'Jenis bansos berhasil ditambahkan');
    }

    public function show($id)
    {
        $jenisBansos = JenisBansos::findOrFail($id);
        return view('jenis-bansos.jenis', compact('jenisBansos'));
    }

    public function edit($id)
    {
        $jenisBansos = JenisBansos::findOrFail($id);
        return view('jenis-bansos.jenis-edit', compact('jenisBansos'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama_bansos' => 'required',
            'deskripsi' => 'nullable',
            'jumlah_bantuan' => 'nullable|numeric'
        ]);

        $jenisBansos = JenisBansos::findOrFail($id);
        $jenisBansos->update($data);

        return redirect('/jenis-bansos')->with('success', 'Jenis bansos berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jenisBansos = JenisBansos::findOrFail($id);
        $jenisBansos->delete();

        return redirect('/jenis-bansos')->with('success', 'Jenis bansos berhasil dihapus');
    }
}