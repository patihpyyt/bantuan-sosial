<x-app-layout>

    <div class="py-10">
        <div class="max-w-5xl mx-auto">

            <div class="bg-white shadow rounded-xl p-8">

                <h2 class="text-2xl font-bold mb-6">
                    Tambah Penerima Bansos
                </h2>


                <form action="{{ route('penerima-bansos.store') }}" method="POST">

                    @csrf


                    <!-- WARGA -->
                    <div class="mb-5">

                        <label class="block font-semibold mb-2">
                            Nama Warga
                        </label>


                        <select name="warga_id"
                            class="w-full border rounded-lg p-3">


                            <option value="">
                                -- Pilih Warga --
                            </option>


                            @foreach($warga as $item)

                                <option value="{{ $item->id }}">

                                    {{ $item->nama_lengkap }}
                                    - NIK: {{ $item->nik }}
                                    @if($item->rt && $item->rw)
                                        (RT {{ $item->rt }}/RW {{ $item->rw }})
                                    @else
                                        (RT/RW belum diisi)
                                    @endif

                                </option>

                            @endforeach


                        </select>

                    </div>



                    <!-- JENIS BANSOS -->
                    <div class="mb-5">

                        <label class="block font-semibold mb-2">
                            Jenis Bantuan
                        </label>


                        <select name="jenis_bansos_id"
                            class="w-full border rounded-lg p-3">


                            <option value="">
                                -- Pilih Bantuan --
                            </option>


                            @foreach($jenisBansos as $item)

                                <option value="{{ $item->id }}">

                                    {{ $item->nama_bansos }}

                                </option>

                            @endforeach


                        </select>

                    </div>



                    <!-- STATUS -->
                    <div class="mb-5">

                        <label class="block font-semibold mb-2">
                            Status Penerimaan
                        </label>


                        <select name="status"
                            class="w-full border rounded-lg p-3">


                            <option value="layak">
                                Layak Menerima
                            </option>


                            <option value="tidak_layak">
                                Tidak Layak
                            </option>


                        </select>

                    </div>



                    <!-- TANGGAL -->
                    <div class="mb-5">

                        <label class="block font-semibold mb-2">
                            Tanggal Menerima
                        </label>


                        <input type="date"
                            name="tanggal_menerima"
                            class="w-full border rounded-lg p-3">


                    </div>



                    <!-- KETERANGAN -->
                    <div class="mb-5">

                        <label class="block font-semibold mb-2">
                            Keterangan
                        </label>


                        <textarea name="keterangan"
                            class="w-full border rounded-lg p-3"
                            rows="4"></textarea>


                    </div>



                    <div class="flex gap-3">


                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">

                            Simpan

                        </button>


                        <a href="{{ route('penerima-bansos.index') }}"
                            class="bg-gray-200 px-6 py-3 rounded-lg">

                            Kembali

                        </a>


                    </div>


                </form>


            </div>

        </div>
    </div>


</x-app-layout>