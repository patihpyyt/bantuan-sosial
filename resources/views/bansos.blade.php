<x-app-layout>
    {{-- 1. HERO & SEARCH SECTION (Fokus Utama Warga Langsung di Atas) --}}
    <section class="relative overflow-hidden min-h-screen sm:min-h-[80vh] flex items-center pt-16 pb-32">

        {{-- Layer Gambar Background (tajam, sebagai latar penuh) --}}
        <img
    src="/img/pp.png"
    alt=""
    class="absolute inset-0 w-full h-full object-cover"
>

        {{-- Overlay Navy Gelap dengan Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-b from-slate-950/95 via-blue-950/85 to-blue-900/70"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/60 via-transparent to-slate-950/60"></div>

        {{-- Lengkungan Putih di Bawah (transisi ke section berikutnya) --}}
        <div class="absolute bottom-0 left-0 right-0 h-24 sm:h-32 bg-white rounded-t-[50%] translate-y-1/2 z-10"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 text-center">

            {{-- Lencana Selamat Datang --}}
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-white text-blue-700 tracking-wide uppercase mb-6 shadow-lg">
                <span class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-pulse"></span>
                Layanan Cek Mandiri Warga Desa
            </span>

            {{-- Judul Utama --}}
            <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight drop-shadow-lg">
                Pencarian Status Penerima <br>
                <span class="bg-gradient-to-r from-blue-400 to-indigo-300 bg-clip-text text-transparent font-black">
                    Bantuan Sosial Desa
                </span>
            </h1>

            {{-- Deskripsi Pendek --}}
            <p class="mt-4 text-sm sm:text-lg text-slate-200 max-w-xl mx-auto leading-relaxed">
                Masukkan 16 digit Nomor Induk Kependudukan (NIK) Anda untuk memeriksa status penetapan dan riwayat penyaluran bantuan (PKH, BLT, BPNT) secara transparan.
            </p>

            {{-- FORM CEK BANSOS PREMIUM (Ditaruh di Atas) --}}
            <div class="mt-10 max-w-2xl mx-auto bg-white border border-slate-200/80 shadow-2xl shadow-black/40 rounded-2xl p-5 sm:p-6 transition-all duration-300 hover:border-slate-300">
                <form action="{{ route('portal.cek') }}" method="POST" class="space-y-4 sm:space-y-0 sm:flex sm:gap-3">
                    @csrf {{-- Token Keamanan Laravel --}}

                    <div class="relative flex-1 text-left">
                        {{-- Icon KTP/ID di dalam Input --}}
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 012-2v2M6 14h.01M6 10h.01M6 18h.01"></path>
                            </svg>
                        </div>
                        <input
                            type="text"
                            name="nik"
                            id="nik"
                            maxlength="16"
                            required
                            placeholder="Masukkan 16 Digit NIK Anda..."
                            class="w-full bg-slate-50/50 border border-slate-200 focus:border-blue-500 focus:bg-white text-slate-800 rounded-xl pl-12 pr-4 py-4 text-sm font-semibold tracking-wider placeholder-slate-400 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 outline-none"
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 active:scale-[0.98] transition-all duration-150 shrink-0 text-sm"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari Data Bansos
                    </button>
                </form>
            </div>

            {{-- Teks Info Tambahan di Bawah Form --}}
            <p class="mt-4 text-xs text-slate-300 font-medium flex items-center justify-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Data diperbarui secara berkala oleh operator jaring pengaman sosial desa.
            </p>

            {{-- 3. BLOK HASIL PENCARIAN (Hanya muncul jika variable $nik dikirim dari controller) --}}
            @if(isset($nik))
            <div class="mt-10 max-w-2xl mx-auto text-left border border-slate-200/60 bg-white shadow-xl rounded-2xl p-6 transition-all duration-300">

                @if(!$warga)
                    {{-- KONDISI 1: NIK Tidak Terdaftar --}}
                    <div class="bg-red-50/80 border border-red-200 rounded-xl p-5">
                        <div class="flex gap-3">
                            <div class="shrink-0 text-red-500 pt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-red-900">Data Tidak Ditemukan</h3>
                                <p class="mt-1 text-xs text-red-600/90 leading-relaxed font-semibold">
                                    Nomor NIK <span class="underline font-bold text-red-700">{{ $nik }}</span> tidak terdaftar dalam basis data penerima jaring pengaman sosial desa. Mohon pastikan kembali angka yang Anda masukkan sudah benar.
                                </p>
                            </div>
                        </div>
                    </div>

                @elseif($warga->penerimaBansos->isEmpty())
                    {{-- KONDISI 2: Warga Terdaftar, Tapi Bukan Penerima Bansos --}}
                    <div class="bg-amber-50/80 border border-amber-200 rounded-xl p-5">
                        <div class="flex gap-3">
                            <div class="shrink-0 text-amber-600 pt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-amber-900">Identitas Terverifikasi (Bukan Penerima)</h3>
                                <div class="mt-2 text-xs font-bold text-slate-700 space-y-0.5">
                                    <p>Nama Lengkap: <span class="text-slate-900 font-extrabold">{{ $warga->nama_lengkap }}</span></p>
                                    <p>Status: Warga Terdaftar</p>
                                </div>
                                <p class="mt-3 text-xs text-amber-700/90 leading-relaxed font-medium pt-2 border-t border-amber-200/60">
                                    Orang dengan NIK tersebut aktif terdata sebagai warga desa, namun saat ini <span class="font-bold">belum ditetapkan</span> sebagai penerima aktif program bantuan sosial apa pun.
                                </p>
                            </div>
                        </div>
                    </div>

                @else
                    {{-- KONDISI 3: Sukses & Terdaftar Sebagai Penerima --}}
                    <div class="space-y-5">
                        {{-- Header Banner Sukses --}}
                        <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                            <span class="p-2 bg-emerald-50 text-emerald-600 rounded-xl shadow-xs shadow-emerald-500/10">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            <div>
                                <h3 class="text-base font-extrabold text-slate-900">Data Penerima Bansos Ditemukan</h3>
                                <p class="text-[11px] text-slate-400 font-semibold tracking-wide">Hasil pencarian untuk NIK: {{ $nik }}</p>
                            </div>
                        </div>

                        {{-- Profil Singkat --}}
                        <div class="grid grid-cols-2 gap-3 bg-slate-50 border border-slate-100 rounded-xl p-3.5 text-xs font-bold text-slate-600">
                            <div>
                                <span class="text-[10px] text-slate-400 font-medium block mb-0.5">NAMA PENERIMA</span>
                                <span class="text-slate-900 font-black tracking-wide">{{ $warga->nama_lengkap }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-400 font-medium block mb-0.5">WILAYAH DOMISILI</span>
                                <span class="text-slate-900 font-black">RT {{ $warga->rt }} / RW {{ $warga->rw }}</span>
                            </div>
                        </div>

                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider pt-1">Daftar Bantuan Sosial Aktif:</h4>

                        {{-- Looping Jenis BANSOS --}}
                        @foreach($warga->penerimaBansos as $penerima)
                            <div class="border border-slate-100 rounded-xl p-4 bg-slate-50/40 hover:border-slate-200 transition">
                                <div class="flex justify-between items-start mb-1">
                                    <h5 class="text-sm font-black text-blue-600 tracking-tight">{{ $penerima->jenisBansos->nama_bansos }}</h5>
                                    <span class="px-2 py-0.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-[9px] font-black rounded-md uppercase tracking-wider">Aktif</span>
                                </div>
                                <p class="text-[11px] text-slate-400 font-medium leading-relaxed mb-4">{{ $penerima->jenisBansos->deskripsi }}</p>

                                {{-- Detail Penyaluran --}}
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Riwayat Log Penyaluran:</div>
                                @if($penerima->penyaluran->isEmpty())
                                    <p class="text-xs text-slate-400 italic font-medium">Belum ada catatan log riwayat penyaluran untuk tahun ini.</p>
                                @else
                                    <div class="border border-slate-100 rounded-xl overflow-hidden bg-white text-[11px]">
                                        <table class="w-full text-left border-collapse">
                                            <thead class="bg-slate-50 text-slate-400 font-bold border-b border-slate-100">
                                                <tr>
                                                    <th class="p-2.5 font-bold">Periode Distribusi</th>
                                                    <th class="p-2.5 text-right font-bold">Besaran Dana</th>
                                                    <th class="p-2.5 text-center font-bold">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-100 font-semibold text-slate-600">
                                                @foreach($penerima->penyaluran as $log)
                                                <tr>
                                                    <td class="p-2.5 text-slate-800">{{ $log->periode_bulan }} {{ $log->periode_tahun }}</td>
                                                    <td class="p-2.5 text-right font-bold text-slate-900">Rp {{ number_format($penerima->jenisBansos->jumlah_bantuan, 0, ',', '.') }}</td>
                                                    <td class="p-2.5 text-center">
                                                        <span class="inline-block px-2 py-0.5 bg-emerald-50 text-emerald-700 font-bold rounded-full text-[10px]">Tersalurkan</span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            @endif
        </div>
    </section>

    {{-- 2. LAYANAN SISTEM SECTION (Informasi Alur/Edukasi Transparansi di Bawahnya) --}}
    <section class="bg-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Judul Sekunder --}}
            <div class="text-center max-w-xl mx-auto space-y-2">
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                    Komitmen Transparansi Desa
                </h2>
                <p class="text-sm text-slate-400 font-medium">
                    Bagaimana sistem ini membantu keterbukaan penyaluran bantuan sosial.
                </p>
            </div>

            {{-- Tiga Kolom Edukasi Informasi --}}
            <div class="grid md:grid-cols-3 gap-8 mt-14 text-slate-600">

                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm shadow-slate-100/50 hover:shadow-md transition-all duration-200">
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mb-5 font-bold">01</div>
                    <h3 class="text-base font-bold text-slate-900 mb-1.5">Verifikasi Terintegrasi</h3>
                    <p class="text-xs text-slate-400 leading-relaxed font-normal">
                        Seluruh data penerima dicocokkan langsung dengan basis data kependudukan desa (Master Data Warga) untuk meminimalisir salah sasaran.
                    </p>
                </div>

                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm shadow-slate-100/50 hover:shadow-md transition-all duration-200">
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mb-5 font-bold">02</div>
                    <h3 class="text-base font-bold text-slate-900 mb-1.5">Multi-Kategori Bantuan</h3>
                    <p class="text-xs text-slate-400 leading-relaxed font-normal">
                        Mendukung pemantauan berbagai jenis klaster bantuan pemerintah nasional maupun lokal seperti PKH, BLT Dana Desa, hingga BPNT.
                    </p>
                </div>

                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm shadow-slate-100/50 hover:shadow-md transition-all duration-200">
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mb-5 font-bold">03</div>
                    <h3 class="text-base font-bold text-slate-900 mb-1.5">Status Penyaluran Nyata</h3>
                    <p class="text-xs text-slate-400 leading-relaxed font-normal">
                        Warga dapat melihat secara terbuka apakah bantuan miliknya masih dalam status proses logistik atau sudah diserahkan (*tersalur*).
                    </p>
                </div>

            </div>
        </div>
    </section>
</x-app-layout>