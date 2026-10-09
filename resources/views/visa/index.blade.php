@extends('layouts.app')

@section('content')
<section class="py-20 bg-[#F8F9FA]">
    <div class="container mx-auto px-6">
        <div class="max-w-2xl mx-auto text-center mb-20">
            <h2 class="text-[#D6C3A3] font-bold tracking-widest uppercase text-sm mb-3">Our Services</h2>
            <h1 class="text-4xl md:text-5xl font-extrabold text-[#0F3D3E] mb-6">Visa Service Options</h1>
            <div class="w-20 h-1.5 bg-[#D6C3A3] mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-6 text-lg">Professional immigration solutions to ensure your journey in Indonesia is seamless and hassle-free.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {{-- Menggunakan @forelse dengan variabel $categories Utama dari Database --}}
            @forelse($categories as $cat)
                <div class="group bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500 ease-out flex flex-col hover:-translate-y-2">

                    <div class="h-32 bg-linear-to-r from-[#0F3D3E] to-[#1a5f60] flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                        <span class="text-4xl z-10 filter drop-shadow-lg">{{ $cat->icon ?? '✨' }}</span>
                    </div>

                    <div class="p-8 grow">
                        <h3 class="text-2xl font-bold text-[#0F3D3E] mb-4 group-hover:text-[#1a5f60] transition-colors">
                            {{ $cat->name }}
                        </h3>
                        <p class="text-gray-500 mb-8 leading-relaxed line-clamp-3 text-sm">
                            {{ $cat->description ?? 'Complete details regarding ' . $cat->name . ' for your immigration needs.' }}
                        </p>

                        <div class="space-y-3">
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Available Services</p>

                            {{-- PERBAIKAN: Menampilkan list Sub-Kategori (children) dari Kategori Utama --}}
                            @foreach($cat->children as $subCategory)
                                <div class="flex items-center text-gray-700 text-sm">
                                    <div class="w-6 h-6 rounded-full bg-green-50 flex items-center justify-center mr-3 shrink-0">
                                        <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                        </svg>
                                    </div>
                                    <span>{{ $subCategory->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- PERBAIKAN: Generate route tombol secara dinamis berdasarkan slug kategori --}}
                    <div class="px-8 pb-8">
                        <a href="{{ route('visa.type', $cat->slug) }}"
                           class="block w-full text-center bg-[#0F3D3E] text-white font-semibold py-4 rounded-2xl hover:bg-[#D6C3A3] hover:text-[#0F3D3E] transition duration-300 shadow-md">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <p class="text-gray-500 text-xl italic">Currently, there are no visa categories available.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection