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
                        <span class="text-[11px] font-medium tracking-wider text-slate-400 uppercase">Dashboard Tingkat Kecamatan</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight text-white leading-[1.15]">
                        Selamat datang kembali,<br>
                        <span class="bg-gradient-to-r from-blue-400 via-indigo-200 to-white bg-clip-text text-transparent font-bold">
                            {{ Auth::user()->nama_lengkap ?? Auth::user()->name }}
                        </span>
                    </h1>
                    <p class="mt-3 text-slate-400 text-sm sm:text-base font-normal leading-relaxed">
                        Pantau anggaran, distribusi dana, dan realisasi bantuan sosial ke seluruh Kelurahan.
                    </p>
                </div>
            </div>

            {{-- MENU CEPAT --}}
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50">

                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                        Akses Kecamatan
                    </h2>
                    <span class="text-[11px] text-slate-400 font-medium">
                        3 Modul Tersedia
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                    {{-- Dana Masuk --}}
                    <a href="{{ route('kecamatan.dana.index') }}"
                       class="group flex items-center gap-4 border border-slate-100 rounded-xl p-4 hover:bg-slate-50 transition">
                        <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center
                                    group-hover:bg-emerald-600 group-hover:text-white transition">
                            💰
                        </div>
                        <div>
                            <span class="block font-semibold">Menerima Dana</span>
                            <span class="text-xs text-slate-400">Dana dari Kabupaten/Kota</span>
                        </div>
                    </a>

                    {{-- Distribusi --}}
                    <a href="{{ route('kecamatan.distribusi.index') }}"
                       class="group flex items-center gap-4 border border-slate-100 rounded-xl p-4 hover:bg-slate-50 transition">
                        <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center
                                    group-hover:bg-amber-600 group-hover:text-white transition">
                            🚚
                        </div>
                        <div>
                            <span class="block font-semibold">Distribusi</span>
                            <span class="text-xs text-slate-400">Salurkan ke Kelurahan</span>
                        </div>
                    </a>

                    {{-- Monitoring --}}
                    <a href="{{ route('kecamatan.monitoring.index') }}"
                       class="group flex items-center gap-4 border border-slate-100 rounded-xl p-4 hover:bg-slate-50 transition">
                        <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center
                                    group-hover:bg-purple-600 group-hover:text-white transition">
                            📊
                        </div>
                        <div>
                            <span class="block font-semibold">Monitoring</span>
                            <span class="text-xs text-slate-400">Monitoring Kelurahan</span>
                        </div>
                    </a>

                </div>
            </div>

            {{-- RINGKASAN ANGGARAN --}}
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50">
                <div class="flex justify-between items-center">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Ringkasan Anggaran</h2>
                    <form method="GET" class="flex gap-2">
                        <select name="tahun" onchange="this.form.submit()"
                                class="text-xs font-semibold border border-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @for($y = now()->year; $y >= now()->year - 5; $y--)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-5">
                    <div class="border-l-4 border-blue-600 bg-slate-50/60 rounded-xl p-4">
                        <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Total Anggaran</p>
                        <p class="text-lg font-bold text-slate-900 tracking-tight mt-1">Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</p>
                    </div>
                    <div class="border-l-4 border-red-500 bg-slate-50/60 rounded-xl p-4">
                        <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Anggaran Terpakai</p>
                        <p class="text-lg font-bold text-slate-900 tracking-tight mt-1">Rp {{ number_format($totalTerpakai, 0, ',', '.') }}</p>
                    </div>
                    <div class="border-l-4 border-emerald-500 bg-slate-50/60 rounded-xl p-4">
                        <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Sisa Anggaran</p>
                        <p class="text-lg font-bold text-slate-900 tracking-tight mt-1">Rp {{ number_format($totalSisa, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- 2-COLUMN LAYOUT --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                {{-- LEFT COLUMN --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- DISTRIBUSI PER KELURAHAN --}}
                    <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Distribusi Dana per Kelurahan</h2>
                                <p class="text-xs text-slate-400 mt-0.5">Ringkasan realisasi penyaluran per kelurahan</p>
                            </div>
                            <a href="{{ route('kecamatan.distribusi.create') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition flex items-center gap-1 shrink-0">
                                + Distribusi Baru
                            </a>
                        </div>

                        <div class="space-y-1">
                            @forelse($distribusiKelurahan as $d)
                            <div class="flex justify-between items-center py-3 px-2 rounded-xl hover:bg-slate-50/80 transition duration-150">
                                <div class="flex items-center gap-3 truncate">
                                    <div class="w-8 h-8 bg-slate-100 text-slate-600 text-xs font-bold rounded-full flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($d->kelurahan ?? 'K', 0, 2)) }}
                                    </div>
                                    <div class="truncate">
                                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $d->kelurahan }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5">{{ number_format($d->jumlah_penyaluran) }} kali penyaluran</p>
                                    </div>
                                </div>
                                <div class="shrink-0 pl-4 text-right">
                                    <span class="inline-flex text-[11px] bg-emerald-50 text-emerald-700 font-semibold px-2.5 py-0.5 rounded-full border border-emerald-200/30">
                                        Rp {{ number_format($d->total_dana, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-10 border border-dashed border-slate-200 rounded-xl">
                                <svg class="w-8 h-8 text-slate-300 mx-auto mb-2 stroke-[1.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m16.5 0a2.25 2.25 0 0 0-2.25-2.25H6m12 0V4.5m0 0a2.25 2.25 0 0 0-2.25-2.25h-5.25A2.25 2.25 0 0 0 6 4.5v1.5m12 0a2.25 2.25 0 0 1-2.25 2.25H6"/></svg>
                                <p class="text-xs text-slate-400 font-medium">Belum ada data penyaluran.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                </div>

                {{-- RIGHT COLUMN: SIDEBAR --}}
                <div class="space-y-6">

                    <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50 space-y-5">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Metrik Agregat</h2>

                        <div class="flex items-center justify-between py-1.5">
                            <div>
                                <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Total Kelurahan</p>
                                <p class="text-2xl font-bold text-slate-900 tracking-tight mt-0.5">{{ $totalKelurahan }}</p>
                            </div>
                            <span class="text-[10px] font-bold bg-blue-50 text-blue-600 px-2 py-0.5 rounded-md">Wilayah</span>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 py-1.5">
                            <div>
                                <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Total Distribusi</p>
                                <p class="text-lg font-bold text-slate-900 tracking-tight mt-0.5">Rp {{ number_format($totalDistribusi, 0, ',', '.') }}</p>
                            </div>
                            <span class="text-[10px] font-bold bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-md">Tahun {{ $tahun }}</span>
                        </div>
                    </div>

                    {{-- PENYERAPAN ANGGARAN --}}
                    @php
                        $persenTerpakai = $totalAnggaran > 0 ? round(($totalTerpakai / $totalAnggaran) * 100, 1) : 0;
                        $persenSisa = $totalAnggaran > 0 ? round(($totalSisa / $totalAnggaran) * 100, 1) : 0;
                    @endphp
                    <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-5">Penyerapan Anggaran</h2>

                        <div class="space-y-5">
                            <div>
                                <div class="flex justify-between items-baseline text-xs mb-1.5">
                                    <span class="font-semibold text-slate-700">Anggaran Terpakai</span>
                                    <span class="text-xs font-bold text-slate-800">{{ $persenTerpakai }}%</span>
                                </div>
                                <div class="w-full bg-slate-100/70 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-red-500 h-1.5 rounded-full" style="width: {{ $persenTerpakai }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between items-baseline text-xs mb-1.5">
                                    <span class="font-semibold text-slate-700">Sisa Anggaran</span>
                                    <span class="text-xs font-bold text-slate-800">{{ $persenSisa }}%</span>
                                </div>
                                <div class="w-full bg-slate-100/70 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-emerald-600 h-1.5 rounded-full" style="width: {{ $persenSisa }}%"></div>
                                </div>
                            </div>

                            <div class="pt-4 mt-2 border-t border-slate-100">
                                <div class="flex justify-between items-baseline text-xs mb-2">
                                    <span class="font-bold text-slate-500 text-[10px] uppercase tracking-wider">Total Penyerapan</span>
                                    <span class="text-sm font-extrabold text-indigo-600">{{ $persenTerpakai }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden shadow-inner">
                                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $persenTerpakai }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>