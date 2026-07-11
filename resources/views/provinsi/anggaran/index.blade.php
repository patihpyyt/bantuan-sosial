<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Alokasi Anggaran ke Kabupaten/Kota
        </h2>
    </x-slot>

    <div class="container-fluid py-4">

        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('anggaran.create') }}" class="btn btn-primary">
                + Anggaran Baru
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ================= RINGKASAN / SUMMARY CARDS ================= --}}
        @php
            $totalAnggaran       = $anggaran->sum('total_anggaran');
            $jumlahTransaksi     = $anggaran->count();
            $jumlahKabupatenUnik = $anggaran->pluck('kabupaten_id')->unique()->count();
            $tahunAktif          = $anggaran->pluck('tahun')->unique()->count();
        @endphp

        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <div class="card p-3 h-100 border-start border-primary border-4">
                    <small class="text-muted">Total Anggaran Dialokasikan</small>
                    <h5 class="mb-0">Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 h-100 border-start border-success border-4">
                    <small class="text-muted">Jumlah Transaksi</small>
                    <h5 class="mb-0">{{ number_format($jumlahTransaksi) }} transaksi</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 h-100 border-start border-info border-4">
                    <small class="text-muted">Kabupaten/Kota Menerima</small>
                    <h5 class="mb-0">{{ $jumlahKabupatenUnik }} wilayah</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 h-100 border-start border-secondary border-4">
                    <small class="text-muted">Tahun Anggaran Tercatat</small>
                    <h5 class="mb-0">{{ $tahunAktif }} tahun</h5>
                </div>
            </div>
        </div>

        {{-- ================= TABEL RIWAYAT ANGGARAN ================= --}}
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Kabupaten/Kota</th>
                            <th>Tahun</th>
                            <th class="text-end">Jumlah Anggaran</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggaran as $item)
                        <tr>
                            <td>{{ optional($item->created_at)->format('d-m-Y') ?? '-' }}</td>
                            <td>{{ $item->kabupaten->nama_lengkap ?? 'Data terhapus' }}</td>
                            <td>{{ $item->tahun ?? '-' }}</td>
                            <td class="text-end">Rp {{ number_format($item->total_anggaran, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <a href="{{ route('anggaran.edit', $item->id) }}"
                                   class="btn btn-sm btn-outline-primary" title="Edit anggaran">
                                    Edit
                                </a>
                                <form action="{{ route('anggaran.destroy', $item->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin hapus alokasi anggaran Rp {{ number_format($item->total_anggaran, 0, ',', '.') }} untuk {{ $item->kabupaten->nama_lengkap ?? '' }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada data anggaran yang tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($anggaran->count() > 0)
                    <tfoot>
                        <tr class="fw-bold table-light">
                            <td colspan="3" class="text-end">Total Anggaran:</td>
                            <td class="text-end">Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</x-app-layout>