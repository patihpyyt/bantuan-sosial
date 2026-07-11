<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Data Penyaluran Bansos
        </h2>
    </x-slot>

    <div class="container-fluid py-4">

        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('penyaluran.create') }}" class="btn btn-primary">
                + Penyaluran Baru
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

        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal Salur</th>
                            <th>Penerima</th>
                            <th class="text-end">Nominal</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penyaluran as $p)
                        <tr>
                            <td>{{ optional($p->tanggal_salur)->format('d-m-Y') ?? '-' }}</td>
                            <td>{{ $p->penerima->warga->nama_lengkap ?? 'Data terhapus' }}</td>
                            <td class="text-end">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                            <td>
                                @if($p->status === 'tersalur')
                                    <span class="badge bg-success">Tersalur</span>
                                @elseif($p->status === 'tertunda')
                                    <span class="badge bg-warning text-dark">Tertunda</span>
                                @else
                                    <span class="badge bg-danger">Gagal</span>
                                @endif
                            </td>
                            <td>{{ $p->keterangan ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('penyaluran.edit', $p->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('penyaluran.destroy', $p->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin hapus data penyaluran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada data penyaluran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>