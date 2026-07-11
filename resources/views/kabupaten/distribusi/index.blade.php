<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Distribusi Dana ke Kecamatan
        </h2>
    </x-slot>

    <div class="container-fluid py-4">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <h5>Daftar Distribusi</h5>

            <a href="{{ route('kabupaten.distribusi.create') }}"
               class="btn btn-primary">
                + Tambah Distribusi
            </a>
        </div>

        <div class="card shadow-sm">

            <div class="card-body p-0">

                <table class="table table-bordered table-hover mb-0">

                    <thead class="table-light">

                    <tr>

                        <th>No</th>
                        <th>Kecamatan</th>
                        <th>Tahun</th>
                        <th>Jumlah Dana</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th width="180">Aksi</th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($distribusi as $item)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $item->kecamatan->nama ?? '-' }}</td>

                            <td>{{ $item->tahun }}</td>

                            <td class="text-end">
                                Rp {{ number_format($item->jumlah,0,',','.') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_distribusi)->format('d-m-Y') }}
                            </td>

                            <td>

                                @if($item->status=='terkirim')

                                    <span class="badge bg-primary">
                                        Terkirim
                                    </span>

                                @elseif($item->status=='diterima')

                                    <span class="badge bg-success">
                                        Diterima
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Dibatalkan
                                    </span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('kabupaten.distribusi.show',$item->id) }}"
                                   class="btn btn-info btn-sm">
                                    Detail
                                </a>

                                <a href="{{ route('kabupaten.distribusi.edit',$item->id) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('kabupaten.distribusi.cancel',$item->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Batalkan distribusi ini?')">

                                        Batalkan

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center text-muted">

                                Belum ada distribusi.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>