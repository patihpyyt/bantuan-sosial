<x-app-layout>
    <div class="py-10 bg-[#f8fafc] min-h-screen font-sans antialiased selection:bg-blue-500 selection:text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- NOTIFIKASI FLASH MESSAGES --}}
            @if(session('success'))
                <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold p-4 rounded-xl shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-2 bg-red-50 border border-red-200 text-red-800 text-sm font-semibold p-4 rounded-xl shadow-sm">
                    <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- BANNER HERO --}}
            <div class="relative bg-slate-950 rounded-3xl p-8 sm:p-10 text-white overflow-hidden shadow-2xl shadow-slate-950/20 group">
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-500/20 rounded-full blur-[100px] pointer-events-none transition duration-500 group-hover:scale-110"></div>
                <div class="absolute -bottom-20 left-1/3 w-64 h-64 bg-blue-500/15 rounded-full blur-[80px] pointer-events-none"></div>
                <div class="relative z-10 max-w-2xl">
                    <div class="inline-flex items-center gap-2 bg-slate-900 border border-slate-800/60 backdrop-blur-md px-3 py-1 rounded-full mb-6 shadow-inner">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-[11px] font-bold tracking-wider text-slate-400 uppercase">Dashboard Tingkat Kabupaten/Kota</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight text-white leading-[1.15]">
                        Selamat datang kembali,<br>
                        <span class="bg-gradient-to-r from-blue-400 via-indigo-200 to-white bg-clip-text text-transparent font-black">
                            {{ Auth::user()->nama_lengkap ?? Auth::user()->name }}
                        </span>
                    </h1>
                    <p class="mt-3 text-slate-400 text-sm sm:text-base font-normal leading-relaxed">
                        Pantau sirkulasi dana bantuan sosial operasional yang diterima dari Provinsi serta manajemen realisasi penyaluran ke tingkat Kecamatan.
                    </p>
                </div>
            </div>

            {{-- MODUL MENU CEPAT --}}
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Akses Kontrol Utama</h2>
                    <span class="text-[11px] bg-slate-100 text-slate-500 px-2.5 py-0.5 rounded-full font-bold">3 Modul Aktif</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    {{-- DANA MASUK --}}
                    <a href="{{ route('kabupaten.dana.index') }}"
                       class="group flex items-center gap-4 border border-slate-100 rounded-2xl p-4 hover:bg-slate-50/80 hover:border-slate-200 transition-all duration-200 shadow-sm">
                        <div class="w-12 h-12 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-900 shadow-sm transition-all duration-200 group-hover:scale-105 group-hover:border-slate-900">
                            {{-- Ikon Koin / Dana Masuk --}}
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-800 text-sm group-hover:text-blue-600 transition">Menerima Dana</span>
                            <span class="text-xs text-slate-400 font-medium">Log alokasi dari Provinsi</span>
                        </div>
                    </a>

                    {{-- DISTRIBUSI KECAMATAN --}}
                    <a href="{{ route('kabupaten.distribusi.index') }}"
                       class="group flex items-center gap-4 border border-slate-100 rounded-2xl p-4 hover:bg-slate-50/80 hover:border-slate-200 transition-all duration-200 shadow-sm">
                        <div class="w-12 h-12 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-900 shadow-sm transition-all duration-200 group-hover:scale-105 group-hover:border-slate-900">
                            {{-- Ikon Truk Distribusi --}}
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                            </svg>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-800 text-sm group-hover:text-blue-600 transition">Distribusi Dana</span>
                            <span class="text-xs text-slate-400 font-medium">Penyaluran ke Kecamatan</span>
                        </div>
                    </a>

                    {{-- MONITORING LAPORAN --}}
                    <a href="{{ route('kabupaten.monitoring.index') }}"
                       class="group flex items-center gap-4 border border-slate-100 rounded-2xl p-4 hover:bg-slate-50/80 hover:border-slate-200 transition-all duration-200 shadow-sm">
                        <div class="w-12 h-12 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-900 shadow-sm transition-all duration-200 group-hover:scale-105 group-hover:border-slate-900">
                            {{-- Ikon Grafik Monitoring --}}
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-800 text-sm group-hover:text-blue-600 transition">Sistem Monitoring</span>
                            <span class="text-xs text-slate-400 font-medium">Evaluasi cakupan wilayah</span>
                        </div>
                    </a>
                </div>
            </div>

            {{-- PANEL FILTER & RINGKASAN ANGGARAN --}}
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <form method="GET" class="flex items-center gap-3 bg-white px-4 py-2 rounded-xl border border-slate-200/80 shadow-sm">
                        <label for="tahun" class="text-xs font-bold text-slate-400 uppercase tracking-wider">Periode Keuangan</label>
                        <select name="tahun" id="tahun" onchange="this.form.submit()" 
                            class="border-0 p-0 text-sm font-bold text-slate-700 bg-white focus:ring-0 cursor-pointer">
                            @forelse($tahunTersedia ?? [] as $t)
                                <option value="{{ $t }}" @selected($t == ($tahun ?? now()->year))>Tahun {{ $t }}</option>
                            @empty
                                <option value="{{ $tahun ?? now()->year }}">Tahun {{ $tahun ?? now()->year }}</option>
                            @endforelse
                        </select>
                    </form>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-5">
                        Ringkasan Anggaran Makro ({{ $tahun ?? now()->year }})
                    </h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        {{-- TOTAL DANA DITERIMA --}}
                        <div class="border-l-4 border-blue-600 bg-slate-50/60 rounded-xl p-4 shadow-inner">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Dana Diterima</p>
                            <p class="text-xl font-black text-slate-900 tracking-tight mt-1">
                                Rp {{ number_format($anggaran->total_anggaran ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                        {{-- ANGGARAN TERPAKAI --}}
                        <div class="border-l-4 border-rose-500 bg-slate-50/60 rounded-xl p-4 shadow-inner">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Telah Disalurkan</p>
                            <p class="text-xl font-black text-slate-900 tracking-tight mt-1">
                                Rp {{ number_format($anggaran->anggaran_terpakai ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                        {{-- SISA ANGGARAN --}}
                        <div class="border-l-4 border-emerald-500 bg-slate-50/60 rounded-xl p-4 shadow-inner">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sisa Anggaran Kas</p>
                            <p class="text-xl font-black text-slate-900 tracking-tight mt-1">
                                Rp {{ number_format($anggaran->sisa_anggaran ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="text-xs text-slate-400 mt-6 pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2">
                        <span>Akumulasi histori modal masuk keseluruhan waktu:</span>
                        <span class="font-bold text-sm text-slate-800 bg-slate-100 px-3 py-1 rounded-lg">
                            Rp {{ number_format($totalDiterimaKeseluruhan ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- RIWAYAT DANA MASUK TABEL --}}
            <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm shadow-slate-100/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/30">
                    <h2 class="text-xs font-bold text-slate-700 uppercase tracking-widest">Riwayat Alokasi Dana dari Provinsi</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Daftar manifestasi transfer dana perimbangan jaminan sosial provinsi</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-200 text-slate-400 text-[11px] uppercase tracking-wider text-left font-bold">
                                <th class="px-6 py-3.5">Tanggal Salur</th>
                                <th class="px-6 py-3.5">Nominal Penerimaan</th>
                                <th class="px-6 py-3.5">Keterangan Dokumen</th>
                                <th class="px-6 py-3.5 text-center">Status Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($distribusi ?? [] as $item)
                                <tr class="hover:bg-slate-50/40 transition">
                                    <td class="px-6 py-4 font-medium text-slate-500">
                                        {{ \Carbon\Carbon::parse($item->tanggal_distribusi)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-slate-900">
                                        Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 max-w-xs truncate" title="{{ $item->keterangan }}">
                                        {{ $item->keterangan ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->status === 'terkirim')
                                            <span class="inline-flex text-[11px] bg-emerald-50 text-emerald-700 font-bold px-2.5 py-0.5 rounded-full border border-emerald-200/40">
                                                Terkirim
                                            </span>
                                        @else
                                            <span class="inline-flex text-[11px] bg-rose-50 text-rose-600 font-bold px-2.5 py-0.5 rounded-full border border-rose-200/40">
                                                Dibatalkan
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center bg-slate-50/10">
                                        <div class="flex flex-col items-center justify-center gap-3">
                                            <svg class="w-10 h-10 text-slate-300 stroke-[1.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m16.5 0a2.25 2.25 0 0 0-2.25-2.25H6m12 0V4.5m0 0a2.25 2.25 0 0 0-2.25-2.25h-5.25A2.25 2.25 0 0 0 6 4.5v1.5m12 0a2.25 2.25 0 0 1-2.25 2.25H6"/>
                                            </svg>
                                            <p class="text-xs text-slate-400 font-semibold">
                                                Belum ada dana transfer masuk dari Provinsi terdeteksi di tahun {{ $tahun ?? now()->year }}.
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