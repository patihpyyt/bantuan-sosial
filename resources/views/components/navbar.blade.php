<nav class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50 transition-all duration-300">
   <div class="max-w-7xl mx-auto pl-0 pr-4 sm:pr-6 lg:pr-8">
    <div class="flex justify-between h-20 items-center">
        
      {{-- Sisi Kiri: Identitas Aplikasi / Brand Logo Modern --}}
      <div class="flex items-center gap-3 pl-0 ml-0">
         <div class="rounded-2xl w-20 h-20 flex items-center justify-center rounded-xl overflow-hidden">
        <img src="/img/bansos.png" alt="Logo Bansos Desa" class="w-full h-full object-contain">
    </div>
          <div>
              <h1 class="text-base font-bold text-slate-900 tracking-tight leading-tight">
                  Sistem <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent font-extrabold">Bansos Desa</span>
              </h1>
              <p class="text-[11px] text-slate-400 font-medium hidden sm:block">Pendataan & Monitoring Transparan</p>
          </div>
      </div>

            {{-- Menu Desktop (disembunyikan di HP) --}}
            <div class="hidden lg:flex items-center gap-8 text-sm font-semibold text-slate-600">
                
                <a href="/" class="hover:text-blue-600 transition-all duration-200 relative group py-2">
                    Cek Bantuan
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="/#donasi" class="hover:text-blue-600 transition-all duration-200 relative group py-2">
                    Donasi
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#komitmen" class="hover:text-blue-600 transition-all duration-200 relative group py-2">
                     Transparansi Desa
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#statistik" class="hover:text-blue-600 transition-all duration-200 relative group py-2">
                    Statistik Bantuan
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#jenis" class="hover:text-blue-600 transition-all duration-200 relative group py-2">
                    Jenis Program
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#alur" class="hover:text-blue-600 transition-all duration-200 relative group py-2">
                    Alur Pengajuan
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#faq" class="hover:text-blue-600 transition-all duration-200 relative group py-2">
                   Pertanyaan
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#lapor" class="hover:text-blue-600 transition-all duration-200 relative group py-2">
                   Lapor
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>

                <div class="h-5 w-px bg-slate-200 hidden sm:block"></div>

                @guest
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login.warga') }}" class="inline-flex items-center justify-center px-4 py-2.5 text-slate-600 hover:text-blue-600 font-medium rounded-xl transition-all duration-200">
                            Login Warga
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2.5 border border-slate-200 text-slate-600 hover:border-blue-300 hover:text-blue-600 font-medium rounded-xl transition-all duration-200">
                            Daftar
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-xl shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 active:scale-[0.98] transition-all duration-200">
                            Login Petugas
                        </a>
                    </div>
                @endguest

                @auth
                    <div class="flex items-center gap-5">
                        <a href="/dashboard" class="text-blue-600 hover:text-indigo-600 flex items-center gap-1 transition-colors">
                            Dashboard 
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        
                        <div class="flex items-center gap-3 pl-5 border-l border-slate-200">
                            <div class="text-right hidden md:block">
                                <p class="text-xs font-bold text-slate-800 leading-none">{{ Auth::user()->nama_lengkap }}</p>
                                <p class="text-[10px] text-slate-400 font-medium mt-1">
                                    {{ Auth::user()->role === 'warga' ? 'Warga' : 'Petugas Desa' }}
                                </p>
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

            {{-- Tombol Hamburger (hanya tampil di HP/tablet) --}}
            <button
                id="navbar-toggle"
                type="button"
                class="lg:hidden inline-flex items-center justify-center p-2 rounded-lg text-slate-600 hover:text-blue-600 hover:bg-slate-100 transition-colors"
                aria-controls="mobile-menu"
                aria-expanded="false"
                aria-label="Buka menu"
            >
                <svg id="icon-open" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg id="icon-close" class="w-7 h-7 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

        </div>
    </div>

    {{-- Panel Menu Mobile (dropdown) --}}
    <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-100 bg-white/95 backdrop-blur-md">
        <div class="px-4 py-4 flex flex-col gap-1 text-sm font-semibold text-slate-600">

            <a href="/" class="px-3 py-2.5 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors">Cek Bantuan</a>
            <a href="/#donasi" class="px-3 py-2.5 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors">Donasi</a>
            <a href="#komitmen" class="px-3 py-2.5 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors">Transparansi Desa</a>
            <a href="#statistik" class="px-3 py-2.5 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors">Statistik Bantuan</a>
            <a href="#jenis" class="px-3 py-2.5 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors">Jenis Program</a>
            <a href="#alur" class="px-3 py-2.5 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors">Alur Pengajuan</a>
            <a href="#faq" class="px-3 py-2.5 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors">Pertanyaan</a>
            <a href="#lapor" class="px-3 py-2.5 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors">Lapor</a>

            <div class="h-px bg-slate-200 my-2"></div>

            @guest
                <a href="{{ route('login.warga') }}" class="px-3 py-2.5 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors">
                    Login Warga
                </a>
                <a href="{{ route('register') }}" class="px-3 py-2.5 rounded-lg border border-slate-200 text-center hover:border-blue-300 hover:text-blue-600 transition-colors">
                    Daftar
                </a>
                <a href="{{ route('login') }}" class="px-3 py-2.5 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-center font-medium shadow-md shadow-blue-500/10 active:scale-[0.98] transition-all">
                    Login Petugas
                </a>
            @endguest

            @auth
                <a href="/dashboard" class="px-3 py-2.5 rounded-lg text-blue-600 hover:bg-blue-50 flex items-center gap-1 transition-colors">
                    Dashboard
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>

                <div class="flex items-center justify-between px-3 py-2.5 mt-1 border-t border-slate-100 pt-3">
                    <div>
                        <p class="text-xs font-bold text-slate-800 leading-none">{{ Auth::user()->nama_lengkap }}</p>
                        <p class="text-[10px] text-slate-400 font-medium mt-1">
                            {{ Auth::user()->role === 'warga' ? 'Warga' : 'Petugas Desa' }}
                        </p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 border border-red-100 text-xs text-red-600 bg-red-50/50 hover:bg-red-50 rounded-xl font-medium transition-all duration-200 active:scale-95">
                            Keluar
                        </button>
                    </form>
                </div>
            @endauth

        </div>
    </div>
</nav>

<script>
    const navToggle = document.getElementById('navbar-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const iconOpen = document.getElementById('icon-open');
    const iconClose = document.getElementById('icon-close');

    navToggle.addEventListener('click', () => {
        const isHidden = mobileMenu.classList.contains('hidden');

        mobileMenu.classList.toggle('hidden');
        iconOpen.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');
        navToggle.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
    });

    // Tutup menu otomatis saat salah satu link diklik
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            iconOpen.classList.remove('hidden');
            iconClose.classList.add('hidden');
            navToggle.setAttribute('aria-expanded', 'false');
        });
    });
</script>