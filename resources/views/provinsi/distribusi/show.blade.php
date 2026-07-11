<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Monitoring Kecamatan — {{ $kabupaten->name }}
        </h2>
    </x-slot>

    <div class="container-fluid py-4">

        <a href="{{ route('provinsi.monitoring.index', ['tahun' => $tahun]) }}" class="btn btn-sm btn-secondary mb-3">
            ← Kembali
        </a>

        <p class="text-muted mb-4">Tahun {{ $tahun }}</p>

        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <div class="card p-3">
                    <small class="text-muted">Total Anggaran</small>
                    <h5>Rp {{ number_format($dataKabupaten['total_anggaran'], 0, ',', '.') }}</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <small class="text-muted">Serapan</small>
                    <h5>{{ $dataKabupaten['persentase_serapan'] }}%</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <small class="text-muted">Total Warga</small>
                    <h5>{{ number_format($dataKabupaten['total_warga']) }}</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <small class="text-muted">Total Penerima</small>
                    <h5>{{ number_format($dataKabupaten['total_penerima']) }}</h5>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kecamatan</th>
                            <th>Total Warga</th>
                            <th>Total Penerima</th>
                            <th>Total Penyaluran</th>
                            <th>Jumlah Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($monitoringKecamatan as $kec)
                        <tr>
                            <td>{{ $kec['kecamatan'] }}</td>
                            <td>{{ number_format($kec['total_warga']) }}</td>
                            <td>{{ number_format($kec['total_penerima']) }}</td>
                            <td>Rp {{ number_format($kec['total_penyaluran'], 0, ',', '.') }}</td>
                            <td>{{ number_format($kec['jumlah_transaksi']) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data kecamatan untuk kabupaten ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>