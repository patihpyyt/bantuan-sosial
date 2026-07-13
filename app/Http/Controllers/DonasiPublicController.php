<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DonasiPublicController extends Controller
{
    // Halaman form donasi
    public function create()
    {
        return view('donasi.create');
    }

    // Simpan donasi baru, generate kode referensi
    public function store(Request $request)
    {
        $request->validate([
            'nama_donatur'       => 'required|string|max:100',
            'email'              => 'nullable|email',
            'jumlah'             => 'required|numeric|min:10000',
            'metode_pembayaran'  => 'required|in:transfer_bank,qris,ewallet',
            'pesan'              => 'nullable|string|max:255',
        ]);

        $kodeReferensi = 'DON-' . strtoupper(Str::random(8));

        $donasi = Donasi::create([
            'kode_referensi'      => $kodeReferensi,
            'nama_donatur'        => $request->nama_donatur,
            'email'               => $request->email,
            'jumlah'              => $request->jumlah,
            'metode_pembayaran'   => $request->metode_pembayaran,
            'pesan'               => $request->pesan,
            'status'              => 'menunggu_pembayaran',
        ]);

        return redirect()->route('donasi.instruksi', $donasi->kode_referensi);
    }

    // Halaman instruksi pembayaran (dummy)
    public function instruksi($kode)
    {
        $donasi = Donasi::where('kode_referensi', $kode)->firstOrFail();

        return view('donasi.instruksi', compact('donasi'));
    }

    // User klik "Saya Sudah Bayar"
    public function konfirmasi($kode)
    {
        $donasi = Donasi::where('kode_referensi', $kode)->firstOrFail();

        if ($donasi->status === 'menunggu_pembayaran') {
            $donasi->status = 'menunggu_verifikasi';
            $donasi->save();
        }

        return redirect()->route('donasi.instruksi', $kode)
            ->with('success', 'Terima kasih! Pembayaran Anda sedang diverifikasi oleh admin.');
    }

    // Halaman cek status donasi pakai kode referensi (opsional, untuk donatur cek ulang)
    public function cekStatus(Request $request)
    {
        $donasi = null;

        if ($request->filled('kode')) {
            $donasi = Donasi::where('kode_referensi', $request->kode)->first();
        }

        return view('donasi.cek-status', compact('donasi'));
    }
}