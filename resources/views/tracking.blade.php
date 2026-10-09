@extends('layouts.app')

@section('content')
<div class="max-w-4xl w-full mx-auto px-4 py-12 text-gray-800">

    <div class="text-center mb-10">
        <span class="text-xs font-bold uppercase tracking-widest text-emerald-800 bg-emerald-50 px-4 py-1.5 rounded-full shadow-sm">Professional Immigration Services</span>
        <h1 class="text-3xl md:text-4xl font-extrabold text-emerald-950 mt-4 mb-2 tracking-tight">Track Your Visa Status</h1>
        <p class="text-gray-500 max-w-md mx-auto text-sm md:text-base">Monitor your immigration documents and KITAS transparently and in real-time.</p>
    </div>

    <div class="space-y-8">
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
            <form action="{{ route('tracking.search') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="passport_number" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Passport Number</label>
                        <input type="text" name="passport_number" id="passport_number"
                            value="{{ old('passport_number') }}"
                            placeholder="Enter your passport number"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-800 focus:border-transparent transition placeholder-gray-400 text-sm font-medium" required>
                        @error('passport_number')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="unique_code" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Unique Code</label>
                        <input type="text" name="unique_code" id="unique_code"
                            value="{{ old('unique_code') }}"
                            placeholder="Enter your registration unique code"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-800 focus:border-transparent transition placeholder-gray-400 text-sm font-medium" required>
                        @error('unique_code')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-emerald-800 hover:bg-emerald-900 text-white font-bold py-3.5 px-6 rounded-xl transition duration-300 shadow-md hover:shadow-lg flex items-center justify-center space-x-2 text-sm md:text-base">
                        <svg class="w-5 h-5 text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <span>Check Status Now</span>
                    </button>
                </div>
            </form>

            @if (session('error'))
                <div class="mt-5 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl flex items-start space-x-3">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    <p class="text-sm text-red-700 font-semibold">{{ session('error') }}</p>
                </div>
            @endif
        </div>

        @if(isset($order))
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-300">

                <div class="p-6 bg-gray-900 text-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-0.5">Booking Code</span>
                        <span class="text-2xl font-black text-amber-200 font-mono">#{{ $order->booking_code }}</span>
                    </div>

                    <div>
                        @if(strtolower($order->status) == 'pending')
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-extrabold bg-amber-500 text-white shadow-sm uppercase tracking-widest">
                                ⏳ Pending
                            </span>
                        @elseif(strtolower($order->status) == 'processing')
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-extrabold bg-sky-500 text-white shadow-sm uppercase tracking-widest">
                                ⚙️ Processing
                            </span>
                        @elseif(strtolower($order->status) == 'approved')
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-extrabold bg-emerald-500 text-white shadow-sm uppercase tracking-widest">
                                ✅ Approved
                            </span>
                        @elseif(strtolower($order->status) == 'rejected')
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-extrabold bg-red-600 text-white shadow-sm uppercase tracking-widest">
                                ❌ Rejected
                            </span>
                        @elseif(strtolower($order->status) == 'completed')
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-extrabold bg-emerald-800 text-white shadow-sm uppercase tracking-widest">
                                🎉 Completed
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-extrabold bg-gray-600 text-white shadow-sm uppercase tracking-widest">
                                {{ $order->status }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="px-6 py-16 bg-gray-50 border-b border-gray-100">
                    <div class="max-w-xl mx-auto relative">
                        <div class="absolute left-6 right-6 top-6 h-2 bg-gray-200 -translate-y-1/2 rounded-full z-0"></div>

                        @php
                            $statusLower = strtolower($order->status);
                            $progressWidth = 'w-0';
                            if($statusLower == 'processing') $progressWidth = 'w-1/2';
                            if(in_array($statusLower, ['approved', 'completed', 'rejected'])) $progressWidth = 'w-full';
                        @endphp

                        <div class="absolute left-6 top-6 h-2 bg-emerald-600 -translate-y-1/2 rounded-full transition-all duration-700 z-0 {{ $progressWidth }}"></div>

                        <div class="relative flex justify-between items-center w-full z-10">

                            <div class="flex flex-col items-center">
                                @if($statusLower == 'pending')
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-amber-500 text-white border-4 border-white shadow-lg ring-4 ring-amber-100 animate-pulse transition-all duration-300">
                                        <svg class="w-5 h-5 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <span class="text-xs font-black mt-3 text-amber-600 uppercase tracking-wider">Received</span>
                                @else
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-emerald-600 text-white border-4 border-white shadow-md transition-all duration-300">
                                        <svg class="w-5 h-5 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="text-xs font-extrabold mt-3 text-emerald-950">Received</span>
                                @endif
                            </div>

                            <div class="flex flex-col items-center">
                                @if(in_array($statusLower, ['approved', 'completed']))
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-emerald-600 text-white border-4 border-white shadow-md transition-all duration-300">
                                        <svg class="w-5 h-5 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="text-xs font-extrabold mt-3 text-emerald-950">Processing</span>
                                @elseif($statusLower == 'processing')
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-amber-500 text-white border-4 border-white shadow-lg animate-pulse ring-4 ring-amber-100 transition-all duration-300">
                                        <svg class="w-5 h-5 animate-spin stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.212 12H19c0 3.866-3.134 7-7 7s-7-3.134-7-7 3.134-7 7-7a6.974 6.974 0 014.882 2H15"></path></svg>
                                    </div>
                                    <span class="text-xs font-black mt-3 text-amber-600 uppercase tracking-wider">Processing</span>
                                @else
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-white border-4 border-gray-200 text-gray-300 shadow-sm">
                                        <svg class="w-5 h-5 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <span class="text-xs font-bold mt-3 text-gray-400">Processing</span>
                                @endif
                            </div>

                            <div class="flex flex-col items-center">
                                @if($statusLower == 'rejected')
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-red-600 text-white border-4 border-white shadow-md">
                                        <svg class="w-5 h-5 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </div>
                                    <span class="text-xs font-extrabold mt-3 text-red-600">Rejected</span>
                                @elseif(in_array($statusLower, ['approved', 'completed']))
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-emerald-700 text-white border-4 border-white shadow-lg ring-4 ring-emerald-100">
                                        <svg class="w-5 h-5 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="text-xs font-black mt-3 text-emerald-800 uppercase tracking-wider">Completed</span>
                                @else
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-white border-4 border-gray-200 text-gray-300 shadow-sm">
                                        <svg class="w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="text-xs font-bold mt-3 text-gray-400">Completed</span>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-6">
                    <div class="border-b border-gray-100 pb-2">
                        <h3 class="text-sm font-bold text-emerald-900 uppercase tracking-wider">Document Submission Details</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Applicant Name</span>
                            <span class="text-sm font-bold text-gray-900 block">{{ $order->customer->name ?? '-' }}</span>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Visa Type / Service</span>
                            <span class="text-sm font-bold text-emerald-800 block">{{ $order->visa_type ?? '-' }}</span>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Passport Number</span>
                            <span class="text-sm font-mono font-bold text-gray-900 block tracking-wide">{{ $order->customer->passport_number ?? '-' }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Submission Date</span>
                                <span class="text-xs font-bold text-gray-800 block">
                                    {{ $order->submission_date ? \Carbon\Carbon::parse($order->submission_date)->translatedFormat('M d, Y') : '-' }}
                                </span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Estimated Completion</span>
                                <span class="text-xs font-bold text-emerald-700 block">
                                    {{ $order->completion_date ? \Carbon\Carbon::parse($order->completion_date)->translatedFormat('M d, Y') : 'Estimated' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if(!empty($order->notes))
                        <div class="mt-4 bg-amber-50 p-4 rounded-xl border border-amber-100 flex space-x-3">
                            <span class="text-base">📢</span>
                            <div>
                                <span class="text-xs font-bold text-amber-800 uppercase tracking-wider block mb-0.5">Additional Agent Notes:</span>
                                <p class="text-sm text-amber-900 font-medium leading-relaxed">{{ $order->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection