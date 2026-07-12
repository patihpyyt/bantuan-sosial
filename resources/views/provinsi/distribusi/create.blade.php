<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Distribusi Dana Baru
        </h2>
    </x-slot>

    <div class="container-fluid py-4">

        <div class="mb-3">
            <a href="{{ route('provinsi.distribusi.index') }}" class="text-decoration-none">
                &larr; Kembali ke Daftar Distribusi
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Ada kesalahan pada input:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Form Distribusi Dana ke Kabupaten/Kota</h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('provinsi.distribusi.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kabupaten/Kota</label>
                            <select name="kabupaten_id" class="form-select" required>
                                <option value="">-- Pilih Kabupaten/Kota --</option>
                                @foreach($kabupatenList as $kab)
                                    <option value="{{ $kab->id }}" {{ old('kabupaten_id') == $kab->id ? 'selected' : '' }}>
                                        {{ $kab->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tahun Anggaran</label>
                            <input type="number" name="tahun" class="form-control"
                                value="{{ old('tahun', now()->year) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jumlah Dana (Rp)</label>
                            <input type="text" id="jumlah_display" class="form-control"
                                value="{{ old('jumlah') ? number_format(old('jumlah'), 0, ',', '.') : '' }}"
                                placeholder="Contoh: 50.000.000" inputmode="numeric" autocomplete="off" required>
                            <input type="hidden" name="jumlah" id="jumlah" value="{{ old('jumlah') }}">
                            <small class="text-muted">Titik otomatis menyesuaikan saat mengetik.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Distribusi</label>
                            <input type="date" name="tanggal_distribusi" class="form-control"
                                value="{{ old('tanggal_distribusi', now()->format('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select">
                                <option value="terkirim" selected>Terkirim</option>
                                <option value="dibatalkan">Dibatalkan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Keterangan (opsional)</label>
                            <input type="text" name="keterangan" class="form-control"
                                value="{{ old('keterangan') }}" placeholder="Misal: Termin 1">
                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            Simpan &amp; Distribusikan
                        </button>
                        <a href="{{ route('provinsi.distribusi.index') }}" class="btn btn-outline-secondary px-4">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const display = document.getElementById('jumlah_display');
            const hidden  = document.getElementById('jumlah');

            display.addEventListener('input', function () {
                let angka = display.value.replace(/\D/g, '');
                hidden.value = angka;
                display.value = angka ? new Intl.NumberFormat('id-ID').format(angka) : '';
            });
        });
    </script>
</x-app-layout>