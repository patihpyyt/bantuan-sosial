<?php

namespace App\Http\Controllers\Kabupaten;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AnggaranKecamatan;
use App\Models\DistribusiKecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistribusiController extends Controller
{
    /**
     * Daftar riwayat distribusi dana Kabupaten ke Kecamatan.
     */
    public function index(Request $request)
    {
        $kabupatenId = auth()->id();
        $tahun       = $request->input('tahun', now()->year);
        $kecamatan   = $request->input('kecamatan_id');
        $status      = $request->input('status');

        $query = DistribusiKecamatan::with('kecamatan')
            ->where('kabupaten_id', $kabupatenId)
            ->where('tahun', $tahun)
            ->latest('tanggal_distribusi');

        if ($kecamatan) {
            $query->where('kecamatan_id', $kecamatan);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $distribusi = $query->get();

        $kecamatanList = User::where('role', 'kecamatan')->get();

        $tahunTersedia = DistribusiKecamatan::where('kabupaten_id', $kabupatenId)
            ->select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return view('kabupaten.distribusi.index', [
            'distribusi'      => $distribusi,
            'kecamatanList'   => $kecamatanList,
            'tahun'           => $tahun,
            'tahunTersedia'   => $tahunTersedia,
            'filterKecamatan' => $kecamatan,
        ]);
    }

    /**
     * Form input distribusi baru ke Kecamatan.
     */
    public function create()
{
    $kecamatan = User::where('role', 'kecamatan')
    ->where('kabupaten_id', auth()->id())
    ->get();
    return view('kabupaten.distribusi.create', compact('kecamatan'));
}
    /**
     * Simpan distribusi baru + update/tambah AnggaranKecamatan terkait.
     * Sekaligus mengurangi sisa anggaran Kabupaten yang login (karena dana diteruskan).
     */
    public function store(Request $request)
    {
        $request->validate([
            'kecamatan_id'       => 'required|exists:users,id',
            'tahun'              => 'required|digits:4',
            'jumlah'             => 'required|numeric|min:1',
            'tanggal_distribusi' => 'required|date',
            'keterangan'         => 'nullable|string|max:255',
            'status'             => 'nullable|in:terkirim,dibatalkan',
        ]);

        $kabupatenId = auth()->id();

        $anggaranKabupaten = \App\Models\Anggaran::where('kabupaten_id', $kabupatenId)
            ->where('tahun', $request->tahun)
            ->first();

         if (!$anggaranKabupaten || $anggaranKabupaten->sisa_anggaran < $request->jumlah) {   // 👈 ini baris yang bikin "refresh"
        return back()
            ->withInput()
            ->with('error', 'Sisa anggaran Kabupaten tidak mencukupi untuk distribusi ini.');
    }

        DB::transaction(function () use ($request, $kabupatenId, $anggaranKabupaten) {

            DistribusiKecamatan::create([
                'kecamatan_id'       => $request->kecamatan_id,
                'kabupaten_id'       => $kabupatenId,
                'tahun'              => $request->tahun,
                'jumlah'             => $request->jumlah,
                'tanggal_distribusi' => $request->tanggal_distribusi,
                'keterangan'         => $request->keterangan,
                'status'             => $request->status ?? 'terkirim',
                'created_by'         => auth()->id(),
            ]);

            $anggaranKecamatan = AnggaranKecamatan::firstOrNew([
                'kecamatan_id' => $request->kecamatan_id,
                'tahun'        => $request->tahun,
            ]);

            if (!$anggaranKecamatan->exists) {
                $anggaranKecamatan->kabupaten_id      = $kabupatenId;
                $anggaranKecamatan->anggaran_terpakai  = 0;
                $anggaranKecamatan->total_anggaran     = 0;
                $anggaranKecamatan->sisa_anggaran      = 0;
            }

            $anggaranKecamatan->total_anggaran += $request->jumlah;
            $anggaranKecamatan->sisa_anggaran  += $request->jumlah;
            $anggaranKecamatan->save();

            $anggaranKabupaten->sisa_anggaran -= $request->jumlah;
            $anggaranKabupaten->save();
        });

        return redirect()
            ->route('kabupaten.distribusi.index', ['tahun' => $request->tahun])
            ->with('success', 'Dana berhasil didistribusikan ke Kecamatan.');
    }

    /**
     * Detail riwayat distribusi untuk satu Kecamatan tertentu.
     */
    public function show($kecamatanId, Request $request)
    {
        $tahun     = $request->input('tahun', now()->year);
        $kecamatan = User::where('role', 'kecamatan')->findOrFail($kecamatanId);

        $riwayat = DistribusiKecamatan::where('kecamatan_id', $kecamatanId)
            ->where('kabupaten_id', auth()->id())
            ->where('tahun', $tahun)
            ->orderByDesc('tanggal_distribusi')
            ->get();

        $anggaran = AnggaranKecamatan::where('kecamatan_id', $kecamatanId)
            ->where('tahun', $tahun)
            ->first();

        return view('kabupaten.distribusi.show', compact(
            'kecamatan', 'riwayat', 'anggaran', 'tahun'
        ));
    }

    /**
     * Batalkan satu transaksi distribusi (soft cancel).
     * Anggaran kecamatan dikurangi, anggaran kabupaten dikembalikan.
     */
    public function cancel($id)
    {
        $distribusi = DistribusiKecamatan::where('kabupaten_id', auth()->id())
            ->findOrFail($id);

        if ($distribusi->status === 'dibatalkan') {
            return back()->with('error', 'Distribusi ini sudah dibatalkan sebelumnya.');
        }

        $anggaranKecamatan = AnggaranKecamatan::where('kecamatan_id', $distribusi->kecamatan_id)
            ->where('tahun', $distribusi->tahun)
            ->first();

        if (!$anggaranKecamatan) {
            return back()->with('error', 'Data anggaran kecamatan terkait tidak ditemukan.');
        }

        $sisaSetelahDibatalkan = $anggaranKecamatan->sisa_anggaran - $distribusi->jumlah;
        if ($sisaSetelahDibatalkan < 0) {
            return back()->with('error', 'Distribusi tidak bisa dibatalkan karena dana sudah terpakai sebagian oleh Kecamatan.');
        }

        DB::transaction(function () use ($distribusi, $anggaranKecamatan) {
            $anggaranKecamatan->total_anggaran -= $distribusi->jumlah;
            $anggaranKecamatan->sisa_anggaran  -= $distribusi->jumlah;
            $anggaranKecamatan->save();

            $anggaranKabupaten = \App\Models\Anggaran::where('kabupaten_id', $distribusi->kabupaten_id)
                ->where('tahun', $distribusi->tahun)
                ->first();

            if ($anggaranKabupaten) {
                $anggaranKabupaten->sisa_anggaran += $distribusi->jumlah;
                $anggaranKabupaten->save();
            }

            $distribusi->status = 'dibatalkan';
            $distribusi->save();
        });

        return back()->with('success', 'Distribusi berhasil dibatalkan.');
    }

    public function edit($id)
    {
        $distribusi = DistribusiKecamatan::where('kabupaten_id', auth()->id())
            ->findOrFail($id);
        $kecamatanList = User::where('role', 'kecamatan')->get();

        return view('kabupaten.distribusi.edit', compact('distribusi', 'kecamatanList'));
    }

    public function update(Request $request, $id)
    {
        $distribusi = DistribusiKecamatan::where('kabupaten_id', auth()->id())
            ->findOrFail($id);

        $request->validate([
            'kecamatan_id'       => 'required|exists:users,id',
            'tahun'              => 'required|digits:4',
            'jumlah'             => 'required|numeric|min:1',
            'tanggal_distribusi' => 'required|date',
            'keterangan'         => 'nullable|string|max:255',
            'status'             => 'required|in:terkirim,dibatalkan',
        ]);

        DB::transaction(function () use ($request, $distribusi) {

            $jumlahLama      = $distribusi->jumlah;
            $kecamatanIdLama = $distribusi->kecamatan_id;
            $tahunLama       = $distribusi->tahun;

            $anggaranLama = AnggaranKecamatan::where('kecamatan_id', $kecamatanIdLama)
                ->where('tahun', $tahunLama)
                ->first();

            if ($anggaranLama) {
                $anggaranLama->total_anggaran -= $jumlahLama;
                $anggaranLama->sisa_anggaran  -= $jumlahLama;
                $anggaranLama->save();
            }

            $distribusi->update([
                'kecamatan_id'       => $request->kecamatan_id,
                'tahun'              => $request->tahun,
                'jumlah'             => $request->jumlah,
                'tanggal_distribusi' => $request->tanggal_distribusi,
                'keterangan'         => $request->keterangan,
                'status'             => $request->status,
            ]);

            $anggaranBaru = AnggaranKecamatan::firstOrNew([
                'kecamatan_id' => $request->kecamatan_id,
                'tahun'        => $request->tahun,
            ]);

            if (!$anggaranBaru->exists) {
                $anggaranBaru->kabupaten_id       = auth()->id();
                $anggaranBaru->anggaran_terpakai  = 0;
                $anggaranBaru->total_anggaran     = 0;
                $anggaranBaru->sisa_anggaran      = 0;
            }

            $anggaranBaru->total_anggaran += $request->jumlah;
            $anggaranBaru->sisa_anggaran  += $request->jumlah;
            $anggaranBaru->save();
        });

        return redirect()
            ->route('kabupaten.distribusi.index', ['tahun' => $request->tahun])
            ->with('success', 'Distribusi berhasil diperbarui.');
    }
}