<x-app-layout>
    <section class="relative overflow-hidden bg-slate-950 pt-24 pb-20">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/40 via-slate-900 to-slate-950"></div>

        <div class="max-w-2xl mx-auto px-4 sm:px-6 relative z-10 text-center">
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-white text-blue-700 tracking-wide uppercase mb-6 shadow-lg">
                <span class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-pulse"></span>
                Partisipasi Masyarakat
            </span>

            <h1 class="mb-4 text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight drop-shadow-lg">
                Bantu Program <span class="text-blue-400">Bansos Desa</span>
            </h1>

            <p class="mb-10 text-sm sm:text-base text-white/80 max-w-xl mx-auto leading-relaxed">
                Donasi Anda akan dikelola secara transparan oleh Admin Provinsi dan disalurkan
                sebagai tambahan bantuan sosial bagi warga yang membutuhkan.
            </p>
        </div>

        <div class="max-w-xl mx-auto px-4 sm:px-6 relative z-10">
            <div class="bg-white rounded-3xl shadow-[0_20px_60px_rgba(0,0,0,.35)] p-6 sm:p-8">

                @if($errors->any())
                    <div class="mb-5 bg-red-50 border border-red-200 rounded-xl p-4 text-xs font-semibold text-red-700">
                        <ul class="space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('donasi.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">
                            Nama Donatur
                        </label>
                        <input type="text" name="nama_donatur" value="{{ old('nama_donatur') }}" required
                            placeholder="Nama Anda"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">
                            Email <span class="normal-case font-medium text-slate-400">(opsional, untuk notifikasi)</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">
                            Jumlah Donasi (Rp)
                        </label>
                        <input type="text" id="jumlah_display" placeholder="Contoh: 100.000" autocomplete="off"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition">
                        <input type="hidden" name="jumlah" id="jumlah" value="{{ old('jumlah') }}">
                        <p class="mt-1.5 text-[11px] text-slate-400">Minimal Rp 10.000</p>

                        <div class="flex gap-2 mt-3 flex-wrap">
                            @foreach([25000, 50000, 100000, 250000] as $nominal)
                                <button type="button"
                                    onclick="setNominal({{ $nominal }})"
                                    class="px-3 py-1.5 text-xs font-bold rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                                    {{ number_format($nominal, 0, ',', '.') }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">
                            Metode Pembayaran
                        </label>
                        <div class="grid grid-cols-3 gap-2">
                            <label class="cursor-pointer">
                                <input type="radio" name="metode_pembayaran" value="transfer_bank" class="peer sr-only" checked>
                                <div class="text-center py-3 rounded-xl border-2 border-slate-200 peer-checked:border-blue-600 peer-checked:bg-blue-50 text-xs font-bold text-slate-600 peer-checked:text-blue-700 transition">
                                    Transfer Bank
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="metode_pembayaran" value="qris" class="peer sr-only">
                                <div class="text-center py-3 rounded-xl border-2 border-slate-200 peer-checked:border-blue-600 peer-checked:bg-blue-50 text-xs font-bold text-slate-600 peer-checked:text-blue-700 transition">
                                    QRIS
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="metode_pembayaran" value="ewallet" class="peer sr-only">
                                <div class="text-center py-3 rounded-xl border-2 border-slate-200 peer-checked:border-blue-600 peer-checked:bg-blue-50 text-xs font-bold text-slate-600 peer-checked:text-blue-700 transition">
                                    E-Wallet
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">
                            Pesan/Doa <span class="normal-case font-medium text-slate-400">(opsional)</span>
                        </label>
                        <textarea name="pesan" rows="2" placeholder="Semoga bermanfaat bagi yang membutuhkan..."
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition">{{ old('pesan') }}</textarea>
                    </div>

                    <button type="submit"
                        class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-500/20 transition">
                        Lanjutkan Donasi
                    </button>

                    <p class="text-center text-[11px] text-slate-400">
                        Sudah donasi sebelumnya?
                        <a href="{{ route('donasi.cek-status') }}" class="text-blue-600 font-bold hover:underline">Cek status di sini</a>
                    </p>
                </form>
            </div>
        </div>
    </section>

    <script>
        function setNominal(nominal) {
            document.getElementById('jumlah').value = nominal;
            document.getElementById('jumlah_display').value = new Intl.NumberFormat('id-ID').format(nominal);
        }

        document.addEventListener('DOMContentLoaded', function () {
            const display = document.getElementById('jumlah_display');
            const hidden  = document.getElementById('jumlah');

            if (hidden.value) {
                display.value = new Intl.NumberFormat('id-ID').format(hidden.value);
            }

            display.addEventListener('input', function () {
                let angka = display.value.replace(/\D/g, '');
                hidden.value = angka;
                display.value = angka ? new Intl.NumberFormat('id-ID').format(angka) : '';
            });
        });
    </script>
</x-app-layout>