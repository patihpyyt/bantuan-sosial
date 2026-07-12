<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Tambah Alokasi Anggaran
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
                <form action="{{ route('anggaran.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="kabupaten_id" class="form-label">Kabupaten/Kota Tujuan</label>
                            <select name="kabupaten_id" id="kabupaten_id"
                                    class="form-select @error('kabupaten_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Kabupaten/Kota --</option>
                                @foreach($kabupaten as $kab)
                                    <option value="{{ $kab->id }}" {{ old('kabupaten_id') == $kab->id ? 'selected' : '' }}>
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
                                   value="{{ old('tahun', date('Y')) }}" min="2000" max="2100" required>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="total_anggaran_display" class="form-label">Jumlah Anggaran (Rp)</label>
                            <input type="text" id="total_anggaran_display"
                                   class="form-control @error('total_anggaran') is-invalid @enderror"
                                   value="{{ old('total_anggaran') ? number_format(old('total_anggaran'), 0, ',', '.') : '' }}"
                                   placeholder="Contoh: 234.000.000"
                                   inputmode="numeric" autocomplete="off" required>
                            <input type="hidden" name="total_anggaran" id="total_anggaran" value="{{ old('total_anggaran') }}">
                            <small class="text-muted">Titik otomatis menyesuaikan saat mengetik.</small>
                            @error('total_anggaran')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Anggaran</button>
                        <a href="{{ route('anggaran.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
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