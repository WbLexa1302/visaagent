@extends('layouts.app')

@section('content')
<div class="bg-brand-lightbg dark:bg-gray-900 text-brand-charcoal dark:text-gray-100 font-sans min-h-screen py-10 antialiased transition-colors duration-300">
    <div class="container mx-auto px-4 max-w-7xl">

        {{-- Breadcrumb Navigation --}}
        <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-8" aria-label="Breadcrumb">
            <a href="/" class="hover:text-brand-darkgreen dark:hover:text-brand-gold font-medium transition-colors duration-200">Home</a>
            <svg class="w-3 h-3 text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            <a href="/posts" class="hover:text-brand-darkgreen dark:hover:text-brand-gold font-medium transition-colors duration-200">Articles</a>
            <svg class="w-3 h-3 text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-brand-darkgreen dark:text-brand-gold font-semibold truncate max-w-[200px] sm:max-w-xs" title="{{ $post->title }}">
                {{ Str::limit($post->title, 30) }}
            </span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            {{-- Kolom Utama (Konten & Komentar) --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Card Artikel Utama --}}
                <article class="bg-white dark:bg-gray-800/90 rounded-2xl p-6 md:p-8 shadow-sm dark:shadow-md border border-gray-100 dark:border-gray-700/80">
                    <h1 class="text-3xl md:text-4xl font-extrabold text-brand-darkgreen dark:text-gray-100 leading-tight mb-4 tracking-tight">
                        {{ $post->title }}
                    </h1>

                    {{-- Metadata Artikel --}}
                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 dark:text-gray-400 pb-6 mb-6 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-1.5">
                            <div class="w-6 h-6 rounded-full bg-brand-darkgreen/10 dark:bg-brand-gold/20 flex items-center justify-center text-xs text-brand-darkgreen dark:text-brand-gold font-bold">B</div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Bali Ease Admin</span>
                        </div>
                        <span class="text-gray-300 dark:text-gray-600">•</span>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>{{ $post->created_at->format('M d, Y') }}</span>
                        </div>
                        <span class="text-gray-300 dark:text-gray-600">•</span>
                        <div class="bg-emerald-50 dark:bg-emerald-950/50 text-emerald-800 dark:text-emerald-300 px-3 py-1 rounded-full text-xs font-semibold tracking-wide border border-transparent dark:border-emerald-800/40">
                            Visa Info
                        </div>
                    </div>

                    {{-- Cover Image --}}
                    @if($post->cover_image)
                        <div class="rounded-xl overflow-hidden mb-8 shadow-sm bg-gray-50 dark:bg-gray-700 group">
                            <img src="{{ asset('storage/' . $post->cover_image) }}"
                                 alt="{{ $post->title }}"
                                 class="w-full h-auto object-cover max-h-[480px] transform hover:scale-[1.01] transition-transform duration-500 ease-out">
                        </div>
                    @endif

                    {{-- Isi Konten --}}
                    <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-200 leading-relaxed space-y-5 prose-headings:text-brand-darkgreen dark:prose-headings:text-gray-100 prose-a:text-brand-gold hover:prose-a:text-brand-darkgreen dark:hover:prose-a:text-brand-gold prose-img:rounded-xl">
                        {!! $post->content !!}
                    </div>
                </article>

                {{-- Seksi Komentar --}}
                <section class="bg-white dark:bg-gray-800/90 rounded-2xl p-6 md:p-8 shadow-sm dark:shadow-md border border-gray-100 dark:border-gray-700/80">
                    <h3 class="text-xl font-bold text-brand-darkgreen dark:text-gray-100 mb-6 flex items-center gap-3">
                        <span>Comments</span>
                        <span class="text-xs bg-brand-gold/20 dark:bg-brand-gold/30 text-brand-darkgreen dark:text-brand-gold px-2.5 py-1 rounded-full font-semibold">0 Comments</span>
                    </h3>

                    <form action="#" method="POST" class="space-y-5 mb-8">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Full Name</label>
                                <input type="text" class="w-full bg-gray-50/50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-brand-darkgreen dark:focus:border-brand-gold focus:bg-white dark:focus:bg-gray-900 focus:ring-4 focus:ring-brand-darkgreen/5 dark:focus:ring-brand-gold/10 transition-all duration-200" placeholder="Enter your name..." required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Email</label>
                                <input type="email" class="w-full bg-gray-50/50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-brand-darkgreen dark:focus:border-brand-gold focus:bg-white dark:focus:bg-gray-900 focus:ring-4 focus:ring-brand-darkgreen/5 dark:focus:ring-brand-gold/10 transition-all duration-200" placeholder="name@email.com" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Your Comment</label>
                            <textarea rows="4" class="w-full bg-gray-50/50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:border-brand-darkgreen dark:focus:border-brand-gold focus:bg-white dark:focus:bg-gray-900 focus:ring-4 focus:ring-brand-darkgreen/5 dark:focus:ring-brand-gold/10 transition-all duration-200 resize-none" placeholder="Write your feedback or questions here..." required></textarea>
                        </div>
                        <button type="submit" class="inline-flex items-center justify-center bg-brand-darkgreen dark:bg-brand-gold text-white dark:text-brand-darkgreen font-semibold px-6 py-3 rounded-xl text-sm hover:bg-opacity-95 dark:hover:bg-white transform active:scale-95 transition-all duration-150 shadow-md shadow-brand-darkgreen/10">
                            Post Comment
                        </button>
                    </form>

                    <div class="text-center py-8 text-gray-400 dark:text-gray-500 text-sm border-t border-dashed border-gray-200 dark:border-gray-700">
                        <svg class="w-8 h-8 mx-auto text-gray-300 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        No comments yet. Be the first to share your thoughts!
                    </div>
                </section>

            </div>

            {{-- Kolom Sidebar Kanan --}}
            <div class="space-y-6 lg:sticky lg:top-6">

                {{-- CTA Visa Solutions Card --}}
                <div class="bg-gradient-to-br from-brand-darkgreen via-[#0e4439] to-[#134e43] text-white rounded-2xl p-6 shadow-xl relative overflow-hidden group border border-transparent dark:border-gray-700">
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-brand-gold opacity-10 rounded-full blur-xl group-hover:scale-125 transition-transform duration-500"></div>

                    <span class="bg-brand-gold/20 text-brand-gold text-xs font-bold px-3 py-1 rounded-md uppercase tracking-wider border border-brand-gold/30">
                        Visa Solutions
                    </span>
                    <h4 class="text-xl font-bold mt-4 mb-2 leading-snug">Need Help With KITAS or Visa Processing?</h4>
                    <p class="text-emerald-100/80 text-xs leading-relaxed mb-6">
                        Don't let bureaucracy hinder your plans to stay in Bali. Our team of specialists is ready to help you process it legally and quickly.
                    </p>

                    <div class="space-y-3 mb-6">
                        <div class="text-xs text-brand-gold font-bold uppercase tracking-wider opacity-90">Services Related to This Article:</div>
                        <div class="flex flex-col gap-2">
                            <a href="/layanan/kitas-investor" class="bg-white/5 hover:bg-white/15 text-white text-xs px-3 py-2.5 rounded-xl border border-white/10 transition-all duration-200 flex items-center gap-2 group/link">
                                <span>🌐</span>
                                <span class="group-hover/link:text-brand-gold transition-colors">Investor KITAS</span>
                            </a>
                            <a href="/layanan/visa-wisata" class="bg-white/5 hover:bg-white/15 text-white text-xs px-3 py-2.5 rounded-xl border border-white/10 transition-all duration-200 flex items-center gap-2 group/link">
                                <span>🏖️</span>
                                <span class="group-hover/link:text-brand-gold transition-colors">Tourist Visa</span>
                            </a>
                        </div>
                    </div>

                    <a href="/konsultasi" class="block text-center bg-brand-gold text-brand-darkgreen font-bold text-sm py-3.5 rounded-xl hover:bg-white hover:text-brand-darkgreen transform active:scale-95 transition-all duration-200 shadow-lg shadow-black/10">
                        Free Consultation Now &rarr;
                    </a>
                </div>

                {{-- Widget Most Popular --}}
                <div class="bg-white dark:bg-gray-800/90 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700/80">
                    <h4 class="text-base font-bold text-brand-darkgreen dark:text-gray-100 pb-2 mb-4 border-b-2 border-brand-gold/60 inline-block">
                        Most Popular
                    </h4>

                    <div class="space-y-4">
                        <a href="#" class="group flex gap-3 items-center p-1.5 -mx-1.5 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200">
                            <div class="w-14 h-14 bg-brand-darkgreen/5 dark:bg-gray-700 rounded-xl flex-shrink-0 flex items-center justify-center text-lg transform group-hover:scale-105 transition-transform text-brand-darkgreen dark:text-brand-gold">
                                📰
                            </div>
                            <div class="space-y-1">
                                <h5 class="text-xs font-bold text-gray-800 dark:text-gray-200 group-hover:text-brand-darkgreen dark:group-hover:text-brand-gold transition-colors line-clamp-2 leading-snug">
                                    Easy Guide to Obtaining an Indonesian Golden Visa in 2026
                                </h5>
                                <span class="text-[10px] text-gray-400 dark:text-gray-500 block">12 hours ago</span>
                            </div>
                        </a>

                        <a href="#" class="group flex gap-3 items-center p-1.5 -mx-1.5 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200">
                            <div class="w-14 h-14 bg-brand-darkgreen/5 dark:bg-gray-700 rounded-xl flex-shrink-0 flex items-center justify-center text-lg transform group-hover:scale-105 transition-transform text-brand-darkgreen dark:text-brand-gold">
                                📰
                            </div>
                            <div class="space-y-1">
                                <h5 class="text-xs font-bold text-gray-800 dark:text-gray-200 group-hover:text-brand-darkgreen dark:group-hover:text-brand-gold transition-colors line-clamp-2 leading-snug">
                                    Latest Requirements for Bali Corporate Work KITAS
                                </h5>
                                <span class="text-[10px] text-gray-400 dark:text-gray-500 block">3 days ago</span>
                            </div>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection