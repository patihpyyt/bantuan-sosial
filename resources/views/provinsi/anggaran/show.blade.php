<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Detail Alokasi Anggaran
        </h2>
    </x-slot>

    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('anggaran.index') }}" class="btn btn-outline-secondary btn-sm">
                &larr; Kembali ke Daftar Anggaran
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('anggaran.edit', $anggaran->id) }}" class="btn btn-sm btn-outline-primary">
                    Edit
                </a>
                <form action="{{ route('anggaran.destroy', $anggaran->id) }}" method="POST"
                      onsubmit="return confirm('Yakin hapus alokasi anggaran ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-3">

            {{-- ================= RINGKASAN UTAMA ================= --}}
            <div class="col-md-4">
                <div class="card p-3 h-100 border-start border-primary border-4">
                    <small class="text-muted">Kabupaten/Kota Tujuan</small>
                    <h5 class="mb-0">{{ $anggaran->kabupaten->name ?? 'Data terhapus' }}</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 h-100 border-start border-success border-4">
                    <small class="text-muted">Jumlah Anggaran</small>
                    <h5 class="mb-0">Rp {{ number_format($anggaran->jumlah, 0, ',', '.') }}</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 h-100 border-start border-info border-4">
                    <small class="text-muted">Tahun Anggaran</small>
                    <h5 class="mb-0">{{ $anggaran->tahun ?? '-' }}</h5>
                </div>
            </div>

            {{-- ================= DETAIL LENGKAP ================= --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-muted" style="width: 220px;">Keterangan</td>
                                    <td>{{ $anggaran->keterangan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tanggal Dibuat</td>
                                    <td>{{ optional($anggaran->created_at)->format('d-m-Y H:i') ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Terakhir Diperbarui</td>
                                    <td>{{ optional($anggaran->updated_at)->format('d-m-Y H:i') ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>