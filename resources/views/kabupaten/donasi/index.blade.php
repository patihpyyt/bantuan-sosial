<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Menerima Donasi Non-Provinsi
        </h2>
    </x-slot>

    <div class="py-10 bg-[#f8fafc] min-h-screen font-sans antialiased">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- CARD STATISTIK KABUPATEN --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl border-l-4 border-blue-600 border-y border-r border-slate-100 shadow-sm shadow-slate-100/50 p-5">
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Total Dana Diterima</p>
                    <p class="text-2xl font-bold text-slate-900 tracking-tight mt-1">Rp {{ number_format($donasi->sum('jumlah'), 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-2xl border-l-4 border-emerald-500 border-y border-r border-slate-100 shadow-sm shadow-slate-100/50 p-5">
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Total Transaksi</p>
                    <p class="text-2xl font-bold text-slate-900 tracking-tight mt-1">{{ $donasi->count() }} <span class="text-sm font-medium text-slate-400">transaksi</span></p>
                </div>
                <div class="bg-white rounded-2xl border-l-4 border-amber-500 border-y border-r border-slate-100 shadow-sm shadow-slate-100/50 p-5">
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Distribusi Bulan Ini</p>
                    <p class="text-2xl font-bold text-slate-900 tracking-tight mt-1">0 <span class="text-sm font-medium text-slate-400">transaksi</span></p>
                </div>
            </div>

            {{-- TABEL RIWAYAT DANA KABUPATEN --}}
            <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm shadow-slate-100/50 overflow-hidden">
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Riwayat Dana Dari Donatur</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100">
                                <th class="text-center px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider w-16">No</th>
                                <th class="text-left px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                                <th class="text-left px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tahun</th>
                                <th class="text-left px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Jumlah Dana</th>
                                <th class="text-center px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                                <th class="text-left px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($donasi as $index => $d)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-5 py-4 text-center text-slate-500 font-medium">{{ $index + 1 }}</td>
                                    <td class="px-5 py-4 text-slate-700">
                                        {{ $d->created_at ? $d->created_at->format('d M Y') : '14 Jul 2026' }}
                                    </td>
                                    <td class="px-5 py-4 text-slate-600">
                                        {{ $d->created_at ? $d->created_at->format('Y') : '2026' }}
                                    </td>
                                    {{-- FIX UTAMA: Menggunakan $d->jumlah agar nominal Rp 12.000.000 terbaca sempurna --}}
                                    <td class="px-5 py-4 font-bold text-slate-900">
                                        Rp {{ number_format($d->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="inline-flex text-[11px] bg-emerald-50 text-emerald-700 font-semibold px-2.5 py-1 rounded-full border border-emerald-200/40">
                                            {{ $d->status }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-slate-400 text-xs">
                                        {{ $d->pesan ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-12">
                                        <svg class="w-8 h-8 text-slate-300 mx-auto mb-2 stroke-[1.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                                        </svg>
                                        <p class="text-xs text-slate-400 font-medium">Belum ada alokasi dana yang diterima dari pihak non-Provinsi.</p>
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