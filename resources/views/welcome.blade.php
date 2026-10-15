@extends('layouts.app')

@section('title', 'Bali Ease | Agen Visa & KITAS Specialist Terpercaya di Bali')

@section('schema')
    {{-- Memanggil Local Business Schema yang detail --}}
    {!! \App\Services\SeoSchemaService::generateLocalBusiness() !!}
    
    {{-- Memanggil FAQ Schema jika ada data faq --}}
    @if(isset($faqs))
        {!! \App\Services\SeoSchemaService::generateFaq($faqs) !!}
    @endif
@endsection

@section('content')
    {{-- Animasi & Hero Section --}}
    <div data-aos="fade-zoom-in" data-aos-duration="1500">
        <x-hero-section />
    </div>

    {{-- Visa Selector Section --}}
    <div data-aos="fade-up" data-aos-delay="200">
        <x-visa-selector :countries="$countries" :products="$products" />
    </div>

    {{-- Garis Pembatas (Divider Line) --}}
    <div class="max-w-4xl mx-auto px-6 mt-25 mb-auto">
        <div class="h-[5px] w-full bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-700 to-transparent transition-colors duration-300"></div>
    </div>

    {{-- Services Showcase Section --}}
    <div id="layanan-section" data-aos="fade-up">
        <x-services-showcase />
    </div>

    {{-- How It Works Section --}}
    <div data-aos="fade-up">
        <x-how-it-works />
    </div>

    {{-- Instagram Feed Section --}}
    <div data-aos="fade-up">
        <x-instagram-feed :posts="$posts" :profile="$igProfile" />
    </div>

    {{-- Testimonial Slider Section --}}
    <div data-aos="fade-up">
        <x-testimonial-slider />
    </div>

    {{-- FAQ Section --}}
    <div id="faq" data-aos="fade-up">
        <x-frequentlyask :faqs="$faqs" />
    </div>

    {{-- Maps Embed Section --}}
    <div data-aos="fade-up">
        <x-mapsembed />
    </div>

    {{-- Floating Action Menu (Contact Widget) --}}
    <div x-data="{ open: false }"
         class="fixed bottom-8 right-8 z-[100] flex flex-col items-center gap-4"
         @click.away="open = false">

        {{-- Pop-up Pilihan Kontak --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="flex flex-col gap-3 mb-2">

            <!-- WhatsApp Button -->
            <a href="https://wa.me/6281547410870" target="_blank" 
               class="w-12 h-12 flex items-center justify-center bg-[#25D366] rounded-full shadow-lg hover:scale-110 transition-transform text-white"
               title="Chat WhatsApp">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
            </a>

            <!-- Instagram Button -->
            <a href="https://instagram.com/balieasevisa" target="_blank" 
               class="w-12 h-12 flex items-center justify-center bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600 rounded-full shadow-lg hover:scale-110 transition-transform text-white"
               title="Instagram">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.173.055 1.957.26 2.651.533.719.278 1.25.666 1.79 1.206.54.54.928 1.071 1.206 1.79.273.694.477 1.478.533 2.651.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.055 1.173-.26 1.957-.533 2.651-.278.719-.666 1.25-1.206 1.79-.54.54-1.071.928-1.79 1.206-.694.273-1.478.477-2.651.533-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.173-.055-1.957-.26-2.651-.533-.719-.278-1.25-.666-1.79-1.206-.54-.54-.928-1.071-1.206-1.79-.273-.694-.477-1.478-.533-2.651-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.055-1.173.26-1.957.533-2.651.278-.719.666-1.25 1.206-1.79.54-.54 1.071-.928 1.79-1.206.694-.273 1.478-.477 2.651-.533 1.266-.058 1.646-.07 4.85-.07zm0 2.163c-3.11 0-3.483.013-4.713.069-1.144.053-1.765.238-2.178.4-.547.212-.937.467-1.346.877-.41.41-.665.8-.877 1.346-.162.413-.347 1.034-.4 2.178-.056 1.23-.069 1.603-.069 4.713s.013 3.483.069 4.713c.053 1.144.238 1.765.4 2.178.212.547.467.937.877 1.346.41.41.8.665 1.346.877.413.162 1.034.347 2.178.4 1.23.056 1.603.069 4.713.069s3.483-.013 4.713-.069c1.144-.053 1.765-.238 2.178-.4.547-.212.937-.467 1.346-.877.41-.41.665-.8.877-1.346.162-.413.347-1.034.4-2.178.056-1.23.069-1.603.069-4.713s-.013-3.483-.069-4.713c-.053-1.144-.238-1.765-.4-2.178-.212-.547-.467-.937-.877-1.346-.41-.41-.665-.8-.877-1.346-.413-.162-1.034-.347-2.178-.4-1.23-.056-1.603-.069-4.713-.069zM12 7.387c2.548 0 4.613 2.065 4.613 4.613s-2.065 4.613-4.613 4.613-4.613-2.065-4.613-4.613 2.065-4.613 4.613-4.613zm0 2.163c-1.348 0-2.45 1.102-2.45 2.45s1.102 2.45 2.45 2.45 2.45-1.102 2.45-2.45-1.102-2.45-2.45-2.45zm5.75-5.234c.594 0 1.075.481 1.075 1.075 0 .594-.481 1.075-1.075 1.075-.594 0-1.075-.481-1.075-1.075 0-.594.481-1.075 1.075-1.075z"/></svg>
            </a>

            <!-- Email Button -->
            <a href="mailto:balieasevisa@gmail.com" 
               class="w-12 h-12 flex items-center justify-center bg-gray-800 dark:bg-gray-700 rounded-full shadow-lg hover:scale-110 transition-transform text-white border border-transparent dark:border-gray-600"
               title="Email Us">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
            </a>
        </div>

        {{-- Tombol Utama Floating Widget --}}
        <button @click="open = !open"
                class="w-16 h-16 flex items-center justify-center bg-[#1A3C34] dark:bg-[#0b3930] text-white rounded-full shadow-2xl hover:scale-105 transition-all duration-300 border border-transparent dark:border-brand-gold/30">
            <svg x-show="!open" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <svg x-show="open" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endsection