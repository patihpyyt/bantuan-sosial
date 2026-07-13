<x-app-layout>
    {{-- HEADER HALAMAN --}}
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-slate-900 leading-tight">
            Alokasi Anggaran ke Kabupaten/Kota
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        {{-- TOMBOL ANGGARAN BARU --}}
        <div class="flex justify-end mb-6">
            <a href="{{ route('anggaran.create') }}" 
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-4 py-2.5 rounded-xl shadow-sm shadow-blue-500/10 transition duration-200 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                + Anggaran Baru
            </a>
        </div>

        {{-- NOTIFIKASI / ALERTS --}}
        @if(session('success'))
            <div class="mb-6 flex items-center justify-between bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold p-4 rounded-xl shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-6 flex items-center justify-between bg-red-50 border border-red-200 text-red-700 text-sm font-semibold p-4 rounded-xl shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        {{-- ================= RINGKASAN / SUMMARY CARDS ================= --}}
        @php
            $totalAnggaran       = $anggaran->sum('total_anggaran');
            $jumlahTransaksi     = $anggaran->count();
            $jumlahKabupatenUnik = $anggaran->pluck('kabupaten_id')->unique()->count();
            $tahunAktif          = $anggaran->pluck('tahun')->unique()->count();
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            {{-- CARD TOTAL ANGGARAN --}}
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm border-l-4 border-l-blue-600">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Anggaran Dialokasikan</p>
                <p class="text-lg font-black text-slate-900">Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</p>
            </div>
            {{-- CARD JUMLAH TRANSAKSI --}}
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm border-l-4 border-l-emerald-600">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Jumlah Transaksi</p>
                <p class="text-lg font-black text-slate-900">{{ number_format($jumlahTransaksi) }} <span class="text-sm font-semibold text-slate-500">transaksi</span></p>
            </div>
            {{-- CARD KABUPATEN --}}
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm border-l-4 border-l-cyan-600">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Kabupaten/Kota Menerima</p>
                <p class="text-lg font-black text-slate-900">{{ $jumlahKabupatenUnik }} <span class="text-sm font-semibold text-slate-500">wilayah</span></p>
            </div>
            {{-- CARD TAHUN --}}
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm border-l-4 border-l-slate-600">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tahun Anggaran Tercatat</p>
                <p class="text-lg font-black text-slate-900">{{ $tahunAktif }} <span class="text-sm font-semibold text-slate-500">tahun</span></p>
            </div>
        </div>

        {{-- ================= TABEL RIWAYAT ANGGARAN ================= --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="px-6 py-3.5">Tanggal</th>
                            <th class="px-6 py-3.5">Kabupaten/Kota</th>
                            <th class="px-6 py-3.5">Tahun</th>
                            <th class="px-6 py-3.5 text-right">Jumlah Anggaran</th>
                            <th class="px-6 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($anggaran as $item)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-6 py-4 font-medium text-slate-500">
                                    {{ optional($item->created_at)->format('d-m-Y') ?? '-' }}
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-900">
                                    {{ $item->kabupaten->nama_lengkap ?? 'Data terhapus' }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-600">
                                    {{ $item->tahun ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-slate-900">
                                    Rp {{ number_format($item->total_anggaran, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('anggaran.edit', $item->id) }}"
                                           class="inline-flex items-center px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 shadow-sm transition" 
                                           title="Edit anggaran">
                                            Edit
                                        </a>
                                        <form action="{{ route('anggaran.destroy', $item->id) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Yakin hapus alokasi anggaran Rp {{ number_format($item->total_anggaran, 0, ',', '.') }} untuk {{ $item->kabupaten->nama_lengkap ?? '' }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg border border-red-200 bg-white hover:bg-red-50 text-xs font-bold text-red-600 shadow-sm transition cursor-pointer">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-slate-400 font-medium py-12 bg-slate-50/30">
                                    Belum ada data anggaran yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    
                    @if($anggaran->count() > 0)
                        <tfoot>
                            <tr class="bg-slate-50 border-t border-slate-200 font-bold text-sm text-slate-900">
                                <td colspan="3" class="px-6 py-4 text-right text-slate-500 font-semibold">Total Anggaran:</td>
                                <td class="px-6 py-4 text-right text-base font-black text-blue-600">Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</x-app-layout>