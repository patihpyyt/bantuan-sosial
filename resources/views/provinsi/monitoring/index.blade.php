<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Monitoring Bantuan Sosial per Kabupaten/Kota
        </h2>
    </x-slot>

    <div class="container-fluid py-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ================= RINGKASAN / SUMMARY CARDS ================= --}}
        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <div class="card p-3 h-100 border-start border-primary border-4">
                    <small class="text-muted">Total Warga Terdata</small>
                    <h5 class="mb-0">{{ number_format($summary['total_warga'] ?? 0) }} warga</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 h-100 border-start border-success border-4">
                    <small class="text-muted">Total Penerima Bantuan</small>
                    <h5 class="mb-0">{{ number_format($summary['total_penerima'] ?? 0) }} penerima</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 h-100 border-start border-info border-4">
                    <small class="text-muted">Total Penyaluran</small>
                    <h5 class="mb-0">{{ number_format($summary['total_penyaluran'] ?? 0) }} kali salur</h5>
                </div>
            </div>
        </div>

        {{-- ================= FILTER TAHUN ================= --}}
        <form method="GET" class="mb-3 d-flex gap-2 flex-wrap align-items-center">
            <select name="tahun" class="form-select w-auto" onchange="this.form.submit()">
                @forelse($tahunTersedia as $t)
                    <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>Tahun {{ $t }}</option>
                @empty
                    <option value="{{ $tahun }}" selected>Tahun {{ $tahun }}</option>
                @endforelse
            </select>
        </form>

        {{-- ================= TABEL MONITORING PER KABUPATEN/KOTA ================= --}}
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kabupaten/Kota</th>
                            <th class="text-end">Total Warga</th>
                            <th class="text-end">Total Penerima</th>
                            <th class="text-end">Total Penyaluran</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($monitoring as $m)
                        <tr>
                            <td>{{ $m->kabupaten->name ?? $m->name ?? 'Data terhapus' }}</td>
                            <td class="text-end">{{ number_format($m->total_warga ?? 0) }}</td>
                            <td class="text-end">{{ number_format($m->total_penerima ?? 0) }}</td>
                            <td class="text-end">{{ number_format($m->total_penyaluran ?? 0) }}</td>
                            <td class="text-center">
                                <a href="{{ route('provinsi.monitoring.show', ['kabupatenId' => $m->kabupaten_id ?? $m->id, 'tahun' => $tahun]) }}"
                                   class="btn btn-sm btn-outline-primary" title="Lihat rincian per kecamatan">
                                    Detail per Kecamatan
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada data monitoring untuk tahun {{ $tahun }}.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>