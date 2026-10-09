@extends('layouts.app')

@section('content')
{{-- Kontainer utama dengan padding top agar tidak tertutup navbar fixed --}}
<div class="pt-32 pb-20 min-h-screen bg-[#F8F9FA] antialiased font-sans">
    <div class="container mx-auto px-6">

        <!-- Hero Section: Menampilkan Judul & Harga -->
        <div class="bg-[#0F3D3E] rounded-3xl p-10 md:p-16 text-white mb-12 relative overflow-hidden shadow-2xl">
            {{-- Pola background halus --}}
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>

            <div class="relative z-10">
                <span class="px-4 py-1.5 bg-[#D6C3A3] text-[#0F3D3E] text-xs font-bold uppercase rounded-full tracking-widest mb-6 inline-block">
                    {{ str_replace('_', ' ', $product->visa_type) }}
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4">{{ $product->name }}</h1>
                <p class="text-2xl text-[#D6C3A3] font-bold">
                    Mulai dari <span class="text-white">IDR {{ number_format($product->price, 0, ',', '.') }}</span>
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Kolom Kiri: Konten Utama -->
            <div class="lg:col-span-2 space-y-12">

                {{-- 1. Detail Visa --}}
                @if($product->description)
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold text-[#0F3D3E] mb-6 border-b pb-4">Detail Visa</h2>
                    <div class="prose prose-slate max-w-none text-gray-600 leading-relaxed">
                        {!! $product->description !!}
                    </div>
                </div>
                @endif

                {{-- 2. Pilihan Layanan (Repeater) --}}
                @if($product->services && count($product->services) > 0)
                <div class="space-y-6">
                    <h2 class="text-2xl font-bold text-[#0F3D3E] px-2">Pilihan Layanan</h2>
                    <div class="grid gap-4">
                        @foreach($product->services as $service)
                        <div class="bg-white p-6 rounded-2xl border-l-8 border-[#D6C3A3] shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center hover:shadow-md transition-shadow">
                            <div class="mb-4 md:mb-0">
                                <h4 class="font-bold text-xl text-[#0F3D3E]">{{ $service['service_name'] }}</h4>
                                <p class="text-sm text-gray-500">Estimasi: {{ $service['process_time'] }}</p>
                            </div>
                            <div class="text-left md:text-right">
                                <span class="block text-xs uppercase tracking-widest text-gray-400">Harga</span>
                                <span class="font-bold text-[#0F3D3E] text-lg">IDR {{ number_format($service['service_price'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- 3. Persyaratan Dokumen --}}
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold text-[#0F3D3E] mb-6 border-b pb-4 flex items-center">
                        <span class="mr-3">📋</span> Persyaratan Dokumen
                    </h2>
                    <div class="prose max-w-none text-gray-600 leading-relaxed whitespace-pre-line">
                        {{ $product->requirements }}
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Sidebar Informasi Cepat -->
            <div class="lg:col-span-1">
                <div class="sticky top-32 space-y-6">
                    <div class="bg-[#0F3D3E] text-white rounded-3xl p-8 shadow-xl">
                        <h3 class="text-xl font-bold mb-8 flex items-center">
                            <span class="w-8 h-1 bg-[#D6C3A3] mr-3 rounded-full"></span>
                            Informasi Cepat
                        </h3>

                        <div class="space-y-6">
                            <div class="flex justify-between items-center border-b border-white/10 pb-4">
                                <span class="text-gray-400">Durasi</span>
                                <span class="font-bold">{{ $product->duration ?? '60' }} Hari</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-white/10 pb-4">
                                <span class="text-gray-400">Proses</span>
                                <span class="font-bold text-right">{{ $product->processing_time ?? '14 Hari Kerja' }}</span>
                            </div>
                        </div>

                        <a href="https://wa.me/628123456789" class="block w-full text-center bg-[#D6C3A3] text-[#0F3D3E] font-bold py-4 rounded-2xl mt-10 hover:bg-white transition-all duration-300 shadow-lg">
                            KONSULTASI GRATIS →
                        </a>
                    </div>

                    {{-- Gambar Produk jika ada --}}
                    @if($product->image)
                    <div class="bg-white p-2 rounded-3xl shadow-md">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-2xl object-cover">
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
