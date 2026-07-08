<x-app-layout>
    <div class="max-w-2xl mx-auto py-10 px-4">

        <div class="mb-8 text-center">
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Cek Data Bansos Warga</h2>
            <p class="text-sm text-slate-400 mt-1">Cari nama atau NIK untuk melihat status penerima bansos.</p>
        </div>

        {{-- SEARCH BAR --}}
        <form method="GET" action="{{ route('dashboard.cari-warga') }}" class="mb-8">
            <div class="flex gap-2">
                <input
                    type="text"
                    name="keyword"
                    value="{{ $keyword ?? '' }}"
                    placeholder="Masukkan Nama atau NIK..."
                    minlength="3"
                    required
                    class="flex-1 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition duration-200"
                >
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-500/20 transition duration-200 cursor-pointer">
                    Cari
                </button>
            </div>
            @error('keyword')
                <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
            @enderror
        </form>

        {{-- HASIL PENCARIAN --}}
        @if(isset($hasil))
            @if($hasil->count() > 0)
                <div class="space-y-4">
                    @foreach($hasil as $warga)
                        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h3 class="font-bold text-slate-900">{{ $warga->nama_lengkap }}</h3>
                                    <p class="text-xs text-slate-400 mt-0.5">NIK: {{ $warga->nik }}</p>
                                    <p class="text-xs text-slate-500 mt-2">{{ $warga->alamat }}</p>

                                    <span class="inline-block mt-3 text-[11px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-lg
                                        {{ $warga->status_bansos === 'Terdaftar sebagai penerima bansos'
                                            ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                                            : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                                        {{ $warga->status_bansos }}
                                    </span>
                                </div>

                                <button type="button"
                                    class="shrink-0 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs rounded-lg border border-red-200 transition cursor-pointer">
                                    Sanggah
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10">
                    <p class="text-sm text-slate-400">Tidak ada data ditemukan untuk "<span class="font-semibold text-slate-600">{{ $keyword }}</span>".</p>
                </div>
            @endif
        @endif

    </div>
</x-app-layout>