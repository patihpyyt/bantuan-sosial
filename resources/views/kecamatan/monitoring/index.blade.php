<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Monitoring Kelurahan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end mb-4">
                <form method="GET" class="flex gap-2">
                    <select name="tahun" class="form-select" onchange="this.form.submit()">
                        @for($y = now()->year; $y >= now()->year - 5; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white shadow-sm rounded-lg p-4 text-center">
                    <div class="text-gray-500 text-sm">Total Kelurahan</div>
                    <div class="text-xl font-bold">{{ $totalKelurahan }}</div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-4 text-center">
                    <div class="text-gray-500 text-sm">Total Anggaran</div>
                    <div class="text-lg font-bold">Rp {{ number_format($totalDana, 0, ',', '.') }}</div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-4 text-center">
                    <div class="text-gray-500 text-sm">Anggaran Terpakai</div>
                    <div class="text-lg font-bold">Rp {{ number_format($totalTerpakai, 0, ',', '.') }}</div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-4 text-center">
                    <div class="text-gray-500 text-sm">Sisa Anggaran</div>
                    <div class="text-lg font-bold">Rp {{ number_format($totalSisa, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <table class="table table-striped align-middle w-full">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kelurahan</th>
                            <th>Total Anggaran</th>
                            <th>Anggaran Terpakai</th>
                            <th>Sisa Anggaran</th>
                            <th>Total Distribusi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($monitoring as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->nama_lengkap }}</td>
                                <td>Rp {{ number_format($item->total_anggaran, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->anggaran_terpakai, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->sisa_anggaran, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->total_distribusi, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-400">Belum ada data kelurahan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>