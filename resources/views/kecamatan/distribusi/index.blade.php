<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Distribusi ke Kelurahan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end mb-4">
                <a href="{{ route('kecamatan.distribusi.create') }}" class="btn btn-primary">
                    + Distribusi Baru
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">
                <table class="table table-striped align-middle w-full">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kelurahan</th>
                            <th>Tahun</th>
                            <th>Jumlah</th>
                            <th>Tanggal Distribusi</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($distribusi as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->kelurahan->nama_lengkap ?? '-' }}</td>
                                <td>{{ $item->tahun }}</td>
                                <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_distribusi)->format('d-m-Y') }}</td>
                                <td>
                                    <span class="badge {{ $item->status === 'terkirim' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-gray-400">Belum ada data distribusi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>