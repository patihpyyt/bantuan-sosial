<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Distribusi ke Kabupaten/Kota
        </h2>
    </x-slot>

    <div class="container-fluid py-4">

        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('provinsi.distribusi.create') }}" class="btn btn-primary">
                + Distribusi Baru
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

        {{-- ================= RINGKASAN / SUMMARY CARDS (dihitung dari koleksi $distribusi) ================= --}}
        @php
            $totalDistribusiAktif = $distribusi->where('status', 'terkirim')->sum('jumlah');
            $totalDistribusiBatal = $distribusi->where('status', 'dibatalkan')->sum('jumlah');
            $jumlahTransaksi      = $distribusi->count();
            $jumlahKabupatenUnik  = $distribusi->where('status', 'terkirim')->pluck('kabupaten_id')->unique()->count();
        @endphp

        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <div class="card p-3 h-100 border-start border-primary border-4">
                    <small class="text-muted">Total Dana Terdistribusi</small>
                    <h5 class="mb-0">Rp {{ number_format($totalDistribusiAktif, 0, ',', '.') }}</h5>
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
                    <h5 class="mb-0">{{ $jumlahKabupatenUnik }} / {{ $kabupatenList->count() }} wilayah</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 h-100 border-start border-secondary border-4">
                    <small class="text-muted">Dana Dibatalkan</small>
                    <h5 class="mb-0">Rp {{ number_format($totalDistribusiBatal, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>

        {{-- ================= FILTER ================= --}}
        <form method="GET" class="mb-3 d-flex gap-2 flex-wrap align-items-center">
            <select name="tahun" class="form-select w-auto" onchange="this.form.submit()">
                @forelse($tahunTersedia as $t)
                    <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>Tahun {{ $t }}</option>
                @empty
                    <option value="{{ $tahun }}" selected>Tahun {{ $tahun }}</option>
                @endforelse
            </select>

            <select name="kabupaten_id" class="form-select w-auto" onchange="this.form.submit()">
                <option value="">Semua Kabupaten/Kota</option>
                @foreach($kabupatenList as $kab)
                    <option value="{{ $kab->id }}" {{ (string) $filterKabupaten === (string) $kab->id ? 'selected' : '' }}>
                        {{ $kab->name }}
                    </option>
                @endforeach
            </select>

            @if($filterKabupaten)
                <a href="{{ route('provinsi.distribusi.index', ['tahun' => $tahun]) }}" class="btn btn-sm btn-outline-secondary">
                    Reset Filter
                </a>
            @endif
        </form>

        {{-- ================= TABEL RIWAYAT ================= --}}
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Kabupaten/Kota</th>
                            <th class="text-end">Jumlah</th>
                            <th>Keterangan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($distribusi as $d)
                        <tr class="{{ $d->status === 'dibatalkan' ? 'table-secondary text-muted' : '' }}">
                            <td>{{ optional($d->tanggal_distribusi)->format('d-m-Y') ?? '-' }}</td>
                            <td>{{ $d->kabupaten->name ?? 'Data terhapus' }}</td>
                            <td class="text-end">Rp {{ number_format($d->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $d->keterangan ?? '-' }}</td>
                            <td class="text-center">
                                @if($d->status === 'terkirim')
                                    <span class="badge bg-success">Terkirim</span>
                                @else
                                    <span class="badge bg-secondary">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('provinsi.distribusi.show', $d->kabupaten_id) }}"
                                   class="btn btn-sm btn-outline-primary" title="Lihat riwayat kabupaten ini">
                                    Riwayat
                                </a>
                                @if($d->status === 'terkirim')
                                <form action="{{ route('provinsi.distribusi.cancel', $d->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin batalkan distribusi Rp {{ number_format($d->jumlah, 0, ',', '.') }} ke {{ $d->kabupaten->name ?? '' }}?')">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-outline-danger">Batalkan</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada distribusi untuk tahun {{ $tahun }}
                                @if($filterKabupaten) pada kabupaten ini @endif.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($distribusi->count() > 0)
                    <tfoot>
                        <tr class="fw-bold table-light">
                            <td colspan="2" class="text-end">Total (status terkirim):</td>
                            <td class="text-end">Rp {{ number_format($totalDistribusiAktif, 0, ',', '.') }}</td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</x-app-layout>