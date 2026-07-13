<?php

namespace App\Http\Controllers\Provinsi;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\Request;

class DonasiController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $query = Donasi::latest();

        if ($status) {
            $query->where('status', $status);
        }

        $donasi = $query->get();

        $totalTerverifikasi = Donasi::where('status', 'terverifikasi')->sum('jumlah');
        $totalMenunggu      = Donasi::where('status', 'menunggu_verifikasi')->count();
        $totalDonatur       = Donasi::where('status', 'terverifikasi')->distinct('nama_donatur')->count('nama_donatur');

        return view('provinsi.donasi.index', compact(
            'donasi', 'totalTerverifikasi', 'totalMenunggu', 'totalDonatur', 'status'
        ));
    }

    public function verifikasi($id)
    {
        $donasi = Donasi::findOrFail($id);

        if ($donasi->status !== 'menunggu_verifikasi') {
            return back()->with('error', 'Donasi ini tidak dalam status menunggu verifikasi.');
        }

        $donasi->status      = 'terverifikasi';
        $donasi->verified_by = auth()->id();
        $donasi->verified_at = now();
        $donasi->save();

        return back()->with('success', 'Donasi berhasil diverifikasi.');
    }

    public function tolak($id)
    {
        $donasi = Donasi::findOrFail($id);

        $donasi->status      = 'ditolak';
        $donasi->verified_by = auth()->id();
        $donasi->verified_at = now();
        $donasi->save();

        return back()->with('success', 'Donasi ditolak.');
    }
}