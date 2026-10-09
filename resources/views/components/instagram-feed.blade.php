@props(['posts', 'profile'])

<section class="py-10 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-[#1A3C34]">Follow our updates on Instagram</h2>
            <p class="text-gray-500 mt-2">Stay connected with our latest visa news and insights.</p>
        </div>

        <div class="border border-gray-100 rounded-3xl p-5 md:p-6 bg-gray-50/50 shadow-sm">
            <div class="flex flex-col lg:grid lg:grid-cols-[320px_1fr] gap-14 items-start">

                {{-- PROFILE --}}
                <div class="w-full">
                    <span class="text-xs font-bold tracking-widest text-gray-400 uppercase block mb-4">
                        Our Instagram
                    </span>

                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-24 h-24 rounded-full overflow-hidden border border-gray-200 flex-shrink-0">
                            <img
                                src="{{ $profile['profilePictureUrl'] ?? 'https://via.placeholder.com/150' }}"
                                alt="Instagram Profile {{ $profile['username'] ?? 'balieasevisa' }} - Bali Ease"
                                class="w-full h-full object-cover">
                        </div>

                        <div>
                            <h3 class="text-2xl font-black text-gray-900 leading-tight">
                                <span>@</span>{{ $profile['username'] ?? 'balieasevisa' }}
                            </h3>

                            <a
                                href="https://instagram.com/{{ $profile['username'] ?? 'balieasevisa' }}"
                                target="_blank"
                                class="inline-flex mt-3 bg-[#1A3C34] hover:bg-[#132d27] text-white text-sm font-bold px-5 py-2 rounded-full transition-all duration-300">
                                Follow
                            </a>
                        </div>
                    </div>

                    {{-- STATS --}}
                    <div class="flex gap-8 py-4 border-y border-gray-200">
                        <div>
                            <div class="font-black text-2xl text-gray-900">
                                {{ count($posts) }}
                            </div>
                            <div class="text-sm text-gray-400">
                                Posts
                            </div>
                        </div>

                        <div>
                            <div class="font-black text-2xl text-gray-900">
                                {{ number_format($profile['followersCount'] ?? 0) }}
                            </div>
                            <div class="text-sm text-gray-400">
                                Followers
                            </div>
                        </div>

                        <div>
                            <div class="font-black text-2xl text-gray-900">
                                {{ number_format($profile['followsCount'] ?? 0) }}
                            </div>
                            <div class="text-sm text-gray-400">
                                Following
                            </div>
                        </div>
                    </div>

                    {{-- BIO --}}
                    <div class="mt-5">
                        <p class="text-sm text-gray-600 leading-7 whitespace-pre-line">
                            {{ $profile['biography'] ?? 'Follow us to get the newest update about Visa & KITAS.' }}
                        </p>
                    </div>
                </div>

                {{-- POSTS --}}
                <div class="w-full">
                    @if(count($posts) > 0)
                        <div class="flex overflow-x-auto pb-4 gap-5 snap-x snap-mandatory md:grid md:grid-cols-2 lg:grid-cols-3 md:overflow-x-visible md:pb-0">
                            
                            @foreach(collect($posts)->slice(0, 6) as $post)
                                <div class="w-[260px] md:w-full flex-shrink-0 snap-start bg-white rounded-2xl border border-gray-100 overflow-hidden group hover:shadow-lg transition-all duration-300 flex flex-col">
                                    
                                    <a
                                        href="{{ $post['permalink'] }}"
                                        target="_blank"
                                        class="block relative aspect-square overflow-hidden bg-gray-50">

                                        <img
                                            src="{{ $post['mediaUrl'] }}"
                                            alt="{{ isset($post['caption']) ? Str::limit($post['caption'], 60) : 'Instagram Post - Bali Ease Visa & KITAS Specialist' }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                                        <div class="absolute inset-0 bg-[#1A3C34]/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-3">
                                            <span class="text-white text-xs font-medium uppercase tracking-wider">
                                                View on IG ↗
                                            </span>
                                        </div>
                                    </a>

                                    <div class="p-3 flex-1 flex flex-col justify-between">
                                        <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed min-h-[38px]">
                                            {{ $post['caption'] ?? 'Bali Ease Update' }}
                                        </p>

                                        <div class="text-[11px] text-gray-400 mt-3">
                                            {{ isset($post['timestamp']) ? date('d M Y', strtotime($post['timestamp'])) : '' }}
                                        </div>
                                    </div>

                                </div>
                            @endforeach

                        </div>
                    @else
                        <div class="text-center py-12 border border-dashed border-gray-200 rounded-xl text-gray-400 text-sm">
                            No posts found at the moment.
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</section>