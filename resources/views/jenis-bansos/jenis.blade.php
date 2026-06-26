<x-app-layout>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <h2 class="font-bold text-xl text-gray-800">Jenis Bantuan Sosial</h2>
                <a href="/jenis-bansos/create"
                   class="bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    + Tambah Jenis
                </a>
            </div>

            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl p-4 mb-6">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide w-10">No</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Nama Bantuan</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Deskripsi</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Jumlah Bantuan</th>
                            <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($jenisBansos as $index => $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-400">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $item->nama_bansos }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $item->deskripsi ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $item->jumlah_bantuan ? 'Rp ' . number_format($item->jumlah_bantuan, 0, ',', '.') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="/jenis-bansos/{{ $item->id }}/edit"
                                       class="text-xs text-blue-600 border border-blue-200 px-3 py-1.5 rounded-lg hover:bg-blue-50 transition">
                                        Edit
                                    </a>
                                    <form method="POST" action="/jenis-bansos/{{ $item->id }}"
                                          onsubmit="return confirm('Hapus jenis bantuan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-xs text-red-500 border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400 text-sm">
                                Belum ada jenis bantuan. <a href="/jenis-bansos/create" class="text-blue-500 hover:underline">Tambah sekarang</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</x-app-layout>