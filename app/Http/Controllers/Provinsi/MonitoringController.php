<?php

namespace App\Http\Controllers\Provinsi;

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
    /**
     * Halaman utama: ringkasan monitoring seluruh Kabupaten/Kota.
     */
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

        // Ringkasan total seluruh provinsi
        $summary = [
            'total_anggaran'   => $monitoring->sum('total_anggaran'),
            'total_terpakai'   => $monitoring->sum('anggaran_terpakai'),
            'total_sisa'       => $monitoring->sum('sisa_anggaran'),
            'total_warga'      => $monitoring->sum('total_warga'),
            'total_penerima'   => $monitoring->sum('total_penerima'),
            'total_penyaluran' => $monitoring->sum('total_penyaluran'),
        ];

        return view('provinsi.monitoring.index', [
            'monitoring'     => $monitoring,
            'summary'        => $summary,
            'tahun'          => $tahun,
            'tahunTersedia'  => $tahunTersedia,
        ]);
    }

    /**
     * Drill-down: detail monitoring per Kecamatan dalam satu Kabupaten/Kota.
     */
    public function show(Request $request, $kabupatenId)
    {
        $tahun     = $request->input('tahun', now()->year);
        $kabupaten = User::where('role', 'kabupaten')->findOrFail($kabupatenId);

        $dataKabupaten = $this->hitungDataKabupaten($kabupaten, $tahun);

        $kecamatanList = Warga::where('kabupaten', $kabupaten->name)
            ->whereNotNull('kecamatan')
            ->select('kecamatan')
            ->distinct()
            ->pluck('kecamatan');

        $monitoringKecamatan = $kecamatanList->map(function ($kecamatan) use ($kabupaten) {

            $totalWarga = Warga::where('kabupaten', $kabupaten->name)
                ->where('kecamatan', $kecamatan)
                ->count();

            $totalPenerima = PenerimaBansos::whereHas('warga', function ($q) use ($kabupaten, $kecamatan) {
                $q->where('kabupaten', $kabupaten->name)
                  ->where('kecamatan', $kecamatan);
            })->count();

            $totalPenyaluran = Penyaluran::whereHas('penerima.warga', function ($q) use ($kabupaten, $kecamatan) {
                $q->where('kabupaten', $kabupaten->name)
                  ->where('kecamatan', $kecamatan);
            })->sum('nominal');

            $jumlahTransaksi = Penyaluran::whereHas('penerima.warga', function ($q) use ($kabupaten, $kecamatan) {
                $q->where('kabupaten', $kabupaten->name)
                  ->where('kecamatan', $kecamatan);
            })->count();

            return [
                'kecamatan'        => $kecamatan,
                'total_warga'      => $totalWarga,
                'total_penerima'   => $totalPenerima,
                'total_penyaluran' => $totalPenyaluran,
                'jumlah_transaksi' => $jumlahTransaksi,
            ];
        });

        return view('provinsi.monitoring.show', [
            'kabupaten'           => $kabupaten,
            'dataKabupaten'       => $dataKabupaten,
            'monitoringKecamatan' => $monitoringKecamatan,
            'tahun'               => $tahun,
        ]);
    }

    /**
     * Data grafik tren penyaluran per bulan (dipakai via AJAX/fetch di view).
     */
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

        // Isi bulan yang kosong dengan 0 supaya grafik tetap 12 titik
        $hasil = collect(range(1, 12))->map(function ($bulan) use ($data) {
            $item = $data->firstWhere('bulan', $bulan);
            return [
                'bulan' => $bulan,
                'total' => $item->total ?? 0,
            ];
        });

        return response()->json($hasil);
    }

    /**
     * Export data monitoring ke CSV sederhana.
     */
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

    /**
     * Helper: hitung semua metrik monitoring untuk satu kabupaten.
     */
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

        $totalWarga = Warga::where('kabupaten', $kab->name)->count();

        $totalPenerima = PenerimaBansos::whereHas('warga', function ($q) use ($kab) {
            $q->where('kabupaten', $kab->name);
        })->count();

        $totalPenyaluran = Penyaluran::whereHas('penerima.warga', function ($q) use ($kab) {
            $q->where('kabupaten', $kab->name);
        })->sum('nominal');

        $jumlahPenyaluran = Penyaluran::whereHas('penerima.warga', function ($q) use ($kab) {
            $q->where('kabupaten', $kab->name);
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

        return [
            'kabupaten_id'       => $kab->id,
            'nama_kabupaten'     => $kab->name,
            'total_anggaran'     => $totalAnggaran,
            'anggaran_terpakai'  => $terpakai,
            'sisa_anggaran'      => $sisa,
            'persentase_serapan' => $persentaseSerapan,
            'total_warga'        => $totalWarga,
            'total_penerima'     => $totalPenerima,
            'total_penyaluran'   => $totalPenyaluran,
            'jumlah_penyaluran'  => $jumlahPenyaluran,
            'status'             => $status,
        ];
    }
}