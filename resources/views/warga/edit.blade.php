<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800">Edit Data Warga</h2>
            <a href="/warga" class="text-sm text-gray-500 hover:text-gray-700">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl border border-gray-100 p-8">

                <h3 class="text-base font-semibold text-gray-700 mb-6">Edit Data Warga</h3>

                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl p-4 mb-6">
                    <ul class="list-disc ml-4 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="/warga/{{ $warga->id }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">

                        {{-- NIK --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIK <span class="text-red-500">*</span></label>
                            <input type="text"
                                   name="nik"
                                   value="{{ old('nik', $warga->nik) }}"
                                   maxlength="16"
                                   class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('nik') border-red-400 @enderror">
                            @error('nik') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- NO KK --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. Kartu Keluarga <span class="text-red-500">*</span></label>
                            <input type="text"
                                   name="no_kk"
                                   value="{{ old('no_kk', $warga->no_kk) }}"
                                   maxlength="16"
                                   class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('no_kk') border-red-400 @enderror">
                            @error('no_kk') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- NAMA --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text"
                                   name="nama_lengkap"
                                   value="{{ old('nama_lengkap', $warga->nama_lengkap) }}"
                                   class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('nama_lengkap') border-red-400 @enderror">
                            @error('nama_lengkap') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- JENIS KELAMIN --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="jenis_kelamin"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('jenis_kelamin') border-red-400 @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- ALAMAT --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                            <textarea name="alamat"
                                      rows="3"
                                      class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('alamat') border-red-400 @enderror">{{ old('alamat', $warga->alamat) }}</textarea>
                            @error('alamat') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                    {{-- KABUPATEN --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota <span class="text-red-500">*</span></label>
    <select name="kabupaten"
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('kabupaten') border-red-400 @enderror">
        <option value="">-- Pilih Kabupaten/Kota --</option>
        @foreach($kabupatenList as $kab)
            <option value="{{ $kab->nama_lengkap }}" {{ old('kabupaten', $warga->kabupaten) == $kab->nama_lengkap ? 'selected' : '' }}>
                {{ $kab->nama_lengkap }}
            </option>
        @endforeach
    </select>
    @error('kabupaten') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
</div>

{{-- KECAMATAN --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan <span class="text-red-500">*</span></label>
    <input type="text"
           name="kecamatan"
           value="{{ old('kecamatan', $warga->kecamatan) }}"
           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('kecamatan') border-red-400 @enderror">
    @error('kecamatan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
</div>


                        {{-- RT & RW --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">RT <span class="text-red-500">*</span></label>
                                <input type="text"
                                       name="rt"
                                       value="{{ old('rt', $warga->rt) }}"
                                       placeholder="Contoh: 002"
                                       maxlength="5"
                                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('rt') border-red-400 @enderror">
                                @error('rt') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">RW <span class="text-red-500">*</span></label>
                                <input type="text"
                                       name="rw"
                                       value="{{ old('rw', $warga->rw) }}"
                                       placeholder="Contoh: 005"
                                       maxlength="5"
                                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 @error('rw') border-red-400 @enderror">
                                @error('rw') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                    </div>

                    <div class="flex gap-3 mt-8">
                        <button type="submit"
                                class="bg-blue-600 text-white text-sm font-medium px-6 py-2.5 rounded-lg hover:bg-blue-700 transition">
                            Update Data
                        </button>
                        <a href="/warga"
                           class="text-sm font-medium text-gray-500 px-6 py-2.5 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                            Batal
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>