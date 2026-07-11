<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Distribusi Dana ke Kecamatan
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

        @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
        <div class="card shadow">

            <div class="card-header bg-primary text-white">
                Form Distribusi Dana
            </div>

            <div class="card-body">

                <form action="{{ route('kabupaten.distribusi.store') }}" method="POST">

                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Kecamatan Tujuan
                            </label>

                            <select
                                name="kecamatan_id"
                                class="form-select"
                                required>

                                <option value="">-- Pilih Kecamatan --</option>

                                @foreach($kecamatan as $item)

                                    <option value="{{ $item->id }}">

                                        {{ $item->nama_lengkap }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tahun
                            </label>

                            <input
                                type="number"
                                name="tahun"
                                class="form-control"
                                value="{{ date('Y') }}"
                                required>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Jumlah Dana
                            </label>

                            <input
                                type="number"
                                name="jumlah"
                                class="form-control"
                                placeholder="Masukkan nominal"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tanggal Distribusi
                            </label>

                            <input
                                type="date"
                                name="tanggal_distribusi"
                                value="{{ date('Y-m-d') }}"
                                class="form-control"
                                required>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            rows="3"
                            class="form-control"></textarea>

                    </div>

                    <div class="d-flex justify-content-end">

                        <a
                            href="{{ route('kabupaten.distribusi.index') }}"
                            class="btn btn-secondary me-2">

                            Kembali

                        </a>

                        <button
                            class="btn btn-primary">

                            Simpan Distribusi

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>