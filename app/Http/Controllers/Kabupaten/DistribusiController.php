<?php

namespace App\Http\Controllers\Kabupaten;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Anggaran;
use App\Models\DistribusiAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DistribusiController extends Controller
{
    /**
     * Daftar seluruh riwayat distribusi dana ke Kecamatan.
     */
    public function index(Request $request)
    {
        $tahun     = $request->input('tahun', now()->year);
        $kabupaten = $request->input('kabupaten_id');
        $status    = $request->input('status');

        $query = DistribusiAnggaran::with('kabupaten')
            ->where('tahun', $tahun)
            ->latest('tanggal_distribusi');

        if ($kabupaten) {
            $query->where('kabupaten_id', $kabupaten);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $distribusi = $query->get();

        $kabupatenList = User::where('role', 'kecamatan')->get();

        $tahunTersedia = DistribusiAnggaran::select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return view('kabupaten.distribusi.index', [
            'distribusi'      => $distribusi,
            'kabupatenList'   => $kabupatenList,
            'tahun'           => $tahun,
            'tahunTersedia'   => $tahunTersedia,
            'filterKabupaten' => $kabupaten,
        ]);
    }

    /**
     * Form input distribusi baru.
     */
    public function create()
    {
        $kecamatan = User::where('role', 'kecamatan')->get();

        return view('kabupaten.distribusi.create', compact('kecamatan'));
    }

    /**
     * Simpan distribusi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kecamatan_id'       => ['required', Rule::exists('users', 'id')->where('role', 'kecamatan')],
            'tahun'              => 'required|digits:4',
            'jumlah'             => 'required|numeric|min:1',
            'tanggal_distribusi' => 'required|date',
            'keterangan'         => 'nullable|string|max:255',
            'status'             => 'nullable|in:terkirim,dibatalkan',
        ]);

        $anggaran = Anggaran::where('kabupaten_id', auth()->id())
            ->where('tahun', $request->tahun)
            ->first();

        if (!$anggaran) {
            return back()->withInput()->with('error', 'Kabupaten ini belum punya alokasi anggaran untuk tahun tersebut. Alokasikan dulu di menu Kelola Anggaran.');
        }

        if ($anggaran->sisa_anggaran < $request->jumlah) {
            return back()->withInput()->with('error', 'Jumlah distribusi melebihi sisa anggaran kabupaten ini. Sisa saat ini: Rp ' . number_format($anggaran->sisa_anggaran, 0, ',', '.'));
        }

        DB::transaction(function () use ($request, $anggaran) {

            DistribusiAnggaran::create([
                'kabupaten_id'       => $request->kecamatan_id,
                'tahun'              => $request->tahun,
                'jumlah'             => $request->jumlah,
                'tanggal_distribusi' => $request->tanggal_distribusi,
                'keterangan'         => $request->keterangan,
                'status'             => $request->status ?? 'terkirim',
                'created_by'         => auth()->id(),
            ]);

            $anggaran->anggaran_terpakai += $request->jumlah;
            $anggaran->sisa_anggaran     -= $request->jumlah;
            $anggaran->save();
        });

        return redirect()
            ->route('kabupaten.distribusi.index', ['tahun' => $request->tahun])
            ->with('success', 'Dana berhasil didistribusikan ke Kecamatan.');
    }

    /**
     * Detail riwayat distribusi untuk satu Kecamatan tertentu.
     */
    public function show($kabupatenId, Request $request)
    {
        $tahun     = $request->input('tahun', now()->year);
        $kabupaten = User::where('role', 'kecamatan')->findOrFail($kabupatenId);

        $riwayat = DistribusiAnggaran::where('kabupaten_id', $kabupatenId)
            ->where('tahun', $tahun)
            ->orderByDesc('tanggal_distribusi')
            ->get();

        $anggaran = Anggaran::where('kabupaten_id', $kabupatenId)
            ->where('tahun', $tahun)
            ->first();

        return view('kabupaten.distribusi.show', compact(
            'kabupaten', 'riwayat', 'anggaran', 'tahun'
        ));
    }

    /**
     * Batalkan satu transaksi distribusi (soft cancel, bukan hapus).
     */
    public function cancel($id)
    {
        $distribusi = DistribusiAnggaran::findOrFail($id);

        if ($distribusi->status === 'dibatalkan') {
            return back()->with('error', 'Distribusi ini sudah dibatalkan sebelumnya.');
        }

        $anggaran = Anggaran::where('kabupaten_id', auth()->id())
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
        $distribusi = DistribusiAnggaran::findOrFail($id);

        $kecamatan = User::where('role', 'kecamatan')->get();

        return view('kabupaten.distribusi.edit', compact(
            'distribusi',
            'kecamatan'
        ));
    }

    /**
     * Update transaksi distribusi.
     */
    public function update(Request $request, $id)
    {
        $distribusi = DistribusiAnggaran::findOrFail($id);

        $request->validate([
            'kecamatan_id'       => ['required', Rule::exists('users', 'id')->where('role', 'kecamatan')],
            'tahun'              => 'required|digits:4',
            'jumlah'             => 'required|numeric|min:1',
            'tanggal_distribusi' => 'required|date',
            'keterangan'         => 'nullable|string|max:255',
            'status'             => 'required|in:terkirim,dibatalkan',
        ]);

        DB::transaction(function () use ($request, $distribusi) {

            $jumlahLama = $distribusi->jumlah;
            $tahunLama  = $distribusi->tahun;
            $statusLama = $distribusi->status;

            if ($statusLama !== 'dibatalkan') {
                $anggaranLama = Anggaran::where('kabupaten_id', auth()->id())
                    ->where('tahun', $tahunLama)
                    ->first();

                if ($anggaranLama) {
                    $anggaranLama->anggaran_terpakai -= $jumlahLama;
                    $anggaranLama->sisa_anggaran      += $jumlahLama;
                    $anggaranLama->save();
                }
            }

            $distribusi->update([
                'kabupaten_id'       => $request->kecamatan_id,
                'tahun'              => $request->tahun,
                'jumlah'             => $request->jumlah,
                'tanggal_distribusi' => $request->tanggal_distribusi,
                'keterangan'         => $request->keterangan,
                'status'             => $request->status,
            ]);

            if ($request->status !== 'dibatalkan') {
                $anggaranBaru = Anggaran::where('kabupaten_id', auth()->id())
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
            ->route('kabupaten.distribusi.index', ['tahun' => $request->tahun])
            ->with('success', 'Distribusi berhasil diperbarui.');
    }

    /**
     * Hapus permanen transaksi distribusi.
     */
    public function destroy($id)
    {
        $distribusi = DistribusiAnggaran::findOrFail($id);

        if ($distribusi->status !== 'dibatalkan') {
            $anggaran = Anggaran::where('kabupaten_id', auth()->id())
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
            ->route('kabupaten.distribusi.index')
            ->with('success', 'Data distribusi berhasil dihapus permanen.');
    }
}