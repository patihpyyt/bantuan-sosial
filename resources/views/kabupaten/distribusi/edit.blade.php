<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Distribusi Kecamatan
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

        <div class="card shadow">

            <div class="card-header bg-warning">
                Edit Distribusi Dana
            </div>

            <div class="card-body">

                <form action="{{ route('kabupaten.distribusi.update',$distribusi->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    {{-- Status tidak diedit lewat form ini (ada tombol Batalkan terpisah),
                         jadi kirim ulang value status yang sudah ada supaya validasi lolos --}}
                    <input type="hidden" name="status" value="{{ $distribusi->status }}">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label>Kecamatan</label>

                            <select name="kecamatan_id" class="form-select">

                                @foreach($kecamatan as $item)

                                    <option
                                        value="{{ $item->id }}"
                                        {{ $distribusi->kabupaten_id==$item->id ? 'selected':'' }}>

                                        {{ $item->nama_lengkap }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Tahun</label>

                            <input
                                type="number"
                                name="tahun"
                                class="form-control"
                                value="{{ $distribusi->tahun }}">

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label>Jumlah Dana</label>

                            <input
                                type="number"
                                name="jumlah"
                                class="form-control"
                                value="{{ $distribusi->jumlah }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Tanggal Distribusi</label>

                            <input
                                type="date"
                                name="tanggal_distribusi"
                                class="form-control"
                                value="{{ $distribusi->tanggal_distribusi->format('Y-m-d') }}">

                        </div>

                    </div>

                    <div class="mb-3">

                        <label>Keterangan</label>

                        <textarea
                            name="keterangan"
                            rows="3"
                            class="form-control">{{ $distribusi->keterangan }}</textarea>

                    </div>

                    <div class="d-flex justify-content-end">

                        <a
                            href="{{ route('kabupaten.distribusi.index') }}"
                            class="btn btn-secondary me-2">

                            Kembali

                        </a>

                        <button class="btn btn-warning">

                            Update Distribusi

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>