<x-app-layout>
    {{-- 1. HERO & SEARCH SECTION (Fokus Utama Warga Langsung di Atas) --}}
    <section class="relative overflow-hidden min-h-screen sm:min-h-[80vh] flex items-center pt-16 pb-32">

        {{-- Layer Gambar Background --}}
        <div class="absolute inset-0 z-0 overflow-hidden">
            <img
                src="/img/pp.png"
                alt=""
                class="absolute inset-0 w-full h-full object-cover object-[80%_top] md:w-[55%] md:left-auto md:right-0"
                style="filter: brightness(0.6) saturate(0.85);"
            >

            {{-- Overlay dasar solid, gelap total --}}
            <div class="absolute inset-0 bg-emerald-950/85"></div>

           
            <div
                class="absolute inset-0"
                style="background: linear-gradient(to right, rgba(7, 24, 52, 0.98) 0%, rgba(2, 5, 20, 0.9) 35%, rgba(4, 2, 20, 0.55) 65%, rgba(2,20,15,0.25) 100%);"
            ></div>

            <div
                class="absolute inset-0"
                style="background: linear-gradient(to top, rgba(20, 28, 37, 0.9) 0%, rgba(2,20,15,0.2) 40%, rgba(2, 2, 20, 0) 70%);"
            ></div>
        </div>

        {{-- Overlay biru Gelap dengan Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/95 via-green-900/80 to-blue-700/40"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-emerald-950/70 via-transparent to-emerald-950/60"></div>

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
                <span class="text-blue from-sky-300 to-indigo-200 bg-clip-text font-black drop-shadow-md">
                    Bantuan Sosial Desa
                </span>
            </h1>

            {{-- Deskripsi Pendek --}}
            <p class="mt-4 text-sm sm:text-lg text-white max-w-xl mx-auto leading-relaxed drop-shadow-md">
                Masukkan 16 digit Nomor Induk Kependudukan (NIK) Anda untuk memeriksa status penetapan dan riwayat penyaluran bantuan (PKH, BLT, BPNT) secara transparan.
            </p>

            {{-- FORM CEK BANSOS PREMIUM (Ditaruh di Atas) --}}
            <div class="mt-10 max-w-2xl mx-auto bg-white/95 backdrop-blur-md shadow-2xl shadow-black/40 rounded-2xl p-5 sm:p-6 transition-all duration-300">
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
                            class="w-full backdrop-filter-blur shadow-inner shadow-slate-200/40 focus:bg-white text-slate-900 rounded-xl pl-12 pr-4 py-4 text-sm font-semibold tracking-wider placeholder-slate-400 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 outline-none"
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
            <p class="mt-4 text-xs text-white font-medium flex items-center justify-center gap-1.5 drop-shadow-md">
                <svg class="w-3.5 h-3.5 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Data diperbarui secara berkala oleh operator jaring pengaman sosial desa.
            </p>

            {{-- 3. BLOK HASIL PENCARIAN (Hanya muncul jika variable $nik dikirim dari controller) --}}
            @if(isset($nik))
            <div class="mt-10 max-w-2xl mx-auto text-left bg-white/95 backdrop-blur-md shadow-xl shadow-black/30 rounded-2xl p-6 transition-all duration-300">

                @if(!$warga)
                    {{-- KONDISI 1: NIK Tidak Terdaftar --}}
                    <div class="bg-red-50/80 rounded-xl p-5 shadow-[0_0_25px_rgba(239,68,68,0.15)]">
                        <div class="flex gap-3">
                            <div class="shrink-0 text-red-500 pt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-red-900">Data Tidak Ditemukan</h3>
                                <p class="mt-1 text-xs text-red-700 leading-relaxed font-semibold">
                                    Nomor NIK <span class="underline font-bold text-red-800">{{ $nik }}</span> tidak terdaftar dalam basis data penerima jaring pengaman sosial desa. Mohon pastikan kembali angka yang Anda masukkan sudah benar.
                                </p>
                            </div>
                        </div>
                    </div>

                @elseif($warga->penerimaBansos->isEmpty())
                    {{-- KONDISI 2: Warga Terdaftar, Tapi Bukan Penerima Bansos --}}
                    <div class="bg-amber-50/80 rounded-xl p-5 shadow-[0_0_25px_rgba(245,158,11,0.15)]">
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
                                <p class="mt-3 text-xs text-amber-800 leading-relaxed font-medium pt-2 shadow-[0_-1px_0_0_rgba(245,158,11,0.2)]">
                                    Orang dengan NIK tersebut aktif terdata sebagai warga desa, namun saat ini <span class="font-bold">belum ditetapkan</span> sebagai penerima aktif program bantuan sosial apa pun.
                                </p>
                            </div>
                        </div>
                    </div>

                @else
                    {{-- KONDISI 3: Sukses & Terdaftar Sebagai Penerima --}}
                    <div class="space-y-5">
                        {{-- Header Banner Sukses --}}
                        <div class="flex items-center gap-3 pb-4 shadow-[0_1px_0_0_rgba(0,0,0,0.05)]">
                            <span class="p-2 bg-emerald-50 text-emerald-600 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.2)]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            <div>
                                <h3 class="text-base font-extrabold text-white">Data Penerima Bansos Ditemukan</h3>
                                <p class="text-[11px] text-slate-500 font-semibold tracking-wide">Hasil pencarian untuk NIK: {{ $nik }}</p>
                            </div>
                        </div>

                        {{-- Profil Singkat --}}
                        <div class="grid grid-cols-2 gap-3 bg-slate-50 rounded-xl p-3.5 text-xs font-bold text-slate-600 shadow-[0_2px_20px_rgba(0,0,0,0.04)]">
                            <div>
                                <span class="text-[10px] text-slate-500 font-medium block mb-0.5">NAMA PENERIMA</span>
                                <span class="text-slate-900 font-black tracking-wide">{{ $warga->nama_lengkap }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-500 font-medium block mb-0.5">WILAYAH DOMISILI</span>
                                <span class="text-slate-900 font-black">RT {{ $warga->rt }} / RW {{ $warga->rw }}</span>
                            </div>
                        </div>

                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider pt-1">Daftar Bantuan Sosial Aktif:</h4>

                        {{-- Looping Jenis BANSOS --}}
                        @foreach($warga->penerimaBansos as $penerima)
                            <div class="rounded-xl p-4 bg-slate-50/40 shadow-[0_2px_20px_rgba(0,0,0,0.05)] hover:shadow-[0_4px_25px_rgba(0,0,0,0.08)] transition">
                                <div class="flex justify-between items-start mb-1">
                                    <h5 class="text-sm font-black text-blue-600 tracking-tight">{{ $penerima->jenisBansos->nama_bansos }}</h5>
                                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[9px] font-black rounded-md uppercase tracking-wider shadow-[0_0_10px_rgba(16,185,129,0.2)]">Aktif</span>
                                </div>
                                <p class="text-[11px] text-slate-500 leading-relaxed mb-4">
                                    {{ $penerima->jenisBansos->deskripsi }}
                                </p>

                                {{-- Detail Penyaluran --}}
                                <div class="text-[10px] text-white font-bold text-slate-500 uppercase tracking-wide mb-2">Riwayat Log Penyaluran:</div>
                                @if($penerima->penyaluran->isEmpty())
                                    <p class="text-xs text-slate-500 italic font-medium">Belum ada catatan log riwayat penyaluran untuk tahun ini.</p>
                                @else
                                    <div class="rounded-xl overflow-hidden bg-white text-[11px] shadow-[0_2px_20px_rgba(0,0,0,0.06)]">
                                        <table class="w-full text-left border-collapse">
                                            <thead class="bg-slate-50 text-slate-500 font-bold shadow-[0_1px_0_0_rgba(0,0,0,0.05)]">
                                                <tr>
                                                    <th class="p-2.5 font-bold">Periode Distribusi</th>
                                                    <th class="p-2.5 text-right font-bold">Besaran Dana</th>
                                                    <th class="p-2.5 text-center font-bold">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="font-semibold text-slate-600">
                                                @foreach($penerima->penyaluran as $log)
                                                <tr class="shadow-[0_1px_0_0_rgba(0,0,0,0.04)]">
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
    <section class="bg-white py-16 sm:py-24" id="komitmen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Judul Sekunder --}}
            <div class="text-center max-w-xl mx-auto space-y-2">
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                    Komitmen Transparansi Desa
                </h2>
                <p class="text-sm text-slate-500 font-medium">
                    Bagaimana sistem ini membantu keterbukaan penyaluran bantuan sosial.
                </p>
            </div>

            {{-- Tiga Kolom Edukasi Informasi --}}
            <div class="grid md:grid-cols-3 gap-8 mt-14 text-slate-600">

                <div class="bg-white rounded-2xl p-6 shadow-[0_4px_30px_rgba(0,0,0,0.06)] hover:shadow-[0_8px_35px_rgba(0,0,0,0.1)] transition-all duration-200">
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mb-5 font-bold">01</div>
                    <h3 class="text-base font-bold text-slate-900 mb-1.5">Verifikasi Terintegrasi</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-normal">
                        Seluruh data penerima dicocokkan langsung dengan basis data kependudukan desa (Master Data Warga) untuk meminimalisir salah sasaran.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-[0_4px_30px_rgba(0,0,0,0.06)] hover:shadow-[0_8px_35px_rgba(0,0,0,0.1)] transition-all duration-200">
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mb-5 font-bold">02</div>
                    <h3 class="text-base font-bold text-slate-900 mb-1.5">Multi-Kategori Bantuan</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-normal">
                        Mendukung pemantauan berbagai jenis klaster bantuan pemerintah nasional maupun lokal seperti PKH, BLT Dana Desa, hingga BPNT.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-[0_4px_30px_rgba(0,0,0,0.06)] hover:shadow-[0_8px_35px_rgba(0,0,0,0.1)] transition-all duration-200">
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mb-5 font-bold">03</div>
                    <h3 class="text-base font-bold text-slate-900 mb-1.5">Status Penyaluran Nyata</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-normal">
                        Warga dapat melihat secara terbuka apakah bantuan miliknya masih dalam status proses logistik atau sudah diserahkan (*tersalur*).
                    </p>
                </div>

            </div>
        </div>
    </section>

      {{-- 3. STATISTIK RINGKAS DESA --}}
    <section class="bg-slate-50 py-14 sm:py-20" id="statistik">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto space-y-2 mb-12">
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                    Statistik Bantuan Sosial Desa
                </h2>
                <p class="text-sm text-slate-500 font-medium">
                    Ringkasan data penyaluran bantuan sosial tahun berjalan.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                <div class="bg-white rounded-2xl p-5 text-center shadow-[0_4px_30px_rgba(0,0,0,0.06)]">
                    <p class="text-2xl sm:text-3xl font-black text-blue-600">{{ $totalPenerima ?? '0' }}</p>
                    <p class="text-[11px] sm:text-xs font-bold text-slate-500 mt-1 uppercase tracking-wide">Total Penerima</p>
                </div>
                <div class="bg-white rounded-2xl p-5 text-center shadow-[0_4px_30px_rgba(0,0,0,0.06)]">
                    <p class="text-2xl sm:text-3xl font-black text-emerald-600">{{ $totalProgram ?? '0' }}</p>
                    <p class="text-[11px] sm:text-xs font-bold text-slate-500 mt-1 uppercase tracking-wide">Program Aktif</p>
                </div>
                <div class="bg-white rounded-2xl p-5 text-center shadow-[0_4px_30px_rgba(0,0,0,0.06)]">
                    <p class="text-xl sm:text-2xl font-black text-indigo-600">Rp {{ number_format($totalAnggaran ?? 0, 0, ',', '.') }}</p>
                    <p class="text-[11px] sm:text-xs font-bold text-slate-500 mt-1 uppercase tracking-wide">Total Anggaran Tersalur</p>
                </div>
                <div class="bg-white rounded-2xl p-5 text-center shadow-[0_4px_30px_rgba(0,0,0,0.06)]">
                    <p class="text-2xl sm:text-3xl font-black text-amber-600">{{ $totalRTRW ?? '0' }}</p>
                    <p class="text-[11px] sm:text-xs font-bold text-slate-500 mt-1 uppercase tracking-wide">RT/RW Terjangkau</p>
                </div>
            </div>
        </div>
    </section>

  
    {{-- 4. PENJELASAN JENIS PROGRAM BANSOS --}}
    <section class="bg-slate-50 py-16 sm:py-24" id="jenis">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto space-y-2 mb-14">
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                    Jenis Program Bantuan Sosial
                </h2>
                <p class="text-sm text-slate-500 font-medium">
                    Program bantuan yang dipantau melalui portal ini.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-[0_4px_30px_rgba(0,0,0,0.06)]">
                    <span class="inline-block px-3 py-1 bg-blue-50 text-blue-700 text-[10px] font-black rounded-full uppercase tracking-wider mb-4">PKH</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Program Keluarga Harapan</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Bantuan tunai bersyarat bagi keluarga kurang mampu dengan komponen kesehatan, pendidikan, dan kesejahteraan sosial. Disalurkan bertahap setiap triwulan.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-[0_4px_30px_rgba(0,0,0,0.06)]">
                    <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-black rounded-full uppercase tracking-wider mb-4">BLT</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2">BLT Dana Desa</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Bantuan langsung tunai yang bersumber dari Dana Desa, diperuntukkan bagi keluarga miskin dan rentan yang belum menerima bantuan sosial lain.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-[0_4px_30px_rgba(0,0,0,0.06)]">
                    <span class="inline-block px-3 py-1 bg-amber-50 text-amber-700 text-[10px] font-black rounded-full uppercase tracking-wider mb-4">BPNT</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Bantuan Pangan Non Tunai</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Bantuan berupa saldo elektronik untuk pembelian bahan pangan pokok melalui e-warong atau agen resmi yang ditunjuk pemerintah.
                    </p>
                </div>
            </div>
        </div>
    </section>

           {{-- 5. ALUR PENGAJUAN / VERIFIKASI --}}
<section class="bg-slate-50/50 py-16 sm:py-24" id="alur">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section --}}
        <div class="text-center max-w-xl mx-auto mb-12">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Alur Pengajuan & Verifikasi
            </h2>
            <p class="text-sm text-slate-500 font-medium mt-2">
                Tahapan keterbukaan warga menjadi calon penerima bantuan sosial desa.
            </p>
        </div>

        {{-- Grid Langkah (Step Cards) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['no' => '01', 'judul' => 'Pendaftaran Mandiri', 'desc' => 'Warga mengisi formulir usulan calon penerima di kantor desa atau via operator setempat.'],
                ['no' => '02', 'judul' => 'Verifikasi Faktual', 'desc' => 'Tim verifikator melakukan kunjungan lapangan untuk survei riil kondisi rumah tangga.'],
                ['no' => '03', 'judul' => 'Musyawarah Desa', 'desc' => 'Hasil verifikasi dibahas bersama dalam Musdes untuk menetapkan kelayakan secara adil.'],
                ['no' => '04', 'judul' => 'Penetapan & Penyaluran', 'desc' => 'Data disahkan ke sistem pusat dan bantuan mulai disalurkan sesuai jadwal program.'],
            ] as $step)
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm hover:shadow-md hover:border-slate-200 transition duration-300 flex flex-col justify-between">
                <div>
                    {{-- Header Kartu: Nomor + Judul --}}
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-black tracking-widest text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md uppercase">
                            Langkah {{ $step['no'] }}
                        </span>
                        <div class="w-1.5 h-1.5 rounded-full bg-slate-300"></div>
                    </div>
                    
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">
                        {{ $step['judul'] }}
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mt-2">
                        {{ $step['desc'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

    {{-- 6. FAQ --}}
    <section class="bg-slate-50 py-16 sm:py-24" id="faq">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-2 mb-12">
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                    Pertanyaan yang Sering Diajukan
                </h2>
            </div>

            <div class="space-y-3" x-data="{ open: null }">
                @foreach([
                    ['q' => 'Apakah data NIK saya aman jika dicek di sini?', 'a' => 'Ya. Sistem hanya menampilkan status penetapan dan riwayat penyaluran, tanpa menampilkan data pribadi sensitif lain seperti alamat lengkap atau nomor rekening.'],
                    ['q' => 'Kenapa NIK saya terdaftar sebagai warga tapi belum menerima bansos?', 'a' => 'Penetapan penerima bansos ditentukan berdasarkan hasil verifikasi dan musyawarah desa, bukan otomatis dari status kependudukan. Anda tetap bisa mengajukan diri sebagai calon penerima.'],
                    ['q' => 'Berapa lama proses verifikasi setelah pendaftaran?', 'a' => 'Umumnya proses verifikasi faktual dan musyawarah desa memakan waktu 2-4 minggu, tergantung jadwal tim verifikator dan agenda musyawarah desa setempat.'],
                    ['q' => 'Ke mana saya harus melapor jika ada dugaan kesalahan data?', 'a' => 'Silakan hubungi kantor desa atau gunakan kontak pengaduan yang tersedia di bagian bawah halaman ini.'],
                ] as $i => $faq)
                <div class="bg-white rounded-xl shadow-[0_2px_20px_rgba(0,0,0,0.05)] overflow-hidden">
                    <button
                        type="button"
                        @click="open = open === {{ $i }} ? null : {{ $i }}"
                        class="w-full flex justify-between items-center gap-4 p-4 sm:p-5 text-left"
                    >
                        <span class="text-sm font-bold text-slate-800">{{ $faq['q'] }}</span>
                        <svg class="w-4 h-4 shrink-0 text-slate-400 transition-transform" :class="open === {{ $i }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open === {{ $i }}" x-collapse class="px-4 sm:px-5 pb-4 sm:pb-5">
                        <p class="text-xs text-slate-500 leading-relaxed">{{ $faq['a'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 7. KONTAK PENGADUAN --}}
    <section class="bg-white py-16 sm:py-24" id="lapor">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-8 sm:p-12 text-center shadow-xl shadow-blue-500/20">
                <h2 class="text-xl sm:text-2xl font-extrabold text-white mb-3">
                    Ada Pertanyaan atau Ingin Melapor?
                </h2>
                <p class="text-sm text-blue-100 max-w-lg mx-auto mb-8 leading-relaxed">
                    Sampaikan keluhan, pertanyaan, atau laporan dugaan penyalahgunaan bantuan sosial melalui kanal resmi berikut.
                </p>
                <div class="grid sm:grid-cols-3 gap-4 max-w-2xl mx-auto text-left">
                    <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
                        <p class="text-[10px] font-bold text-blue-200 uppercase tracking-wide mb-1">Kantor Desa</p>
                        <p class="text-xs font-bold text-white">Senin - Jumat, 08.00 - 15.00</p>
                    </div>
                    <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
                        <p class="text-[10px] font-bold text-blue-200 uppercase tracking-wide mb-1">WhatsApp Pengaduan</p>
                        <p class="text-xs font-bold text-white">{{ $kontakWA ?? '0838936115' }}</p>
                    </div>
                    <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
                        <p class="text-[10px] font-bold text-blue-200 uppercase tracking-wide mb-1">Email Resmi</p>
                        <p class="text-xs font-bold text-white">{{ $kontakEmail ?? 'bansos@desa.go.id' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>