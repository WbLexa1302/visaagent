@props(['countries'])

<section class="py-10 bg-white overflow-hidden">
    <div class="container mx-auto px-6 mb-8 text-center">
        <h3 class="text-lg font-semibold text-primary">Melayani Klien dari Seluruh Dunia</h3>
    </div>

    {{-- MARQUEE TRACK JALUR KIRI --}}
    <div class="marquee-container mb-6">
        <div class="marquee-track flex gap-12 animate-marquee-left">
            @for ($i = 0; $i < 4; $i++)
                @foreach ($countries as $country)
                    @php
                        // Memastikan format kode negara selalu lowercase (dua huruf) sesuai standar flagcdn
                        $flagCode = strtolower(trim($country['code'] ?? $country->code ?? ''));
                        $countryName = $country['name'] ?? $country->name ?? '';
                    @endphp
                    
                    @if($flagCode)
                        <div class="flex items-center gap-4 min-w-max bg-gray-50/50 px-5 py-3 rounded-2xl border border-gray-100">
                            <img src="https://flagcdn.com/w40/{{ $flagCode }}.png" 
                                 srcset="https://flagcdn.com/w80/{{ $flagCode }}.png 2x"
                                 width="40" 
                                 alt="Bendera {{ $countryName }}"
                                 loading="lazy" {{-- Ditambahkan agar meringankan load halaman --}}
                                 class="rounded-md shadow-sm object-cover h-6 w-8">
                            <span class="font-bold text-gray-800">{{ $countryName }}</span>
                        </div>
                    @endif
                @endforeach
            @endfor
        </div>
    </div>

    {{-- MARQUEE TRACK JALUR KANAN --}}
    <div class="marquee-container">
        <div class="marquee-track flex gap-12 animate-marquee-right">
            @for ($i = 0; $i < 4; $i++)
                @foreach ($countries as $country)
                    @php
                        $flagCode = strtolower(trim($country['code'] ?? $country->code ?? ''));
                        $countryName = $country['name'] ?? $country->name ?? '';
                    @endphp
                    
                    @if($flagCode)
                        <div class="flex items-center gap-4 min-w-max bg-gray-50/50 px-5 py-3 rounded-2xl border border-gray-100">
                            <img src="https://flagcdn.com/w40/{{ $flagCode }}.png" 
                                 srcset="https://flagcdn.com/w80/{{ $flagCode }}.png 2x"
                                 width="40" 
                                 alt="Bendera {{ $countryName }}"
                                 loading="lazy"
                                 class="rounded-md shadow-sm object-cover h-6 w-8">
                            <span class="font-bold text-gray-800">{{ $countryName }}</span>
                        </div>
                    @endif
                @endforeach
            @endfor
        </div>
    </div>
</section>

<style>
    .marquee-container {
        display: flex;
        overflow: hidden;
        user-select: none;
        mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
    }

    .animate-marquee-left {
        animation: custom-marquee-left 240s linear infinite !important;
    }

    .animate-marquee-right {
        animation: custom-marquee-right 240s linear infinite !important;
    }

    @keyframes custom-marquee-left {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    @keyframes custom-marquee-right {
        0% { transform: translateX(-50%); }
        100% { transform: translateX(0); }
    }

    .marquee-container:hover .marquee-track {
        animation-play-state: paused !important;
    }
</style>