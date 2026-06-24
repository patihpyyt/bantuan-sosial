<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $log = LogAktivitas::with('user')
            ->when($request->aksi,    fn($q) => $q->where('aksi', $request->aksi))
            ->when($request->tabel,   fn($q) => $q->where('tabel_terdampak', $request->tabel))
            ->when($request->tanggal, fn($q) => $q->whereDate('created_at', $request->tanggal))
            ->latest('created_at')
            ->paginate(20);

        return view('log-aktivitas.index', compact('log'));
    }

    public function show(int $id)
    {
        $log = LogAktivitas::with('user')->findOrFail($id);
        return view('log-aktivitas.show', compact('log'));
    }
}