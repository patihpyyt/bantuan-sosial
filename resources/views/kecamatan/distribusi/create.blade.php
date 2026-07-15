<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Distribusi Dana ke Kelurahan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">
                <form method="POST" action="{{ route('kecamatan.distribusi.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Kelurahan</label>
                        <select name="kelurahan_id" class="form-select" required>
                            <option value="">-- Pilih Kelurahan --</option>
                            @foreach($kelurahan as $k)
                                <option value="{{ $k->id }}" {{ old('kelurahan_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="number" name="tahun" class="form-control"
                               value="{{ old('tahun', now()->year) }}" required>
                    </div>
<div class="mb-3">
    <label class="form-label">Jumlah (Rp)</label>
    <input type="text" id="jumlah_display" class="form-control"
           inputmode="numeric" autocomplete="off"
           value="{{ old('jumlah') ? number_format(old('jumlah'), 0, ',', '.') : '' }}"
           placeholder="Masukkan nominal" required>
    <input type="hidden" name="jumlah" id="jumlah_asli" value="{{ old('jumlah') }}">
</div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Distribusi</label>
                        <input type="date" name="tanggal_distribusi" class="form-control"
                               value="{{ old('tanggal_distribusi', now()->format('Y-m-d')) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="terkirim" selected>Terkirim</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('kecamatan.distribusi.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script>
    const inputDisplay = document.getElementById('jumlah_display');
    const inputAsli = document.getElementById('jumlah_asli');

    inputDisplay.addEventListener('input', function (e) {
        let angka = e.target.value.replace(/\D/g, '');
        inputAsli.value = angka;
        e.target.value = angka
            ? new Intl.NumberFormat('id-ID').format(angka)
            : '';
    });

    document.querySelector('form').addEventListener('submit', function () {
        let angka = inputDisplay.value.replace(/\D/g, '');
        inputAsli.value = angka;
    });
</script>
</x-app-layout>