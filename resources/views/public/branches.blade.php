@extends('layout')

@section('title', 'Lokasi Cabang - Rental Mobil')

@section('content')
<div class="min-h-screen bg-gray-50 pb-20">
    <!-- Navbar (Simplified) -->
    <nav class="bg-white shadow-sm mb-12 border-b border-gray-100 italic normal-case tracking-normal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="text-2xl font-black text-red-600 tracking-tighter uppercase">RENTAL MOBIL</a>
                <div class="hidden md:flex items-center gap-8 text-sm font-bold text-gray-500 uppercase tracking-widest italic">
                    <a href="{{ route('landing.vehicles') }}" class="hover:text-red-600 transition">Armada</a>
                    <a href="{{ route('landing.about') }}" class="hover:text-red-600 transition">Tentang Kami</a>
                    <a href="{{ route('landing.faq') }}" class="hover:text-red-600 transition">Bantuan</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-5xl md:text-6xl font-black text-gray-900 mb-4 tracking-tighter italic uppercase leading-tight">Jaringan Layanan Kami.</h1>
            <p class="text-gray-500 text-lg font-bold lowercase italic tracking-normal normal-case">Kami hadir di berbagai titik strategis untuk kenyamanan perjalanan Anda.</p>
        </div>

        @if($branches->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($branches as $branch)
                    <div class="bg-white rounded-[2rem] p-10 shadow-sm border border-gray-100 hover:shadow-2xl hover:border-red-600 transition duration-300 group">
                        <div class="h-16 w-16 bg-red-50 text-red-600 flex items-center justify-center rounded-2xl mb-8 group-hover:bg-red-600 group-hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 mb-4 italic uppercase tracking-tighter">{{ $branch->name }}</h3>
                        <div class="space-y-4 font-bold normal-case italic tracking-normal text-sm">
                            <div class="flex items-start gap-3">
                                <span class="text-red-600 font-extrabold shrink-0 italic uppercase text-[10px] bg-red-50 px-2 py-0.5 rounded tracking-widest mt-1">LOKASI</span>
                                <p class="text-gray-500 leading-relaxed">{{ $branch->address }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-red-600 font-extrabold shrink-0 italic uppercase text-[10px] bg-red-50 px-2 py-0.5 rounded tracking-widest">PHONE</span>
                                <p class="text-gray-900">{{ $branch->phone }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-red-600 font-extrabold shrink-0 italic uppercase text-[10px] bg-red-50 px-2 py-0.5 rounded tracking-widest">EMAIL</span>
                                <p class="text-gray-900 uppercase lowercase italic">{{ $branch->email }}</p>
                            </div>
                        </div>
                        <div class="mt-8 pt-8 border-t border-gray-50">
                            <a href="{{ route('landing.vehicles', ['branch' => $branch->id]) }}" class="inline-flex items-center gap-2 text-red-600 font-black italic uppercase tracking-widest group-hover:gap-4 transition-all">
                                CARI MOBIL DI SINI
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-[3rem] p-20 text-center shadow-xl border border-gray-100">
                <div class="h-24 w-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 italic uppercase">Belum Ada Lokasi Aktif.</h3>
                <p class="text-gray-400 font-bold lowercase italic normal-case tracking-normal mt-2">Kami sedang mempersiapkan ekspansi besar-besaran untuk menjangkau Anda.</p>
            </div>
        @endif
    </div>
</div>
@endsection
