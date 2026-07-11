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
    /**
     * Daftar seluruh riwayat distribusi dana ke Kabupaten/Kota.
     */
    public function index(Request $request)
    {
        $tahun     = $request->input('tahun', now()->year);
        $kabupaten = $request->input('kabupaten_id');

        $query = DistribusiAnggaran::with('kabupaten')
            ->where('tahun', $tahun)
            ->latest('tanggal_distribusi');

        if ($kabupaten) {
            $query->where('kabupaten_id', $kabupaten);
        }

        $distribusi = $query->get();

        $kabupatenList = User::where('role', 'kabupaten')->get();

        $tahunTersedia = DistribusiAnggaran::select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return view('provinsi.distribusi.index', [
            'distribusi'     => $distribusi,
            'kabupatenList'  => $kabupatenList,
            'tahun'          => $tahun,
            'tahunTersedia'  => $tahunTersedia,
            'filterKabupaten'=> $kabupaten,
        ]);
    }

    /**
     * Form input distribusi baru.
     */
    public function create()
    {
        $kabupatenList = User::where('role', 'kabupaten')->get();

        return view('provinsi.distribusi.create', compact('kabupatenList'));
    }

    /**
     * Simpan distribusi baru + update/tambah Anggaran kabupaten terkait.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kabupaten_id'       => 'required|exists:users,id',
            'tahun'              => 'required|digits:4',
            'jumlah'             => 'required|numeric|min:1',
            'tanggal_distribusi' => 'required|date',
            'keterangan'         => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {

            // 1. Catat transaksi distribusi
            DistribusiAnggaran::create([
                'kabupaten_id'       => $request->kabupaten_id,
                'tahun'              => $request->tahun,
                'jumlah'             => $request->jumlah,
                'tanggal_distribusi' => $request->tanggal_distribusi,
                'keterangan'         => $request->keterangan,
                'status'             => 'terkirim',
                'created_by'         => auth()->id(),
            ]);

            // 2. Update atau buat baru Anggaran kabupaten untuk tahun ini
            $anggaran = Anggaran::firstOrNew([
                'kabupaten_id' => $request->kabupaten_id,
                'tahun'        => $request->tahun,
            ]);

            if (!$anggaran->exists) {
                $anggaran->anggaran_terpakai = 0;
                $anggaran->total_anggaran    = 0;
                $anggaran->sisa_anggaran     = 0;
            }

            $anggaran->total_anggaran += $request->jumlah;
            $anggaran->sisa_anggaran  += $request->jumlah;
            $anggaran->save();
        });

        return redirect()
            ->route('provinsi.distribusi.index', ['tahun' => $request->tahun])
            ->with('success', 'Dana berhasil didistribusikan ke Kabupaten/Kota.');
    }

    /**
     * Detail riwayat distribusi untuk satu Kabupaten/Kota tertentu.
     */
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

    /**
     * Batalkan satu transaksi distribusi (soft cancel, bukan hapus).
     * Anggaran dikurangi kembali sejumlah distribusi yang dibatalkan.
     */
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

        // Cegah pembatalan kalau dana sudah kadung terpakai kabupaten
        $sisaSetelahDibatalkan = $anggaran->sisa_anggaran - $distribusi->jumlah;
        if ($sisaSetelahDibatalkan < 0) {
            return back()->with('error', 'Distribusi tidak bisa dibatalkan karena dana sudah terpakai sebagian oleh Kabupaten.');
        }

        DB::transaction(function () use ($distribusi, $anggaran) {
            $anggaran->total_anggaran -= $distribusi->jumlah;
            $anggaran->sisa_anggaran  -= $distribusi->jumlah;
            $anggaran->save();

            $distribusi->status = 'dibatalkan';
            $distribusi->save();
        });

        return back()->with('success', 'Distribusi berhasil dibatalkan.');
    }
}