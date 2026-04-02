@extends('layout')

@section('title', 'Kontak Kami - Rental Mobil')

@section('content')
<div class="min-h-screen bg-white pb-20">
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
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-start mb-20">
            <!-- Form Section -->
            <div class="bg-gray-50 rounded-[3rem] p-12 md:p-20 shadow-2xl relative overflow-hidden group">
                <div class="relative z-10">
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4 tracking-tighter italic uppercase leading-tight">Hubungi Kami Secara Langsung.</h2>
                    <p class="text-gray-400 font-bold normal-case italic tracking-normal lowercase mb-12">Kirim pesan kepada tim kami untuk bantuan instan.</p>

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-600 p-4 mb-8">
                            <p class="text-green-700 italic font-black uppercase text-xs tracking-widest">{{ session('success') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('landing.contact.submit') }}" method="POST" class="space-y-6 normal-case tracking-normal not-italic font-medium">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-2 italic">Nama</label>
                                <input type="text" name="name" id="name" required class="w-full px-6 py-4 rounded-2xl border-transparent bg-white focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold shadow-sm" placeholder="Contoh: Budi Santoso">
                            </div>
                            <div>
                                <label for="email" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-2 italic">Email</label>
                                <input type="email" name="email" id="email" required class="w-full px-6 py-4 rounded-2xl border-transparent bg-white focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold shadow-sm" placeholder="budi@email.com">
                            </div>
                        </div>
                        <div>
                            <label for="subject" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-2 italic">Subjek</label>
                            <input type="text" name="subject" id="subject" required class="w-full px-6 py-4 rounded-2xl border-transparent bg-white focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold shadow-sm" placeholder="Pertanyaan Sewa / Kerjasama">
                        </div>
                        <div>
                            <label for="message" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-2 italic">Pesan</label>
                            <textarea name="message" id="message" rows="5" required class="w-full px-6 py-4 rounded-2xl border-transparent bg-white focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold shadow-sm" placeholder="Tuliskan pesan Anda di sini..."></textarea>
                        </div>
                        <button type="submit" class="w-full py-5 bg-red-600 text-white rounded-2xl font-black italic uppercase tracking-widest shadow-xl hover:shadow-2xl transition transform hover:scale-[1.02]">
                            KIRIM PESAN SEKARANG
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Details Section -->
            <div class="space-y-12 py-10">
                <section>
                    <h3 class="text-xs font-black text-red-600 uppercase tracking-[0.5em] mb-6 italic">01. Alamat Kantor Pusat</h3>
                    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm font-bold normal-case italic tracking-normal">
                        <p class="text-lg text-gray-900 mb-2 font-black uppercase tracking-tighter">Graha Rental Mobil Building</p>
                        <p class="text-gray-500 leading-relaxed">Jl. Gatot Subroto No. 123, Jakarta Selatan<br>DKI Jakarta, 12950</p>
                    </div>
                </section>

                <section>
                    <h3 class="text-xs font-black text-red-600 uppercase tracking-[0.5em] mb-6 italic">02. Saluran Komunikasi</h3>
                    <div class="space-y-4 font-bold normal-case italic tracking-normal">
                        <div class="flex items-center gap-6 p-6 bg-white rounded-3xl border border-gray-100 shadow-sm group hover:border-red-600 transition">
                            <div class="h-12 w-12 bg-red-50 text-red-600 flex items-center justify-center rounded-xl shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 uppercase tracking-widest mb-1 italic">Phone / WhatsApp</div>
                                <div class="text-xl font-black text-gray-900 tracking-tighter uppercase">+62 812-3456-7890</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-6 p-6 bg-white rounded-3xl border border-gray-100 shadow-sm group hover:border-red-600 transition">
                            <div class="h-12 w-12 bg-red-50 text-red-600 flex items-center justify-center rounded-xl shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 uppercase tracking-widest mb-1 italic">Email Support</div>
                                <div class="text-xl font-black text-gray-900 tracking-tighter uppercase italic">HELLO@RENTALMOBIL.COM</div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Google Map Placeholder -->
        <div class="h-[500px] w-full bg-gray-100 rounded-[3rem] overflow-hidden shadow-2xl relative">
            <div class="absolute inset-0 flex items-center justify-center text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <div class="absolute bottom-10 left-10 p-8 bg-white/90 backdrop-blur rounded-3xl shadow-xl italic normal-case tracking-normal">
                    <h4 class="font-black italic uppercase text-gray-900 mb-1">INTERACTIVE MAP</h4>
                    <p class="text-xs font-bold text-gray-500 lowercase italic">Kunjungi Kami Di Kantor Paling Dekat Dengan Anda.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
