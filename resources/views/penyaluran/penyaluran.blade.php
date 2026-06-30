<x-app-layout>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h2 class="font-bold text-2xl text-gray-900">Penyaluran Bantuan</h2>
                    <p class="text-sm text-gray-500 mt-1">Pantau dan perbarui status penyaluran bantuan per periode.</p>
                </div>
                <a href="/penyaluran/create"
                   class="inline-flex items-center justify-center gap-2 bg-blue-600 text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-blue-700 transition shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Penyaluran
                </a>
            </div>

            @if(session('success'))
            <div class="flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3 mb-6">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white rounded-2xl border border-gray-100 p-5 mb-6">
                <form method="GET" action="/penyaluran" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Bulan</label>
                        <select name="bulan" class="border border-gray-200 rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400">
                            @foreach(range(1, 12) as $b)
                                <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Tahun</label>
                        <select name="tahun" class="border border-gray-200 rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400">
                            @foreach(range(now()->year - 2, now()->year + 1) as $t)
                                <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                            class="bg-gray-900 text-white text-sm font-medium px-5 py-2 rounded-lg hover:bg-gray-800 transition">
                        Terapkan Filter
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama Warga</th>
                                <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Jenis Bantuan</th>
                                <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Periode</th>
                                <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nominal</th>
                                <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                                <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Tgl Salur</th>
                                <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($penyaluran as $item)
                            <tr class="hover:bg-gray-50/80 transition">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $item->penerima->warga->nama_lengkap ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $item->penerima->jenisBansos->nama_bansos ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ \Carbon\Carbon::create()->month($item->periode_bulan)->translatedFormat('F') }} {{ $item->periode_tahun }}
                                </td>
                                <td class="px-6 py-4 text-gray-900 font-medium tabular-nums">
                                    {{ $item->nominal ? 'Rp ' . number_format($item->nominal, 0, ',', '.') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusStyle = match($item->status) {
                                            'tersalur' => 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-200',
                                            'proses'   => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-200',
                                            'gagal'    => 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-200',
                                            default    => 'bg-gray-100 text-gray-600 ring-1 ring-inset ring-gray-200',
                                        };
                                        $statusLabel = match($item->status) {
                                            'tersalur' => 'Tersalur',
                                            'proses'   => 'Proses',
                                            'gagal'    => 'Gagal',
                                            default    => 'Belum',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full {{ $statusStyle }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $item->tanggal_salur ? $item->tanggal_salur->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="/penyaluran/{{ $item->id }}/edit"
                                       class="inline-flex items-center gap-1.5 text-xs font-medium text-blue-600 border border-blue-200 px-3 py-1.5 rounded-lg hover:bg-blue-50 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                        </svg>
                                        Update
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16">
                                    <div class="flex flex-col items-center text-center">
                                        <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-sm text-gray-500 mb-4">Belum ada data penyaluran untuk periode ini.</p>
                                        <a href="/penyaluran/create"
                                           class="text-sm font-medium text-blue-600 hover:text-blue-700">
                                            + Tambah penyaluran sekarang
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($penyaluran->hasPages())
            <div class="mt-6">
                {{ $penyaluran->links() }}
            </div>
            @endif

        </div>
    </div>

</x-app-layout>