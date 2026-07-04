<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl">
                Data Penerima Bansos
            </h2>

            <a href="{{ route('penerima-bansos.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                + Tambah Penerima
            </a>
        </div>
    </x-slot>


    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">

            <div class="bg-white shadow rounded-xl p-6 overflow-x-auto">

                <table class="w-full">

                    <thead>
                        <tr class="border-b bg-gray-50">

                            <th class="text-left py-3 px-3">
                                No
                            </th>

                            <th class="text-left px-3">
                                Nama Warga
                            </th>

                            <th class="text-left px-3">
                                Jenis Bansos
                            </th>

                            <th class="text-left px-3">
                                Tanggal Menerima
                            </th>

                            <th class="text-left px-3">
                                Status
                            </th>

                            <th class="text-left px-3">
                                Aksi
                            </th>

                        </tr>
                    </thead>


                    <tbody>

                        @forelse($penerima as $item)

                        <tr class="border-b">

                            <td class="py-3 px-3">
                                {{ $loop->iteration }}
                            </td>


                            <td class="px-3">
                                {{ $item->warga->nama_lengkap ?? '-' }}
                            </td>


                            <td class="px-3">
                                {{ $item->jenisBansos->nama_bansos ?? '-' }}
                            </td>


                            <td class="px-3">
                                {{ $item->tanggal_menerima ?? '-' }}
                            </td>


                            <td class="px-3">

                                @if($item->status == 'layak')

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded">
                                        Layak
                                    </span>

                                @else

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded">
                                        Tidak Layak
                                    </span>

                                @endif

                            </td>

                              <td class="px-3">
                                {{ $item->keterangan ?? '-' }}
                            </td>
                            <td class="px-3">

                                <a href="{{ route('penerima-bansos.edit', $item->id) }}"
                                    class="text-blue-600">
                                    Edit
                                </a>


                                <form action="{{ route('penerima-bansos.destroy', $item->id) }}"
                                    method="POST"
                                    class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Hapus data ini?')"
                                        class="text-red-600 ml-3">

                                        Hapus

                                    </button>

                                </form>

                            </td>

                        </tr>


                        @empty

                        <tr>

                            <td colspan="6"
                                class="text-center py-5 text-gray-500">

                                Belum ada data penerima

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</x-app-layout>