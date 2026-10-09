@extends('layouts.app')

@section('content')
<section class="py-20 bg-[#F8F9FA]">
    <div class="container mx-auto px-6">
        <div class="max-w-2xl mx-auto text-center mb-16">
            <h2 class="text-[#D6C3A3] font-bold tracking-widest uppercase text-sm mb-3">Visa Category</h2>
            <h1 class="text-4xl md:text-5xl font-extrabold text-[#0F3D3E] mb-6">{{ $typeName }}</h1>
            <div class="w-20 h-1.5 bg-[#D6C3A3] mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-6 text-lg">Choose the {{ $typeName }} service package that best suits your travel plans or residency requirements.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($products as $product)
                <div class="group bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500 flex flex-col hover:-translate-y-2">

                    <div class="relative h-48 bg-[#0F3D3E] overflow-hidden">
                        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover mix-blend-overlay group-hover:scale-110 transition-transform duration-700">
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-[#D6C3A3] text-[#0F3D3E] text-xs font-bold uppercase rounded-full tracking-tighter">
                                {{ $product->code ?? str_replace('_', ' ', $product->visa_type) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-8 grow">
                        <h3 class="text-xl font-bold text-[#0F3D3E] mb-2 group-hover:text-[#1a5f60] transition-colors">
                            {{ $product->name }}
                        </h3>
                        <p class="text-2xl font-black text-[#0F3D3E] mb-6">
                            <span class="text-sm font-medium text-gray-400 block mb-1">Starting from</span>
                            IDR {{ number_format($product->price, 0, ',', '.') }}
                        </p>

                        <div class="flex items-center text-sm text-gray-500 gap-4 mb-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-[#D6C3A3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $product->duration ?? '-' }} Days
                            </div>
                        </div>
                    </div>

                    <div class="px-8 pb-8">
                        <a href="{{ route('visa.detail', [$type, $category->slug, $product->slug]) }}"
                           class="block w-full text-center bg-[#0F3D3E] text-white font-semibold py-4 rounded-2xl hover:bg-[#D6C3A3] hover:text-[#0F3D3E] transition duration-300 shadow-md">
                            View Details & Pricing
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <p class="text-gray-400 text-xl italic">No visa packages available for this category yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection