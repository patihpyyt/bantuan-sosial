<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Distribusi Dana ke Kelurahan
        </h2>
    </x-slot>

    <div class="py-10 bg-[#f8fafc] min-h-screen font-sans antialiased">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- PANEL NOTIFIKASI ERROR VALIDASI --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 text-sm font-medium rounded-2xl px-5 py-4 shadow-sm">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <span class="font-bold block mb-1">Periksa kembali isian Anda:</span>
                            <ul class="list-disc list-inside space-y-0.5 text-xs text-red-700/90 font-normal">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- PANEL NOTIFIKASI ERROR SESSION --}}
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 text-sm font-medium rounded-2xl px-5 py-4 flex items-start gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-red-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- CARD UTAMA FORM --}}
            <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm shadow-slate-100/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Formulir Alokasi Distribusi Kelurahan</h3>
                    <p class="text-xs text-slate-400 mt-1">Silakan tentukan kelurahan sasaran, nominal dana, serta rincian distribusi bantuan.</p>
                </div>

                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('kecamatan.distribusi.store') }}" class="space-y-6">
                        @csrf

                        {{-- BARIS 1: KELURAHAN & TAHUN --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                                    Kelurahan Sasaran
                                </label>
                                <div class="relative">
                                    <select
                                        name="kelurahan_id"
                                        class="w-full text-sm text-slate-700 bg-white border border-slate-200 rounded-xl px-4 py-2.5 appearance-none transition focus:outline-none focus:ring-2 focus:ring-blue-600/10 focus:border-blue-600"
                                        required>
                                        <option value="">-- Pilih Kelurahan --</option>
                                        @foreach($kelurahan as $k)
                                            <option value="{{ $k->id }}" {{ old('kelurahan_id') == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_lengkap }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                                    Tahun Anggaran
                                </label>
                                <input
                                    type="number"
                                    name="tahun"
                                    class="w-full text-sm text-slate-700 bg-white border border-slate-200 rounded-xl px-4 py-2.5 transition focus:outline-none focus:ring-2 focus:ring-blue-600/10 focus:border-blue-600"
                                    value="{{ old('tahun', now()->year) }}"
                                    required>
                            </div>
                        </div>

                        {{-- BARIS 2: JUMLAH DANA & TANGGAL --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                                    Jumlah Dana (Nominal)
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 font-semibold text-sm">Rp</span>
                                    <input
                                        type="text"
                                        id="jumlah_display"
                                        class="w-full text-sm font-bold text-slate-800 bg-white border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 transition focus:outline-none focus:ring-2 focus:ring-blue-600/10 focus:border-blue-600"
                                        placeholder="Masukkan nominal"
                                        inputmode="numeric"
                                        autocomplete="off"
                                        value="{{ old('jumlah') ? number_format(old('jumlah'), 0, ',', '.') : '' }}"
                                        required>
                                    <input type="hidden" name="jumlah" id="jumlah_asli" value="{{ old('jumlah') }}">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                                    Tanggal Distribusi
                                </label>
                                <input
                                    type="date"
                                    name="tanggal_distribusi"
                                    class="w-full text-sm text-slate-700 bg-white border border-slate-200 rounded-xl px-4 py-2.5 transition focus:outline-none focus:ring-2 focus:ring-blue-600/10 focus:border-blue-600"
                                    value="{{ old('tanggal_distribusi', now()->format('Y-m-d')) }}"
                                    required>
                            </div>
                        </div>

                        {{-- BARIS 3: STATUS --}}
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                                Status Distribusi
                            </label>
                            <div class="relative">
                                <select
                                    name="status"
                                    class="w-full text-sm text-slate-700 bg-white border border-slate-200 rounded-xl px-4 py-2.5 appearance-none transition focus:outline-none focus:ring-2 focus:ring-blue-600/10 focus:border-blue-600">
                                    <option value="terkirim" {{ old('status') == 'terkirim' ? 'selected' : '' }}>Terkirim</option>
                                    <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- BARIS 4: KETERANGAN --}}
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                                Keterangan Tambahan
                            </label>
                            <textarea
                                name="keterangan"
                                rows="4"
                                placeholder="Tulis rincian atau keterangan mengenai distribusi dana bantuan ini..."
                                class="w-full text-sm text-slate-700 bg-white border border-slate-200 rounded-xl px-4 py-2.5 transition focus:outline-none focus:ring-2 focus:ring-blue-600/10 focus:border-blue-600">{{ old('keterangan') }}</textarea>
                        </div>

                        {{-- AKSI TOMBOL --}}
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                            <a href="{{ route('kecamatan.distribusi.index') }}"
                                class="inline-flex items-center justify-center text-xs font-semibold px-5 py-2.5 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 transition-all">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center justify-center text-xs font-bold px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition-all shadow-md shadow-blue-600/10 hover:shadow-lg hover:shadow-blue-600/15">
                                Simpan Distribusi
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- SCRIPTS AUTO-FORMAT RUPIAH --}}
    <script>
        const inputDisplay = document.getElementById('jumlah_display');
        const inputAsli = document.getElementById('jumlah_asli');

        inputDisplay.addEventListener('input', function (e) {
            let angka = e.target.value.replace(/\D/g, '');
            inputAsli.value = angka;
            e.target.value = angka
                ? new Intl.NumberFormat('id-ID').format(angka)
                : '';
        });

        document.querySelector('form').addEventListener('submit', function () {
            let angka = inputDisplay.value.replace(/\D/g, '');
            inputAsli.value = angka;
        });
    </script>
</x-app-layout>