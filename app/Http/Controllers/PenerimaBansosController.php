<?php

namespace App\Http\Controllers;

use App\Models\PenerimaBansos;
use App\Models\Warga;
use App\Models\JenisBansos;
use Illuminate\Http\Request;

class PenerimaBansosController extends Controller
{
    /**
     * Menampilkan semua penerima bansos
     */
    public function index()
    {
        $penerima = PenerimaBansos::with([
            'warga',
            'jenisBansos'
        ])->get();

        return view('penerima_bansos.index', compact('penerima'));
    }


    /**
     * Form tambah penerima
     */
    public function create()
    {
        $warga = Warga::all();

        $jenisBansos = JenisBansos::all();

        return view('penerima_bansos.create', compact(
            'warga',
            'jenisBansos'
        ));
    }


    /**
     * Simpan penerima baru
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'warga_id' => 'required',
            'jenis_bansos_id' => 'required',
            'tanggal_menerima' => 'nullable|date',
            'status' => 'required',
            'keterangan' => 'nullable'
        ]);


        PenerimaBansos::create($data);


        return redirect()
            ->route('penerima-bansos.index')
            ->with('success','Data penerima bansos berhasil ditambahkan');
    }


    /**
     * Detail penerima
     */
    public function show(PenerimaBansos $penerimaBansos)
    {
        return view(
            'penerima_bansos.show',
            compact('penerimaBansos')
        );
    }


    /**
     * Form edit
     */
    public function edit(PenerimaBansos $penerimaBansos)
    {
        $warga = Warga::all();

        $jenisBansos = JenisBansos::all();

        return view(
            'penerima_bansos.edit',
            compact(
                'penerimaBansos',
                'warga',
                'jenisBansos'
            )
        );
    }


    /**
     * Update data
     */
    public function update(
        Request $request,
        PenerimaBansos $penerimaBansos
    )
    {
        $data = $request->validate([
            'warga_id' => 'required',
            'jenis_bansos_id' => 'required',
            'tanggal_menerima' => 'nullable|date',
            'status' => 'required',
            'keterangan' => 'nullable'
        ]);


        $penerimaBansos->update($data);


        return redirect()
            ->route('penerima-bansos.index')
            ->with('success','Data berhasil diperbarui');
    }


    /**
     * Hapus data
     */
    public function destroy(PenerimaBansos $penerimaBansos)
    {
        $penerimaBansos->delete();


        return redirect()
            ->route('penerima-bansos.index')
            ->with('success','Data berhasil dihapus');
    }
}