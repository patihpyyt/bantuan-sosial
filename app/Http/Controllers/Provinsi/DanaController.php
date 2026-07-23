<?php

namespace App\Http\Controllers\Provinsi;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\DistribusiDonasi;
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
    $donasi = Donasi::findOrFail($id);

    $request->validate([
        'kabupaten_id'       => 'required|exists:users,id',
        'jumlah_dana'        => 'required|numeric|min:1',
        'program_id'         => 'required|exists:jenis_bansos,id',
        'tanggal_penyaluran' => 'required|date',
        'keterangan'         => 'nullable|string',
    ]);

    $sudahTersalur = \App\Models\DistribusiDonasi::where('donasi_id', $donasi->id)->sum('jumlah_dana');
    $sisaSaldo = $donasi->jumlah - $sudahTersalur;

    if ($request->jumlah_dana > $sisaSaldo) {
        return back()
            ->withErrors(['jumlah_dana' => 'Jumlah melebihi sisa saldo donasi yang tersedia (Rp ' . number_format($sisaSaldo, 0, ',', '.') . ').'])
            ->withInput();
    }

    \App\Models\DistribusiDonasi::create([
        'donasi_id'          => $donasi->id,
        'kabupaten_id'       => $request->kabupaten_id,
        'program_id'         => $request->program_id,
        'jumlah_dana'        => $request->jumlah_dana,
        'tanggal_penyaluran' => $request->tanggal_penyaluran,
        'keterangan'         => $request->keterangan,
    ]);

    $totalTersalurSekarang = $sudahTersalur + $request->jumlah_dana;
    if ($totalTersalurSekarang >= $donasi->jumlah) {
        $donasi->update(['status' => 'tersalurkan']);
    }

    return redirect()->route('provinsi.donasi.index')->with('success', 'Dana donasi berhasil disalurkan ke Kabupaten tujuan.');
}
}