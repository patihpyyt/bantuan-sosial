<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Kelola Donasi Masyarakat
        </h2>
    </x-slot>

    <div class="py-10 bg-[#f8fafc] min-h-screen font-sans antialiased">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium rounded-xl px-4 py-3 flex items-center justify-between">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 text-sm font-medium rounded-xl px-4 py-3 flex items-center justify-between">
                    {{ session('error') }}
                </div>
            @endif

            {{-- RINGKASAN DONASI --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl border-l-4 border-emerald-500 border-y border-r border-slate-100 shadow-sm shadow-slate-100/50 p-5">
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Total Donasi Terverifikasi</p>
                    <p class="text-2xl font-bold text-emerald-600 tracking-tight mt-1">Rp {{ number_format($totalTerverifikasi, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-2xl border-l-4 border-amber-500 border-y border-r border-slate-100 shadow-sm shadow-slate-100/50 p-5">
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Menunggu Verifikasi</p>
                    <p class="text-2xl font-bold text-amber-600 tracking-tight mt-1">{{ $totalMenunggu }} <span class="text-sm font-medium text-slate-400">transaksi</span></p>
                </div>
                <div class="bg-white rounded-2xl border-l-4 border-blue-600 border-y border-r border-slate-100 shadow-sm shadow-slate-100/50 p-5">
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Jumlah Donatur</p>
                    <p class="text-2xl font-bold text-blue-600 tracking-tight mt-1">{{ $totalDonatur }} <span class="text-sm font-medium text-slate-400">orang</span></p>
                </div>
            </div>

            {{-- FILTER STATUS --}}
            <div class="bg-white rounded-2xl border border-slate-200/60 p-2 shadow-sm shadow-slate-100/50">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('provinsi.donasi.index') }}"
                        class="text-xs font-semibold px-4 py-2 rounded-xl transition {{ !$status ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50' }}">
                        Semua
                    </a>
                    <a href="{{ route('provinsi.donasi.index', ['status' => 'menunggu_verifikasi']) }}"
                        class="text-xs font-semibold px-4 py-2 rounded-xl transition {{ $status === 'menunggu_verifikasi' ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50' }}">
                        Menunggu Verifikasi
                    </a>
                    <a href="{{ route('provinsi.donasi.index', ['status' => 'terverifikasi']) }}"
                        class="text-xs font-semibold px-4 py-2 rounded-xl transition {{ $status === 'terverifikasi' ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50' }}">
                        Terverifikasi
                    </a>
                    <a href="{{ route('provinsi.donasi.index', ['status' => 'tersalurkan']) }}"
                        class="text-xs font-semibold px-4 py-2 rounded-xl transition {{ $status === 'tersalurkan' ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50' }}">
                        Tersalurkan
                    </a>
                    <a href="{{ route('provinsi.donasi.index', ['status' => 'menunggu_pembayaran']) }}"
                        class="text-xs font-semibold px-4 py-2 rounded-xl transition {{ $status === 'menunggu_pembayaran' ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50' }}">
                        Menunggu Bayar
                    </a>
                    <a href="{{ route('provinsi.donasi.index', ['status' => 'ditolak']) }}"
                        class="text-xs font-semibold px-4 py-2 rounded-xl transition {{ $status === 'ditolak' ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50' }}">
                        Ditolak
                    </a>
                </div>
            </div>

            {{-- TABEL DONASI --}}
            <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm shadow-slate-100/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100">
                                <th class="text-left px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kode Referensi</th>
                                <th class="text-left px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Donatur</th>
                                <th class="text-right px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Jumlah</th>
                                <th class="text-left px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Metode</th>
                                <th class="text-left px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pesan</th>
                                <th class="text-center px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                                <th class="text-center px-5 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($donasi as $d)
                                {{-- MODIFIKASI KUNCI: Sembunyikan data donasi yang sudah berstatus 'tersalurkan' dari filter 'Semua' --}}
                                @if(!$status && $d->status === 'tersalurkan')
                                    @continue
                                @endif

                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-5 py-4 font-semibold text-slate-800">{{ $d->kode_referensi }}</td>
                                    <td class="px-5 py-4 text-slate-700">
                                        {{ $d->nama_donatur }}
                                        @if($d->email)
                                            <span class="block text-xs text-slate-400 mt-0.5">{{ $d->email }}</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-right font-bold text-slate-900">Rp {{ number_format($d->jumlah, 0, ',', '.') }}</td>
                                    <td class="px-5 py-4 text-slate-600">
                                        @if($d->metode_pembayaran === 'transfer_bank') Transfer Bank
                                        @elseif($d->metode_pembayaran === 'qris') QRIS
                                        @else E-Wallet
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-slate-400 text-xs max-w-[180px] truncate">{{ $d->pesan ?? '-' }}</td>
                                    <td class="px-5 py-4 text-center">
                                        @if($d->status === 'menunggu_pembayaran')
                                            <span class="inline-flex text-[11px] bg-slate-100 text-slate-600 font-semibold px-2.5 py-1 rounded-full">Menunggu Bayar</span>
                                        @elseif($d->status === 'menunggu_verifikasi')
                                            <span class="inline-flex text-[11px] bg-amber-50 text-amber-700 font-semibold px-2.5 py-1 rounded-full border border-amber-200/40">Menunggu Verifikasi</span>
                                        @elseif($d->status === 'terverifikasi')
                                            <span class="inline-flex text-[11px] bg-emerald-50 text-emerald-700 font-semibold px-2.5 py-1 rounded-full border border-emerald-200/40">Terverifikasi</span>
                                        @elseif($d->status === 'tersalurkan')
                                            <span class="inline-flex text-[11px] bg-blue-50 text-blue-700 font-semibold px-2.5 py-1 rounded-full border border-blue-200/40">Tersalurkan</span>
                                        @else
                                            <span class="inline-flex text-[11px] bg-red-50 text-red-700 font-semibold px-2.5 py-1 rounded-full border border-red-200/40">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        @if($d->status === 'menunggu_verifikasi')
                                            <div class="flex justify-center gap-2">
                                                <form action="{{ route('provinsi.donasi.verifikasi', $d->id) }}" method="POST"
                                                    onsubmit="return confirm('Verifikasi donasi Rp {{ number_format($d->jumlah, 0, ',', '.') }} dari {{ $d->nama_donatur }}?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="text-[11px] font-semibold px-3 py-1.5 rounded-lg border border-emerald-200 text-emerald-600 hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition">
                                                        Verifikasi
                                                    </button>
                                                </form>
                                                <form action="{{ route('provinsi.donasi.tolak', $d->id) }}" method="POST"
                                                    onsubmit="return confirm('Tolak donasi ini?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="text-[11px] font-semibold px-3 py-1.5 rounded-lg border border-red-200 text-red-600 hover:bg-red-600 hover:text-white hover:border-red-600 transition">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($d->status === 'terverifikasi')
                                            <a href="{{ route('provinsi.dana.create', $d->id) }}"
                                                class="inline-flex items-center gap-1.5 text-[11px] font-semibold px-3 py-1.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                                Salurkan
                                            </a>
                                        @else
                                            <span class="text-slate-300 text-xs">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12">
                                        <svg class="w-8 h-8 text-slate-300 mx-auto mb-2 stroke-[1.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                                        <p class="text-xs text-slate-400 font-medium">Belum ada data donasi.</p>
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