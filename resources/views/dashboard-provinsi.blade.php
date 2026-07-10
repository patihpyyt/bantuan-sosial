<x-app-layout>

<div class="p-8">

    <h1 class="text-3xl font-bold">
        Dashboard Provinsi
    </h1>
</div>
@foreach($grafikPenyaluran as $item)

<div>

    Bulan {{ $item->bulan }}

    -

    Rp {{ number_format($item->total,0,',','.') }}

</div>

<table class="w-full border">

    <thead>

        <tr class="bg-gray-200">

            <th class="border p-2">
                Kabupaten
            </th>

            <th class="border p-2">
                Jumlah Penyaluran
            </th>

            <th class="border p-2">
                Total Dana
            </th>

        </tr>

    </thead>

    <tbody>

@foreach($distribusiKabupaten as $item)

<tr>

<td class="border p-2">
{{ $item->kabupaten }}
</td>

<td class="border p-2">
{{ $item->jumlah_penyaluran }}
</td>

<td class="border p-2">
Rp {{ number_format($item->total_dana,0,',','.') }}
</td>

</tr>

@endforeach

    </tbody>

</table>
@endforeach


</x-app-layout>