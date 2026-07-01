<nav class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
          {{-- Sisi Kiri: Identitas Aplikasi / Brand Logo Modern --}}
<div class="flex items-center gap-3">
    <div class="w-11 h-11 flex items-center justify-center rounded-xl overflow-hidden">
        <img src="/img/bansos.png" alt="Logo Bansos Desa" class="w-full h-full object-contain">
    </div>
    <div>
        <h1 class="text-base font-bold text-slate-900 tracking-tight leading-tight">
            Sistem <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent font-extrabold">Bansos Desa</span>
        </h1>
        <p class="text-[11px] text-slate-400 font-medium hidden sm:block">Pendataan & Monitoring Transparan</p>
    </div>
</div>

            {{-- Sisi Kanan: Navigasi Menu & Status Login --}}
            <div class="flex items-center gap-8 text-sm font-semibold text-slate-600">
                
                {{-- Menu Beranda --}}
                <a href="/" class="hover:text-blue-600 transition-all duration-200 relative group py-2">
                    Beranda
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>

                {{-- Menu Cek Bantuan (Disesuaikan ke /cek-bansos sesuai web.php kamu) --}}
                <a href="/cek-bansos" class="hover:text-blue-600 transition-all duration-200 relative group py-2">
                    Cek Bantuan
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>

                {{-- Pembatas Garis Tipis --}}
                <div class="h-5 w-px bg-slate-200 hidden sm:block"></div>

                {{-- KONDISI 1: JIKA PETUGAS BELUM LOGIN (GUEST) --}}
                @guest
                    <a href="/login" class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-xl shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 active:scale-[0.98] transition-all duration-200">
                        Login Petugas
                    </a>
                @endguest

                {{-- KONDISI 2: JIKA PETUGAS SUDAH LOGIN (AUTH) --}}
                @auth
                    <div class="flex items-center gap-5">
                        <a href="/dashboard" class="text-blue-600 hover:text-indigo-600 flex items-center gap-1 transition-colors">
                            Dashboard 
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        
                        {{-- Profil Singkat & Tombol Keluar --}}
                        <div class="flex items-center gap-3 pl-5 border-l border-slate-200">
                            <div class="text-right hidden md:block">
                                <p class="text-xs font-bold text-slate-800 leading-none">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-slate-400 font-medium mt-1">Petugas Desa</p>
                            </div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 border border-red-100 text-xs text-red-600 bg-red-50/50 hover:bg-red-50 rounded-xl font-medium transition-all duration-200 active:scale-95">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

            </div>
        </div>
    </div>
</nav>