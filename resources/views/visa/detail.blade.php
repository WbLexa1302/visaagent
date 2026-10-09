@extends('layouts.app')

@section('content')
<div x-data="{ 
    openModal: false, 
    pdfUrl: '', 
    visaName: '',
    openPdfPreview(link, name) {
        if (!link) return;
        
        let embedLink = link;
        if (link.includes('drive.google.com')) {
            embedLink = link.split('/view')[0];
            embedLink = embedLink.replace('/open?id=', '/file/d/');
            embedLink = embedLink.trim().replace(/\/$/, '') + '/preview';
        }
        
        this.pdfUrl = embedLink;
        this.visaName = name;
        this.openModal = true;
    }
}" class="pt-32 pb-20 min-h-screen bg-[#F8F9FA] antialiased font-sans">
    <div class="container mx-auto px-6">

        <div class="bg-[#0F3D3E] rounded-3xl p-10 md:p-16 text-white mb-12 relative overflow-hidden shadow-2xl">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            <div class="relative z-10">
                <span class="px-4 py-1.5 bg-[#D6C3A3] text-[#0F3D3E] text-xs font-bold uppercase rounded-full tracking-widest mb-6 inline-block">
                    {{ ucwords(str_replace('_', ' ', $product->visa_type ?? 'Single Entry')) }}
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4">{{ $product->name }}</h1>
                <p class="text-2xl text-[#D6C3A3] font-bold">
                    Starting from <span class="text-white">IDR {{ number_format($product->price ?? 0, 0, ',', '.') }}</span>
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2 space-y-12">

                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold text-[#0F3D3E] mb-6 border-b pb-4">Visa Details</h2>
                    <div class="prose prose-slate max-w-none text-gray-600 leading-relaxed">
                        {!! $product->description ?? 'No description available.' !!}
                    </div>
                </div>

                <div class="space-y-6">
                    <h2 class="text-2xl font-bold text-[#0F3D3E] px-2">Service Options</h2>
                    <div class="grid gap-4">
                        @if($product->services && count($product->services) > 0)
                            @foreach($product->services as $layanan)
                                <div class="bg-white p-6 rounded-2xl border-l-8 border-[#D6C3A3] shadow-sm flex flex-col md:grid md:grid-cols-2 items-start md:items-center hover:shadow-md transition-shadow">
                                    <div class="mb-4 md:mb-0">
                                        <h4 class="font-bold text-xl text-[#0F3D3E]">{{ $layanan['service_name'] ?? '-' }}</h4>
                                        <p class="text-sm text-gray-500">Estimate: {{ $layanan['process_time'] ?? '-' }}</p>
                                    </div>
                                    <div class="text-left md:text-right">
                                        <span class="block text-xs uppercase tracking-widest text-gray-400">Price</span>
                                        <span class="font-bold text-[#0F3D3E] text-lg">IDR {{ number_format($layanan['service_price'] ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-400 italic px-2">No service list added yet.</p>
                        @endif
                    </div>
                </div>

                @if($product->extension_price && count($product->extension_price) > 0)
                    <div class="space-y-6 mt-12">
                        <h2 class="text-2xl font-bold text-[#0F3D3E] px-2 flex items-center gap-2">
                            <span>🔄</span> Extension Options
                        </h2>
                        <div class="grid gap-4">
                            @foreach($product->extension_price as $ext)
                                <div class="bg-white p-6 rounded-2xl border-l-8 border-teal-600 shadow-sm flex flex-col md:grid md:grid-cols-2 items-start md:items-center hover:shadow-md transition-shadow">
                                    <div class="mb-4 md:mb-0">
                                        <h4 class="font-bold text-xl text-teal-900">{{ $ext['ext_name'] ?? '-' }}</h4>
                                        <p class="text-sm text-gray-500">Processing Time: {{ $ext['ext_process_time'] ?? '-' }}</p>
                                    </div>
                                    <div class="text-left md:text-right">
                                        <span class="block text-xs uppercase tracking-widest text-gray-400">Extension Fee</span>
                                        <span class="font-bold text-teal-700 text-lg">IDR {{ number_format($ext['ext_price'] ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold text-[#0F3D3E] mb-6 border-b pb-4 flex items-center">
                        <span class="mr-3">📋</span> Document Requirements
                    </h2>
                    <div class="prose max-w-none text-gray-600 leading-relaxed whitespace-pre-line">
                        {!! nl2br(e($product->requirements ?? 'No document requirements.')) !!}
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-32 space-y-6">
                    <div class="bg-[#0F3D3E] text-white rounded-3xl p-8 shadow-xl">
                        <h3 class="text-xl font-bold mb-8 flex items-center">
                            <span class="w-8 h-1 bg-[#D6C3A3] mr-3 rounded-full"></span>
                            Quick Info
                        </h3>
                        <div class="space-y-6">
                            <div class="flex justify-between items-center border-b border-white/10 pb-4">
                                <span class="text-gray-400">Duration</span>
                                <span class="font-bold">{{ $product->duration ?? '-' }} Days</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-white/10 pb-4">
                                <span class="text-gray-400">Process</span>
                                <span class="font-bold text-right">{{ $product->processing_time ?? '-' }}</span>
                            </div>
                            
                            @if($product->extension_price && count($product->extension_price) > 0)
                                <div class="flex justify-between items-center border-b border-white/10 pb-4 bg-white/5 -mx-4 px-4 py-2 rounded-xl border border-dashed border-[#D6C3A3]/20">
                                    <span class="text-[#D6C3A3] font-medium text-sm">Extension Services</span>
                                    <span class="font-bold text-white text-sm">{{ count($product->extension_price) }} Options Available</span>
                                </div>
                            @endif
                        </div>
                        
                        <a href="https://wa.me/6281547410870" target="_blank" class="block w-full text-center bg-[#D6C3A3] text-[#0F3D3E] font-bold py-4 rounded-2xl mt-10 hover:bg-white transition-all duration-300 shadow-lg">
                            FREE CONSULTATION →
                        </a>

                        @if(!empty($product->drive_link))
                            <button type="button" 
                                    @click="openPdfPreview('{{ $product->drive_link }}', '{{ $product->name }}')"
                                    class="block w-full text-center border-2 border-[#D6C3A3] hover:border-white text-[#D6C3A3] hover:text-white font-bold py-3.5 rounded-2xl mt-3 transition-all duration-300 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                More Details
                            </button>
                        @endif
                    </div>

                    @if($product->image)
                        <div class="bg-white p-2 rounded-3xl shadow-md">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-2xl object-cover">
                        </div>
                    @endif

                    <a href="{{ route('visa.index') }}" class="flex items-center justify-center gap-2 w-full bg-white text-gray-500 font-semibold py-4 px-4 rounded-2xl hover:bg-gray-50 border border-gray-200 transition-all text-xs uppercase tracking-wider shadow-sm">
                        ← Back to Visa List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div x-show="openModal" class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display: none;" @click.self="openModal = false">
        <div class="bg-white w-full max-w-4xl h-[85vh] rounded-3xl shadow-2xl flex flex-col overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h4 class="font-bold text-gray-800 text-lg" x-text="visaName"></h4>
                    <p class="text-xs text-gray-400 font-medium">Document Details & Guidelines</p>
                </div>
                <button type="button" @click="openModal = false" class="p-2 rounded-xl bg-gray-200/50 hover:bg-gray-200 text-gray-500 hover:text-gray-800 transition-colors">
                    ✕
                </button>
            </div>
            <div class="flex-1 bg-gray-100">
                <template x-if="openModal">
                    <iframe :src="pdfUrl" class="w-full h-full border-0" allow="autoplay"></iframe>
                </template>
            </div>
        </div>
    </div>
</div>
@endsection