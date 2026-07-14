<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Monitoring Kelurahan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Filter Tahun --}}
            <div class="flex justify-end">
                <form method="GET" class="flex gap-2">
                    <select name="tahun"
                        class="rounded-lg border-gray-200 text-sm text-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        onchange="this.form.submit()">
                        @for($y = now()->year; $y >= now()->year - 5; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </form>
            </div>

            {{-- Ringkasan Cards --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xs font-bold tracking-wide text-gray-400 uppercase mb-4">
                    Ringkasan Anggaran Kelurahan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    <div class="bg-gray-50 rounded-xl border-l-4 border-blue-500 pl-4 py-4 pr-4">
                        <div class="text-xs font-semibold tracking-wide text-gray-400 uppercase mb-1">
                            Total Kelurahan
                        </div>
                        <div class="text-xl font-bold text-gray-900">
                            {{ $totalKelurahan }}
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl border-l-4 border-amber-500 pl-4 py-4 pr-4">
                        <div class="text-xs font-semibold tracking-wide text-gray-400 uppercase mb-1">
                            Total Anggaran
                        </div>
                        <div class="text-xl font-bold text-gray-900">
                            Rp {{ number_format($totalDana, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl border-l-4 border-emerald-500 pl-4 py-4 pr-4">
                        <div class="text-xs font-semibold tracking-wide text-gray-400 uppercase mb-1">
                            Anggaran Terpakai
                        </div>
                        <div class="text-xl font-bold text-gray-900">
                            Rp {{ number_format($totalTerpakai, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl border-l-4 border-rose-500 pl-4 py-4 pr-4">
                        <div class="text-xs font-semibold tracking-wide text-gray-400 uppercase mb-1">
                            Sisa Anggaran
                        </div>
                        <div class="text-xl font-bold text-gray-900">
                            Rp {{ number_format($totalSisa, 0, ',', '.') }}
                        </div>
                    </div>

                </div>
            </div>

            {{-- Tabel Monitoring --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-xs font-bold tracking-wide text-gray-400 uppercase">
                        Detail Anggaran per Kelurahan
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Rincian anggaran, pemakaian, dan distribusi dana tiap kelurahan
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-gray-400 uppercase">#</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-gray-400 uppercase">Kelurahan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-gray-400 uppercase">Total Anggaran</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-gray-400 uppercase">Anggaran Terpakai</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-gray-400 uppercase">Sisa Anggaran</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-gray-400 uppercase">Total Distribusi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($monitoring as $i => $item)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $i + 1 }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $item->nama_lengkap }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">Rp {{ number_format($item->total_anggaran, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">Rp {{ number_format($item->anggaran_terpakai, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">Rp {{ number_format($item->sisa_anggaran, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">Rp {{ number_format($item->total_distribusi, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5A1.5 1.5 0 014.5 6h4.379a1.5 1.5 0 011.06.44l1.122 1.12a1.5 1.5 0 001.06.44H19.5A1.5 1.5 0 0121 9.5v7A1.5 1.5 0 0119.5 18h-15A1.5 1.5 0 013 16.5v-9z" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-500">
                                                Belum ada data kelurahan.
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>