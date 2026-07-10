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

        // Role warga punya alur data sendiri (tetangga satu RT/RW)
        if ($user->role === 'warga') {
            return $this->dashboardWarga($request);
        }

        // Data agregat untuk role petugas/admin (provinsi, kabupaten, kecamatan, kelurahan)
        $data = [
            'totalWarga'        => Warga::count(),
            'totalJenisBansos'  => JenisBansos::count(),
            'totalPenerima'     => PenerimaBansos::count(),
            'totalPenyaluran'   => Penyaluran::whereMonth('created_at', now()->month)
                                            ->whereYear('created_at', now()->year)
                                            ->count(),
            'tersalur'          => Penyaluran::where('status', 'tersalur')->count(),
            'penyaluranTerbaru' => Penyaluran::with(['penerima.warga', 'penerima.jenisBansos'])
                                            ->latest()
                                            ->take(5)
                                            ->get(),
            'realisasiPKH'      => $this->hitungRealisasi(1),
            'realisasiBLT'      => $this->hitungRealisasi(2),
            'realisasiBPNT'     => $this->hitungRealisasi(4),
            'belumTersalur'     => Penyaluran::whereIn('status', ['belum', 'proses'])->count(),
            'gagal'             => Penyaluran::where('status', 'gagal')->count(),
        ];

        $data['realisasiTotal'] = round((
            $data['realisasiPKH'] + $data['realisasiBLT'] + $data['realisasiBPNT']
        ) / 3);

        // Tentukan view sesuai role user yang sedang login
        return match ($user->role) {
            'provinsi'  => view('dashboard-provinsi', $data),
            'kabupaten' => view('dashboard-kabupaten', $data),
            'kecamatan' => view('dashboard-kecamatan', $data),
            'kelurahan' => view('dashboard-kelurahan', $data),
            default     => abort(403, 'Role tidak dikenali.'),
        };
    }

    /**
     * Dashboard warga: otomatis tampilkan tetangga satu RT/RW,
     * plus search bar untuk mempersempit hasil.
     */
    private function dashboardWarga(Request $request)
    {
        $user = Auth::user();

        // Data diri warga yang sedang login (asumsi model Warga terhubung lewat nik)
        $dataDiri = Warga::where('nik', $user->nik)->first();

        if (!$dataDiri) {
            return view('dashboard-warga', [
                'dataDiri'       => null,
                'tetangga'       => collect(),
                'belumTerdaftar' => true,
                'keyword'        => $request->keyword,
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
            $warga->status_bansos = $warga->penerimaBansos()->exists()
                ? 'Terdaftar sebagai penerima bansos'
                : 'Belum terdaftar';

            return $warga;
        });

        return view('dashboard-warga', [
            'dataDiri'       => $dataDiri,
            'tetangga'       => $tetangga,
            'belumTerdaftar' => false,
            'keyword'        => $request->keyword,
        ]);
    }

    /**
     * Fitur cari warga (dipakai untuk route dashboard.cari-warga).
     */
    public function cariWarga(Request $request)
    {
        return $this->dashboardWarga($request);
    }

    private function hitungRealisasi($jenisBansosId)
    {
        $totalTarget = PenerimaBansos::where('jenis_bansos_id', $jenisBansosId)->count() * 12;

        if ($totalTarget == 0) {
            return 0;
        }

        $tersalur = Penyaluran::whereHas('penerima', function ($q) use ($jenisBansosId) {
            $q->where('jenis_bansos_id', $jenisBansosId);
        })
        ->where('status', 'tersalur')
        ->count();

        return round(($tersalur / $totalTarget) * 100);
    }
}