<x-app-layout>
    <x-slot name="header">
        Monitoring Kecamatan
    </x-slot>

    <div class="p-6">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-xl font-bold text-slate-800">Monitoring Kecamatan</h1>
            <p class="text-sm text-slate-500 mt-1">
                Pantau seluruh rekam jejak anggaran dan distribusi dana tiap Kecamatan Tahun {{ $tahun }}.
            </p>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            {{-- Total Anggaran --}}
            <div class="bg-white rounded-xl border-l-4 border-blue-500 shadow-sm px-6 py-5">
                <p class="text-xs font-semibold tracking-wide text-slate-400 uppercase">
                    Total Anggaran
                </p>
                <p class="text-2xl font-bold text-slate-800 mt-1">
                    Rp {{ number_format($monitoring->sum('total_anggaran'), 0, ',', '.') }}
                </p>
            </div>

            {{-- Terpakai --}}
            <div class="bg-white rounded-xl border-l-4 border-emerald-500 shadow-sm px-6 py-5">
                <p class="text-xs font-semibold tracking-wide text-slate-400 uppercase">
                    Total Terpakai
                </p>
                <p class="text-2xl font-bold text-slate-800 mt-1">
                    Rp {{ number_format($monitoring->sum('anggaran_terpakai'), 0, ',', '.') }}
                </p>
            </div>

            {{-- Distribusi --}}
            <div class="bg-white rounded-xl border-l-4 border-amber-500 shadow-sm px-6 py-5">
                <p class="text-xs font-semibold tracking-wide text-slate-400 uppercase">
                    Total Distribusi ({{ $tahun }})
                </p>
                <p class="text-2xl font-bold text-slate-800 mt-1">
                    Rp {{ number_format($monitoring->sum('total_distribusi'), 0, ',', '.') }}
                </p>
            </div>

        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-100">

            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="text-xs font-bold tracking-wide text-slate-500 uppercase">
                    Riwayat Anggaran per Kecamatan
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="text-left text-xs font-semibold tracking-wide text-slate-400 uppercase">
                            <th class="px-6 py-3">Kecamatan</th>
                            <th class="px-6 py-3">Total Anggaran</th>
                            <th class="px-6 py-3">Terpakai</th>
                            <th class="px-6 py-3">Sisa</th>
                            <th class="px-6 py-3">Total Distribusi ({{ $tahun }})</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($monitoring as $item)
                            <tr class="border-t border-slate-100 hover:bg-slate-50">
                                <td class="px-6 py-3 font-medium text-slate-700">
                                    {{ $item->nama_lengkap }}
                                </td>
                                <td class="px-6 py-3 text-slate-600">
                                    Rp {{ number_format($item->total_anggaran, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-3 text-slate-600">
                                    Rp {{ number_format($item->anggaran_terpakai, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-3 text-slate-600">
                                    Rp {{ number_format($item->sisa_anggaran, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-3 text-slate-600">
                                    Rp {{ number_format($item->total_distribusi, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-16">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mb-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 7l1.5 12.5A2 2 0 0 0 6.49 21h11.02a2 2 0 0 0 1.99-1.5L21 7M3 7l2-4h14l2 4M9 11h6" />
                                        </svg>
                                        <p class="text-sm">Belum ada data kecamatan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</x-app-layout>