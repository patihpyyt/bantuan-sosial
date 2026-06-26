<x-app-layout>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- HERO --}}
            <div class="bg-blue-600 rounded-2xl p-8 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 rounded-full -translate-y-1/2 translate-x-1/4 opacity-50"></div>
                <div class="relative z-10">
                    <span class="inline-flex items-center gap-1.5 bg-blue-500 text-blue-100 text-xs font-medium px-3 py-1 rounded-full mb-4">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span>
                        Sistem Aktif
                    </span>
                    <h1 class="text-3xl font-bold">
                        Selamat Datang,<br>{{ Auth::user()->nama_lengkap ?? Auth::user()->name }}
                    </h1>
                    <p class="mt-2 text-blue-100 text-sm max-w-lg">
                        Sistem Informasi Pendataan dan Monitoring Penerima Bantuan Sosial — PKH, BLT, BPNT
                    </p>
                </div>
            </div>

            {{-- STATISTIK --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Total Warga</p>
                    <p class="text-3xl font-bold text-blue-600 mt-1">{{ $totalWarga ?? 0 }}</p>
                    <p class="text-xs text-gray-400 mt-1">KK terdaftar</p>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Jenis Bantuan</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $totalJenisBansos ?? 0 }}</p>
                    <p class="text-xs text-gray-400 mt-1">PKH · BLT · BPNT</p>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Penerima Bansos</p>
                    <p class="text-3xl font-bold text-amber-500 mt-1">{{ $totalPenerima ?? 0 }}</p>
                    <p class="text-xs text-gray-400 mt-1">warga terverifikasi</p>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Penyaluran</p>
                    <p class="text-3xl font-bold text-purple-600 mt-1">{{ $totalPenyaluran ?? 0 }}</p>
                    <p class="text-xs text-gray-400 mt-1">sudah tersalur</p>
                </div>

            </div>

            {{-- MENU UTAMA --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">

                <h2 class="text-base font-semibold text-gray-700 mb-4">Menu Pengelolaan</h2>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">

                    <a href="/warga"
                       class="flex flex-col items-center gap-2 border border-gray-100 rounded-xl p-4 hover:bg-blue-50 hover:border-blue-200 transition text-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-xl">&#128101;</div>
                        <span class="text-sm font-medium text-gray-700">Data Warga</span>
                        <span class="text-xs text-gray-400">Input & kelola KK</span>
                    </a>

                    <a href="/jenis-bansos"
                       class="flex flex-col items-center gap-2 border border-gray-100 rounded-xl p-4 hover:bg-green-50 hover:border-green-200 transition text-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-xl">&#127873;</div>
                        <span class="text-sm font-medium text-gray-700">Jenis Bansos</span>
                        <span class="text-xs text-gray-400">PKH, BLT, BPNT</span>
                    </a>

                    <a href="/penerima-bansos"
                       class="flex flex-col items-center gap-2 border border-gray-100 rounded-xl p-4 hover:bg-amber-50 hover:border-amber-200 transition text-center">
                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center text-xl">&#128203;</div>
                        <span class="text-sm font-medium text-gray-700">Penerima</span>
                        <span class="text-xs text-gray-400">Verifikasi & seleksi</span>
                    </a>

                    <a href="/penyaluran"
                       class="flex flex-col items-center gap-2 border border-gray-100 rounded-xl p-4 hover:bg-purple-50 hover:border-purple-200 transition text-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center text-xl">&#128230;</div>
                        <span class="text-sm font-medium text-gray-700">Penyaluran</span>
                        <span class="text-xs text-gray-400">Monitoring bantuan</span>
                    </a>

                    <a href="/laporan"
                       class="flex flex-col items-center gap-2 border border-gray-100 rounded-xl p-4 hover:bg-teal-50 hover:border-teal-200 transition text-center">
                        <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center text-xl">&#128202;</div>
                        <span class="text-sm font-medium text-gray-700">Laporan</span>
                        <span class="text-xs text-gray-400">Ekspor per periode</span>
                    </a>

                </div>

            </div>

            {{-- PENYALURAN TERBARU + REALISASI --}}
            <div class="grid md:grid-cols-2 gap-6">

                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-base font-semibold text-gray-700">Penyaluran Terbaru</h2>
                        <a href="/penyaluran" class="text-xs text-blue-500 hover:underline">Lihat semua</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($penyaluranTerbaru ?? [] as $item)
                        <div class="flex justify-between items-center py-2 border-b border-gray-50 last:border-0">
                            <div>
                                <p class="text-sm font-medium text-gray-700">{{ $item->warga->nama_lengkap ?? '-' }}</p>
                                <p class="text-xs text-gray-400">{{ $item->jenisBansos->nama_bansos ?? '-' }} · {{ $item->created_at->format('d M Y') }}</p>
                            </div>
                            @if($item->status === 'tersalur')
                                <span class="text-xs bg-green-100 text-green-700 font-medium px-2.5 py-1 rounded-full">Tersalur</span>
                            @elseif($item->status === 'pending')
                                <span class="text-xs bg-amber-100 text-amber-700 font-medium px-2.5 py-1 rounded-full">Pending</span>
                            @else
                                <span class="text-xs bg-blue-100 text-blue-700 font-medium px-2.5 py-1 rounded-full">Diproses</span>
                            @endif
                        </div>
                        @empty
                        <p class="text-sm text-gray-400 text-center py-4">Belum ada data penyaluran</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h2 class="text-base font-semibold text-gray-700 mb-4">Realisasi per Jenis Bantuan</h2>
                    <div class="space-y-4">

                        <div>
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>PKH (Program Keluarg Harapan)</span>
                                <span class="font-medium text-gray-700">{{ $realisasiPKH ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $realisasiPKH ?? 0 }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>BLT (Bantuan Langsung Tunai)</span>
                                <span class="font-medium text-gray-700">{{ $realisasiBLT ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $realisasiBLT ?? 0 }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>BPNT (Bantuan Pangan Non-Tunai)</span>
                                <span class="font-medium text-gray-700">{{ $realisasiBPNT ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-amber-500 h-2 rounded-full" style="width: {{ $realisasiBPNT ?? 0 }}%"></div>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-gray-100">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span class="font-semibold text-gray-700">Total Realisasi</span>
                                <span class="font-semibold text-purple-600">{{ $realisasiTotal ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2.5">
                                <div class="bg-purple-500 h-2.5 rounded-full" style="width: {{ $realisasiTotal ?? 0 }}%"></div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            {{-- FOOTER CEK STATUS --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-700">Cek Status Bantuan untuk Warga</p>
                    <p class="text-xs text-gray-400 mt-0.5">Warga dapat mengecek status penerimaan bantuan secara mandiri</p>
                </div>
                <a href="/cek-bansos"
                   class="text-sm text-blue-600 hover:text-blue-800 font-medium border border-blue-200 px-4 py-2 rounded-lg hover:bg-blue-50 transition whitespace-nowrap">
                    Halaman Cek Status &rarr;
                </a>
            </div>

        </div>
    </div>

</x-app-layout>