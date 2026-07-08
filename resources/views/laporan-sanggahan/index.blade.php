<x-app-layout>

<div class="min-h-screen p-8">

    <h1 class="text-3xl font-bold text-slate-800 mb-8">
        Laporan Sanggahan
    </h1>

    <div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-100">

                <tr>

                    <th class="p-4 border text-left">No</th>
                    <th class="p-4 border text-left">Pelapor</th>
                    <th class="p-4 border text-left">Warga Disanggah</th>
                    <th class="p-4 border text-left">Alasan</th>
                    <th class="p-4 border text-center">Bukti</th>
                    <th class="p-4 border text-center">Status</th>

                </tr>

            </thead>

            <tbody>

                @forelse($laporan as $item)

                <tr class="hover:bg-slate-50">

                    <td class="p-4 border">
                        {{ $loop->iteration }}
                    </td>

                    <td class="p-4 border">
                        {{ $item->pelapor->nama_lengkap }}
                    </td>

                    <td class="p-4 border">
                        {{ $item->warga->nama_lengkap }}
                    </td>

                    <td class="p-4 border">
                        {{ $item->alasan }}
                    </td>

                    <td class="p-4 border text-center">

                        @if($item->bukti)

                            <a href="{{ asset('storage/'.$item->bukti) }}"
                               target="_blank"
                               class="text-blue-600 hover:underline">

                                Lihat Bukti

                            </a>

                        @else

                            -

                        @endif

                    </td>

                    <td class="p-4 border text-center">

                        @if($item->status == 'menunggu')

                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                Menunggu
                            </span>

                        @elseif($item->status == 'diproses')

                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                Diproses
                            </span>

                        @elseif($item->status == 'selesai')

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                Selesai
                            </span>

                        @else

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                Ditolak
                            </span>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center py-10 text-slate-500">

                        Belum ada laporan sanggahan.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</x-app-layout>