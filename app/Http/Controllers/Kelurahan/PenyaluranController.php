<?php

namespace App\Http\Controllers\Kelurahan;

use App\Http\Controllers\Controller;
use App\Models\Penyaluran;
use App\Models\PenerimaBansos;
use Illuminate\Http\Request;

class PenyaluranController extends Controller
{
    // PenyaluranController@index
public function index()
{
    $penyaluran = Penyaluran::with('penerima.warga')
        ->whereHas('penerima.warga', function ($q) {
            $q->where('kelurahan_id', auth()->id());
        })
        ->latest('tanggal_salur')
        ->get();

    return view('penyaluran.index', compact('penyaluran'));
}

  public function create()
{
    $penerima = PenerimaBansos::with('warga')
        ->whereHas('warga', function ($q) {
            $q->where('kelurahan_id', auth()->id());
        })
        ->get();

    return view('penyaluran.create', compact('penerima'));
}

public function store(Request $request)
{
    $request->validate([
        'penerima_id'   => 'required|exists:penerima_bansos,id',
        'nominal'       => 'required|numeric|min:1',
        'tanggal_salur' => 'required|date',
        'status'        => 'required|in:tersalur,tertunda,gagal',
        'metode'        => 'nullable|string',
        'no_referensi'  => 'nullable|string|max:100',
        'catatan'       => 'nullable|string|max:255',
    ]);

    $tanggalSalur = \Carbon\Carbon::parse($request->tanggal_salur);

    Penyaluran::create([
        'penerima_id'   => $request->penerima_id,
        'periode_bulan' => $tanggalSalur->month,
        'periode_tahun' => $tanggalSalur->year,
        'nominal'       => $request->nominal,
        'tanggal_salur' => $request->tanggal_salur,
        'status'        => $request->status,
        'metode'        => $request->metode,
        'no_referensi'  => $request->no_referensi,
        'catatan'       => $request->catatan,
    ]);

    return redirect()
        ->route('penyaluran.index')
        ->with('success', 'Data penyaluran berhasil ditambahkan.');
}

public function update(Request $request, $id)
{
    $penyaluran = Penyaluran::findOrFail($id);

    $request->validate([
        'penerima_id'   => 'required|exists:penerima_bansos,id',
        'nominal'       => 'required|numeric|min:1',
        'tanggal_salur' => 'required|date',
        'status'        => 'required|in:tersalur,tertunda,gagal',
        'metode'        => 'nullable|string',
        'no_referensi'  => 'nullable|string|max:100',
        'catatan'       => 'nullable|string|max:255',
    ]);

    $tanggalSalur = \Carbon\Carbon::parse($request->tanggal_salur);

    $penyaluran->update([
        'penerima_id'   => $request->penerima_id,
        'periode_bulan' => $tanggalSalur->month,
        'periode_tahun' => $tanggalSalur->year,
        'nominal'       => $request->nominal,
        'tanggal_salur' => $request->tanggal_salur,
        'status'        => $request->status,
        'metode'        => $request->metode,
        'no_referensi'  => $request->no_referensi,
        'catatan'       => $request->catatan,
    ]);

    return redirect()
        ->route('penyaluran.index')
        ->with('success', 'Data penyaluran berhasil diubah.');
} 



    public function edit($id)
    {
        $penyaluran = Penyaluran::findOrFail($id);
        $penerima   = PenerimaBansos::with('warga')->get();

        return view('penyaluran.edit', compact('penyaluran', 'penerima'));
    }

   

    public function destroy($id)
    {
        $penyaluran = Penyaluran::findOrFail($id);
        $penyaluran->delete();

        return redirect()
            ->route('penyaluran.index')
            ->with('success', 'Data penyaluran berhasil dihapus.');
    }
}