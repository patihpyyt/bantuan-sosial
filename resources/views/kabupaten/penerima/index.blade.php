<x-app-layout>
    {{-- SLOT HEADER UTAMA --}}
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-slate-800 leading-tight">
                Menerima Dana dari Provinsi
            </h2>
            <p class="text-sm text-slate-500 mt-0.5">
                Pantau seluruh rekam jejak modal masuk dan alokasi dana perimbangan dari Provinsi.
            </p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- NOTIFIKASI FLASH MESSAGES --}}
        @if(session('success'))
            <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold p-4 rounded-xl shadow-sm">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- KARTU RINGKASAN METRIK (FLAT ELEGAN) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            
            {{-- TOTAL DANA DITERIMA --}}
            <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-blue-600 p-5 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Dana Diterima</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight mt-1.5">
                    Rp {{ number_format($totalDana, 0, ',', '.') }}
                </h3>
            </div>

            {{-- TOTAL DISTRIBUSI --}}
            <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-emerald-500 p-5 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Transaksi</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight mt-1.5">
                    {{ $totalDistribusi }} <span class="text-xs text-slate-400 font-medium">transaksi</span>
                </h3>
            </div>

            {{-- DISTRIBUSI BULAN INI --}}
            <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-amber-500 p-5 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Distribusi Bulan Ini</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight mt-1.5">
                    {{ $bulanIni }} <span class="text-xs text-slate-400 font-medium">transaksi</span>
                </h3>
            </div>

        </div>

        {{-- KARTU UTAMA & TABEL RIWAYAT --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            {{-- HEADER KARTU --}}
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest">Riwayat Dana dari Provinsi</h3>
            </div>

            {{-- RESPONSIVE CONTAINER TABEL --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    
                    {{-- THEAD STYLING --}}
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-400 uppercase tracking-wider">
                            <th class="px-6 py-3.5 text-center w-12">No</th>
                            <th class="px-6 py-3.5 text-center">Tanggal</th>
                            <th class="px-6 py-3.5 text-center w-20">Tahun</th>
                            <th class="px-6 py-3.5 text-right">Jumlah Dana</th>
                            <th class="px-6 py-3.5 text-center">Status</th>
                            <th class="px-6 py-3.5">Keterangan</th>
                        </tr>
                    </thead>

                    {{-- TBODY STYLING --}}
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700 bg-white">
                        @forelse($distribusi as $item)
                            <tr class="hover:bg-slate-50/40 transition">
                                {{-- NOMOR URUT --}}
                                <td class="px-6 py-4 text-center font-medium text-slate-400">
                                    {{ $loop->iteration }}
                                </td>
                                {{-- TANGGAL --}}
                                <td class="px-6 py-4 text-center font-medium text-slate-600">
                                    {{ \Carbon\Carbon::parse($item->tanggal_distribusi)->format('d-m-Y') }}
                                </td>
                                {{-- TAHUN ANGGARAN --}}
                                <td class="px-6 py-4 text-center font-semibold text-slate-600">
                                    {{ $item->tahun }}
                                </td>
                                {{-- NOMINAL DANA --}}
                                <td class="px-6 py-4 text-right font-extrabold text-slate-900">
                                    Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                </td>
                                {{-- STATUS BADGE --}}
                                <td class="px-6 py-4 text-center">
                                    @if($item->status == 'terkirim')
                                        <span class="inline-flex text-[11px] bg-blue-50 text-blue-700 font-bold px-2.5 py-0.5 rounded-full border border-blue-200/40">Terkirim</span>
                                    @elseif($item->status == 'diterima')
                                        <span class="inline-flex text-[11px] bg-emerald-50 text-emerald-700 font-bold px-2.5 py-0.5 rounded-full border border-emerald-200/40">Diterima</span>
                                    @else
                                        <span class="inline-flex text-[11px] bg-rose-50 text-rose-600 font-bold px-2.5 py-0.5 rounded-full border border-rose-200/40">Dibatalkan</span>
                                    @endif
                                </td>
                                {{-- KETERANGAN --}}
                                <td class="px-6 py-4 text-slate-500 max-w-xs truncate" title="{{ $item->keterangan }}">
                                    {{ $item->keterangan ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-slate-400 font-medium py-16 bg-slate-50/10">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <svg class="w-10 h-10 text-slate-300 stroke-[1.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m16.5 0a2.25 2.25 0 0 0-2.25-2.25H6m12 0V4.5m0 0a2.25 2.25 0 0 0-2.25-2.25h-5.25A2.25 2.25 0 0 0 6 4.5v1.5m12 0a2.25 2.25 0 0 1-2.25 2.25H6"/>
                                        </svg>
                                        <p class="text-xs text-slate-400 font-semibold">Belum ada alokasi dana yang diterima dari pihak Provinsi.</p>
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