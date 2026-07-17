<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Distribusi Dana ke Kecamatan
        </h2>
    </x-slot>

    <div class="py-10 bg-[#f8fafc] min-h-screen font-sans antialiased">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- PANEL NOTIFIKASI ERROR VALIDASI --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 text-sm font-medium rounded-2xl px-5 py-4 shadow-sm">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
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
                    <svg class="w-5 h-5 text-red-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- CARD UTAMA FORM --}}
            <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm shadow-slate-100/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Formulir Alokasi Distribusi</h3>
                    <p class="text-xs text-slate-400 mt-1">Silakan tentukan tujuan kecamatan dan nominal dana bantuan yang akan didistribusikan.</p>
                </div>

                <div class="p-6 sm:p-8">
                    <form action="{{ route('kabupaten.distribusi.store') }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- BARIS 1: KECAMATAN & TAHUN --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                                    Kecamatan Tujuan
                                </label>
                                <div class="relative">
                                    <select
                                        name="kecamatan_id"
                                        class="w-full text-sm text-slate-700 bg-white border border-slate-200 rounded-xl px-4 py-2.5 appearance-none transition focus:outline-none focus:ring-2 focus:ring-blue-600/10 focus:border-blue-600"
                                        required>
                                        <option value="">-- Pilih Kecamatan --</option>
                                        @foreach($kecamatan as $item)
                                            <option value="{{ $item->id }}" {{ old('kecamatan_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_lengkap }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
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
                                    value="{{ old('tahun', date('Y')) }}"
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
                                        placeholder="Masukkan nominal dana"
                                        inputmode="numeric"
                                        autocomplete="off"
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
                                    value="{{ old('tanggal_distribusi', date('Y-m-d')) }}"
                                    class="w-full text-sm text-slate-700 bg-white border border-slate-200 rounded-xl px-4 py-2.5 transition focus:outline-none focus:ring-2 focus:ring-blue-600/10 focus:border-blue-600"
                                    required>
                            </div>
                        </div>

                        {{-- BARIS 3: KETERANGAN --}}
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
                            <a href="{{ route('kabupaten.distribusi.index') }}"
                                class="inline-flex items-center justify-center text-xs font-semibold px-5 py-2.5 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 transition-all">
                                Kembali
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

        // Fungsi format pemisah ribuan
        function formatRupiah(value) {
            let angka = value.replace(/\D/g, '');
            inputAsli.value = angka;
            return angka ? new Intl.NumberFormat('id-ID').format(angka) : '';
        }

        // Set value awal jika ada old value dari backend (redirect back saat validasi gagal)
        if (inputAsli.value) {
            inputDisplay.value = new Intl.NumberFormat('id-ID').format(inputAsli.value);
        }

        inputDisplay.addEventListener('input', function (e) {
            e.target.value = formatRupiah(e.target.value);
        });

        document.querySelector('form').addEventListener('submit', function () {
            let angka = inputDisplay.value.replace(/\D/g, '');
            inputAsli.value = angka;
        });
    </script>
</x-app-layout>