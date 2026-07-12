<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Menerima Dana dari Kabupaten
        </h2>
    </x-slot>

    <div class="container-fluid py-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-3 mb-3">

            <div class="col-md-4">
                <div class="card border-start border-primary border-4 shadow-sm">
                    <div class="card-body">
                        <h6>Total Dana Diterima</h6>
                        <h3 class="text-primary">
                            Rp {{ number_format($totalDana, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-start border-success border-4 shadow-sm">
                    <div class="card-body">
                        <h6>Total Distribusi</h6>
                        <h3 class="text-success">
                            {{ $totalDistribusi }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-start border-warning border-4 shadow-sm">
                    <div class="card-body">
                        <h6>Distribusi Bulan Ini</h6>
                        <h3 class="text-warning">
                            {{ $bulanIni }}
                        </h3>
                    </div>
                </div>
            </div>

        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                Riwayat Dana dari Kabupaten
            </div>

            <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Tahun</th>
                            <th>Jumlah Dana</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($distribusi as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_distribusi)->format('d-m-Y') }}</td>
                                <td>{{ $item->tahun }}</td>
                                <td class="text-end">
                                    Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if($item->status == 'terkirim')
                                        <span class="badge bg-primary">Terkirim</span>
                                    @elseif($item->status == 'diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @else
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @endif
                                </td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Belum ada dana yang diterima dari Kabupaten.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>