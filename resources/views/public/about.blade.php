@extends('layout')

@section('title', 'Tentang Kami - Rental Mobil')

@section('content')
<div class="min-h-screen bg-white pb-20">
    <!-- Hero Section -->
    <div class="relative h-[400px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-red-600">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
        </div>
        <div class="relative z-10 text-center px-4 max-w-4xl">
            <h1 class="text-5xl md:text-7xl font-black text-white italic uppercase tracking-tighter mb-4 animate-fade-in-up">Mendefinisikan Ulang Kebebasan Berkendara.</h1>
            <p class="text-red-100 text-xl font-bold tracking-tight max-w-2xl mx-auto">Sejak 2010, kami telah menjadi mitra terpercaya bagi ribuan petualang di seluruh Indonesia.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-28">
            <div>
                <h2 class="text-4xl font-black text-gray-900 italic uppercase tracking-tighter mb-8 border-l-8 border-red-600 pl-6">Misi Kami</h2>
                <div class="space-y-6 text-gray-600 text-lg font-medium leading-relaxed">
                    <p>Rental Mobil lahir dari visi sederhana: memberikan akses transportasi yang berkualitas, aman, dan terjangkau bagi setiap individu. Kami percaya bahwa perjalanan yang nyaman adalah hak bagi setiap orang.</p>
                    <p>Dengan armada terbaru yang selalu dalam kondisi prima dan tim profesional yang berdedikasi, kami memastikan setiap detik perjalanan Anda adalah pengalaman yang menyenangkan.</p>
                </div>
                <div class="mt-10 grid grid-cols-2 gap-8">
                    <div>
                        <div class="text-4xl font-black text-red-600 mb-1 leading-none italic">15+</div>
                        <div class="text-sm font-bold text-gray-400 uppercase tracking-widest italic">Tahun Beroperasi</div>
                    </div>
                    <div>
                        <div class="text-4xl font-black text-red-600 mb-1 leading-none italic">100k+</div>
                        <div class="text-sm font-bold text-gray-400 uppercase tracking-widest italic">Booking Selesai</div>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="aspect-square bg-gray-100 rounded-3xl overflow-hidden shadow-2xl relative group">
                    <div class="p-12 flex flex-col justify-center h-full">
                        <div class="text-xs font-black text-red-600 uppercase tracking-[0.5em] mb-4">Values</div>
                        <h3 class="text-3xl font-black text-gray-900 mb-8 italic uppercase leading-tight">Integritas, Keamanan, & Kenyamanan.</h3>
                        <ul class="space-y-4">
                            <li class="flex items-center gap-3 font-bold text-gray-700">
                                <span class="h-6 w-6 bg-red-600 text-white rounded-full flex items-center justify-center text-xs shrink-0">&check;</span>
                                Pemeliharaan Armada Standar Dealer
                            </li>
                            <li class="flex items-center gap-3 font-bold text-gray-700">
                                <span class="h-6 w-6 bg-red-600 text-white rounded-full flex items-center justify-center text-xs shrink-0">&check;</span>
                                Proteksi Asuransi Komprehensif
                            </li>
                            <li class="flex items-center gap-3 font-bold text-gray-700">
                                <span class="h-6 w-6 bg-red-600 text-white rounded-full flex items-center justify-center text-xs shrink-0">&check;</span>
                                Layanan Bantuan 24/7 di Seluruh Kota
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-red-600 rounded-3xl -z-10 shadow-xl"></div>
            </div>
        </div>

        <!-- Visionary Call to Action -->
        <div class="bg-gray-900 rounded-[3rem] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl">
            <div class="relative z-10 max-w-3xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-black text-white italic uppercase tracking-tighter mb-8 leading-tight">Siap Memulai Perjalanan Bersama Kami?</h2>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="{{ route('landing.vehicles') }}" class="px-12 py-5 bg-red-600 text-white rounded-2xl font-black italic uppercase tracking-widest hover:bg-red-700 shadow-xl transition transform hover:scale-105 duration-200">
                        Cari Mobil Sekarang
                    </a>
                    <a href="{{ route('landing.contact') }}" class="px-12 py-5 bg-white text-gray-900 rounded-2xl font-black italic uppercase tracking-widest hover:bg-gray-100 shadow-xl transition transform hover:scale-105 duration-200">
                        Hubungi Kami
                    </a>
                </div>
            </div>
            <!-- Decorative circle -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] border-[40px] border-white/5 rounded-full pointer-events-none"></div>
        </div>
    </div>
</div>
@endsection
