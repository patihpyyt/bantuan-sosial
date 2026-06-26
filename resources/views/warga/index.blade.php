<x-app-layout>


<div class="p-8 bg-gray-100 min-h-screen">


<div class="bg-white rounded-xl shadow p-6">


<div class="flex justify-between mb-6">


<h1 class="text-2xl font-bold">
Data Warga
</h1>



<a href="{{route('warga.create')}}"
class="bg-blue-600 text-white px-5 py-2 rounded">

+ Tambah Warga

</a>


</div>



@if(session('success'))

<div class="bg-green-100 p-3 mb-5">
{{session('success')}}
</div>

@endif




<table class="w-full border">


<tr class="bg-gray-200">

<th class="border p-3">
No
</th>

<th class="border p-3">
NIK
</th>

<th class="border p-3">
Nama
</th>

<th class="border p-3">
JK
</th>

<th class="border p-3">
Alamat
</th>

<th class="border p-3">
Aksi
</th>


</tr>



@foreach($warga as $data)


<tr>

<td class="border p-3">
{{$loop->iteration}}
</td>


<td class="border p-3">
{{$data->nik}}
</td>


<td class="border p-3">
{{$data->nama_lengkap}}
</td>


<td class="border p-3">
{{$data->jenis_kelamin}}
</td>


<td class="border p-3">
{{$data->alamat}}
</td>


<td class="border p-3">


<a href="{{route('warga.edit',$data->id)}}"
class="text-blue-600">
Edit
</a>


<form action="{{route('warga.destroy',$data->id)}}"
method="POST"
class="inline">


@csrf
@method('DELETE')


<button class="text-red-600 ml-3">
Hapus
</button>


</form>


</td>


</tr>


@endforeach



</table>



</div>


</div>


</x-app-layout>