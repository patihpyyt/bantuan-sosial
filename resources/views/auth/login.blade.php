<x-guest-layout>
    {{-- HEADER PORTAL LOGIN (Logo bawaan sudah bersih total) --}}
    <div class="mb-6 border-b border-slate-100 pb-4">
        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Portal Login Petugas</h2>
        <p class="text-xs text-slate-400 mt-0.5">Sistem Informasi Jaring Pengaman Sosial Desa</p>
    </div>

    @if (session('status'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold p-3 rounded-xl">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

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

        <div class="pt-2">
            <button type="submit" 
                class="w-full flex justify-center items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-5 py-3 rounded-xl shadow-lg shadow-blue-500/20 transition duration-200 cursor-pointer">
                Masuk ke Dashboard
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
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