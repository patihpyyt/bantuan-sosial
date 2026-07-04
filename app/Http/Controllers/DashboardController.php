<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\JenisBansos;
use App\Models\PenerimaBansos;
use App\Models\Penyaluran;

class DashboardController extends Controller
{
    public function index()
    {
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