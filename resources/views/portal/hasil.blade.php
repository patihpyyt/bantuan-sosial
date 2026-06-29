<x-app-layout>
    {{-- Mengatur Title Halaman Secara Dinamis ke app.blade.php --}}
    <x-slot name="title">Hasil Cek Bansos - Sistem Bansos Desa</x-slot>

    {{-- KONTEN UTAMA HASIL PENCARIAN --}}
    <div class="max-w-3xl mx-auto my-12 p-6 sm:p-8 bg-white rounded-2xl border border-slate-100 shadow-xl shadow-slate-200/50">
        
        {{-- HEADER HASIL --}}
        <div class="border-b border-slate-100 pb-5 mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Hasil Pencarian Status Bansos</h2>
                <p class="text-xs text-slate-400 mt-0.5">Sistem Informasi Jaring Pengaman Sosial Desa</p>
            </div>
            <div class="text-sm text-slate-600 bg-slate-50 border border-slate-200/60 px-3 py-1.5 rounded-xl self-start sm:self-auto">
                NIK yang dicari: <span class="font-bold text-blue-600 tracking-wide">{{ $nik }}</span>
            </div>
        </div>

        @if(!$warga)
            {{-- KONDISI 1: NIK Tidak Terdaftar di Sistem --}}
            <div class="bg-red-50/80 border border-red-200 p-5 rounded-2xl flex gap-3 items-start">
                <div class="mt-0.5 text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-red-900">Data Tidak Ditemukan!</h3>
                    <p class="text-sm text-red-700/90 mt-1 leading-relaxed">
                        Nomor NIK Anda tidak terdaftar dalam sistem data warga penerima bantuan sosial. Pastikan kembali nomor yang dimasukkan sudah benar.
                    </p>
                </div>
            </div>
        @elseif($warga->penerimaBansos->isEmpty())
            {{-- KONDISI 2: Warga Terdaftar, Tapi Bukan Penerima Bansos --}}
            <div class="bg-amber-50/80 border border-amber-200 p-5 rounded-2xl">
                <div class="flex items-center gap-2 text-amber-800 mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="text-base font-bold text-slate-900">Identitas Warga Ditemukan</h3>
                </div>
                <div class="bg-white/60 border border-amber-100 rounded-xl p-3 mb-3 text-sm space-y-1 text-slate-700">
                    <p>Nama Warga : <strong class="text-slate-900">{{ $warga->nama_lengkap }}</strong></p>
                    <p>Alamat Rumah : <span class="text-slate-800 font-medium">{{ $warga->alamat }}</span></p>
                </div>
                <p class="text-sm text-amber-800 leading-relaxed">
                    Status: Terdaftar sebagai warga resmi, namun saat ini <strong class="text-amber-900">Belum Terdaftar</strong> sebagai penerima aktif program bantuan sosial apa pun.
                </p>
            </div>
        @else
            {{-- KONDISI 3: Warga Ditemukan & Menerima Bansos --}}
            <div class="bg-emerald-50/80 border border-emerald-200 p-5 rounded-2xl mb-6">
                <div class="flex items-center gap-2 text-emerald-800 mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="text-base font-bold text-emerald-900">Selamat! Data Penerima Ditemukan</h3>
                </div>
                <div class="overflow-hidden bg-white/80 border border-emerald-100 rounded-xl p-4 shadow-xs">
                    <table class="text-sm text-slate-700 w-full max-w-md">
                        <tr>
                            <td class="w-32 py-1.5 font-medium text-slate-400">Nama Penerima</td>
                            <td class="py-1.5 text-slate-900 font-bold">: {{ $warga->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="py-1.5 font-medium text-slate-400">Alamat Rumah</td>
                            <td class="py-1.5 text-slate-800 font-semibold">: {{ $warga->alamat }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <h4 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Daftar Bantuan yang Diterima:</h4>
            
            @foreach($warga->penerimaBansos as $penerima)
                <div class="border border-slate-200/80 rounded-2xl p-5 mb-5 bg-white shadow-xs">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-3 mb-3">
                        <span class="font-extrabold text-slate-900 text-base tracking-tight">
                            {{ $penerima->jenisBansos->nama_bansos }}
                        </span>
                        <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold rounded-full">
                            Bansos Aktif
                        </span>
                    </div>
                    <p class="text-sm text-slate-500 mb-4 leading-relaxed">{{ $penerima->jenisBansos->deskripsi }}</p>

                    <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Riwayat Penyaluran Terakhir:
                    </h5>
                    
                    @if($penerima->penyaluran->isEmpty())
                        <div class="text-xs text-slate-400 italic bg-slate-50/80 p-4 rounded-xl border border-dashed border-slate-200 text-center">
                            Belum ada catatan riwayat penyaluran untuk periode saat ini.
                        </div>
                    @else
                        <div class="overflow-hidden border border-slate-100 rounded-xl bg-slate-50/30">
                            <table class="min-w-full text-xs text-left text-slate-600">
                                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-100">
                                    <tr>
                                        <th class="px-4 py-3">Periode Bulan / Tahun</th>
                                        <th class="px-4 py-3">Jumlah Bantuan</th>
                                        <th class="px-4 py-3 text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($penerima->penyaluran as $log)
                                        <tr class="hover:bg-slate-50/50 transition">
                                            <td class="px-4 py-3 font-semibold text-slate-800">{{ $log->periode_bulan }} {{ $log->periode_tahun }}</td>
                                            <td class="px-4 py-3 text-slate-600 font-medium">Rp {{ number_format($penerima->jenisBansos->jumlah_bantuan, 0, ',', '.') }}</td>
                                            <td class="px-4 py-3 text-right">
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full font-bold">
                                                    Sukses Disalurkan
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif

        {{-- NAVIGASI KEMBALI --}}
        <div class="mt-8 text-center border-t border-slate-100 pt-5">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-3 rounded-xl shadow-lg shadow-blue-500/20 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali Cari NIK Lain
            </a>
        </div>
    </div>
</x-app-layout>