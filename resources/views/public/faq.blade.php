@extends('layout')

@section('title', 'Pertanyaan Umum (FAQ) - Rental Mobil')

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
                    <a href="{{ route('landing.contact') }}" class="hover:text-red-600 transition">Kontak</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-5xl md:text-6xl font-black text-gray-900 mb-4 tracking-tighter leading-tight italic uppercase">Pusat Bantuan.</h1>
            <p class="text-gray-500 text-lg font-bold lowercase italic tracking-normal normal-case">Segala hal yang perlu Anda ketahui tentang penyewaan kendaraan bersama kami.</p>
        </div>

        <!-- FAQ Categories -->
        <div class="space-y-12">
            <!-- Category: Rental Basics -->
            <section>
                <h3 class="text-xs font-black text-red-600 uppercase tracking-[0.5em] mb-6 italic">01. Dasar Penyewaan</h3>
                <div class="space-y-4">
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 group hover:border-red-600 transition duration-300">
                        <h4 class="text-lg font-black text-gray-900 mb-2 italic">Syarat utama menyewa mobil?</h4>
                        <p class="text-gray-500 font-bold lowercase normal-case italic tracking-normal leading-relaxed">Anda wajib memiliki KTP asli, SIM A yang masih berlaku, dan dokumen pendukung sesuai kebijakan cabang setempat.</p>
                    </div>
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 group hover:border-red-600 transition duration-300">
                        <h4 class="text-lg font-black text-gray-900 mb-2 italic">Berapa durasi minimal sewa?</h4>
                        <p class="text-gray-500 font-bold lowercase normal-case italic tracking-normal leading-relaxed">Durasi sewa minimal adalah 24 jam (1 hari). Overtime akan dikenakan biaya tambahan per jam.</p>
                    </div>
                </div>
            </section>

            <!-- Category: Payments & Fees -->
            <section>
                <h3 class="text-xs font-black text-red-600 uppercase tracking-[0.5em] mb-6 italic">02. Pembayaran & Biaya</h3>
                <div class="space-y-4">
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 group hover:border-red-600 transition duration-300">
                        <h4 class="text-lg font-black text-gray-900 mb-2 italic">Metode pembayaran apa saja yang tersedia?</h4>
                        <p class="text-gray-500 font-bold lowercase normal-case italic tracking-normal leading-relaxed">Kami menerima transfer bank, kartu kredit, dan dompet digital (E-Wallet) melalui sistem pembayaran terenkripsi kami.</p>
                    </div>
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 group hover:border-red-600 transition duration-300">
                        <h4 class="text-lg font-black text-gray-900 mb-2 italic">Apakah ada jaminan (deposit)?</h4>
                        <p class="text-gray-500 font-bold lowercase normal-case italic tracking-normal leading-relaxed">Ya, setiap pemesanan lepas kunci memerlukan deposit jaminan yang akan dikembalikan segera setelah unit kembali dalam kondisi semula.</p>
                    </div>
                </div>
            </section>

            <!-- Category: Insurance & Safety -->
            <section>
                <h3 class="text-xs font-black text-red-600 uppercase tracking-[0.5em] mb-6 italic">03. Keamanan & Asuransi</h3>
                <div class="space-y-4">
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 group hover:border-red-600 transition duration-300">
                        <h4 class="text-lg font-black text-gray-900 mb-2 italic">Bagaimana jika terjadi kerusakan?</h4>
                        <p class="text-gray-500 font-bold lowercase normal-case italic tracking-normal leading-relaxed">Seluruh armada kami dilindungi asuransi. Penyewa hanya bertanggung jawab atas biaya risiko sendiri (Own Risk) sesuai ketentuan polis.</p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Contact Support Link -->
        <div class="mt-20 p-12 bg-gray-900 rounded-[3rem] text-center shadow-2xl relative overflow-hidden group">
            <div class="relative z-10">
                <h4 class="text-2xl font-black text-white italic uppercase tracking-tighter mb-4">Masih Butuh Bantuan Lain?</h4>
                <p class="text-gray-400 font-bold normal-case italic tracking-normal mb-8">Tim support kami tersedia 24/7 untuk menjawab setiap pertanyaan Anda.</p>
                <a href="{{ route('landing.contact') }}" class="px-10 py-5 bg-red-600 text-white rounded-2xl font-black italic uppercase tracking-widest shadow-xl hover:shadow-2xl transition transform hover:scale-110 duration-200">
                    HUBUNGI KAMI
                </a>
            </div>
            <!-- Glow effect -->
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-red-600 rounded-full blur-[100px] opacity-20 group-hover:opacity-40 transition duration-500"></div>
        </div>
    </div>
</div>
@endsection
