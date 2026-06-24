<?php

namespace App\Http\Controllers;

use App\Models\Penyaluran;
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

        return view('penyaluran.index', compact('penyaluran', 'bulan', 'tahun'));
    }

    public function edit(int $id)
    {
        $penyaluran = Penyaluran::with(['penerima.warga', 'penerima.jenisBansos'])->findOrFail($id);
        return view('penyaluran.edit', compact('penyaluran'));
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