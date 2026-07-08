<x-app-layout>
    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="mb-8">
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Dashboard Warga</h2>
            <p class="text-sm text-slate-400 mt-1">
                @if(!empty($dataDiri) && $dataDiri->rt)
                    Data tetangga di lingkungan RT {{ $dataDiri->rt }} / RW {{ $dataDiri->rw }}
                @else
                    Data lingkungan RT/RW Anda
                @endif
            </p>
        </div>

        @if($belumTerdaftar)
            {{-- KONDISI: DATA WARGA BELUM DIINPUT PETUGAS --}}
            <div class="bg-white border border-amber-200 rounded-2xl p-8 text-center shadow-sm">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-amber-50 flex items-center justify-center">
                    <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-800 mb-1">Data Anda Belum Terdaftar</h3>
                <p class="text-sm text-slate-400 max-w-md mx-auto">
                    Data kependudukan dan RT/RW Anda belum diinput oleh petugas desa.
                    Silakan hubungi kantor desa untuk melengkapi data Anda.
                </p>
            </div>
        @else
            {{-- STAT CARDS (gaya sama seperti dashboard petugas) --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Tetangga</p>
                    <p class="text-3xl font-extrabold text-slate-900 mt-1">{{ $tetangga->count() }}</p>
                    <p class="text-xs text-slate-400 mt-1">RT {{ $dataDiri->rt }} / RW {{ $dataDiri->rw }}</p>
                </div>
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Penerima Bansos</p>
                    <p class="text-3xl font-extrabold text-emerald-600 mt-1">
                        {{ $tetangga->where('status_bansos', 'Terdaftar sebagai penerima bansos')->count() }}
                    </p>
                    <p class="text-xs text-slate-400 mt-1">Terverifikasi petugas</p>
                </div>
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Belum Terdaftar</p>
                    <p class="text-3xl font-extrabold text-slate-500 mt-1">
                        {{ $tetangga->where('status_bansos', 'Belum terdaftar')->count() }}
                    </p>
                    <p class="text-xs text-slate-400 mt-1">Belum menerima bansos</p>
                </div>
            </div>

            {{-- SEARCH BAR --}}
            <form method="GET" action="{{ route('dashboard') }}" class="mb-6">
                <div class="flex gap-2">
                    <input
                        type="text"
                        name="keyword"
                        value="{{ $keyword ?? '' }}"
                        placeholder="Cari nama atau NIK tetangga di RT/RW Anda..."
                        class="flex-1 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition duration-200"
                    >
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-500/20 transition duration-200 cursor-pointer">
                        Cari
                    </button>
                    @if($keyword)
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-500 font-semibold text-sm rounded-xl transition duration-200">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            {{-- TABEL TETANGGA --}}
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                @if($tetangga->count() > 0)
                    <table class="w-full text-sm">
                        <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                            <th class="px-5 py-3">Nama</th>
                            <th class="px-5 py-3">NIK</th>
                            <th class="px-5 py-3">RT/RW</th>
                            <th class="px-5 py-3">Alamat</th>
                            <th class="px-5 py-3">Status Bansos</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                                        <tbody class="divide-y divide-slate-100">
                    @foreach($tetangga as $warga)
                        <tr class="hover:bg-slate-50/60 transition">

                            <td class="px-5 py-4 font-semibold text-slate-800">
                                {{ $warga->nama_lengkap }}
                            </td>

                            <td class="px-5 py-4 text-slate-500">
                                {{ $warga->nik }}
                            </td>

                            <td class="px-5 py-4 text-slate-500 font-medium">
                                RT {{ $warga->rt }} / RW {{ $warga->rw }}
                            </td>

                            <td class="px-5 py-4 text-slate-500">
                                {{ $warga->alamat }}
                            </td>

                            <td class="px-5 py-4">
                                <span class="text-[11px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-lg
                                    {{ $warga->status_bansos === 'Terdaftar sebagai penerima bansos'
                                        ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                                        : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                                    {{ $warga->status_bansos }}
                                </span>
                            </td>

                            <td class="px-5 py-4 text-right">
                                <button type="button"
                                    class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs rounded-lg border border-red-200 transition cursor-pointer">
                                    Sanggah
                                </button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
                    </table>
                @else
                    <div class="text-center py-12">
                        <p class="text-sm text-slate-400">
                            @if($keyword)
                                Tidak ada tetangga ditemukan untuk "<span class="font-semibold text-slate-600">{{ $keyword }}</span>".
                            @else
                                Belum ada data tetangga lain di RT/RW Anda.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        @endif

    </div>
</x-app-layout>