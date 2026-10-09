@extends('layouts.app')

@section('content')
<section class="py-20 bg-[#F8F9FA]">
    <div class="container mx-auto px-6">
        <div class="max-w-2xl mx-auto text-center mb-20">
            <h2 class="text-[#D6C3A3] font-bold tracking-widest uppercase text-sm mb-3">Visa Category</h2>
            <h1 class="text-4xl md:text-5xl font-extrabold text-[#0F3D3E] mb-6">{{ $typeName }}</h1>
            <div class="w-20 h-1.5 bg-[#D6C3A3] mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-6 text-lg">Please select the document category that best matches your purpose of visit.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {{-- Loop data $categories yang dikirim dari VisaController@indexByType --}}
            @foreach($categories as $category)
                <div class="group bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col justify-between hover:shadow-2xl transition-all duration-500 ease-out hover:-translate-y-2">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center mb-6 text-[#0F3D3E] font-bold text-xl group-hover:bg-[#0F3D3E] group-hover:text-white transition-colors duration-300">
                            📁
                        </div>
                        <h3 class="text-2xl font-bold text-[#0F3D3E] mb-4 group-hover:text-[#1a5f60] transition-colors">
                            {{ $category->name }}
                        </h3>
                        <p class="text-gray-500 mb-6 text-sm leading-relaxed">
                            {{ $category->description ?? 'View all immigration service products available for the ' . $category->name . ' category.' }}
                        </p>
                    </div>

                    {{-- TOMBOL KE HALAMAN LIST PRODUK AKHIR (2 Parameter) --}}
                    {{-- Menggunakan $type (misal: 'single-entry') dan $category->slug (misal: 'tourist-visa') --}}
                    <div class="mt-4">
                        <a href="{{ route('visa.subCategoryList', ['type' => $type, 'category' => $category->slug]) }}"
                           class="block w-full text-center bg-[#0F3D3E] text-white font-semibold py-4 rounded-2xl hover:bg-[#D6C3A3] hover:text-[#0F3D3E] transition duration-300 shadow-md">
                            View Visa Types
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection