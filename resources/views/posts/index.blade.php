@extends('layouts.app')

@section('content')
<div class="bg-brand-lightbg dark:bg-gray-900 text-brand-charcoal dark:text-gray-100 font-sans min-h-screen py-12 antialiased transition-colors duration-300">
    <div class="container mx-auto px-4 max-w-7xl mt-16">

        {{-- Header Section --}}
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-brand-gold text-xs font-bold uppercase tracking-widest bg-brand-darkgreen/5 dark:bg-brand-gold/10 px-3 py-1.5 rounded-full border border-transparent dark:border-brand-gold/20">
                Bali Ease Blog
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-brand-darkgreen dark:text-gray-100 tracking-tight mt-3 mb-4">
                Latest Articles & News
            </h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm md:text-base leading-relaxed">
                Discover the latest information regarding visa regulations, tips for living in Bali, KITAS guides, and news about Indonesian immigration.
            </p>
        </div>

        {{-- Grid Artikel --}}
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <article class="bg-white dark:bg-gray-800/90 rounded-2xl overflow-hidden shadow-sm dark:shadow-md border border-gray-100 dark:border-gray-700/80 flex flex-col hover:shadow-md dark:hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group">

                        {{-- Image / Cover Container --}}
                        <div class="aspect-video w-full bg-gray-100 dark:bg-gray-700 overflow-hidden relative">
                            @if($post->cover_image)
                                <img src="{{ asset('storage/' . $post->cover_image) }}"
                                     alt="{{ $post->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-brand-darkgreen/5 dark:bg-gray-700 text-brand-darkgreen dark:text-brand-gold text-3xl">
                                    📰
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-brand-darkgreen dark:bg-brand-gold dark:text-brand-darkgreen text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md shadow-sm">
                                    Visa Info
                                </span>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="p-6 flex flex-col flex-grow">
                            {{-- Tanggal Artikel --}}
                            <div class="text-xs text-gray-400 dark:text-gray-400 mb-2 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $post->created_at->format('M d, Y') }}
                            </div>

                            {{-- Judul Artikel --}}
                            <h2 class="text-lg font-bold text-brand-darkgreen dark:text-gray-100 line-clamp-2 group-hover:text-brand-gold dark:group-hover:text-brand-gold transition-colors duration-200 mb-3 leading-snug">
                                <a href="/posts/{{ $post->slug }}">
                                    {{ $post->title }}
                                </a>
                            </h2>

                            {{-- Ringkasan Konten --}}
                            <p class="text-gray-500 dark:text-gray-300 text-xs leading-relaxed line-clamp-3 mb-5">
                                {{ strip_tags($post->content) }}
                            </p>

                            {{-- Read More Footer --}}
                            <div class="mt-auto pt-4 border-t border-gray-50 dark:border-gray-700/60">
                                <a href="/posts/{{ $post->slug }}" class="inline-flex items-center text-xs font-bold text-brand-darkgreen dark:text-brand-gold group-hover:text-brand-gold transition-colors gap-1">
                                    Read More
                                    <svg class="w-3 h-3 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </article>
                @endforeach
            </div>

            {{-- Custom Pagination --}}
            <div class="mt-12 custom-pagination">
                {{ $posts->links() }}
            </div>

        @else
            {{-- State Kosong / No Articles --}}
            <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 max-w-md mx-auto shadow-sm">
                <span class="text-5xl block mb-4">📭</span>
                <h3 class="text-lg font-bold text-brand-darkgreen dark:text-gray-100 mb-1">No Articles Found</h3>
                <p class="text-gray-400 dark:text-gray-400 text-xs px-6">We are preparing interesting content for you. Please check back later!</p>
            </div>
        @endif

    </div>
</div>
@endsection