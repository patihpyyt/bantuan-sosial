<x-app-layout>
    <section class="bg-slate-50 min-h-screen pt-24 pb-20">
        <div class="max-w-lg mx-auto px-4 sm:px-6">

            <div class="bg-white rounded-3xl shadow-[0_4px_30px_rgba(0,0,0,0.06)] p-6 sm:p-8">

                <h1 class="text-lg font-extrabold text-slate-900 mb-1">Cek Status Donasi</h1>
                <p class="text-xs text-slate-400 mb-6">Masukkan kode referensi yang Anda terima saat donasi.</p>

                <form action="{{ route('donasi.cek-status') }}" method="GET" class="flex gap-2 mb-6">
                    <input type="text" name="kode" value="{{ request('kode') }}" required
                        placeholder="Contoh: DON-AB12CD34"
                        class="flex-1 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition uppercase">
                    <button type="submit"
                        class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl transition">
                        Cek
                    </button>
                </form>

                @if(request()->filled('kode'))
                    @if($donasi)
                        <div class="bg-slate-50 rounded-2xl p-5 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-500">Kode Referensi</span>
                                <span class="text-sm font-bold text-slate-900">{{ $donasi->kode_referensi }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-500">Nama Donatur</span>
                                <span class="text-sm font-bold text-slate-900">{{ $donasi->nama_donatur }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-500">Jumlah</span>
                                <span class="text-sm font-bold text-slate-900">Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-500">Status</span>
                                @if($donasi->status === 'menunggu_pembayaran')
                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-[11px] font-bold uppercase">Menunggu Bayar</span>
                                @elseif($donasi->status === 'menunggu_verifikasi')
                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 text-[11px] font-bold uppercase">Diverifikasi</span>
                                @elseif($donasi->status === 'terverifikasi')
                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-bold uppercase">Terverifikasi</span>
                                @else
                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-red-100 text-red-700 text-[11px] font-bold uppercase">Ditolak</span>
                                @endif
                            </div>

                            @if($donasi->status === 'menunggu_pembayaran')
                                <a href="{{ route('donasi.instruksi', $donasi->kode_referensi) }}"
                                    class="block text-center mt-2 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-lg transition">
                                    Lanjutkan Pembayaran
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="bg-red-50 rounded-xl p-4 text-center text-xs font-semibold text-red-700">
                            Kode referensi tidak ditemukan. Periksa kembali kode Anda.
                        </div>
                    @endif
                @endif

            </div>
        </div>
    </section>
</x-app-layout>