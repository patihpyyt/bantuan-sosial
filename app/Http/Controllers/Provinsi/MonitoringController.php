<?php

namespace App\Http\Controllers\Provinsi;

use App\Models\DistribusiAnggaran;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Warga;
use App\Models\Anggaran;
use App\Models\Penyaluran;
use App\Models\PenerimaBansos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);

        $tahunTersedia = Anggaran::select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        $kabupatenList = User::where('role', 'kabupaten')->get();

        $monitoring = $kabupatenList->map(function ($kab) use ($tahun) {
            return $this->hitungDataKabupaten($kab, $tahun);
        });

      $summary = [
    'total_anggaran'   => $monitoring->sum('total_anggaran'),
    'total_terpakai'   => $monitoring->sum('anggaran_terpakai'),
    'total_sisa'       => $monitoring->sum('sisa_anggaran'),
    'total_warga'      => $monitoring->sum('total_warga'),
    'total_penerima'   => $monitoring->sum('total_penerima'),
    'total_penyaluran' => $monitoring->sum('total_penyaluran'),
    'total_transaksi'  => $monitoring->sum('jumlah_penyaluran'),  // tambahin ini
];

        return view('provinsi.monitoring.index', [
            'monitoring'    => $monitoring,
            'summary'       => $summary,
            'tahun'         => $tahun,
            'tahunTersedia' => $tahunTersedia,
        ]);
    }

    public function show(Request $request, $kabupatenId)
    {
        $tahun     = $request->input('tahun', now()->year);
        $kabupaten = User::where('role', 'kabupaten')->findOrFail($kabupatenId);

        $dataKabupaten = $this->hitungDataKabupaten($kabupaten, $tahun);

        $kecamatanList = User::where('role', 'kecamatan')
            ->where('kabupaten_id', $kabupaten->id)
            ->get();

        $monitoringKecamatan = $kecamatanList->map(function ($kec) use ($kabupaten, $tahun) {

            $totalWarga = Warga::where('kabupaten', $kabupaten->nama_lengkap)
                ->where('kecamatan', $kec->nama_lengkap)
                ->count();

            $totalPenerima = PenerimaBansos::whereHas('warga', function ($q) use ($kabupaten, $kec) {
                $q->where('kabupaten', $kabupaten->nama_lengkap)
                  ->where('kecamatan', $kec->nama_lengkap);
            })->count();

            $totalPenyaluran = Penyaluran::whereHas('penerima.warga', function ($q) use ($kabupaten, $kec) {
                $q->where('kabupaten', $kabupaten->nama_lengkap)
                  ->where('kecamatan', $kec->nama_lengkap);
            })->sum('nominal');

            // Aliran dana berjenjang kabupaten -> kecamatan
            $diterima = DistribusiAnggaran::where('kabupaten_id', $kec->id)
                ->where('tahun', $tahun)
                ->where('status', 'terkirim')
                ->sum('jumlah');

                    
$diteruskan = DB::table('distribusi_kelurahan') 
    ->where('kecamatan_id', $kec->id)
    ->where('tahun', $tahun)
    ->where('status', 'terkirim')
    ->sum('jumlah');
            $sisa = $diterima - $diteruskan;

            if ($diterima == 0) {
                $statusAliran = 'belum_ada_dana';
            } elseif ($sisa <= 0) {
                $statusAliran = 'tersalur_penuh';
            } elseif ($sisa == $diterima) {
                $statusAliran = 'mengendap';
            } else {
                $statusAliran = 'sebagian';
            }

            return [
                'kecamatan_id'     => $kec->id,
                'kecamatan'        => $kec->nama_lengkap,
                'total_warga'      => $totalWarga,
                'total_penerima'   => $totalPenerima,
                'total_penyaluran' => $totalPenyaluran,
                'diterima'         => $diterima,
                'diteruskan'       => $diteruskan,
                'sisa'             => $sisa,
                'status_aliran'    => $statusAliran,
            ];
        });

        return view('provinsi.monitoring.show', [
            'kabupaten'           => $kabupaten,
            'dataKabupaten'       => $dataKabupaten,
            'monitoringKecamatan' => $monitoringKecamatan,
            'tahun'               => $tahun,
        ]);
    }

    public function grafikTren(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);

        $data = Penyaluran::select(
                DB::raw('MONTH(tanggal_salur) as bulan'),
                DB::raw('SUM(nominal) as total')
            )
            ->whereYear('tanggal_salur', $tahun)
            ->groupBy(DB::raw('MONTH(tanggal_salur)'))
            ->orderBy(DB::raw('MONTH(tanggal_salur)'))
            ->get();

        $hasil = collect(range(1, 12))->map(function ($bulan) use ($data) {
            $item = $data->firstWhere('bulan', $bulan);
            return [
                'bulan' => $bulan,
                'total' => $item->total ?? 0,
            ];
        });

        return response()->json($hasil);
    }

    public function export(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $kabupatenList = User::where('role', 'kabupaten')->get();

        $filename = 'monitoring-wilayah-' . $tahun . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($kabupatenList, $tahun) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Kabupaten/Kota', 'Total Anggaran', 'Terpakai', 'Sisa',
                'Persentase Serapan', 'Total Warga', 'Total Penerima', 'Total Penyaluran',
            ]);

            foreach ($kabupatenList as $kab) {
                $data = $this->hitungDataKabupaten($kab, $tahun);
                fputcsv($file, [
                    $data['nama_kabupaten'],
                    $data['total_anggaran'],
                    $data['anggaran_terpakai'],
                    $data['sisa_anggaran'],
                    $data['persentase_serapan'] . '%',
                    $data['total_warga'],
                    $data['total_penerima'],
                    $data['total_penyaluran'],
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function hitungDataKabupaten(User $kab, $tahun)
    {
        $anggaran = Anggaran::where('kabupaten_id', $kab->id)
            ->where('tahun', $tahun)
            ->first();

        $totalAnggaran = $anggaran->total_anggaran ?? 0;
        $terpakai      = $anggaran->anggaran_terpakai ?? 0;
        $sisa          = $anggaran->sisa_anggaran ?? 0;

        $persentaseSerapan = $totalAnggaran > 0
            ? round(($terpakai / $totalAnggaran) * 100, 1)
            : 0;

        $totalWarga = Warga::where('kabupaten', $kab->nama_lengkap)->count();

        $totalPenerima = PenerimaBansos::whereHas('warga', function ($q) use ($kab) {
            $q->where('kabupaten', $kab->nama_lengkap);
        })->count();

        $totalPenyaluran = Penyaluran::whereHas('penerima.warga', function ($q) use ($kab) {
            $q->where('kabupaten', $kab->nama_lengkap);
        })->sum('nominal');

        $jumlahPenyaluran = Penyaluran::whereHas('penerima.warga', function ($q) use ($kab) {
            $q->where('kabupaten', $kab->nama_lengkap);
        })->count();

        if ($totalAnggaran == 0) {
            $status = 'belum_ada_anggaran';
        } elseif ($persentaseSerapan >= 90) {
            $status = 'hampir_habis';
        } elseif ($persentaseSerapan >= 50) {
            $status = 'normal';
        } else {
            $status = 'rendah';
        }

        // Hitung aliran dana berjenjang
        $diterimaDariProvinsi = DistribusiAnggaran::where('kabupaten_id', $kab->id)
            ->where('tahun', $tahun)
            ->where('status', 'terkirim')
            ->sum('jumlah');

        $diteruskanKeKecamatan = DistribusiAnggaran::where('created_by', $kab->id)
            ->where('tahun', $tahun)
            ->where('status', 'terkirim')
            ->sum('jumlah');

        $sisaMengendap = $diterimaDariProvinsi - $diteruskanKeKecamatan;

        if ($diterimaDariProvinsi == 0) {
            $statusAliran = 'belum_ada_dana';
        } elseif ($sisaMengendap <= 0) {
            $statusAliran = 'tersalur_penuh';
        } elseif ($sisaMengendap == $diterimaDariProvinsi) {
            $statusAliran = 'mengendap';
        } else {
            $statusAliran = 'sebagian';
        }

        return [
            'kabupaten_id'            => $kab->id,
            'nama_kabupaten'          => $kab->nama_lengkap,
            'total_anggaran'          => $totalAnggaran,
            'anggaran_terpakai'       => $terpakai,
            'sisa_anggaran'           => $sisa,
            'persentase_serapan'      => $persentaseSerapan,
            'total_warga'             => $totalWarga,
            'total_penerima'          => $totalPenerima,
            'total_penyaluran'        => $totalPenyaluran,
            'jumlah_penyaluran'       => $jumlahPenyaluran,
            'status'                  => $status,
            'diterima_dari_provinsi'  => $diterimaDariProvinsi,
            'diteruskan_ke_kecamatan' => $diteruskanKeKecamatan,
            'sisa_mengendap'          => $sisaMengendap,
            'status_aliran'           => $statusAliran,
        ];
    }

    public function showKelurahan(Request $request, $kabupatenId, $kecamatanId)
{
    $tahun     = $request->input('tahun', now()->year);
    $kabupaten = User::where('role', 'kabupaten')->findOrFail($kabupatenId);
    $kecamatan = User::where('role', 'kecamatan')->findOrFail($kecamatanId);

    $kelurahanList = User::where('role', 'kelurahan')
        ->where('kecamatan_id', $kecamatan->id)
        ->get();

    $monitoringKelurahan = $kelurahanList->map(function ($kel) use ($tahun) {

        $anggaran = \App\Models\AnggaranKelurahan::where('kelurahan_id', $kel->id)
            ->where('tahun', $tahun)
            ->first();

        $diterima = $anggaran->total_anggaran ?? 0;
        $terpakai = $anggaran->anggaran_terpakai ?? 0;
        $sisa     = $anggaran->sisa_anggaran ?? 0;

        if ($diterima == 0) {
            $statusAliran = 'belum_ada_dana';
        } elseif ($sisa <= 0) {
            $statusAliran = 'tersalur_penuh';
        } elseif ($sisa == $diterima) {
            $statusAliran = 'mengendap';
        } else {
            $statusAliran = 'sebagian';
        }

        return [
            'kelurahan_id'  => $kel->id,
            'kelurahan'     => $kel->nama_lengkap,
            'diterima'      => $diterima,
            'terpakai'      => $terpakai,
            'sisa'          => $sisa,
            'status_aliran' => $statusAliran,
        ];
    });

    return view('provinsi.monitoring.show-kelurahan', [
        'kabupaten'           => $kabupaten,
        'kecamatan'           => $kecamatan,
        'monitoringKelurahan' => $monitoringKelurahan,
        'tahun'               => $tahun,
    ]);
}
}