<x-app-layout>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h2 class="font-bold text-2xl text-gray-900">Laporan Penyaluran Bansos</h2>
                    <p class="text-sm text-gray-500 mt-1">Ringkasan data penyaluran bantuan sosial per periode.</p>
                </div>
                <a href="{{ route('laporan.exportCsv', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                   class="inline-flex items-center gap-2 border border-gray-200 text-gray-600 text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-gray-100 transition shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Export CSV
                </a>
            </div>

            {{-- FILTER --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5 mb-6">
                <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Bulan</label>
                        <select name="bulan" class="border border-gray-200 rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Tahun</label>
                        <select name="tahun" class="border border-gray-200 rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            @for($i = 2025; $i <= 2030; $i++)
                                <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="bg-gray-900 text-white text-sm font-medium px-5 py-2 rounded-lg hover:bg-gray-800 transition">
                        Terapkan
                    </button>
                </form>
            </div>

            {{-- RINGKASAN --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                @foreach([
                    ['label' => 'Total Data',  'value' => $total,        'color' => 'bg-blue-50 text-blue-700'],
                    ['label' => 'Tersalur',    'value' => $tersalur,     'color' => 'bg-green-50 text-green-700'],
                    ['label' => 'Proses',      'value' => $proses,       'color' => 'bg-amber-50 text-amber-700'],
                    ['label' => 'Gagal',       'value' => $gagal,        'color' => 'bg-red-50 text-red-700'],
                ] as $stat)
                <div class="bg-white rounded-2xl border border-gray-100 p-5">
                    <p class="text-xs font-medium text-gray-500 mb-1">{{ $stat['label'] }}</p>
                    <p class="text-3xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
                </div>
                @endforeach
                <div class="bg-white rounded-2xl border border-gray-100 p-5 col-span-2 md:col-span-1">
                    <p class="text-xs font-medium text-gray-500 mb-1">Total Dana</p>
                    <p class="text-lg font-bold text-purple-700">Rp {{ number_format($totalNominal, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- TABEL --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                @foreach(['No', 'NIK', 'Nama Warga', 'Jenis Bansos', 'Nominal', 'Tgl Salur', 'Metode', 'Status'] as $col)
                                <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ $col }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($laporan as $item)
                            <tr class="hover:bg-gray-50/80 transition">
                                <td class="px-6 py-4 text-gray-400">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-gray-600 tabular-nums">{{ $item->penerima->warga->nik ?? '-' }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $item->penerima->warga->nama_lengkap ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $item->penerima->jenisBansos->nama_bansos ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-900 font-medium tabular-nums">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $item->tanggal_salur ? \Carbon\Carbon::parse($item->tanggal_salur)->format('d M Y') : '-' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $item->metode ? ucfirst(str_replace('_', ' ', $item->metode)) : '-' }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $badge = match($item->status) {
                                            'tersalur' => 'bg-green-50 text-green-700 ring-green-200',
                                            'proses'   => 'bg-amber-50 text-amber-700 ring-amber-200',
                                            'gagal'    => 'bg-red-50 text-red-700 ring-red-200',
                                            default    => 'bg-gray-100 text-gray-600 ring-gray-200',
                                        };
                                        $label = match($item->status) {
                                            'tersalur' => 'Tersalur', 'proses' => 'Proses', 'gagal' => 'Gagal', default => 'Belum',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-full ring-1 ring-inset {{ $badge }}">
                                        {{ $label }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-sm text-gray-400">Belum ada data laporan untuk periode ini.</p>
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