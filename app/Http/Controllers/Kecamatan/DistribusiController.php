<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\AnggaranKecamatan;
use App\Models\AnggaranKelurahan;
use App\Models\DistribusiKelurahan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistribusiController extends Controller
{
    public function index()
    {
        $kecamatanId = auth()->id();

        $distribusi = DistribusiKelurahan::where('kecamatan_id', $kecamatanId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kecamatan.distribusi.index', compact('distribusi'));
    }

    public function create()
    {
        $kelurahan = User::where('role', 'kelurahan')->get();

        return view('kecamatan.distribusi.create', compact('kelurahan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelurahan_id'       => 'required|exists:users,id',
            'tahun'              => 'required|digits:4',
            'jumlah'             => 'required|numeric|min:1',
            'tanggal_distribusi' => 'required|date',
            'keterangan'         => 'nullable|string|max:255',
            'status'             => 'nullable|in:terkirim,dibatalkan',
        ]);

        $kecamatanId = auth()->id();

        $anggaranKecamatan = AnggaranKecamatan::where('kecamatan_id', $kecamatanId)
            ->where('tahun', $request->tahun)
            ->first();

        if (!$anggaranKecamatan || $anggaranKecamatan->sisa_anggaran < $request->jumlah) {
            return back()
                ->withInput()
                ->with('error', 'Sisa anggaran Kecamatan tidak mencukupi untuk distribusi ini.');
        }

        DB::transaction(function () use ($request, $kecamatanId, $anggaranKecamatan) {

            DistribusiKelurahan::create([
                'kelurahan_id'       => $request->kelurahan_id,
                'kecamatan_id'       => $kecamatanId,
                'tahun'              => $request->tahun,
                'jumlah'             => $request->jumlah,
                'tanggal_distribusi' => $request->tanggal_distribusi,
                'keterangan'         => $request->keterangan,
                'status'             => $request->status ?? 'terkirim',
                'created_by'         => auth()->id(),
            ]);

            $anggaranKelurahan = AnggaranKelurahan::firstOrNew([
                'kelurahan_id' => $request->kelurahan_id,
                'tahun'        => $request->tahun,
            ]);

            if (!$anggaranKelurahan->exists) {
                $anggaranKelurahan->kecamatan_id      = $kecamatanId;
                $anggaranKelurahan->anggaran_terpakai = 0;
                $anggaranKelurahan->total_anggaran    = 0;
                $anggaranKelurahan->sisa_anggaran     = 0;
            }

            $anggaranKelurahan->total_anggaran += $request->jumlah;
            $anggaranKelurahan->sisa_anggaran  += $request->jumlah;
            $anggaranKelurahan->save();

            $anggaranKecamatan->sisa_anggaran -= $request->jumlah;
            $anggaranKecamatan->save();
        });

        return redirect()
            ->route('kecamatan.distribusi.index')
            ->with('success', 'Dana berhasil didistribusikan ke Kelurahan.');
    }
}