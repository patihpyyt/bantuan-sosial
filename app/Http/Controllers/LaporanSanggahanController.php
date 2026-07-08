<?php

namespace App\Http\Controllers;

use App\Models\LaporanSanggahan;
use Illuminate\Http\Request;

class LaporanSanggahanController extends Controller
{
    public function index()
    {
        $laporan = LaporanSanggahan::with([
            'pelapor',
            'warga'
        ])
        ->latest()
        ->get();

        return view('laporan-sanggahan.index', compact('laporan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required|exists:warga,id',
            'alasan' => 'required|min:10',
            'bukti' => 'nullable|image|max:2048'
        ]);

        $path = null;

        if ($request->hasFile('bukti')) {
            $path = $request->file('bukti')->store('sanggahan', 'public');
        }

        LaporanSanggahan::create([
            'pelapor_id' => auth()->id(),
            'warga_id' => $request->warga_id,
            'alasan' => $request->alasan,
            'bukti' => $path,
            'status' => 'menunggu'
        ]);

        return back()->with('success', 'Laporan berhasil dikirim.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'catatan_petugas' => 'nullable'
        ]);

        $laporan = LaporanSanggahan::findOrFail($id);

        $laporan->update([
            'status' => $request->status,
            'catatan_petugas' => $request->catatan_petugas,
            'ditangani_oleh' => auth()->id()
        ]);

        return back()->with('success', 'Status berhasil diperbarui.');
    }
}