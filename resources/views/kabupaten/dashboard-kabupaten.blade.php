<x-app-layout>
    <div class="py-10 bg-[#f8fafc] min-h-screen font-sans antialiased selection:bg-blue-500 selection:text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

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

            {{-- HERO --}}
            <div class="relative bg-slate-950 rounded-3xl p-8 sm:p-10 text-white overflow-hidden shadow-2xl shadow-slate-950/20 group">
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-500/20 rounded-full blur-[100px] pointer-events-none transition duration-500 group-hover:scale-110"></div>
                <div class="absolute -bottom-20 left-1/3 w-64 h-64 bg-blue-500/15 rounded-full blur-[80px] pointer-events-none"></div>
                <div class="relative z-10 max-w-2xl">
                    <div class="inline-flex items-center gap-2 bg-slate-900 border border-slate-800 backdrop-blur-md px-3 py-1 rounded-full mb-6 shadow-inner">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-[11px] font-medium tracking-wider text-slate-400 uppercase">Dashboard Tingkat Kabupaten/Kota</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight text-white leading-[1.15]">
                        Selamat datang kembali,<br>
                        <span class="bg-gradient-to-r from-blue-400 via-indigo-200 to-white bg-clip-text text-transparent font-bold">
                            {{ Auth::user()->nama_lengkap ?? Auth::user()->name }}
                        </span>
                    </h1>
                    <p class="mt-3 text-slate-400 text-sm sm:text-base font-normal leading-relaxed">
                        Pantau dana bantuan sosial yang diterima dari Provinsi dan realisasi penyaluran ke Kecamatan.
                    </p>
                </div>
            </div>

            {{-- MENU CEPAT --}}
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50">

                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                        Akses Kabupaten/Kota
                    </h2>
                    <span class="text-[11px] text-slate-400 font-medium">
                        3 Modul Tersedia
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                    {{-- Dana Masuk --}}
                    <a href="{{ route('kabupaten.dana.index') }}"
                       class="group flex items-center gap-4 border border-slate-100 rounded-xl p-4 hover:bg-slate-50 transition">
                        <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center
                                    group-hover:bg-emerald-600 group-hover:text-white transition">
                            💰
                        </div>
                        <div>
                            <span class="block font-semibold">Menerima Dana</span>
                            <span class="text-xs text-slate-400">Dana dari Provinsi</span>
                        </div>
                    </a>

                    {{-- Distribusi --}}
                    <a href="{{ route('kabupaten.distribusi.index') }}"
                       class="group flex items-center gap-4 border border-slate-100 rounded-xl p-4 hover:bg-slate-50 transition">
                        <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center
                                    group-hover:bg-amber-600 group-hover:text-white transition">
                            🚚
                        </div>
                        <div>
                            <span class="block font-semibold">Distribusi</span>
                            <span class="text-xs text-slate-400">Salurkan ke Kecamatan</span>
                        </div>
                    </a>

                    {{-- Monitoring --}}
                    <a href="{{ route('kabupaten.monitoring.index') }}"
                       class="group flex items-center gap-4 border border-slate-100 rounded-xl p-4 hover:bg-slate-50 transition">
                        <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center
                                    group-hover:bg-purple-600 group-hover:text-white transition">
                            📊
                        </div>
                        <div>
                            <span class="block font-semibold">Monitoring</span>
                            <span class="text-xs text-slate-400">Monitoring Kecamatan</span>
                        </div>
                    </a>

                </div>
            </div>

            {{-- FILTER TAHUN --}}
            <form method="GET" class="flex items-center gap-3">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tahun</label>
                <select name="tahun" onchange="this.form.submit()" class="border border-slate-200 rounded-xl px-3 py-2 text-sm bg-white shadow-sm">
                    @forelse($tahunTersedia ?? [] as $t)
                        <option value="{{ $t }}" @selected($t == ($tahun ?? now()->year))>{{ $t }}</option>
                    @empty
                        <option value="{{ $tahun ?? now()->year }}">{{ $tahun ?? now()->year }}</option>
                    @endforelse
                </select>
            </form>

            {{-- RINGKASAN ANGGARAN --}}
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50">
                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-5">
                    Ringkasan Anggaran ({{ $tahun ?? now()->year }})
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="border-l-4 border-blue-600 bg-slate-50/60 rounded-xl p-4">
                        <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Total Dana Diterima</p>
                        <p class="text-lg font-bold text-slate-900 tracking-tight mt-1">
                            Rp {{ number_format($anggaran->total_anggaran ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="border-l-4 border-red-500 bg-slate-50/60 rounded-xl p-4">
                        <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Sudah Terpakai</p>
                        <p class="text-lg font-bold text-slate-900 tracking-tight mt-1">
                            Rp {{ number_format($anggaran->anggaran_terpakai ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="border-l-4 border-emerald-500 bg-slate-50/60 rounded-xl p-4">
                        <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Sisa Anggaran</p>
                        <p class="text-lg font-bold text-slate-900 tracking-tight mt-1">
                            Rp {{ number_format($anggaran->sisa_anggaran ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <p class="text-xs text-slate-400 mt-5 pt-5 border-t border-slate-100">
                    Total dana yang pernah diterima sepanjang waktu:
                    <span class="font-semibold text-slate-700">
                        Rp {{ number_format($totalDiterimaKeseluruhan ?? 0, 0, ',', '.') }}
                    </span>
                </p>
            </div>

            {{-- RIWAYAT DANA MASUK --}}
            <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm shadow-slate-100/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Riwayat Dana Masuk dari Provinsi</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Seluruh transaksi distribusi anggaran yang diterima kabupaten ini</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50/60 text-slate-400 text-[11px] uppercase tracking-wider">
                            <tr>
                                <th class="text-left px-6 py-3 font-semibold">Tanggal</th>
                                <th class="text-left px-6 py-3 font-semibold">Jumlah</th>
                                <th class="text-left px-6 py-3 font-semibold">Keterangan</th>
                                <th class="text-left px-6 py-3 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($distribusi ?? [] as $item)
                                <tr class="border-t border-slate-100 hover:bg-slate-50/60 transition">
                                    <td class="px-6 py-3.5 text-slate-600">
                                        {{ \Carbon\Carbon::parse($item->tanggal_distribusi)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-3.5 font-semibold text-slate-800">
                                        Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-3.5 text-slate-500">{{ $item->keterangan ?? '-' }}</td>
                                    <td class="px-6 py-3.5">
                                        @if($item->status === 'terkirim')
                                            <span class="inline-flex text-[11px] bg-emerald-50 text-emerald-700 font-semibold px-2.5 py-0.5 rounded-full border border-emerald-200/30">Terkirim</span>
                                        @else
                                            <span class="inline-flex text-[11px] bg-red-50 text-red-600 font-semibold px-2.5 py-0.5 rounded-full border border-red-200/30">Dibatalkan</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <svg class="w-8 h-8 text-slate-300 mx-auto mb-2 stroke-[1.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m16.5 0a2.25 2.25 0 0 0-2.25-2.25H6m12 0V4.5m0 0a2.25 2.25 0 0 0-2.25-2.25h-5.25A2.25 2.25 0 0 0 6 4.5v1.5m12 0a2.25 2.25 0 0 1-2.25 2.25H6"/>
                                        </svg>
                                        <p class="text-xs text-slate-400 font-medium">
                                            Belum ada dana yang diterima dari Provinsi untuk tahun {{ $tahun ?? now()->year }}.
                                        </p>
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