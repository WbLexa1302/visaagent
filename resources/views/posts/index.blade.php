@extends('layouts.app')

@section('content')
<script>
    if (typeof tailwind !== 'undefined') {
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            darkgreen: '#0b3930', 
                            gold: '#cbb089',      
                            lightbg: '#f8f9fa',   
                            charcoal: '#1f2937'   
                        }
                    }
                }
            }
        }
    }
</script>

<div class="bg-brand-lightbg text-brand-charcoal font-sans min-h-screen py-12 antialiased">
    <div class="container mx-auto px-4 max-w-7xl mt-16">

        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-brand-gold text-xs font-bold uppercase tracking-widest bg-brand-darkgreen/5 px-3 py-1.5 rounded-full">
                Bali Ease Blog
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-brand-darkgreen tracking-tight mt-3 mb-4">
                Latest Articles & News
            </h1>
            <p class="text-gray-500 text-sm md:text-base leading-relaxed">
                Discover the latest information regarding visa regulations, tips for living in Bali, KITAS guides, and news about Indonesian immigration.
            </p>
        </div>

        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <article class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 flex flex-col hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 group">

                        <div class="aspect-video w-full bg-gray-100 overflow-hidden relative">
                            @if($post->cover_image)
                                <img src="{{ asset('storage/' . $post->cover_image) }}"
                                     alt="{{ $post->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-brand-darkgreen/5 text-brand-darkgreen text-3xl">
                                    📰
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-brand-darkgreen text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md shadow-sm">
                                    Visa Info
                                </span>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <div class="text-xs text-gray-400 mb-2 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $post->created_at->format('M d, Y') }}
                            </div>

                            <h2 class="text-lg font-bold text-brand-darkgreen line-clamp-2 group-hover:text-brand-gold transition-colors duration-200 mb-3 leading-snug">
                                <a href="/posts/{{ $post->slug }}">
                                    {{ $post->title }}
                                </a>
                            </h2>

                            <p class="text-gray-500 text-xs leading-relaxed line-clamp-3 mb-5">
                                {{ strip_tags($post->content) }}
                            </p>

                            <div class="mt-auto pt-4 border-t border-gray-50">
                                <a href="/posts/{{ $post->slug }}" class="inline-flex items-center text-xs font-bold text-brand-darkgreen group-hover:text-brand-gold transition-colors gap-1">
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

            <div class="mt-12 custom-pagination">
                {{ $posts->links() }}
            </div>

        @else
            <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 max-w-md mx-auto shadow-sm">
                <span class="text-5xl block mb-4">📭</span>
                <h3 class="text-lg font-bold text-brand-darkgreen mb-1">No Articles Found</h3>
                <p class="text-gray-400 text-xs px-6">We are preparing interesting content for you. Please check back later!</p>
            </div>
        @endif

    </div>
</div>
@endsection