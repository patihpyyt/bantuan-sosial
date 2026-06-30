<x-app-layout>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <h2 class="font-bold text-xl text-gray-800">Tambah Penyaluran</h2>
                <a href="/penyaluran" class="text-sm text-gray-500 hover:text-gray-700">&larr; Kembali</a>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-8">

                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl p-4 mb-6">
                    <ul class="list-disc ml-4 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="/penyaluran">
                    @csrf

                    <div class="space-y-5">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Penerima <span class="text-red-500">*</span></label>
                            <select name="penerima_id"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('penerima_id') border-red-400 @enderror">
                                <option value="">- Pilih Penerima -</option>
                                @foreach($penerima as $p)
                                    <option value="{{ $p->id }}" {{ old('penerima_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->warga->nama_lengkap ?? '-' }} — {{ $p->jenisBansos->nama_bansos ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('penerima_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Bulan <span class="text-red-500">*</span></label>
                                <select name="periode_bulan"
                                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('periode_bulan') border-red-400 @enderror">
                                    @foreach(range(1, 12) as $b)
                                        <option value="{{ $b }}" {{ old('periode_bulan', now()->month) == $b ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('periode_bulan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun <span class="text-red-500">*</span></label>
                                <input type="number"
                                       name="periode_tahun"
                                       value="{{ old('periode_tahun', now()->year) }}"
                                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('periode_tahun') border-red-400 @enderror">
                                @error('periode_tahun') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp)</label>
                            <input type="number"
                                   name="nominal"
                                   value="{{ old('nominal') }}"
                                   class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('nominal') border-red-400 @enderror">
                            @error('nominal') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                            <select name="status"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('status') border-red-400 @enderror">
                                @foreach(['belum' => 'Belum', 'proses' => 'Proses', 'tersalur' => 'Tersalur', 'gagal' => 'Gagal'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('status', 'belum') == $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Salur</label>
                            <input type="date"
                                   name="tanggal_salur"
                                   value="{{ old('tanggal_salur') }}"
                                   class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('tanggal_salur') border-red-400 @enderror">
                            @error('tanggal_salur') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Metode</label>
                            <select name="metode"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('metode') border-red-400 @enderror">
                                <option value="">- Pilih Metode -</option>
                                <option value="transfer_bank" {{ old('metode') == 'transfer_bank' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="tunai" {{ old('metode') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                                <option value="kantor_pos" {{ old('metode') == 'kantor_pos' ? 'selected' : '' }}>Kantor Pos</option>
                            </select>
                            @error('metode') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. Referensi</label>
                            <input type="text"
                                   name="no_referensi"
                                   value="{{ old('no_referensi') }}"
                                   class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('no_referensi') border-red-400 @enderror">
                            @error('no_referensi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                            <textarea name="catatan"
                                      rows="3"
                                      class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('catatan') border-red-400 @enderror">{{ old('catatan') }}</textarea>
                            @error('catatan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                    </div>

                    <div class="flex gap-3 mt-8">
                        <button type="submit"
                                class="bg-blue-600 text-white text-sm font-medium px-6 py-2.5 rounded-lg hover:bg-blue-700 transition">
                            Simpan
                        </button>
                        <a href="/penyaluran"
                           class="text-sm font-medium text-gray-500 px-6 py-2.5 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                            Batal
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>