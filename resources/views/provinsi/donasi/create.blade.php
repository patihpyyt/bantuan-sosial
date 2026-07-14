<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Salurkan Dana Donasi
        </h2>
    </x-slot>

    <div class="py-10 bg-[#f8fafc] min-h-screen font-sans antialiased">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 text-sm font-medium rounded-xl px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 text-sm font-medium rounded-xl px-4 py-3">
                    <p class="mb-1">Terdapat kesalahan pada isian:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- BACK LINK --}}
            <a href="{{ route('provinsi.donasi.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-700 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
                Kembali ke Kelola Donasi
            </a>

            {{-- RINGKASAN DONASI SUMBER --}}
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50">
                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Donasi Sumber</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="border border-slate-100 rounded-xl p-4">
                        <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Kode Referensi</p>
                        <p class="text-sm font-semibold text-slate-800 mt-1">{{ $donasi->kode_referensi }}</p>
                    </div>
                    <div class="border border-slate-100 rounded-xl p-4">
                        <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Donatur</p>
                        <p class="text-sm font-semibold text-slate-800 mt-1">{{ $donasi->nama_donatur }}</p>
                    </div>
                    <div class="border border-slate-100 rounded-xl p-4">
                        <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Jumlah Donasi</p>
                        <p class="text-lg font-bold text-emerald-600 mt-1">Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}</p>
                    </div>
                    <div class="border border-slate-100 rounded-xl p-4">
                        <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Status</p>
                        <span class="inline-flex text-[11px] bg-emerald-50 text-emerald-700 font-semibold px-2.5 py-1 rounded-full border border-emerald-200/40 mt-1">
                            Terverifikasi
                        </span>
                    </div>
                </div>
            </div>

            {{-- FORM PENYALURAN --}}
            <form action="{{ route('provinsi.dana.store', $donasi->id) }}" method="POST" class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm shadow-slate-100/50 space-y-5">
                @csrf

                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Detail Penyaluran</h2>

                <div>
                    <label for="kabupaten_id" class="block text-xs font-semibold text-slate-700 mb-1.5">Kabupaten/Kota Tujuan</label>
                    <select name="kabupaten_id" id="kabupaten_id" required
                        class="w-full text-sm border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition">
                        <option value="" disabled selected>Pilih kabupaten/kota</option>
                 @foreach($kabupatenList as $kab)
                    <option value="{{ $kab->id }}" {{ old('kabupaten_id') == $kab->id ? 'selected' : '' }}>
                       {{ $kab->nama_lengkap }}
                    </option>
                @endforeach
                    </select>
                </div>

                <div>
                    <label for="program_id" class="block text-xs font-semibold text-slate-700 mb-1.5">Program Bantuan</label>
                    <select name="program_id" id="program_id" required
                        class="w-full text-sm border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition">
                        <option value="" disabled selected>Pilih program</option>
                        @foreach($programList as $program)
                            <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                {{ $program->nama_bansos }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="jumlah_dana" class="block text-xs font-semibold text-slate-700 mb-1.5">Jumlah Dana Disalurkan (Rp)</label>
                        <input type="number" name="jumlah_dana" id="jumlah_dana" min="1" max="{{ $donasi->jumlah }}"
                            value="{{ old('jumlah_dana', $donasi->jumlah) }}" required
                            class="w-full text-sm border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition">
                        <p class="text-[11px] text-slate-400 mt-1.5">Maksimal Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <label for="tanggal_penyaluran" class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Penyaluran</label>
                        <input type="date" name="tanggal_penyaluran" id="tanggal_penyaluran"
                            value="{{ old('tanggal_penyaluran', now()->format('Y-m-d')) }}" required
                            class="w-full text-sm border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition">
                    </div>
                </div>

                <div>
                    <label for="keterangan" class="block text-xs font-semibold text-slate-700 mb-1.5">Keterangan (opsional)</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                        class="w-full text-sm border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition resize-none"
                        placeholder="Catatan tambahan terkait penyaluran ini...">{{ old('keterangan') }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('provinsi.donasi.index') }}"
                        class="text-xs font-semibold px-4 py-2.5 rounded-xl text-slate-500 hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold px-5 py-2.5 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        Salurkan Dana
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
