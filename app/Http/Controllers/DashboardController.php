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
            'totalPenerima'    => PenerimaBansos::where('status', 'aktif')->count(),
            'totalPenyaluran'  => Penyaluran::whereMonth('created_at', now()->month)
                                            ->whereYear('created_at', now()->year)
                                            ->count(),
            'tersalur'         => Penyaluran::where('status', 'tersalur')->count(),
            'belumTersalur'    => Penyaluran::whereIn('status', ['belum', 'proses'])->count(),
            'gagal'            => Penyaluran::where('status', 'gagal')->count(),
        ];

        return view('dashboard', $data);
    }
}