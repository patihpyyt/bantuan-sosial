<x-app-layout>
    <section class="bg-slate-50 min-h-screen pt-24 pb-20">
        <div class="max-w-xl mx-auto px-4 sm:px-6">

            @if(session('success'))
                <div class="mb-5 bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-xs font-semibold text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-[0_4px_30px_rgba(0,0,0,0.06)] p-6 sm:p-8">

                <div class="text-center mb-6">
                    @if($donasi->status === 'menunggu_pembayaran')
                        <span class="inline-flex px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-wide">
                            Menunggu Pembayaran
                        </span>
                    @elseif($donasi->status === 'menunggu_verifikasi')
                        <span class="inline-flex px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wide">
                            Menunggu Verifikasi Admin
                        </span>
                    @elseif($donasi->status === 'terverifikasi')
                        <span class="inline-flex px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wide">
                            Donasi Terverifikasi
                        </span>
                    @else
                        <span class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold uppercase tracking-wide">
                            Ditolak
                        </span>
                    @endif

                    <h1 class="mt-4 text-xl font-extrabold text-slate-900">
                        Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}
                    </h1>
                    <p class="text-xs text-slate-400 mt-1">Kode Referensi: <span class="font-bold text-slate-600">{{ $donasi->kode_referensi }}</span></p>
                </div>

                @if($donasi->status === 'menunggu_pembayaran')
                    <div class="bg-slate-50 rounded-2xl p-5 mb-6">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">
                            Instruksi Pembayaran
                            @if($donasi->metode_pembayaran === 'transfer_bank') (Transfer Bank) @endif
                            @if($donasi->metode_pembayaran === 'qris') (QRIS) @endif
                            @if($donasi->metode_pembayaran === 'ewallet') (E-Wallet) @endif
                        </h3>

                        @if($donasi->metode_pembayaran === 'transfer_bank')
                            <div class="bg-white rounded-xl p-4 border border-slate-200 space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Bank Tujuan</span>
                                    <span class="font-bold text-slate-900">Bank Simulasi Desa</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">No. Rekening</span>
                                    <span class="font-bold text-slate-900">1234-5678-{{ str_pad($donasi->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Atas Nama</span>
                                    <span class="font-bold text-slate-900">Bansos Desa (Simulasi)</span>
                                </div>
                            </div>
                        @elseif($donasi->metode_pembayaran === 'qris')
                            <div class="bg-white rounded-xl p-6 border border-slate-200 flex flex-col items-center">
                                <div class="w-40 h-40 bg-slate-100 rounded-lg flex items-center justify-center text-[10px] text-slate-400 font-semibold">
                                    QR CODE SIMULASI
                                </div>
                                <p class="mt-3 text-[11px] text-slate-400">Scan QR ini dengan aplikasi e-wallet/mobile banking (simulasi)</p>
                            </div>
                        @else
                            <div class="bg-white rounded-xl p-4 border border-slate-200 space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Nomor E-Wallet</span>
                                    <span class="font-bold text-slate-900">0812-3456-{{ str_pad($donasi->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        @endif

                        <p class="mt-4 text-[11px] text-slate-400 italic">
                            *Ini adalah simulasi pembayaran untuk keperluan demo sistem, tidak ada transaksi uang nyata.
                        </p>
                    </div>

                    <form action="{{ route('donasi.konfirmasi', $donasi->kode_referensi) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-500/20 transition">
                            Saya Sudah Bayar
                        </button>
                    </form>

                @elseif($donasi->status === 'menunggu_verifikasi')
                    <div class="bg-blue-50 rounded-2xl p-5 text-center">
                        <p class="text-sm text-blue-800 font-semibold">
                            Terima kasih! Pembayaran Anda sedang diverifikasi oleh Admin Provinsi.
                        </p>
                        <p class="text-xs text-blue-600 mt-1">Simpan kode referensi Anda untuk mengecek status.</p>
                    </div>

                @elseif($donasi->status === 'terverifikasi')
                    <div class="bg-emerald-50 rounded-2xl p-5 text-center">
                        <p class="text-sm text-emerald-800 font-semibold">
                            Donasi Anda telah diverifikasi. Terima kasih atas kontribusinya! 🙏
                        </p>
                    </div>

                @else
                    <div class="bg-red-50 rounded-2xl p-5 text-center">
                        <p class="text-sm text-red-800 font-semibold">
                            Maaf, donasi ini ditolak oleh admin. Silakan hubungi kami jika ada pertanyaan.
                        </p>
                    </div>
                @endif

              <div class="mt-6 text-center">
    <a href="/#donasi" class="text-xs text-slate-400 hover:text-slate-600">
        &larr; Kembali ke halaman donasi
    </a>
</div>
            </div>
        </div>
    </section>
</x-app-layout>