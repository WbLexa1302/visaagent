@props(['visa', 'slug'])

<div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-300">
    <h3 class="text-xl font-bold text-[#0F3D3E] mb-2">{{ $visa['title'] }}</h3>
    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $visa['description'] }}</p>

    <a href="{{ route('visa.show', $slug) }}"
       class="inline-block bg-[#0F3D3E] text-white px-5 py-2 rounded-lg font-semibold hover:bg-[#1A5F60] transition">
        Lihat Detail →
    </a>
</div>
