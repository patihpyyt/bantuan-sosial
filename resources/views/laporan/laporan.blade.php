<x-app-layout>

<x-slot name="header">

    <h2 class="font-bold text-xl">
        Laporan Penyaluran Bansos
    </h2>

</x-slot>


<div class="py-8">

<div class="max-w-7xl mx-auto px-6">


<div class="bg-white shadow rounded-xl p-6">


<!-- FILTER -->

<form method="GET"
action="{{ route('laporan.index') }}"
class="flex gap-3 items-center mb-8">


<select name="bulan"
class="border rounded-lg px-4 py-2 w-32">


@for($i=1;$i<=12;$i++)

<option value="{{ $i }}"
{{ $bulan == $i ? 'selected' : '' }}>

Bulan {{ $i }}

</option>

@endfor


</select>



<select name="tahun"
class="border rounded-lg px-4 py-2 w-32">


@for($i=2025;$i<=2030;$i++)

<option value="{{ $i }}"
{{ $tahun == $i ? 'selected' : '' }}>

{{ $i }}

</option>

@endfor


</select>



<button
class="bg-blue-600 text-white px-6 py-2 rounded-lg">

Tampilkan

</button>


</form>





<!-- CARD JUMLAH -->

<div class="grid md:grid-cols-4 gap-5 mb-8">


<div class="bg-blue-50 p-5 rounded-xl">

<p>Total</p>

<h2 class="text-3xl font-bold">
{{ $total }}
</h2>

</div>



<div class="bg-green-50 p-5 rounded-xl">

<p>Tersalur</p>

<h2 class="text-3xl font-bold">
{{ $tersalur }}
</h2>

</div>



<div class="bg-yellow-50 p-5 rounded-xl">

<p>Proses</p>

<h2 class="text-3xl font-bold">
{{ $proses }}
</h2>

</div>



<div class="bg-red-50 p-5 rounded-xl">

<p>Gagal</p>

<h2 class="text-3xl font-bold">
{{ $gagal }}
</h2>

</div>


</div>





<!-- TABLE -->


<div class="overflow-x-auto">


<table class="w-full">


<thead>

<tr class="border-b bg-gray-50">


<th class="text-left p-3">
No
</th>


<th class="text-left">
Nama Warga
</th>


<th class="text-left">
Bansos
</th>


<th class="text-left">
Tanggal Salur
</th>


<th class="text-left">
Status
</th>


</tr>


</thead>



<tbody>


@forelse($laporan as $item)


<tr class="border-b">


<td class="p-3">

{{ $loop->iteration }}

</td>



<td>

{{ $item->penerima->warga->nama_lengkap ?? '-' }}

</td>



<td>

{{ $item->penerima->jenisBansos->nama_bansos ?? '-' }}

</td>



<td>


@if($item->tanggal_salur)

{{ \Carbon\Carbon::parse($item->tanggal_salur)->format('d-m-Y') }}

@else

-

@endif


</td>



<td>


@if($item->status == 'tersalur')

<span class="bg-green-100 text-green-700 px-3 py-1 rounded">

Tersalur

</span>


@elseif($item->status == 'proses')


<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded">

Proses

</span>


@elseif($item->status == 'gagal')


<span class="bg-red-100 text-red-700 px-3 py-1 rounded">

Gagal

</span>


@else


<span class="bg-gray-100 px-3 py-1 rounded">

Belum

</span>


@endif


</td>


</tr>



@empty


<tr>

<td colspan="5"
class="text-center py-5 text-gray-500">

Belum ada data laporan

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