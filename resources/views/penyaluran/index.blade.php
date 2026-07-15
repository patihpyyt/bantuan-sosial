<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            Data Penyaluran Bansos
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="flex items-center justify-end">
                <a href="{{ route('penyaluran.create') }}"
                   class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Penyaluran Baru
                </a>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="px-5 py-3.5">Tanggal Salur</th>
                                <th class="px-5 py-3.5">Penerima</th>
                                <th class="px-5 py-3.5 text-right">Nominal</th>
                                <th class="px-5 py-3.5 text-center">Status</th>
                                <th class="px-5 py-3.5">Keterangan</th>
                                <th class="px-5 py-3.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @forelse($penyaluran as $p)
                                <tr class="hover:bg-gray-50/60 transition">
                                    <td class="px-5 py-4 text-gray-600">
                                        {{ optional($p->tanggal_salur)->format('d-m-Y') ?? '-' }}
                                    </td>
                                    <td class="px-5 py-4 font-medium text-gray-900">
                                        {{ $p->penerima->warga->nama_lengkap ?? 'Data terhapus' }}
                                    </td>
                                    <td class="px-5 py-4 text-right font-semibold text-gray-900">
                                        Rp {{ number_format($p->nominal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        @if($p->status === 'tersalur')
                                            <span class="inline-flex text-[11px] bg-emerald-50 text-emerald-700 font-semibold px-2.5 py-1 rounded-full border border-emerald-200/50">
                                                Tersalur
                                            </span>
                                        @elseif($p->status === 'tertunda')
                                            <span class="inline-flex text-[11px] bg-amber-50 text-amber-700 font-semibold px-2.5 py-1 rounded-full border border-amber-200/50">
                                                Tertunda
                                            </span>
                                        @else
                                            <span class="inline-flex text-[11px] bg-red-50 text-red-700 font-semibold px-2.5 py-1 rounded-full border border-red-200/50">
                                                Gagal
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-gray-500">
                                        {{ $p->keterangan ?? '-' }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-center gap-3">
                                            <a href="{{ route('penyaluran.edit', $p->id) }}"
                                               class="text-xs font-semibold text-blue-600 hover:text-blue-700 hover:underline transition">
                                                Edit
                                            </a>
                                            <span class="text-gray-300">|</span>
                                            <form action="{{ route('penyaluran.destroy', $p->id) }}" method="POST"
                                                  onsubmit="return confirm('Yakin hapus data penyaluran ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-xs font-semibold text-red-600 hover:text-red-700 hover:underline transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-14 text-center">
                                        <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-sm text-gray-400 font-medium">Belum ada data penyaluran.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>