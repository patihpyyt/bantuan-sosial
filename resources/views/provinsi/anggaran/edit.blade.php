<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Edit Alokasi Anggaran
        </h2>
    </x-slot>

    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('anggaran.index') }}" class="btn btn-outline-secondary btn-sm">
                &larr; Kembali ke Daftar Anggaran
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Ada kesalahan pada input kamu:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('anggaran.update', $anggaran->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="kabupaten_id" class="form-label">Kabupaten/Kota Tujuan</label>
                            <select name="kabupaten_id" id="kabupaten_id"
                                    class="form-select @error('kabupaten_id') is-invalid @enderror" required>
                                <option value="" disabled>-- Pilih Kabupaten/Kota --</option>
                                @foreach($kabupaten as $kab)
                                    <option value="{{ $kab->id }}"
                                        {{ old('kabupaten_id', $anggaran->kabupaten_id) == $kab->id ? 'selected' : '' }}>
                                        {{ $kab->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kabupaten_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tahun" class="form-label">Tahun Anggaran</label>
                            <input type="number" name="tahun" id="tahun"
                                   class="form-control @error('tahun') is-invalid @enderror"
                                   value="{{ old('tahun', $anggaran->tahun) }}" min="2000" max="2100" required>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="total_anggaran" class="form-label">Jumlah Anggaran (Rp)</label>
                            <input type="number" name="total_anggaran" id="total_anggaran"
                                   class="form-control @error('total_anggaran') is-invalid @enderror"
                                   value="{{ old('total_anggaran', $anggaran->total_anggaran) }}" min="1" step="1" required>
                            @error('total_anggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('anggaran.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>