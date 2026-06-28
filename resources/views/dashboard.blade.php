<x-app-layout>
    <div class="py-10 bg-[#f8fafc] min-h-screen font-sans antialiased selection:bg-blue-500 selection:text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- HEADER / HERO SECTION (Premium Midnight Style) --}}
            <div class="relative bg-slate-950 rounded-3xl p-8 sm:p-10 text-white overflow-hidden shadow-2xl shadow-slate-950/20 group">
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-500/20 rounded-full blur-[100px] pointer-events-none transition duration-500 group-hover:scale-110"></div>
                <div class="absolute -bottom-20 left-1/3 w-64 h-64 bg-blue-500/15 rounded-full blur-[80px] pointer-events-none"></div>
                
                <div class="relative z-10 max-w-2xl">
                    <div class="inline-flex items-center gap-2 bg-slate-900 border border-slate-800 backdrop-blur-md px-3 py-1 rounded-full mb-6 shadow-inner">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-[11px] font-medium tracking-wider text-slate-400 uppercase">Production Server Active</span>
                    </div>
                    
                    <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight text-white leading-[1.15]">
                        Selamat datang kembali,<br>
                        <span class="bg-gradient-to-r from-blue-400 via-indigo-200 to-white bg-clip-text text-transparent font-bold">
                            {{ Auth::user()->nama_lengkap ?? Auth::user()->name }}
                        </span>
                    </h1>
                    <p class="mt-3 text-slate-400 text-sm sm:text-base font-normal leading-relaxed">
                        Sistem Informasi Pendataan & Monitoring Transparan Penerima Bantuan Sosial (PKH, BLT, BPNT).
                    </p>
                </div>
            </div>

            {{-- 2-COLUMN ASYMMETRIC LAYOUT (Kunci Desain Profesional) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                {{-- LEFT COLUMN: CORE CONTENT (2/3 Width) --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- MENU PENGELOLAAN (Grid Menu Minimalis) --}}
                    <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Akses Kontrol Utama</h2>
                            <span class="text-[11px] text-slate-400 font-medium">5 Modul Tersedia</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <a href="/warga" class="group flex items-center gap-4 border border-slate-100 rounded-xl p-4 hover:bg-slate-50 hover:border-slate-300/80 active:scale-[0.98] transition-all duration-200">
                                <div class="w-10 h-10 bg-slate-50 text-slate-700 rounded-lg flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition duration-200 shrink-0 shadow-sm border border-slate-100">
                                    <svg class="w-5 h-5 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                                </div>
                                <div class="truncate">
                                    <span class="block text-sm font-semibold text-slate-800 group-hover:text-blue-600 transition truncate">Data Warga</span>
                                    <span class="text-xs text-slate-400 block mt-0.5 truncate">Kelola basis KK</span>
                                </div>
                            </a>

                            <a href="/jenis-bansos" class="group flex items-center gap-4 border border-slate-100 rounded-xl p-4 hover:bg-slate-50 hover:border-slate-300/80 active:scale-[0.98] transition-all duration-200">
                                <div class="w-10 h-10 bg-slate-50 text-slate-700 rounded-lg flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition duration-200 shrink-0 shadow-sm border border-slate-100">
                                    <svg class="w-5 h-5 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0-2.625V7.5m0 0h5.25c.621 0 1.125.504 1.125 1.125v1.5a1.125 1.125 0 0 1-1.125 1.125H3.75A1.125 1.125 0 0 1 2.625 9.125v-1.5C2.625 8.004 3.129 7.5 3.75 7.5H12m0 12V10.5"/></svg>
                                </div>
                                <div class="truncate">
                                    <span class="block text-sm font-semibold text-slate-800 group-hover:text-emerald-600 transition truncate">Jenis Bansos</span>
                                    <span class="text-xs text-slate-400 block mt-0.5 truncate">Kategori bantuan</span>
                                </div>
                            </a>

                            <a href="/penerima-bansos" class="group flex items-center gap-4 border border-slate-100 rounded-xl p-4 hover:bg-slate-50 hover:border-slate-300/80 active:scale-[0.98] transition-all duration-200">
                                <div class="w-10 h-10 bg-slate-50 text-slate-700 rounded-lg flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition duration-200 shrink-0 shadow-sm border border-slate-100">
                                    <svg class="w-5 h-5 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 0A48.536 48.536 0 0 1 12 3m0 0c2.917 0 5.747.294 8.5.862m-21 10.398c0-.552.448-1 1-1h6.25a1 1 0 0 1 1 1v3.83a1 1 0 0 1-1 1H2.5a1 1 0 0 1-1-1v-3.83Z"/></svg>
                                </div>
                                <div class="truncate">
                                    <span class="block text-sm font-semibold text-slate-800 group-hover:text-amber-600 transition truncate">Penerima</span>
                                    <span class="text-xs text-slate-400 block mt-0.5 truncate">Seleksi & validasi</span>
                                </div>
                            </a>

                            <a href="/penyaluran" class="group flex items-center gap-4 border border-slate-100 rounded-xl p-4 hover:bg-slate-50 hover:border-slate-300/80 active:scale-[0.98] transition-all duration-200">
                                <div class="w-10 h-10 bg-slate-50 text-slate-700 rounded-lg flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition duration-200 shrink-0 shadow-sm border border-slate-100">
                                    <svg class="w-5 h-5 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-5.25v9"/></svg>
                                </div>
                                <div class="truncate">
                                    <span class="block text-sm font-semibold text-slate-800 group-hover:text-purple-600 transition truncate">Penyaluran</span>
                                    <span class="text-xs text-slate-400 block mt-0.5 truncate">Logistik bantuan</span>
                                </div>
                            </a>

                            <a href="/laporan" class="group flex items-center gap-4 border border-slate-100 rounded-xl p-4 hover:bg-slate-50 hover:border-slate-300/80 active:scale-[0.98] transition-all duration-200">
                                <div class="w-10 h-10 bg-slate-50 text-slate-700 rounded-lg flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition duration-200 shrink-0 shadow-sm border border-slate-100">
                                    <svg class="w-5 h-5 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                                </div>
                                <div class="truncate">
                                    <span class="block text-sm font-semibold text-slate-800 group-hover:text-teal-600 transition truncate">Laporan</span>
                                    <span class="text-xs text-slate-400 block mt-0.5 truncate">Ekspor data</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    {{-- PENYALURAN TERBARU (Sleek Data List) --}}
                    <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Aktivitas Terkini</h2>
                                <p class="text-xs text-slate-400 mt-0.5">Log penyaluran bansos terbaru di lapangan</p>
                            </div>
                            <a href="/penyaluran" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition flex items-center gap-1">
                                Lihat Semua 
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                            </a>
                        </div>

                        <div class="space-y-1">
                            @forelse($penyaluranTerbaru ?? [] as $item)
                            <div class="flex justify-between items-center py-3 px-2 rounded-xl hover:bg-slate-50/80 transition duration-150">
                                <div class="flex items-center gap-3 truncate">
                                    <div class="w-8 h-8 bg-slate-100 text-slate-600 text-xs font-bold rounded-full flex items-center justify-center shrink-0">
                                        {{ uppercase(substr($item->warga->nama_lengkap ?? 'W', 0, 2)) }}
                                    </div>
                                    <div class="truncate">
                                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $item->warga->nama_lengkap ?? '-' }}</p>
                                        <p class="text-xs text-slate-400 flex items-center gap-1.5 mt-0.5">
                                            <span class="font-medium text-slate-500">{{ $item->jenisBansos->nama_bansos ?? '-' }}</span>
                                            <span class="text-slate-300">·</span>
                                            <span>{{ $item->created_at->format('d M Y') }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="shrink-0 pl-4">
                                    @if($item->status === 'tersalur')
                                        <span class="inline-flex text-[11px] bg-emerald-50 text-emerald-700 font-medium px-2.5 py-0.5 rounded-full border border-emerald-200/30">Tersalur</span>
                                    @elseif($item->status === 'pending')
                                        <span class="inline-flex text-[11px] bg-amber-50 text-amber-700 font-medium px-2.5 py-0.5 rounded-full border border-amber-200/30">Pending</span>
                                    @else
                                        <span class="inline-flex text-[11px] bg-blue-50 text-blue-700 font-medium px-2.5 py-0.5 rounded-full border border-blue-200/30">Diproses</span>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-10 border border-dashed border-slate-200 rounded-xl">
                                <svg class="w-8 h-8 text-slate-300 mx-auto mb-2 stroke-[1.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m16.5 0a2.25 2.25 0 0 0-2.25-2.25H6m12 0V4.5m0 0a2.25 2.25 0 0 0-2.25-2.25h-5.25A2.25 2.25 0 0 0 6 4.5v1.5m12 0a2.25 2.25 0 0 1-2.25 2.25H6"/></svg>
                                <p class="text-xs text-slate-400 font-medium">Belum ada rekaman log penyaluran</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                </div>

                {{-- RIGHT COLUMN: ANALYTICS PANEL (1/3 Width - Sidebar Style) --}}
                <div class="space-y-6">
                    
                    {{-- BRIEF STATS PANEL --}}
                    <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50 space-y-5">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Metrik Agregat</h2>
                        
                        <div class="flex items-center justify-between py-1.5">
                            <div>
                                <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Total Warga Terdata</p>
                                <p class="text-2xl font-bold text-slate-900 tracking-tight mt-0.5">{{ $totalWarga ?? 0 }}</p>
                            </div>
                            <span class="text-[10px] font-bold bg-blue-50 text-blue-600 px-2 py-0.5 rounded-md">KK</span>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 py-1.5">
                            <div>
                                <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Penerima Manfaat</p>
                                <p class="text-2xl font-bold text-slate-900 tracking-tight mt-0.5">{{ $totalPenerima ?? 0 }}</p>
                            </div>
                            <span class="text-[10px] font-bold bg-amber-50 text-amber-700 px-2 py-0.5 rounded-md">Jiwa</span>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 py-1.5">
                            <div>
                                <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Alokasi Tersalur</p>
                                <p class="text-2xl font-bold text-slate-900 tracking-tight mt-0.5">{{ $totalPenyaluran ?? 0 }}</p>
                            </div>
                            <span class="text-[10px] font-bold bg-purple-50 text-purple-700 px-2 py-0.5 rounded-md">Paket</span>
                        </div>
                    </div>

                    {{-- REALISASI TARGET (Sleek Progress Trackers) --}}
                    <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-5">Penyerapan Anggaran & Kuota</h2>
                        
                        <div class="space-y-5">
                            <div>
                                <div class="flex justify-between items-baseline text-xs mb-1.5">
                                    <span class="font-semibold text-slate-700">PKH</span>
                                    <span class="text-xs font-bold text-slate-800">{{ $realisasiPKH ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-slate-100/70 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $realisasiPKH ?? 0 }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between items-baseline text-xs mb-1.5">
                                    <span class="font-semibold text-slate-700">BLT Dana Desa</span>
                                    <span class="text-xs font-bold text-slate-800">{{ $realisasiBLT ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-slate-100/70 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-emerald-600 h-1.5 rounded-full" style="width: {{ $realisasiBLT ?? 0 }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between items-baseline text-xs mb-1.5">
                                    <span class="font-semibold text-slate-700">BPNT (Sembako)</span>
                                    <span class="text-xs font-bold text-slate-800">{{ $realisasiBPNT ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-slate-100/70 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $realisasiBPNT ?? 0 }}%"></div>
                                </div>
                            </div>

                            <div class="pt-4 mt-2 border-t border-slate-100">
                                <div class="flex justify-between items-baseline text-xs mb-2">
                                    <span class="font-bold text-slate-500 text-[10px] uppercase tracking-wider">Total Penyerapan Paripurna</span>
                                    <span class="text-sm font-extrabold text-indigo-600">{{ $realisasiTotal ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden shadow-inner">
                                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $realisasiTotal ?? 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- BANNER BOTTOM (Sleek Utility Link) --}}
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50 flex flex-col sm:flex-row gap-4 justify-between sm:items-center">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-700 flex items-center justify-center border border-slate-100 shrink-0">
                        <svg class="w-5 h-5 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 0 0 4.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Cek Transparansi Bansos Mandiri</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Tautan publik terisolasi agar warga dapat mengecek status data NIK mereka.</p>
                    </div>
                </div>
                <a href="/cek-bansos" class="inline-flex items-center justify-center text-xs text-slate-700 hover:text-indigo-600 font-semibold border border-slate-200 hover:border-indigo-200 px-4 py-2.5 rounded-xl hover:bg-indigo-50/40 active:scale-[0.97] transition-all duration-200 shrink-0 text-center shadow-sm bg-white">
                    Buka Halaman Publik &rarr;
                </a>
            </div>

        </div>
    </div>
</x-app-layout>