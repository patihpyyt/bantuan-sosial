<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\JenisBansos;
use App\Models\PenerimaBansos;
use App\Models\Penyaluran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Kalau yang login warga, tampilkan dashboard search-only
        if ($user->role === 'warga') {
            return view('dashboard-warga');
        }

        // ============================
        // Dashboard petugas/admin (logic lama)
        // ============================
        $data = [
            'totalWarga'       => Warga::count(),
            'totalJenisBansos' => JenisBansos::count(),
            'totalPenerima' => PenerimaBansos::count(),
            'totalPenyaluran'  => Penyaluran::whereMonth('created_at', now()->month)
                                            ->whereYear('created_at', now()->year)
                                            ->count(),
            'tersalur'         => Penyaluran::where('status', 'tersalur')->count(),
            'penyaluranTerbaru' => Penyaluran::with(['penerima.warga', 'penerima.jenisBansos'])
                        ->latest()
                        ->take(5)
                        ->get(),
            'realisasiPKH'  => $this->hitungRealisasi(1),
            'realisasiBLT'  => $this->hitungRealisasi(2),
            'realisasiBPNT' => $this->hitungRealisasi(4),
            'belumTersalur'    => Penyaluran::whereIn('status', ['belum', 'proses'])->count(),
            'gagal'            => Penyaluran::where('status', 'gagal')->count(),
        ];
        $data['realisasiTotal'] = round((
            $data['realisasiPKH'] + $data['realisasiBLT'] + $data['realisasiBPNT']
        ) / 3);

        return view('dashboard', $data);
    }

    /**
     * Pencarian warga (nama atau NIK) untuk halaman dashboard warga.
     */
    public function cariWarga(Request $request)
    {
        $request->validate([
            'keyword' => ['required', 'string', 'min:3'],
        ]);

        $keyword = $request->keyword;

        $hasil = Warga::where('nama_lengkap', 'like', "%{$keyword}%")
            ->orWhere('nik', 'like', "%{$keyword}%")
            ->limit(10)
            ->get();

        $hasil = $hasil->map(function ($warga) {
            $penerima = PenerimaBansos::where('nik', $warga->nik)->first();

            $warga->status_bansos = $penerima ? 'Terdaftar sebagai penerima bansos' : 'Belum terdaftar';

            return $warga;
        });

        return view('dashboard-warga', [
            'hasil' => $hasil,
            'keyword' => $keyword,
        ]);
    }

    private function hitungRealisasi($jenisBansosId)
    {
        $totalTarget = \App\Models\PenerimaBansos::where('jenis_bansos_id', $jenisBansosId)->count() * 12;

        if ($totalTarget == 0) {
            return 0;
        }

        $tersalur = \App\Models\Penyaluran::whereHas('penerima', function ($q) use ($jenisBansosId) {
            $q->where('jenis_bansos_id', $jenisBansosId);
        })
        ->where('status', 'tersalur')
        ->count();

        return round(($tersalur / $totalTarget) * 100);
    }
}