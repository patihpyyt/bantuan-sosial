<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Distribusi Dana Baru
        </h2>
    </x-slot>

    <div class="container-fluid py-4">

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
                <form action="{{ route('provinsi.distribusi.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Kabupaten/Kota</label>
                        <select name="kabupaten_id" class="form-select" required>
                            <option value="">-- Pilih Kabupaten/Kota --</option>
                           @foreach($kabupatenList as $kab)
                        <option value="{{ $kab->id }}" {{ old('kabupaten_id') == $kab->id ? 'selected' : '' }}>
                            {{ $kab->nama_lengkap }}
                        </option>
                    @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tahun Anggaran</label>
                        <input type="number" name="tahun" class="form-control" value="{{ old('tahun', now()->year) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Dana (Rp)</label>
                        <input type="number" name="jumlah" class="form-control" step="0.01" value="{{ old('jumlah') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Distribusi</label>
                        <input type="date" name="tanggal_distribusi" class="form-control" value="{{ old('tanggal_distribusi', now()->format('Y-m-d')) }}" required>
                    </div>

                    <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        <option value="terkirim" selected>Terkirim</option>
        <option value="dibatalkan">Dibatalkan</option>
    </select>
</div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan (opsional)</label>
                        <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan') }}" placeholder="Misal: Termin 1">
                    </div>

                    <button class="btn btn-primary">Simpan & Distribusikan</button>
                    <a href="{{ route('provinsi.distribusi.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>