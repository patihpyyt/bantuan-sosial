<x-app-layout>
    <x-slot name="header">
        Monitoring Kecamatan
    </x-slot>
    <div class="p-6">
        <h1 class="text-xl font-semibold mb-4">Monitoring Kecamatan</h1>
        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Kecamatan</th>
                    <th class="text-left py-2">Total Anggaran</th>
                    <th class="text-left py-2">Terpakai</th>
                    <th class="text-left py-2">Sisa</th>
                    <th class="text-left py-2">Total Distribusi ({{ $tahun }})</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($monitoring as $item)
                    <tr class="border-b">
                        <td class="py-2">{{ $item->nama_lengkap }}</td>
                        <td class="py-2">Rp {{ number_format($item->total_anggaran, 0, ',', '.') }}</td>
                        <td class="py-2">Rp {{ number_format($item->anggaran_terpakai, 0, ',', '.') }}</td>
                        <td class="py-2">Rp {{ number_format($item->sisa_anggaran, 0, ',', '.') }}</td>
                        <td class="py-2">Rp {{ number_format($item->total_distribusi, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-slate-400">
                            Belum ada data kecamatan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>