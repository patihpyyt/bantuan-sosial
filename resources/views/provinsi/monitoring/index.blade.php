<x-app-layout>
    {{-- HEADER HALAMAN --}}
    <x-slot name="header">
        <div>
            <h2 class="font-extrabold text-2xl text-slate-900 leading-tight">
                Monitoring Bantuan Sosial per Kabupaten/Kota
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Pantau sebaran data warga terdata, cakupan penerima aktif, dan intensitas volume penyaluran bansos.
            </p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- NOTIFIKASI / ALERTS --}}
        @if(session('success'))
            <div class="flex items-center justify-between bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold p-4 rounded-xl shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- ================= RINGKASAN DATA / SUMMARY CARDS ================= --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            {{-- TOTAL WARGA TERDATA --}}
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-blue-600">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Warga Terdata</p>
                <p class="text-2xl font-black text-slate-900">
                    {{ number_format($summary['total_warga'] ?? 0, 0, ',', '.') }} <span class="text-xs font-bold text-slate-400 uppercase">warga</span>
                </p>
            </div>

            {{-- TOTAL PENERIMA BANTUAN --}}
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-emerald-600">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Penerima Bantuan</p>
                <p class="text-2xl font-black text-slate-900">
                    {{ number_format($summary['total_penerima'] ?? 0, 0, ',', '.') }} <span class="text-xs font-bold text-slate-400 uppercase">penerima</span>
                </p>
            </div>

            {{-- TOTAL PENYALURAN --}}
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-cyan-600">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Penyaluran</p>
                <p class="text-2xl font-black text-slate-900">
                    {{ number_format($summary['total_penyaluran'] ?? 0, 0, ',', '.') }} <span class="text-xs font-bold text-slate-400 uppercase">kali salur</span>
                </p>
            </div>
        </div>

        {{-- ================= FILTER TAHUN ANGGARAN ================= --}}
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm w-full sm:w-auto inline-block">
            <form method="GET" class="flex items-center gap-2">
                <select name="tahun" onchange="this.form.submit()"
                    class="block rounded-xl border-slate-200 text-sm font-semibold text-slate-700 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition pr-10 pl-4 py-2">
                    @forelse($tahunTersedia as $t)
                        <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>Tahun {{ $t }}</option>
                    @empty
                        <option value="{{ $tahun }}" selected>Tahun {{ $tahun }}</option>
                    @endforelse
                </select>
            </form>
        </div>

        {{-- ================= TABEL MONITORING UTAMA ================= --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="px-6 py-4">Kabupaten/Kota</th>
                            <th class="px-6 py-4 text-right">Total Warga</th>
                            <th class="px-6 py-4 text-right">Total Penerima</th>
                            <th class="px-6 py-4 text-right">Total Penyaluran</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700 bg-white">
                        @forelse($monitoring as $m)
                            <tr class="hover:bg-slate-50/50 transition">
                                {{-- NAMA WILAYAH --}}
                                <td class="px-6 py-4 font-bold text-slate-900">
                                    {{ $m['nama_kabupaten'] ?? 'Data terhapus' }}
                                </td>
                                {{-- TOTAL WARGA --}}
                                <td class="px-6 py-4 text-right font-semibold text-slate-600">
                                    {{ number_format($m['total_warga'] ?? 0, 0, ',', '.') }}
                                </td>
                                {{-- TOTAL PENERIMA --}}
                                <td class="px-6 py-4 text-right font-bold text-emerald-600">
                                    {{ number_format($m['total_penerima'] ?? 0, 0, ',', '.') }}
                                </td>
                                {{-- TOTAL PENYALURAN --}}
                                <td class="px-6 py-4 text-right font-semibold text-blue-600">
                                    {{ number_format($m['total_penyaluran'] ?? 0, 0, ',', '.') }}
                                </td>
                                {{-- LINK AKSIONAL --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center">
                                        <a href="{{ route('provinsi.monitoring.show', ['kabupatenId' => $m['kabupaten_id'], 'tahun' => $tahun]) }}"
                                           class="inline-flex items-center px-4 py-2 rounded-xl border border-blue-100 bg-blue-50/50 hover:bg-blue-50 text-xs font-bold text-blue-600 shadow-sm transition" 
                                           title="Lihat rincian data per kecamatan">
                                            Detail per Kecamatan &rarr;
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-slate-400 font-medium py-12 bg-slate-50/20">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span>Belum ada data monitoring untuk tahun {{ $tahun }}.</span>
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