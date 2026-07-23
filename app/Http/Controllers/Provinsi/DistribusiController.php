<?php

namespace App\Http\Controllers\Provinsi;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Anggaran;
use App\Models\DistribusiAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistribusiController extends Controller
{
    public function index(Request $request)
    {
        $tahun     = $request->input('tahun', now()->year);
        $kabupaten = $request->input('kabupaten_id');
        $status    = $request->input('status');

       $query = DistribusiAnggaran::with('kabupaten')
    ->where('tahun', $tahun)
    ->where('created_by', auth()->id())
    ->latest('tanggal_distribusi');

    
        if ($kabupaten) {
            $query->where('kabupaten_id', $kabupaten);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $distribusi = $query->get();

        $kabupatenList = User::where('role', 'kabupaten')->get();

        $tahunTersedia = DistribusiAnggaran::select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return view('provinsi.distribusi.index', [
            'distribusi'      => $distribusi,
            'kabupatenList'   => $kabupatenList,
            'tahun'           => $tahun,
            'tahunTersedia'   => $tahunTersedia,
            'filterKabupaten' => $kabupaten,
        ]);
    }

    public function create()
    {
        $kabupatenList = User::where('role', 'kabupaten')->get();

        return view('provinsi.distribusi.create', compact('kabupatenList'));
    }

   public function store(Request $request)
{
    $request->validate([
        'kabupaten_id'       => 'required|exists:users,id',
        'tahun'              => 'required|digits:4',
        'jumlah'             => 'required|numeric|min:1',
        'tanggal_distribusi' => 'required|date',
        'keterangan'         => 'nullable|string|max:255',
        'status'             => 'nullable|in:terkirim,dibatalkan',
    ]);

    DB::transaction(function () use ($request) {

        $anggaran = Anggaran::where('kabupaten_id', $request->kabupaten_id)
            ->where('tahun', $request->tahun)
            ->first();

        if (!$anggaran) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'kabupaten_id' => 'Belum ada pagu anggaran untuk Kabupaten/Kota & tahun ini. Buat anggaran dulu.',
            ]);
        }

        if ($request->jumlah > $anggaran->sisa_anggaran) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'jumlah' => 'Jumlah distribusi melebihi sisa anggaran yang tersedia (Rp ' . number_format($anggaran->sisa_anggaran, 0, ',', '.') . ').',
            ]);
        }

        DistribusiAnggaran::create([
            'kabupaten_id'       => $request->kabupaten_id,
            'tahun'              => $request->tahun,
            'jumlah'             => $request->jumlah,
            'tanggal_distribusi' => $request->tanggal_distribusi,
            'keterangan'         => $request->keterangan,
            'status'             => $request->status ?? 'terkirim',
            'created_by'         => auth()->id(),
        ]);

        // total_anggaran TETAP, cuma terpakai naik & sisa turun
        $anggaran->anggaran_terpakai += $request->jumlah;
        $anggaran->sisa_anggaran     -= $request->jumlah;
        $anggaran->save();
    });

    return redirect()
        ->route('provinsi.distribusi.index', ['tahun' => $request->tahun])
        ->with('success', 'Dana berhasil didistribusikan ke Kabupaten/Kota.');
}
    public function show($kabupatenId, Request $request)
    {
        $tahun     = $request->input('tahun', now()->year);
        $kabupaten = User::where('role', 'kabupaten')->findOrFail($kabupatenId);

        $riwayat = DistribusiAnggaran::where('kabupaten_id', $kabupatenId)
            ->where('tahun', $tahun)
            ->orderByDesc('tanggal_distribusi')
            ->get();

        $anggaran = Anggaran::where('kabupaten_id', $kabupatenId)
            ->where('tahun', $tahun)
            ->first();

        return view('provinsi.distribusi.show', compact(
            'kabupaten', 'riwayat', 'anggaran', 'tahun'
        ));
    }

    public function cancel($id)
    {
        $distribusi = DistribusiAnggaran::findOrFail($id);

        if ($distribusi->status === 'dibatalkan') {
            return back()->with('error', 'Distribusi ini sudah dibatalkan sebelumnya.');
        }

        $anggaran = Anggaran::where('kabupaten_id', $distribusi->kabupaten_id)
            ->where('tahun', $distribusi->tahun)
            ->first();

        if (!$anggaran) {
            return back()->with('error', 'Data anggaran terkait tidak ditemukan.');
        }

        DB::transaction(function () use ($distribusi, $anggaran) {
            $anggaran->anggaran_terpakai -= $distribusi->jumlah;
            $anggaran->sisa_anggaran     += $distribusi->jumlah;
            $anggaran->save();

            $distribusi->status = 'dibatalkan';
            $distribusi->save();
        });

        return back()->with('success', 'Distribusi berhasil dibatalkan.');
    }

    public function edit($id)
    {
        $distribusi    = DistribusiAnggaran::findOrFail($id);
        $kabupatenList = User::where('role', 'kabupaten')->get();

        return view('provinsi.distribusi.edit', compact('distribusi', 'kabupatenList'));
    }

    public function update(Request $request, $id)
    {
        $distribusi = DistribusiAnggaran::findOrFail($id);

        $request->validate([
            'kabupaten_id'       => 'required|exists:users,id',
            'tahun'              => 'required|digits:4',
            'jumlah'             => 'required|numeric|min:1',
            'tanggal_distribusi' => 'required|date',
            'keterangan'         => 'nullable|string|max:255',
            'status'             => 'required|in:terkirim,dibatalkan',
        ]);

        DB::transaction(function () use ($request, $distribusi) {

            $jumlahLama      = $distribusi->jumlah;
            $kabupatenIdLama = $distribusi->kabupaten_id;
            $tahunLama       = $distribusi->tahun;
            $statusLama      = $distribusi->status;

            if ($statusLama !== 'dibatalkan') {
                $anggaranLama = Anggaran::where('kabupaten_id', $kabupatenIdLama)
                    ->where('tahun', $tahunLama)
                    ->first();

                if ($anggaranLama) {
                    $anggaranLama->anggaran_terpakai -= $jumlahLama;
                    $anggaranLama->sisa_anggaran      += $jumlahLama;
                    $anggaranLama->save();
                }
            }

            $distribusi->update([
                'kabupaten_id'       => $request->kabupaten_id,
                'tahun'              => $request->tahun,
                'jumlah'             => $request->jumlah,
                'tanggal_distribusi' => $request->tanggal_distribusi,
                'keterangan'         => $request->keterangan,
                'status'             => $request->status,
            ]);

            if ($request->status !== 'dibatalkan') {
                $anggaranBaru = Anggaran::where('kabupaten_id', $request->kabupaten_id)
                    ->where('tahun', $request->tahun)
                    ->first();

                if ($anggaranBaru) {
                    $anggaranBaru->anggaran_terpakai += $request->jumlah;
                    $anggaranBaru->sisa_anggaran      -= $request->jumlah;
                    $anggaranBaru->save();
                }
            }
        });

        return redirect()
            ->route('provinsi.distribusi.index', ['tahun' => $request->tahun])
            ->with('success', 'Distribusi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $distribusi = DistribusiAnggaran::findOrFail($id);

        if ($distribusi->status !== 'dibatalkan') {
            $anggaran = Anggaran::where('kabupaten_id', $distribusi->kabupaten_id)
                ->where('tahun', $distribusi->tahun)
                ->first();

            if ($anggaran) {
                $anggaran->anggaran_terpakai -= $distribusi->jumlah;
                $anggaran->sisa_anggaran     += $distribusi->jumlah;
                $anggaran->save();
            }
        }

        $distribusi->delete();

        return redirect()
            ->route('provinsi.distribusi.index')
            ->with('success', 'Data distribusi berhasil dihapus permanen.');
    }
}