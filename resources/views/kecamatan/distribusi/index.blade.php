<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Distribusi ke Kelurahan
        </h2>
    </x-slot>

    <div class="py-10 bg-[#f8fafc] min-h-screen font-sans antialiased">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- FLASH MESSAGES --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium rounded-xl px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 text-sm font-medium rounded-xl px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif

            {{-- HEADER ROW --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="text-lg font-bold text-slate-800">Riwayat Distribusi</h1>
                    <p class="text-xs text-slate-400 mt-0.5">Daftar penyaluran dana ke seluruh Kelurahan</p>
                </div>
                <a href="{{ route('kecamatan.distribusi.create') }}"
                   class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Distribusi Baru
                </a>
            </div>

            {{-- TABLE CARD --}}
            <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm shadow-slate-100/50 overflow-hidden">

                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-xs font-bold text-slate-700 uppercase tracking-widest">Daftar Distribusi</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 text-[11px] uppercase tracking-wider text-left font-bold">
                                <th class="px-6 py-3.5">#</th>
                                <th class="px-6 py-3.5">Kelurahan</th>
                                <th class="px-6 py-3.5">Tahun</th>
                                <th class="px-6 py-3.5">Jumlah</th>
                                <th class="px-6 py-3.5">Tanggal Distribusi</th>
                                <th class="px-6 py-3.5 text-center">Status</th>
                                <th class="px-6 py-3.5">Keterangan</th>
                                <th class="px-6 py-3.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($distribusi as $i => $item)
                                <tr class="hover:bg-slate-50/40 transition">
                                    <td class="px-6 py-4 text-slate-500">{{ $i + 1 }}</td>
                                    <td class="px-6 py-4 font-semibold text-slate-800">
                                        {{ $item->kelurahan->nama_lengkap ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-500">{{ $item->tahun }}</td>
                                    <td class="px-6 py-4 font-bold text-slate-900">
                                        Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-500">
                                        {{ \Carbon\Carbon::parse($item->tanggal_distribusi)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->status === 'terkirim')
                                            <span class="inline-flex text-[11px] bg-emerald-50 text-emerald-700 font-bold px-2.5 py-0.5 rounded-full border border-emerald-200/40">
                                                Terkirim
                                            </span>
                                        @else
                                            <span class="inline-flex text-[11px] bg-rose-50 text-rose-600 font-bold px-2.5 py-0.5 rounded-full border border-rose-200/40">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 max-w-xs truncate" title="{{ $item->keterangan }}">
                                        {{ $item->keterangan ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('kecamatan.distribusi.destroy', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus distribusi ini?');"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 text-xs font-semibold text-slate-500 hover:text-rose-600 border border-slate-200 hover:border-rose-300 px-3 py-1.5 rounded-lg transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6M9.5 7V4.5A1.5 1.5 0 0 1 11 3h2a1.5 1.5 0 0 1 1.5 1.5V7M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-16 text-center bg-slate-50/10">
                                        <div class="flex flex-col items-center justify-center gap-3">
                                            <svg class="w-10 h-10 text-slate-300 stroke-[1.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m16.5 0a2.25 2.25 0 0 0-2.25-2.25H6m12 0V4.5m0 0a2.25 2.25 0 0 0-2.25-2.25h-5.25A2.25 2.25 0 0 0 6 4.5v1.5m12 0a2.25 2.25 0 0 1-2.25 2.25H6"/>
                                            </svg>
                                            <p class="text-xs text-slate-400 font-semibold">
                                                Belum ada data distribusi.
                                            </p>
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