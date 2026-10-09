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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 overflow-x-hidden">
    <x-navbar />

    <main class="min-h-screen">
        @yield('content')
    </main>

    <x-footer />
    <x-floating-buttons />
</body>
</html>