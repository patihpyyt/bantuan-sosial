<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\User;
use Illuminate\Http\Request;

class AnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggaran = Anggaran::with('kabupaten')
            ->latest()
            ->get();

        return view('anggaran.index', compact('anggaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kabupaten = User::where('role', 'kabupaten')->get();

        return view('anggaran.create', compact('kabupaten'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kabupaten_id'    => 'required|exists:users,id',
            'tahun'           => 'required|digits:4',
            'total_anggaran'  => 'required|numeric|min:1',
        ]);

        $cek = Anggaran::where('kabupaten_id', $request->kabupaten_id)
            ->where('tahun', $request->tahun)
            ->exists();

        if ($cek) {
            return back()
                ->withInput()
                ->withErrors([
                    'tahun' => 'Kabupaten ini sudah memiliki anggaran pada tahun tersebut.'
                ]);
        }

        Anggaran::create([
            'kabupaten_id'      => $request->kabupaten_id,
            'tahun'             => $request->tahun,
            'total_anggaran'    => $request->total_anggaran,
            'anggaran_terpakai' => 0,
            'sisa_anggaran'     => $request->total_anggaran,
        ]);

        return redirect()
            ->route('anggaran.index')
            ->with('success', 'Anggaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $anggaran = Anggaran::with('kabupaten')->findOrFail($id);

        return view('anggaran.show', compact('anggaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $anggaran = Anggaran::findOrFail($id);

        $kabupaten = User::where('role', 'kabupaten')->get();

        return view('anggaran.edit', compact(
            'anggaran',
            'kabupaten'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $anggaran = Anggaran::findOrFail($id);

        $request->validate([
            'kabupaten_id'    => 'required|exists:users,id',
            'tahun'           => 'required|digits:4',
            'total_anggaran'  => 'required|numeric|min:1',
        ]);

        $cek = Anggaran::where('kabupaten_id', $request->kabupaten_id)
            ->where('tahun', $request->tahun)
            ->where('id', '!=', $anggaran->id)
            ->exists();

        if ($cek) {
            return back()
                ->withInput()
                ->withErrors([
                    'tahun' => 'Data anggaran untuk kabupaten dan tahun tersebut sudah ada.'
                ]);
        }

        if ($request->total_anggaran < $anggaran->anggaran_terpakai) {
            return back()
                ->withInput()
                ->withErrors([
                    'total_anggaran' => 'Total anggaran tidak boleh lebih kecil dari anggaran yang sudah terpakai.'
                ]);
        }

        $anggaran->update([
            'kabupaten_id'      => $request->kabupaten_id,
            'tahun'             => $request->tahun,
            'total_anggaran'    => $request->total_anggaran,
            'sisa_anggaran'     => $request->total_anggaran - $anggaran->anggaran_terpakai,
        ]);

        return redirect()
            ->route('anggaran.index')
            ->with('success', 'Data anggaran berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $anggaran = Anggaran::findOrFail($id);

        if ($anggaran->anggaran_terpakai > 0) {
            return redirect()
                ->route('anggaran.index')
                ->with('error', 'Anggaran sudah digunakan sehingga tidak dapat dihapus.');
        }

        $anggaran->delete();

        return redirect()
            ->route('anggaran.index')
            ->with('success', 'Data anggaran berhasil dihapus.');
    }
}