<x-app-layout>
    {{-- HEADER HALAMAN --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 leading-tight">
                    Tambah Alokasi Anggaran
                </h2>
                <p class="text-sm text-slate-500 mt-1">Input distribusi alokasi anggaran baru untuk tingkat Kabupaten/Kota.</p>
            </div>
            <div>
                <a href="{{ route('anggaran.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl shadow-sm transition">
                    &larr; Kembali ke Daftar Anggaran
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        {{-- ERROR VALIDASI --}}
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                <div class="flex items-center gap-2 font-bold mb-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>Ada kesalahan pada input kamu:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 text-xs font-medium pl-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM UTAMA --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <form action="{{ route('anggaran.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- KABUPATEN / KOTA --}}
                    <div class="md:col-span-2">
                        <label for="kabupaten_id" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
                            Kabupaten/Kota Tujuan
                        </label>
                        <select name="kabupaten_id" id="kabupaten_id" 
                            class="block w-full rounded-xl border-slate-200 text-sm font-medium text-slate-700 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition py-3 px-4 @error('kabupaten_id') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" required>
                            <option value="" disabled selected>-- Pilih Kabupaten/Kota --</option>
                            @foreach($kabupaten as $kab)
                                <option value="{{ $kab->id }}" {{ old('kabupaten_id') == $kab->id ? 'selected' : '' }}>
                                    {{ $kab->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                        @error('kabupaten_id')
                            <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- TAHUN ANGGARAN --}}
                    <div>
                        <label for="tahun" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
                            Tahun Anggaran
                        </label>
                        <input type="number" name="tahun" id="tahun" min="2000" max="2100"
                            class="block w-full rounded-xl border-slate-200 text-sm text-slate-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition py-3 px-4 @error('tahun') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror"
                            value="{{ old('tahun', date('Y')) }}" required>
                        @error('tahun')
                            <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- JUMLAH ANGGARAN --}}
                    <div>
                        <label for="total_anggaran_display" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
                            Jumlah Anggaran (Rp)
                        </label>
                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-sm font-bold text-slate-400 select-none">Rp</span>
                            <input type="text" id="total_anggaran_display" inputmode="numeric" autocomplete="off" placeholder="Contoh: 234.000.000"
                                class="block w-full pl-11 pr-4 py-3 rounded-xl border-slate-200 text-sm font-bold text-slate-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition @error('total_anggaran') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror"
                                value="{{ old('total_anggaran') ? number_format(old('total_anggaran'), 0, ',', '.') : '' }}" required>
                        </div>
                        <input type="hidden" name="total_anggaran" id="total_anggaran" value="{{ old('total_anggaran') }}">
                        <p class="mt-1.5 text-[11px] font-medium text-slate-400">Titik otomatis menyesuaikan saat mengetik.</p>
                        @error('total_anggaran')
                            <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- TOMBOL AKSI --}}
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <button type="submit" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-6 py-3 rounded-xl shadow-sm transition cursor-pointer">
                        Simpan Anggaran
                    </button>
                    <a href="{{ route('anggaran.index') }}" class="inline-flex items-center px-6 py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-sm font-bold shadow-sm transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const display = document.getElementById('total_anggaran_display');
            const hidden  = document.getElementById('total_anggaran');

            display.addEventListener('input', function () {
                let angka = display.value.replace(/\D/g, '');
                hidden.value = angka;
                display.value = angka ? new Intl.NumberFormat('id-ID').format(angka) : '';
            });
        });
    </script>
</x-app-layout>