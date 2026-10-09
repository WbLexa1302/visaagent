<nav
    x-data="{
        scrolled: false,
        mobileMenuOpen: false
    }"
    @scroll.window="scrolled = (window.scrollY > 20)"
    :class="scrolled || mobileMenuOpen ? 'bg-[#113e3b] shadow-md py-3' : 'bg-transparent py-6'"
    class="fixed top-0 left-0 w-full z-[100] transition-all duration-500"
>
    <div class="container mx-auto flex justify-between items-center px-6">

        <a href="/" class="relative z-auto">
            <img src="{{ asset('Bali Ease NEW FIX FULL (1).png') }}"
                 alt="Bali Ease Logo"
                 class="h-[35px] md:h-[55px] w-auto transition-all duration-500 block"
                 :class="!scrolled && !mobileMenuOpen ? 'brightness-0 invert' : ''">
        </a>

        <div class="hidden lg:flex items-center gap-6 xl:gap-8">
            <a href="/#layanan-section"
               :class="scrolled ? 'text-white hover:text-[#D6C3A3]' : 'text-white/90 hover:text-white'"
               class="font-semibold transition-colors duration-300 text-xs xl:text-sm tracking-widest uppercase">Services</a>

            <a href="/#faq"
               :class="scrolled ? 'text-white hover:text-[#D6C3A3]' : 'text-white/90 hover:text-white'"
               class="font-semibold transition-colors duration-300 text-xs xl:text-sm tracking-widest uppercase">FAQ</a>

            <a href="{{ route('visa.index') }}"
               :class="scrolled ? 'text-white hover:text-[#D6C3A3]' : 'text-white/90 hover:text-white'"
               class="font-semibold transition-colors duration-300 text-xs xl:text-sm tracking-widest uppercase">Visa Services</a>

            <a href="/tracking"
               :class="scrolled ? 'text-white hover:text-[#D6C3A3]' : 'text-white/90 hover:text-white'"
               class="font-semibold transition-colors duration-300 text-xs xl:text-sm tracking-widest uppercase flex items-center gap-1.5">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Track Application
            </a>

            <a href="/posts"
               :class="scrolled ? 'text-white hover:text-[#D6C3A3]' : 'text-white/90 hover:text-white'"
               class="font-semibold transition-colors duration-300 text-xs xl:text-sm tracking-widest uppercase">Articles</a>

            <a href="https://wa.me/6281547410870"
               :class="scrolled ? 'bg-white text-[#113e3b] hover:bg-gray-100' : 'bg-white text-[#1A3C34] hover:bg-gray-100'"
               class="px-6 xl:px-8 py-3 rounded-full font-bold shadow-lg transition-all duration-500 text-xs tracking-widest hover:scale-105">
                CONSULTATION
            </a>
        </div>

        <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="lg:hidden relative z-[110] p-2 focus:outline-none"
                :class="scrolled || mobileMenuOpen ? 'text-white' : 'text-white'">
            <svg class="w-8 h-8 transition-transform duration-300" :class="mobileMenuOpen ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-full"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-full"
         class="fixed inset-0 bg-[#113e3b] z-[105] flex flex-col items-center justify-center space-y-6 lg:hidden"
         style="display: none;">

        <a href="/#layanan-section" @click="mobileMenuOpen = false" class="text-white text-xl font-bold uppercase tracking-widest hover:opacity-70 transition">Services</a>
        <a href="/#faq" @click="mobileMenuOpen = false" class="text-white text-xl font-bold uppercase tracking-widest hover:opacity-70 transition">FAQ</a>
        <a href="{{ route('visa.index') }}" @click="mobileMenuOpen = false" class="text-white text-xl font-bold uppercase tracking-widest hover:opacity-70 transition">Visa Services</a>

        <a href="/tracking" @click="mobileMenuOpen = false" class="text-white text-xl font-bold uppercase tracking-widest hover:opacity-70 transition flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
            Track Application
        </a>

        <a href="/posts" @click="mobileMenuOpen = false" class="text-white text-xl font-bold uppercase tracking-widest hover:opacity-70 transition">Articles & News</a>

        <a href="https://wa.me/6281547410870" class="bg-white text-[#113e3b] px-10 py-4 rounded-full font-bold shadow-xl tracking-widest text-sm transform active:scale-95 transition-transform">
            CONSULTATION
        </a>
    </div>
</nav>