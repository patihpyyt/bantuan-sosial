<x-app-layout>
    <div class="py-10 bg-[#f8fafc] min-h-screen font-sans antialiased selection:bg-blue-500 selection:text-white">
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
                        <span class="text-[11px] font-medium tracking-wider text-slate-400 uppercase">Dashboard Tingkat Provinsi</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight text-white leading-[1.15]">
                        Selamat datang kembali,<br>
                        <span class="bg-gradient-to-r from-blue-400 via-indigo-200 to-white bg-clip-text text-transparent font-bold">
                            {{ Auth::user()->nama_lengkap ?? Auth::user()->name }}
                        </span>
                    </h1>
                    <p class="mt-3 text-slate-400 text-sm sm:text-base font-normal leading-relaxed">
                        Pantau alokasi anggaran, distribusi dana, dan realisasi bantuan sosial di seluruh Kabupaten/Kota.
                    </p>
                </div>
            </div>

            {{-- MENU CEPAT / SHORTCUT FITUR PROVINSI --}}
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Akses Kontrol Provinsi</h2>
                    <span class="text-[11px] text-slate-400 font-medium">4 Modul Tersedia</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('dashboard.provinsi') }}" class="group flex items-center gap-4 border border-slate-100 rounded-xl p-4 hover:bg-slate-50 hover:border-slate-300/80 active:scale-[0.98] transition-all duration-200">
                        <div class="w-10 h-10 bg-slate-50 text-slate-700 rounded-lg flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition duration-200 shrink-0 shadow-sm border border-slate-100">
                            <svg class="w-5 h-5 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                        </div>
                        <div class="truncate">
                            <span class="block text-sm font-semibold text-slate-800 group-hover:text-blue-600 transition truncate">Dashboard Provinsi</span>
                            <span class="text-xs text-slate-400 block mt-0.5 truncate">Ringkasan utama</span>
                        </div>
                    </a>

                    <a href="{{ route('anggaran.index') }}" class="group flex items-center gap-4 border border-slate-100 rounded-xl p-4 hover:bg-slate-50 hover:border-slate-300/80 active:scale-[0.98] transition-all duration-200">
                        <div class="w-10 h-10 bg-slate-50 text-slate-700 rounded-lg flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition duration-200 shrink-0 shadow-sm border border-slate-100">
                            <svg class="w-5 h-5 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182 1.106-.879 2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="truncate">
                            <span class="block text-sm font-semibold text-slate-800 group-hover:text-emerald-600 transition truncate">Kelola Anggaran</span>
                            <span class="text-xs text-slate-400 block mt-0.5 truncate">Alokasi dana bansos</span>
                        </div>
                    </a>

                    <a href="{{ route('provinsi.distribusi.index') }}" class="group flex items-center gap-4 border border-slate-100 rounded-xl p-4 hover:bg-slate-50 hover:border-slate-300/80 active:scale-[0.98] transition-all duration-200">
                        <div class="w-10 h-10 bg-slate-50 text-slate-700 rounded-lg flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition duration-200 shrink-0 shadow-sm border border-slate-100">
                            <svg class="w-5 h-5 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-5.25v9"/></svg>
                        </div>
                        <div class="truncate">
                            <span class="block text-sm font-semibold text-slate-800 group-hover:text-amber-600 transition truncate">Distribusi</span>
                            <span class="text-xs text-slate-400 block mt-0.5 truncate">Ke Kabupaten/Kota</span>
                        </div>
                    </a>

                    <a href="{{ route('provinsi.monitoring.index') }}" class="group flex items-center gap-4 border border-slate-100 rounded-xl p-4 hover:bg-slate-50 hover:border-slate-300/80 active:scale-[0.98] transition-all duration-200">
                        <div class="w-10 h-10 bg-slate-50 text-slate-700 rounded-lg flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition duration-200 shrink-0 shadow-sm border border-slate-100">
                            <svg class="w-5 h-5 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z"/></svg>
                        </div>
                        <div class="truncate">
                            <span class="block text-sm font-semibold text-slate-800 group-hover:text-purple-600 transition truncate">Monitoring</span>
                            <span class="text-xs text-slate-400 block mt-0.5 truncate">Seluruh wilayah</span>
                        </div>
                    </a>
                </div>
            </div>

            {{-- 2-COLUMN ASYMMETRIC LAYOUT --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                {{-- LEFT COLUMN: CORE CONTENT (2/3 Width) --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- RINGKASAN WILAYAH --}}
                    <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-5">Cakupan Wilayah</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="border border-slate-100 rounded-xl p-4">
                                <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Kabupaten/Kota</p>
                                <p class="text-2xl font-bold text-slate-900 tracking-tight mt-1">{{ $totalKabupaten }}</p>
                            </div>
                            <div class="border border-slate-100 rounded-xl p-4">
                                <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Kecamatan</p>
                                <p class="text-2xl font-bold text-slate-900 tracking-tight mt-1">{{ $totalKecamatan }}</p>
                            </div>
                            <div class="border border-slate-100 rounded-xl p-4">
                                <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Kelurahan</p>
                                <p class="text-2xl font-bold text-slate-900 tracking-tight mt-1">{{ $totalKelurahan }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- RINGKASAN ANGGARAN --}}
                    <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-5">Ringkasan Anggaran</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
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

                    {{-- GRAFIK PENYALURAN PER BULAN --}}
                    <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50">
                        <div class="flex justify-between items-center mb-5">
                            <div>
                                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tren Penyaluran Dana</h2>
                                <p class="text-xs text-slate-400 mt-0.5">Sepanjang tahun {{ now()->year }}</p>
                            </div>
                        </div>
                        <canvas id="chartPenyaluran" height="90"></canvas>
                    </div>

                    {{-- DISTRIBUSI PER KABUPATEN (Sleek Data List) --}}
                    <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Distribusi Dana per Kabupaten/Kota</h2>
                                <p class="text-xs text-slate-400 mt-0.5">Ringkasan realisasi penyaluran per wilayah</p>
                            </div>
                            <a href="{{ route('provinsi.distribusi.create') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition flex items-center gap-1 shrink-0">
                                + Distribusi Baru
                            </a>
                        </div>

                        <div class="space-y-1">
                            @forelse($distribusiKabupaten as $d)
                            <div class="flex justify-between items-center py-3 px-2 rounded-xl hover:bg-slate-50/80 transition duration-150">
                                <div class="flex items-center gap-3 truncate">
                                    <div class="w-8 h-8 bg-slate-100 text-slate-600 text-xs font-bold rounded-full flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($d->kabupaten ?? 'K', 0, 2)) }}
                                    </div>
                                    <div class="truncate">
                                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $d->kabupaten }}</p>
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

                {{-- RIGHT COLUMN: ANALYTICS PANEL (1/3 Width - Sidebar Style) --}}
                <div class="space-y-6">

                    {{-- BRIEF STATS PANEL --}}
                    <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50 space-y-5">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Metrik Agregat</h2>

                        <div class="flex items-center justify-between py-1.5">
                            <div>
                                <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Total Warga</p>
                                <p class="text-2xl font-bold text-slate-900 tracking-tight mt-0.5">{{ number_format($totalWarga) }}</p>
                            </div>
                            <span class="text-[10px] font-bold bg-blue-50 text-blue-600 px-2 py-0.5 rounded-md">Jiwa</span>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 py-1.5">
                            <div>
                                <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Penerima Bansos</p>
                                <p class="text-2xl font-bold text-slate-900 tracking-tight mt-0.5">{{ number_format($totalPenerima) }}</p>
                            </div>
                            <span class="text-[10px] font-bold bg-amber-50 text-amber-700 px-2 py-0.5 rounded-md">Jiwa</span>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 py-1.5">
                            <div>
                                <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Jenis Program</p>
                                <p class="text-2xl font-bold text-slate-900 tracking-tight mt-0.5">{{ $totalProgram }}</p>
                            </div>
                            <span class="text-[10px] font-bold bg-purple-50 text-purple-700 px-2 py-0.5 rounded-md">Program</span>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 py-1.5">
                            <div>
                                <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Dana Tersalurkan</p>
                                <p class="text-lg font-bold text-slate-900 tracking-tight mt-0.5">Rp {{ number_format($totalDana, 0, ',', '.') }}</p>
                            </div>
                            <span class="text-[10px] font-bold bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-md">Total</span>
                        </div>
                    </div>

                    {{-- PENYERAPAN ANGGARAN (Sleek Progress Tracker) --}}
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const bulanLabel = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
        const rawData = @json($grafikPenyaluran);

        const dataPerBulan = Array(12).fill(0);
        rawData.forEach(item => {
            dataPerBulan[item.bulan - 1] = parseFloat(item.total);
        });

        new Chart(document.getElementById('chartPenyaluran'), {
            type: 'line',
            data: {
                labels: bulanLabel,
                datasets: [{
                    label: 'Total Penyaluran (Rp)',
                    data: dataPerBulan,
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79,70,229,0.08)',
                    fill: true,
                    tension: 0.35,
                    pointRadius: 3,
                    pointBackgroundColor: '#4f46e5',
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { ticks: { callback: value => 'Rp ' + value.toLocaleString('id-ID') } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</x-app-layout>