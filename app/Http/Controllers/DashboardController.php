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
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'warga') {
            return $this->dashboardWarga($request);
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
     * Dashboard warga: otomatis tampilkan tetangga satu RT/RW,
     * plus search bar untuk mempersempit hasil.
     */
    private function dashboardWarga(Request $request)
    {
        $user = Auth::user();

        // Cari data diri sendiri di tabel warga (data master yang diinput petugas)
        $dataDiri = Warga::where('nik', $user->nik)->first();

        // Kalau petugas belum pernah input data warga ini, tidak bisa filter RT/RW
        if (! $dataDiri || ! $dataDiri->rt || ! $dataDiri->rw) {
            return view('dashboard-warga', [
                'dataDiri' => $dataDiri,
                'tetangga' => collect(),
                'belumTerdaftar' => true,
                'keyword' => $request->keyword,
            ]);
        }

        $query = Warga::where('rt', $dataDiri->rt)
            ->where('rw', $dataDiri->rw)
            ->where('nik', '!=', $user->nik); // exclude diri sendiri dari daftar tetangga

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_lengkap', 'like', "%{$keyword}%")
                  ->orWhere('nik', 'like', "%{$keyword}%");
            });
        }

        $tetangga = $query->orderBy('nama_lengkap')->get();

        // Tambahkan status bansos untuk tiap tetangga
        $tetangga = $tetangga->map(function ($warga) {
            $penerima = PenerimaBansos::where('nik', $warga->nik)->first();
            $warga->status_bansos = $penerima ? 'Terdaftar sebagai penerima bansos' : 'Belum terdaftar';
            return $warga;
        });

        return view('dashboard-warga', [
            'dataDiri' => $dataDiri,
            'tetangga' => $tetangga,
            'belumTerdaftar' => false,
            'keyword' => $request->keyword,
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