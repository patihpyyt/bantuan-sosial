<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Edit Distribusi
        </h2>
    </x-slot>

    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('provinsi.distribusi.index') }}" class="btn btn-outline-secondary btn-sm">
                &larr; Kembali ke Daftar Distribusi
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('provinsi.distribusi.update', $distribusi->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Kabupaten/Kota</label>
                        <select name="kabupaten_id" class="form-select" required>
                            <option value="">-- Pilih Kabupaten/Kota --</option>
                            @foreach($kabupatenList as $kab)
                                <option value="{{ $kab->id }}"
                                    {{ old('kabupaten_id', $distribusi->kabupaten_id) == $kab->id ? 'selected' : '' }}>
                                    {{ $kab->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tahun Anggaran</label>
                        <input type="number" name="tahun" class="form-control"
                               value="{{ old('tahun', $distribusi->tahun) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Dana (Rp)</label>
                        <input type="text" id="jumlah_display" class="form-control"
                               value="{{ number_format(old('jumlah', $distribusi->jumlah), 0, ',', '.') }}"
                               placeholder="Contoh: 50.000.000" inputmode="numeric" autocomplete="off" required>
                        <input type="hidden" name="jumlah" id="jumlah" value="{{ old('jumlah', $distribusi->jumlah) }}">
                        <small class="text-muted">Cek jumlah nolnya sebelum simpan.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Distribusi</label>
                        <input type="date" name="tanggal_distribusi" class="form-control"
                               value="{{ old('tanggal_distribusi', \Carbon\Carbon::parse($distribusi->tanggal_distribusi)->format('Y-m-d')) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan (opsional)</label>
                        <input type="text" name="keterangan" class="form-control"
                               value="{{ old('keterangan', $distribusi->keterangan) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="terkirim" {{ old('status', $distribusi->status) === 'terkirim' ? 'selected' : '' }}>Terkirim</option>
                            <option value="dibatalkan" {{ old('status', $distribusi->status) === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <button class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('provinsi.distribusi.index') }}" class="btn btn-secondary">Batal</a>
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