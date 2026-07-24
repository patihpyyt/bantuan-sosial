<x-app-layout>
    <x-slot name="header">
        <div>
            <nav class="text-xs font-semibold text-slate-400 mb-2">
                <a href="{{ route('provinsi.monitoring.index', ['tahun' => $tahun]) }}" class="hover:text-blue-600">Monitoring</a>
                <span class="mx-1">/</span>
                <span class="text-slate-700">{{ $kabupaten->nama_lengkap }}</span>
            </nav>
            <h2 class="font-extrabold text-2xl text-slate-900 leading-tight">
                Monitoring {{ $kabupaten->nama_lengkap }}
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Rincian aliran dana dan cakupan bantuan per Kecamatan.
            </p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- ================= RINGKASAN ALIRAN DANA KABUPATEN ================= --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-blue-600">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Diterima dari Provinsi</p>
                <p class="text-xl font-black text-slate-900">
                    Rp {{ number_format($dataKabupaten['diterima_dari_provinsi'], 0, ',', '.') }}
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-emerald-600">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Diteruskan ke Kecamatan</p>
                <p class="text-xl font-black text-slate-900">
                    Rp {{ number_format($dataKabupaten['diteruskan_ke_kecamatan'], 0, ',', '.') }}
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-amber-500">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Sisa Mengendap</p>
                <p class="text-xl font-black text-slate-900">
                    Rp {{ number_format($dataKabupaten['sisa_mengendap'], 0, ',', '.') }}
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-cyan-600">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Penerima</p>
                <p class="text-xl font-black text-slate-900">
                    {{ number_format($dataKabupaten['total_penerima'], 0, ',', '.') }} <span class="text-xs text-slate-400">warga</span>
                </p>
            </div>
        </div>

        {{-- ================= FILTER TAHUN ================= --}}
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm w-full sm:w-auto inline-block">
            <form method="GET" class="flex items-center gap-2">
                <select name="tahun" onchange="this.form.submit()"
                    class="block rounded-xl border-slate-200 text-sm font-semibold text-slate-700 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition pr-10 pl-4 py-2">
                    <option value="{{ $tahun }}" selected>Tahun {{ $tahun }}</option>
                </select>
            </form>
        </div>

        {{-- ================= TABEL PER KECAMATAN ================= --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="px-6 py-4">Kecamatan</th>
                            <th class="px-6 py-4 text-right">Diterima</th>
                            <th class="px-6 py-4 text-right">Diteruskan</th>
                            <th class="px-6 py-4 text-right">Sisa</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700 bg-white">
                        @forelse($monitoringKecamatan as $kec)
                            @php
                                $badge = match($kec['status_aliran']) {
                                    'tersalur_penuh' => ['bg-emerald-50 text-emerald-700', 'Tersalur Penuh'],
                                    'sebagian'       => ['bg-amber-50 text-amber-700', 'Sebagian'],
                                    'mengendap'      => ['bg-red-50 text-red-700', 'Mengendap'],
                                    default          => ['bg-slate-100 text-slate-400', 'Belum Ada Dana'],
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $kec['kecamatan'] }}</td>
                                <td class="px-6 py-4 text-right font-semibold text-slate-600">
                                    Rp {{ number_format($kec['diterima'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right font-semibold text-blue-600">
                                    Rp {{ number_format($kec['diteruskan'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right font-semibold {{ $kec['sisa'] > 0 ? 'text-amber-600' : 'text-slate-400' }}">
                                    Rp {{ number_format($kec['sisa'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-bold {{ $badge[0] }}">
                                        {{ $badge[1] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center">
                                        <a href="{{ route('provinsi.monitoring.show-kelurahan', ['kabupatenId' => $kabupaten->id, 'kecamatanId' => $kec['kecamatan_id'], 'tahun' => $tahun]) }}"
                                           class="inline-flex items-center px-4 py-2 rounded-xl border border-blue-100 bg-blue-50/50 hover:bg-blue-50 text-xs font-bold text-blue-600 shadow-sm transition">
                                            Detail per Kelurahan &rarr;
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-slate-400 font-medium py-12 bg-slate-50/20">
                                    Belum ada data kecamatan untuk kabupaten ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>