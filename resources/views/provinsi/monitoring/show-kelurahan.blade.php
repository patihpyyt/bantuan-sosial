<x-app-layout>
    <x-slot name="header">
        <div>
            <nav class="text-xs font-semibold text-slate-400 mb-2">
                <a href="{{ route('provinsi.monitoring.index', ['tahun' => $tahun]) }}" class="hover:text-blue-600">Monitoring</a>
                <span class="mx-1">/</span>
                <a href="{{ route('provinsi.monitoring.show', ['kabupatenId' => $kabupaten->id, 'tahun' => $tahun]) }}" class="hover:text-blue-600">{{ $kabupaten->nama_lengkap }}</a>
                <span class="mx-1">/</span>
                <span class="text-slate-700">{{ $kecamatan->nama_lengkap }}</span>
            </nav>
            <h2 class="font-extrabold text-2xl text-slate-900 leading-tight">
                Monitoring {{ $kecamatan->nama_lengkap }}
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Rincian dana yang diterima dan digunakan di tiap Kelurahan.
            </p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- ================= TABEL PER KELURAHAN ================= --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="px-6 py-4">Kelurahan</th>
                            <th class="px-6 py-4 text-right">Diterima</th>
                            <th class="px-6 py-4 text-right">Terpakai</th>
                            <th class="px-6 py-4 text-right">Sisa</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700 bg-white">
                        @forelse($monitoringKelurahan as $kel)
                            @php
                                $badge = match($kel['status_aliran']) {
                                    'tersalur_penuh' => ['bg-emerald-50 text-emerald-700', 'Sudah Digunakan Penuh'],
                                    'sebagian'       => ['bg-amber-50 text-amber-700', 'Sebagian Terpakai'],
                                    'mengendap'      => ['bg-red-50 text-red-700', 'Belum Digunakan'],
                                    default          => ['bg-slate-100 text-slate-400', 'Belum Ada Dana'],
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $kel['kelurahan'] }}</td>
                                <td class="px-6 py-4 text-right font-semibold text-slate-600">
                                    Rp {{ number_format($kel['diterima'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right font-semibold text-blue-600">
                                    Rp {{ number_format($kel['terpakai'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right font-semibold {{ $kel['sisa'] > 0 ? 'text-amber-600' : 'text-slate-400' }}">
                                    Rp {{ number_format($kel['sisa'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-bold {{ $badge[0] }}">
                                        {{ $badge[1] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-slate-400 font-medium py-12 bg-slate-50/20">
                                    Belum ada data kelurahan untuk kecamatan ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>