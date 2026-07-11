<x-app-layout>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <h2 class="font-bold text-xl text-gray-800">Update Status Penyaluran</h2>
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

                <div class="bg-gray-50 rounded-xl p-4 mb-6 text-sm space-y-1">
                    <p><span class="text-gray-500">Nama Warga:</span> <span class="font-medium text-gray-800">{{ $penyaluran->penerima->warga->nama_lengkap ?? '-' }}</span></p>
                    <p>
                        <span class="text-gray-500">RT/RW:</span>
                        <span class="font-medium text-gray-800">
                            @if(($penyaluran->penerima->warga->rt ?? null) && ($penyaluran->penerima->warga->rw ?? null))
                                {{ $penyaluran->penerima->warga->rt }}/{{ $penyaluran->penerima->warga->rw }}
                            @else
                                -
                            @endif
                        </span>
                    </p>
                    <p><span class="text-gray-500">Jenis Bantuan:</span> <span class="font-medium text-gray-800">{{ $penyaluran->penerima->jenisBansos->nama_bansos ?? '-' }}</span></p>
                    <p><span class="text-gray-500">Periode:</span> <span class="font-medium text-gray-800">{{ \Carbon\Carbon::create()->month($penyaluran->periode_bulan)->translatedFormat('F') }} {{ $penyaluran->periode_tahun }}</span></p>
                </div>

                <form method="POST" action="/penyaluran/{{ $penyaluran->id }}">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-5">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                            <select name="status"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('status') border-red-400 @enderror">
                                @foreach(['belum' => 'Belum', 'proses' => 'Proses', 'tersalur' => 'Tersalur', 'gagal' => 'Gagal'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('status', $penyaluran->status) == $val ? 'selected' : '' }}>
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
                                   value="{{ old('tanggal_salur', $penyaluran->tanggal_salur ? $penyaluran->tanggal_salur->format('Y-m-d') : '') }}"
                                   class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('tanggal_salur') border-red-400 @enderror">
                            @error('tanggal_salur') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Metode</label>
                            <select name="metode"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400">
                                <option value="">- Pilih Metode -</option>
                                @foreach(['transfer_bank' => 'Transfer Bank', 'tunai' => 'Tunai', 'kantor_pos' => 'Kantor Pos'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('metode', $penyaluran->metode) == $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. Referensi</label>
                            <input type="text"
                                   name="no_referensi"
                                   value="{{ old('no_referensi', $penyaluran->no_referensi) }}"
                                   class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                            <textarea name="catatan"
                                      rows="3"
                                      class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400">{{ old('catatan', $penyaluran->catatan) }}</textarea>
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