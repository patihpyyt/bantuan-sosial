<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Distribusi Kecamatan
        </h2>
    </x-slot>

    <div class="container-fluid py-4">

        <div class="card shadow">

            <div class="card-header bg-info text-white">

                Detail Distribusi

            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>

                        <th width="250">Kecamatan</th>

                        <td>

                            {{ $distribusi->kecamatan->nama_lengkap }}

                        </td>

                    </tr>

                    <tr>

                        <th>Tahun</th>

                        <td>

                            {{ $distribusi->tahun }}

                        </td>

                    </tr>

                    <tr>

                        <th>Jumlah Dana</th>

                        <td>

                            Rp {{ number_format($distribusi->jumlah,0,',','.') }}

                        </td>

                    </tr>

                    <tr>

                        <th>Tanggal Distribusi</th>

                        <td>

                            {{ $distribusi->tanggal_distribusi->format('d-m-Y') }}

                        </td>

                    </tr>

                    <tr>

                        <th>Status</th>

                        <td>

                            @if($distribusi->status=='terkirim')

                                <span class="badge bg-primary">

                                    Terkirim

                                </span>

                            @elseif($distribusi->status=='diterima')

                                <span class="badge bg-success">

                                    Diterima

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Dibatalkan

                                </span>

                            @endif

                        </td>

                    </tr>

                    <tr>

                        <th>Keterangan</th>

                        <td>

                            {{ $distribusi->keterangan ?? '-' }}

                        </td>

                    </tr>

                </table>

                <div class="mt-3">

                    <a
                        href="{{ route('kabupaten.distribusi.index') }}"
                        class="btn btn-secondary">

                        Kembali

                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>