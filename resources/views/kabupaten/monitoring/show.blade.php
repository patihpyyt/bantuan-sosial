@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-semibold mb-4">
        Detail Monitoring — {{ $kecamatan->name }}
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="border rounded-xl p-4">
            <small class="text-slate-400">Total Anggaran</small>
            <div class="text-lg font-semibold">
                Rp {{ number_format($anggaran->total_anggaran ?? 0, 0, ',', '.') }}
            </div>
        </div>
        <div class="border rounded-xl p-4">
            <small class="text-slate-400">Terpakai</small>
            <div class="text-lg font-semibold">
                Rp {{ number_format($anggaran->anggaran_terpakai ?? 0, 0, ',', '.') }}
            </div>
        </div>
        <div class="border rounded-xl p-4">
            <small class="text-slate-400">Sisa</small>
            <div class="text-lg font-semibold">
                Rp {{ number_format($anggaran->sisa_anggaran ?? 0, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <h2 class="text-lg font-semibold mb-2">Riwayat Distribusi ({{ $tahun }})</h2>

    <table class="w-full border-collapse">
        <thead>
            <tr class="border-b">
                <th class="text-left py-2">Tanggal</th>
                <th class="text-left py-2">Jumlah</th>
                <th class="text-left py-2">Status</th>
                <th class="text-left py-2">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($riwayat as $item)
                <tr class="border-b">
                    <td class="py-2">{{ $item->tanggal_distribusi }}</td>
                    <td class="py-2">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td class="py-2">{{ ucfirst($item->status) }}</td>
                    <td class="py-2">{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="py-4 text-center text-slate-400">
                        Belum ada riwayat distribusi.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('kabupaten.monitoring.index') }}" class="inline-block mt-4 text-slate-500 hover:underline">
        &larr; Kembali ke Monitoring
    </a>
</div>
@endsection