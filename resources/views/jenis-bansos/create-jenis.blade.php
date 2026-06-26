<x-app-layout>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <h2 class="font-bold text-xl text-gray-800">Tambah Jenis Bantuan</h2>
                <a href="/jenis-bansos" class="text-sm text-gray-500 hover:text-gray-700">&larr; Kembali</a>
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

                <form method="POST" action="/jenis-bansos">
                    @csrf

                    <div class="space-y-5">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Bantuan <span class="text-red-500">*</span></label>
                            <input type="text"
                                   name="nama_bansos"
                                   value="{{ old('nama_bansos') }}"
                                   placeholder="Contoh: PKH, BLT, BPNT"
                                   class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('nama_bansos') border-red-400 @enderror">
                            @error('nama_bansos') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="deskripsi"
                                      rows="3"
                                      placeholder="Keterangan singkat tentang bantuan ini"
                                      class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Bantuan (Rp)</label>
                            <input type="number"
                                   name="jumlah_bantuan"
                                   value="{{ old('jumlah_bantuan') }}"
                                   placeholder="Contoh: 300000"
                                   class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('jumlah_bantuan') border-red-400 @enderror">
                            @error('jumlah_bantuan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                    </div>

                    <div class="flex gap-3 mt-8">
                        <button type="submit"
                                class="bg-blue-600 text-white text-sm font-medium px-6 py-2.5 rounded-lg hover:bg-blue-700 transition">
                            Simpan
                        </button>
                        <a href="/jenis-bansos"
                           class="text-sm font-medium text-gray-500 px-6 py-2.5 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                            Batal
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>