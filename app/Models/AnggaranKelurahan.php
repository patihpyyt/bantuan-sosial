<?php

namespace App\Models;

use App\Models\DistribusiKelurahan;

use Illuminate\Database\Eloquent\Model;

class AnggaranKelurahan extends Model
{
    protected $table = 'anggaran_kelurahan';

    protected $fillable = [
        'kelurahan_id', 'kecamatan_id', 'tahun',
        'total_anggaran', 'anggaran_terpakai', 'sisa_anggaran',
    ];

    public function showKelurahan(Request $request, $kabupatenId, $kecamatanId)
{
    $tahun     = $request->input('tahun', now()->year);
    $kabupaten = User::where('role', 'kabupaten')->findOrFail($kabupatenId);
    $kecamatan = User::where('role', 'kecamatan')->findOrFail($kecamatanId);

    $kelurahanList = User::where('role', 'kelurahan')
        ->where('kecamatan_id', $kecamatan->id)
        ->get();

    $monitoringKelurahan = $kelurahanList->map(function ($kel) use ($tahun) {

        $anggaran = AnggaranKelurahan::where('kelurahan_id', $kel->id)
            ->where('tahun', $tahun)
            ->first();

        $diterima  = $anggaran->total_anggaran ?? 0;
        $terpakai  = $anggaran->anggaran_terpakai ?? 0;
        $sisa      = $anggaran->sisa_anggaran ?? 0;

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
            'kelurahan_id'   => $kel->id,
            'kelurahan'      => $kel->nama_lengkap,
            'diterima'       => $diterima,
            'terpakai'       => $terpakai,
            'sisa'           => $sisa,
            'status_aliran'  => $statusAliran,
        ];
    });

    return view('provinsi.monitoring.show-kelurahan', [
        'kabupaten'            => $kabupaten,
        'kecamatan'            => $kecamatan,
        'monitoringKelurahan'  => $monitoringKelurahan,
        'tahun'                => $tahun,
    ]);
}
}