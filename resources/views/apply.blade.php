<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Visa Application - Bali Ease</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-teal-50/20 min-h-screen py-12 px-4 antialiased">

    <div class="max-w-4xl mx-auto">

        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Formulir Pengajuan Visa</h1>
            <p class="text-slate-500 mt-2 text-sm">Selesaikan detail data Anda untuk memulai proses verifikasi dokumen resmi</p>
        </div>

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl mb-8 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-bold">Gagal Mengirim Aplikasi:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-rose-700 pl-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl mb-8 flex items-center gap-3 shadow-sm animate-fade-in">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            <form action="{{ route('apply.store') }}" method="POST" class="lg:col-span-2 bg-white p-6 md:p-8 rounded-3xl shadow-xl shadow-slate-100/70 border border-slate-100 space-y-6 order-2 lg:order-1">
                @csrf

                @if(request()->has('country'))
                    <input type="hidden" name="country_code" value="{{ request('country') }}">
                @endif

                <div class="space-y-4">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">1. Konfirmasi Layanan</h3>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tipe Visa Terpilih</label>
                        <div class="relative">
                            <select name="product_id" class="w-full p-3.5 pl-4 pr-10 border border-slate-200 rounded-xl shadow-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 outline-none transition-all bg-slate-50 font-medium text-slate-800 cursor-pointer appearance-none" required>
                                <option value="" disabled>Pilih Tipe Visa</option>
                                @foreach($products ?? $visaTypes as $product)
                                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (IDR {{ number_format($product->price, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kecepatan Pemrosesan Dokumen</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label class="relative border border-slate-200 p-4 rounded-xl cursor-pointer hover:border-teal-300 focus-within:ring-4 focus-within:ring-teal-500/10 transition-all flex items-start gap-3 bg-slate-50/50">
                                <input type="radio" name="process_type" value="regular" class="mt-1 text-teal-600 focus:ring-teal-500 border-slate-300 w-4 h-4" checked>
                                <div>
                                    <span class="block font-bold text-slate-800 text-sm">Regular Process</span>
                                    <span class="text-xs text-slate-500 mt-0.5 block">Estimasi selesai 5-7 Hari Kerja</span>
                                </div>
                            </label>

                            <label class="relative border border-slate-200 p-4 rounded-xl cursor-pointer hover:border-teal-300 focus-within:ring-4 focus-within:ring-teal-500/10 transition-all flex items-start gap-3 bg-slate-50/50">
                                <input type="radio" name="process_type" value="express" class="mt-1 text-teal-600 focus:ring-teal-500 border-slate-300 w-4 h-4">
                                <div>
                                    <span class="block font-bold text-slate-800 text-sm flex items-center gap-1.5">
                                        Express Process
                                        <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-1.5 py-0.5 rounded-md uppercase">Fast</span>
                                    </span>
                                    <span class="text-xs text-slate-500 mt-0.5 block">Estimasi selesai 1-2 Hari Kerja</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-100 my-6">

                <div class="space-y-4">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">2. Data Diri Pemohon</h3>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="full_name" placeholder="Sesuai dengan nama di Paspor" class="w-full p-3.5 border border-slate-200 rounded-xl shadow-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 outline-none transition-all placeholder:text-slate-400 font-medium text-slate-800" required>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email Aktif</label>
                            <input type="email" name="email" placeholder="nama@email.com" class="w-full p-3.5 border border-slate-200 rounded-xl shadow-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 outline-none transition-all placeholder:text-slate-400 font-medium text-slate-800" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor Paspor</label>
                            <input type="text" name="passport_number" placeholder="Contoh: A1234567" class="w-full p-3.5 border border-slate-200 rounded-xl shadow-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 outline-none transition-all placeholder:text-slate-400 font-medium text-slate-800 uppercase" required>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-100 flex items-start gap-2.5 text-xs text-slate-500 leading-normal">
                    <svg class="w-4 h-4 text-teal-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span>Data Anda dienkripsi dengan standar keamanan tinggi. Kami tidak akan membagikan informasi pribadi Anda kepada pihak ketiga tanpa persetujuan hukum resmi.</span>
                </div>

                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white py-4 rounded-xl font-bold tracking-wide transition-all shadow-lg shadow-teal-600/20 hover:shadow-xl hover:shadow-teal-600/30 active:scale-[0.99] text-center block">
                    Kirim & Proses Aplikasi
                </button>
            </form>

            <div class="order-1 lg:order-2 space-y-4 lg:sticky lg:top-6">
                @if(request()->has('product_id'))
                    @php
                        $selectedProduct = \App\Models\Product::find(request('product_id'));
                        $selectedCountry = \App\Models\Country::where('code', request('country'))->first();
                    @endphp

                    @if($selectedProduct)
                        <div class="bg-gradient-to-b from-slate-900 to-slate-900 text-white p-6 rounded-3xl shadow-xl border border-slate-800">
                            <h3 class="text-xs font-bold text-teal-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-teal-400 animate-pulse"></span>
                                Selected Service
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <span class="text-xs text-slate-400 block">Layanan Visa</span>
                                    <span class="text-base font-bold text-white block mt-0.5">{{ $selectedProduct->name }}</span>
                                </div>

                                @if($selectedCountry)
                                    <div class="border-t border-slate-800 pt-3">
                                        <span class="text-xs text-slate-400 block">Kewarganegaraan Pemohon</span>
                                        <span class="text-sm font-semibold text-slate-200 block mt-0.5">{{ $selectedCountry->name }} ({{ $selectedCountry->code }})</span>
                                    </div>
                                @endif

                                <div class="border-t border-slate-800 pt-4 mt-2 flex justify-between items-end">
                                    <div>
                                        <span class="text-xs text-slate-400 block">Total Biaya Dasar</span>
                                        <span class="text-2xl font-black text-teal-400 block mt-0.5">
                                            <span class="text-sm font-normal text-slate-300">IDR</span> {{ number_format($selectedProduct->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                <div class="bg-white p-5 rounded-2xl border border-slate-100 text-center shadow-md shadow-slate-100/50">
                    <p class="text-xs font-medium text-slate-500">Butuh panduan pengisian?</p>
                    <a href="https://wa.me/6281547410870" target="_blank" class="mt-2 inline-flex items-center gap-1.5 text-sm font-bold text-teal-600 hover:text-teal-700 transition-colors">
                        Hubungi Agen Konsultan
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
