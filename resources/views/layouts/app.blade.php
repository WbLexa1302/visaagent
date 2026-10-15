<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bali Ease | Agen Visa & KITAS Specialist Terpercaya di Bali')</title>

    <link rel="llms" href="{{ url('/llms.txt') }}">

    <link rel="canonical" href="@yield('canonical', request()->url())">
    <meta name="description" content="Bali Ease adalah mitra terpercaya pengurusan Visa, KITAS, dan PMA di Bali. Proses cepat, transparan, dan aman bersama konsultan ahli kami.">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    {{-- BREADCRUMBS: Muncul di SEMUA halaman internal --}}
    @if(!request()->is('/'))
        {!! \App\Services\SeoSchemaService::generateBreadcrumbs() !!}
    @endif

    {{-- WADAH SKEMA: Di sini kode dari @section('schema') di welcome.blade.php akan muncul --}}
    @yield('schema')

    {{-- SCRIPT ANTI-FLICKER & DETEKSI TEMA AWAL --}}
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 overflow-x-hidden transition-colors duration-300">
    <x-navbar />

    <main class="min-h-screen">
        @yield('content')
    </main>

    <x-footer />
    <x-floating-buttons />

    {{-- Tombol Switcher Dark Mode --}}
    <button id="theme-toggle" type="button" aria-label="Toggle Theme"
        class="fixed bottom-6 left-6 z-50 p-3 rounded-full bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 shadow-xl border border-gray-200 dark:border-gray-700 hover:scale-110 active:scale-95 transition-all duration-200">
        
        <!-- Ikon Matahari (Tampil saat Mode Gelap aktif) -->
        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
        </svg>

        <!-- Ikon Bulan (Tampil saat Mode Terang aktif) -->
        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
        </svg>
    </button>

    <script>
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
        const themeToggleBtn = document.getElementById('theme-toggle');

        // Tampilkan ikon yang sesuai berdasarkan status class 'dark'
        if (document.documentElement.classList.contains('dark')) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        // Fungsi perpindahan mode saat tombol diklik
        themeToggleBtn.addEventListener('click', function() {
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        });
    </script>
</body>
</html>