<x-guest-layout>
    {{-- HEADER PORTAL LOGIN --}}
    <div class="mb-6 border-b border-slate-100 pb-4">
        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Portal Login Provinsi</h2>
        <p class="text-xs text-slate-400 mt-0.5">Sistem Informasi Jaring Pengaman Sosial Desa</p>
    </div>

    @if (session('status'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold p-3 rounded-xl">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- USERNAME --}}
        <div>
            <label for="username" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                Username
            </label>
            <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="username"
                class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition duration-200"
                placeholder="Masukkan username Anda">
            @error('username')
                <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- PASSWORD --}}
        <div>
            <label for="password" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                Password
            </label>
            <div class="relative flex items-center">
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full pl-4 pr-20 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition duration-200"
                    placeholder="••••••••">
                
                <button type="button" onclick="togglePassword()" 
                    class="absolute right-3 px-2 py-1 bg-slate-200/70 hover:bg-slate-200 text-slate-600 rounded-lg text-[11px] font-bold uppercase tracking-wider transition select-none cursor-pointer">
                    <span id="eye-text">Lihat</span>
                </button>
            </div>
            @error('password')
                <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- REMEMBER ME & LUPA PASSWORD --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me" type="checkbox" name="remember" 
                    class="w-4 h-4 rounded border-slate-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-3 focus:ring-blue-500/20 transition cursor-pointer">
                <span class="ms-2 text-xs font-semibold text-slate-500">Ingat Saya</span>
            </label>
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 bg-slate-50 border border-slate-200/60 px-2.5 py-1 rounded-lg self-start sm:self-auto">
                Lupa password? Hubungi admin
            </span>
        </div>

        {{-- TOMBOL UTAMA (Warna Biru Pas) --}}
        <div class="pt-2">
            <button type="submit" 
                class="w-full flex justify-center items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-5 py-3 rounded-xl shadow-lg shadow-blue-500/20 transition duration-200 cursor-pointer">
                Masuk ke Dashboard
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </div>

        {{-- SEPARATOR PORTAL LAIN --}}
        <div class="border-t border-slate-200 pt-5 mt-5">
            <p class="text-center text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">
                Portal Login Lainnya
            </p>

            {{-- GRID LINKS (Ikon Garis Tanpa Warna-Warni Balok) --}}
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('login') }}"
                    class="flex items-center justify-center gap-2 text-center py-2.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold transition shadow-sm">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0V11m0 10V11m0 0h4"/></svg>
                    Provinsi
                </a>

                <a href="{{ route('login') }}"
                    class="flex items-center justify-center gap-2 text-center py-2.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold transition shadow-sm">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0V11m0 10V11m0 0h4M4 9h4m-4 4h4m12-4h4m-4 4h4"/></svg>
                    Kabupaten / Kota
                </a>

                <a href="{{ route('login') }}"
                    class="flex items-center justify-center gap-2 text-center py-2.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold transition shadow-sm">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0V11m0 10V11m0 0h4"/></svg>
                    Kecamatan
                </a>

                <a href="{{ route('login') }}"
                    class="flex items-center justify-center gap-2 text-center py-2.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold transition shadow-sm">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Kelurahan
                </a>
            </div>

            {{-- TOMBOL LOGIN WARGA --}}
            <div class="mt-4">
                <a href="{{ route('login.warga') }}"
                    class="flex items-center justify-center gap-2 block w-full text-center py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Login Warga
                </a>
            </div>
        </div>
    </form>

    {{-- JS UNTUK TOGGLE PASSWORD --}}
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeText = document.getElementById('eye-text');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeText.textContent = 'Sembunyikan';
            } else {
                passwordInput.type = 'password';
                eyeText.textContent = 'Lihat';
            }
        }
    </script>
</x-guest-layout>