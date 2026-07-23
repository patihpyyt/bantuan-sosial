<x-app-layout>
    {{-- SLOT HEADER UTAMA --}}
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            Distribusi Dana ke Kecamatan
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- NOTIFIKASI FLASH MESSAGES --}}
        @if(session('success'))
            <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold p-4 rounded-xl shadow-sm">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- BARIS ATAS: JUDUL & TOMBOL TAMBAH --}}
        <div class="flex items-center justify-between">
            <h5 class="text-base font-bold text-slate-700 tracking-tight">Daftar Distribusi</h5>
            <a href="{{ route('kabupaten.distribusi.create') }}" 
               class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-sm transition">
                + Distribusi Baru
            </a>
        </div>

        {{-- KARTU UTAMA & TABEL DATA --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    
                    {{-- THEAD STYLING --}}
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 tracking-wider">
                            <th class="px-5 py-3.5 text-center w-12">No</th>
                            <th class="px-5 py-3.5">Kecamatan</th>
                            <th class="px-5 py-3.5 text-center w-20">Tahun</th>
                            <th class="px-5 py-3.5 text-right">Jumlah Dana</th>
                            <th class="px-5 py-3.5 text-center">Tanggal</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5 text-center w-48">Aksi</th>
                        </tr>
                    </thead>

                    {{-- TBODY STYLING --}}
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($distribusi as $item)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-5 py-4 text-center text-slate-400 font-medium">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-5 py-4 font-semibold text-slate-900">
                                    {{ $item->kecamatan->nama_lengkap ?? '-' }}
                                </td>
                                <td class="px-5 py-4 text-center font-medium text-slate-600">
                                    {{ $item->tahun }}
                                </td>
                                <td class="px-5 py-4 text-right font-bold text-slate-900">
                                    Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 text-center text-slate-500 font-medium">
                                    {{ \Carbon\Carbon::parse($item->tanggal_distribusi)->format('d-m-Y') }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @if($item->status == 'terkirim')
                                        <span class="inline-flex text-[11px] bg-blue-50 text-blue-700 font-bold px-2.5 py-0.5 rounded-full border border-blue-200/40">Terkirim</span>
                                    @elseif($item->status == 'diterima')
                                        <span class="inline-flex text-[11px] bg-emerald-50 text-emerald-700 font-bold px-2.5 py-0.5 rounded-full border border-emerald-200/40">Diterima</span>
                                    @else
                                        <span class="inline-flex text-[11px] bg-rose-50 text-rose-600 font-bold px-2.5 py-0.5 rounded-full border border-rose-200/40">Dibatalkan</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <div class="inline-flex items-center justify-center gap-2">
                                        {{-- DETAIL --}}
                                        <a href="{{ route('kabupaten.distribusi.show', $item->id) }}"
                                           class="text-xs font-bold text-sky-600 hover:text-sky-700 hover:underline transition">
                                            Detail
                                        </a>

                                        <span class="text-slate-300">|</span>

                                        {{-- EDIT --}}
                                        <a href="{{ route('kabupaten.distribusi.edit', $item->id) }}"
                                           class="text-xs font-bold text-amber-600 hover:text-amber-700 hover:underline transition">
                                            Edit
                                        </a>

                                        <span class="text-slate-300">|</span>

                                        {{-- BATALKAN --}}
                                        <form action="{{ route('kabupaten.distribusi.cancel', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="text-xs font-bold text-rose-600 hover:text-rose-700 hover:underline transition"
                                                    onclick="return confirm('Batalkan distribusi ini?')">
                                                Batalkan
                                            </button>
                                        </form>

                                        <span class="text-slate-300">|</span>

                                        {{-- HAPUS --}}
                                        <form action="{{ route('kabupaten.distribusi.destroy', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-xs font-bold text-slate-500 hover:text-slate-700 hover:underline transition"
                                                    onclick="return confirm('Yakin ingin menghapus distribusi ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-slate-400 font-medium py-12 bg-slate-50/10">
                                    Belum ada data distribusi dana alokasi yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</x-app-layout>