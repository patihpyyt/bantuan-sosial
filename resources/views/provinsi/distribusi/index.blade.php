<x-app-layout>
    {{-- HEADER HALAMAN --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 leading-tight">
                    Distribusi ke Kabupaten/Kota
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Ringkasan real-time, manajemen status, dan riwayat penyaluran dana distribusi per wilayah.
                </p>
            </div>
            <div>
                <a href="{{ route('provinsi.distribusi.create') }}" 
                   class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl shadow-sm shadow-blue-500/10 transition duration-200">
                    + Distribusi Baru
                </a>
            </div>
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
        @if(session('error'))
            <div class="flex items-center justify-between bg-red-50 border border-red-200 text-red-700 text-sm font-semibold p-4 rounded-xl shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        {{-- ================= RINGKASAN DATA / SUMMARY CARDS ================= --}}
        @php
            $totalDistribusiAktif = $distribusi->where('status', 'terkirim')->sum('jumlah');
            $totalDistribusiBatal = $distribusi->where('status', 'dibatalkan')->sum('jumlah');
            $jumlahTransaksi      = $distribusi->count();
            $jumlahKabupatenUnik  = $distribusi->where('status', 'terkirim')->pluck('kabupaten_id')->unique()->count();
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- TOTAL DANA TERDISTRIBUSI --}}
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-blue-600">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Dana Terdistribusi</p>
                <p class="text-xl font-black text-slate-900">Rp {{ number_format($totalDistribusiAktif, 0, ',', '.') }}</p>
            </div>
            
            {{-- JUMLAH TRANSAKSI --}}
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-emerald-600">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Jumlah Transaksi</p>
                <p class="text-xl font-black text-slate-900">{{ number_format($jumlahTransaksi) }} <span class="text-sm font-bold text-slate-400">transaksi</span></p>
            </div>
            
            {{-- KABUPATEN/KOTA MENERIMA --}}
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-cyan-600">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Kabupaten/Kota Menerima</p>
                <p class="text-xl font-black text-slate-900">{{ $jumlahKabupatenUnik }} <span class="text-sm font-bold text-slate-400">/ {{ $kabupatenList->count() }} wilayah</span></p>
            </div>
            
            {{-- DANA DIBATALKAN --}}
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-slate-400">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Dana Dibatalkan</p>
                <p class="text-xl font-black text-slate-500">Rp {{ number_format($totalDistribusiBatal, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- ================= FORM INTERAKTIF FILTER (AUTO-SUBMIT) ================= --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <form method="GET" class="flex flex-wrap items-center gap-3">
                
                {{-- FILTER TAHUN --}}
                <div class="w-full sm:w-auto min-w-[140px]">
                    <select name="tahun" onchange="this.form.submit()"
                        class="block w-full rounded-xl border-slate-200 text-sm font-semibold text-slate-700 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition">
                        @forelse($tahunTersedia as $t)
                            <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>Tahun {{ $t }}</option>
                        @empty
                            <option value="{{ $tahun }}" selected>Tahun {{ $tahun }}</option>
                        @endforelse
                    </select>
                </div>

                {{-- FILTER KABUPATEN --}}
                <div class="w-full sm:w-auto min-w-[240px]">
                    <select name="kabupaten_id" onchange="this.form.submit()"
                        class="block w-full rounded-xl border-slate-200 text-sm font-semibold text-slate-700 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition">
                        <option value="">Semua Kabupaten/Kota</option>
                        @foreach($kabupatenList as $kab)
                            <option value="{{ $kab->id }}" {{ (string) $filterKabupaten === (string) $kab->id ? 'selected' : '' }}>
                                {{ $kab->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- FILTER STATUS --}}
                <div class="w-full sm:w-auto min-w-[160px]">
                    <select name="status" onchange="this.form.submit()"
                        class="block w-full rounded-xl border-slate-200 text-sm font-semibold text-slate-700 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition">
                        <option value="">Semua Status</option>
                        <option value="terkirim" {{ request('status') === 'terkirim' ? 'selected' : '' }}>Terkirim</option>
                        <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                {{-- RESET BUTTON --}}
                @if($filterKabupaten || request('status'))
                    <a href="{{ route('provinsi.distribusi.index', ['tahun' => $tahun]) }}" 
                       class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 text-xs font-bold transition">
                        Reset Filter
                    </a>
                @endif
            </form>
        </div>

        {{-- ================= TABEL RIWAYAT DATA UTAMA ================= --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Kabupaten/Kota</th>
                            <th class="px-6 py-4 text-right">Jumlah</th>
                            <th class="px-6 py-4">Keterangan</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700 bg-white">
                        @forelse($distribusi as $d)
                            <tr class="hover:bg-slate-50/50 transition {{ $d->status === 'dibatalkan' ? 'bg-slate-50/70 text-slate-400' : '' }}">
                                <td class="px-6 py-4 font-medium text-slate-500">
                                    {{ optional($d->tanggal_distribusi)->format('d-m-Y') ?? '-' }}
                                </td>
                                <td class="px-6 py-4 font-bold {{ $d->status === 'dibatalkan' ? 'text-slate-400 line-through' : 'text-slate-900' }}">
                                    {{ $d->kabupaten->nama_lengkap ?? 'Data terhapus' }}
                                </td>
                                <td class="px-6 py-4 text-right font-bold {{ $d->status === 'dibatalkan' ? 'text-slate-400' : 'text-slate-900' }}">
                                    Rp {{ number_format($d->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 max-w-xs truncate font-medium">
                                    {{ $d->keterangan ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center">
                                        @if($d->status === 'terkirim')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                Terkirim
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                                Dibatalkan
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-1.5">
                                        {{-- EDIT --}}
                                        <a href="{{ route('provinsi.distribusi.edit', $d->id) }}"
                                           class="inline-flex items-center px-2.5 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 shadow-sm transition" title="Edit distribusi">
                                            Edit
                                        </a>

                                        {{-- RIWAYAT WILAYAH --}}
                                        <a href="{{ route('provinsi.distribusi.show', $d->kabupaten_id) }}"
                                           class="inline-flex items-center px-2.5 py-1.5 rounded-lg border border-blue-100 bg-blue-50/50 hover:bg-blue-50 text-xs font-bold text-blue-600 shadow-sm transition" title="Lihat riwayat kabupaten ini">
                                            Riwayat
                                        </a>

                                        {{-- PEMBATALAN STATUS --}}
                                        @if($d->status === 'terkirim')
                                            <form action="{{ route('provinsi.distribusi.cancel', $d->id) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Yakin batalkan distribusi Rp {{ number_format($d->jumlah, 0, ',', '.') }} ke {{ $d->kabupaten->nama_lengkap ?? '' }}?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg border border-amber-200 bg-white hover:bg-amber-50 text-xs font-bold text-amber-600 shadow-sm transition cursor-pointer">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif

                                        {{-- HAPUS PERMANEN --}}
                                        <form action="{{ route('provinsi.distribusi.destroy', $d->id) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Hapus data ini secara PERMANEN? Tindakan ini tidak bisa dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg border border-red-200 bg-white hover:bg-red-50 text-xs font-bold text-red-600 shadow-sm transition cursor-pointer">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-slate-400 font-medium py-12 bg-slate-50/20">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span>Belum ada distribusi untuk tahun {{ $tahun }}@if($filterKabupaten) pada kabupaten ini @endif.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    
                    @if($distribusi->count() > 0)
                        <tfoot>
                            <tr class="bg-slate-50 border-t border-slate-200 font-bold text-sm text-slate-900">
                                <td colspan="2" class="px-6 py-4 text-right text-slate-500 font-semibold">Total (status terkirim):</td>
                                <td class="px-6 py-4 text-right text-base font-black text-blue-600">Rp {{ number_format($totalDistribusiAktif, 0, ',', '.') }}</td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</x-app-layout>