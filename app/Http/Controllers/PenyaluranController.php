<?php

namespace App\Http\Controllers;

use App\Models\Penyaluran;
use App\Models\PenerimaBansos;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PenyaluranController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $penyaluran = Penyaluran::with(['penerima.warga', 'penerima.jenisBansos'])
            ->periode($bulan, $tahun)
            ->paginate(20);

        return view('penyaluran.penyaluran', compact('penyaluran', 'bulan', 'tahun'));
    }

    public function create()
    {
        $penerima = PenerimaBansos::with(['warga', 'jenisBansos'])->get();

        return view('penyaluran.create-penyaluran', compact('penerima'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'penerima_id'   => 'required|exists:penerima_bansos,id',
        'periode_bulan' => [
            'required', 'integer', 'min:1', 'max:12',
            Rule::unique('penyaluran')->where(function ($query) use ($request) {
                return $query->where('penerima_id', $request->penerima_id)
                              ->where('periode_tahun', $request->periode_tahun);
            }),
        ],
        'periode_tahun' => 'required|integer|min:2000',
        'nominal'       => 'nullable|numeric',
        'status'        => ['required', Rule::in(['belum', 'proses', 'tersalur', 'gagal'])],
    ], [
        'periode_bulan.unique' => 'Penerima ini sudah memiliki data penyaluran untuk periode bulan/tahun tersebut.',
    ]);

    Penyaluran::create($validated);

    return redirect()->route('penyaluran.index')->with('success', 'Data penyaluran berhasil ditambahkan.');
}

    public function edit(int $id)
    {
        $penyaluran = Penyaluran::with(['penerima.warga', 'penerima.jenisBansos'])->findOrFail($id);
        return view('penyaluran.edit-penyaluran', compact('penyaluran'));
    }

    public function update(Request $request, int $id)
    {
        $penyaluran = Penyaluran::findOrFail($id);

        $validated = $request->validate([
            'status'        => ['required', Rule::in(['belum', 'proses', 'tersalur', 'gagal'])],
            'tanggal_salur' => 'nullable|date',
            'metode'        => ['nullable', Rule::in(['transfer_bank', 'tunai', 'kantor_pos'])],
            'no_referensi'  => 'nullable|string|max:50',
            'catatan'       => 'nullable|string|max:500',
        ]);

        $penyaluran->update($validated + ['diupdate_oleh' => auth()->id()]);

        return redirect()->route('penyaluran.index')->with('success', 'Status berhasil diperbarui.');
    }
}