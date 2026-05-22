@extends('layout')

@section('title', 'Sewa Mobil Premium & Terpercaya - Rental Mobil')

@section('content')
<!-- Navigation Bar -->
<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Brand Logo -->
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center shadow-lg shadow-slate-900/10">
                    <i class="fa-solid fa-car-rear text-lg animate-pulse"></i>
                </div>
                <div class="text-xl font-bold tracking-tight text-slate-900">
                    RENTAL<span class="text-red-600 font-extrabold">MOBIL</span>
                </div>
            </div>

            <!-- Menu Navigation Links -->
            <div class="hidden md:flex items-center space-x-10">
                <a href="#features" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">Keunggulan</a>
                <a href="{{ route('landing.vehicles') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">Armada</a>
                <a href="{{ route('landing.branches') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">Cabang</a>
                <a href="#faq" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">FAQ</a>
            </div>

            <!-- Authentication / CTA Button -->
            <div class="flex items-center space-x-4">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 rounded-xl hover:bg-slate-50 transition text-sm font-semibold text-slate-700 outline-none">
                            <i class="fa-regular fa-circle-user text-lg text-slate-400"></i>
                            <span>{{ auth()->user()->name }}</span>
                            <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 z-50">
                            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('customer.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition font-medium">
                                <i class="fa-solid fa-chart-line text-slate-400 w-4"></i> Dashboard
                            </a>
                            <a href="{{ route('customer.profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition font-medium">
                                <i class="fa-regular fa-user text-slate-400 w-4"></i> Profil Saya
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition font-medium text-left">
                                    <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-700 hover:text-slate-900 px-4 py-2.5 transition">Masuk</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white text-sm font-bold rounded-xl shadow-md hover:shadow-lg transition-all duration-300">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="relative bg-white pt-16 pb-24 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            <!-- Hero Text Content -->
            <div class="lg:col-span-6 animate-fade-in">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-red-50 text-red-600 text-xs font-bold tracking-wide uppercase mb-6">
                    <i class="fa-solid fa-shield-halved"></i> Perlindungan Perjalanan Penuh
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.1] mb-6">
                    Sewa Kendaraan <span class="text-red-600">Premium</span> Tanpa Ribet.
                </h1>
                <p class="text-lg text-slate-500 font-medium leading-relaxed mb-10 max-w-xl">
                    Pesan unit mobil terbaru dengan atau tanpa sopir secara instan. Armada terawat, harga transparan, dan pelayanan profesional untuk kenyamanan perjalanan Anda.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('landing.vehicles') }}" class="px-8 py-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-2xl shadow-lg shadow-red-600/10 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                        Pilih Kendaraan
                    </a>
                    <a href="#features" class="px-8 py-4 border border-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-50 hover:border-slate-300 transition duration-300">
                        Pelajari Layanan
                    </a>
                </div>
            </div>

            <!-- Hero Image Panel -->
            <div class="lg:col-span-6 flex justify-center lg:justify-end relative">
                <!-- Decorative Blur Glow -->
                <div class="absolute -inset-4 bg-linear-to-tr from-red-600/10 to-transparent rounded-3xl filter blur-3xl opacity-60 z-0"></div>
                <div class="relative z-10 max-w-full">
                    <img src="https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&q=80&w=800" alt="Rental Car Premium" class="rounded-3xl shadow-2xl border border-slate-100/50 transform hover:scale-[1.02] transition-transform duration-500">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Floating Horizontal Booking/Search Panel -->
<div class="relative z-20 max-w-6xl mx-auto px-4 -mt-12 sm:-mt-16">
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-100">
        <form action="{{ route('landing.vehicles') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <!-- Location Selection -->
            <div>
                <label for="branch_id" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2.5">Lokasi Cabang</label>
                <div class="relative">
                    <i class="fa-solid fa-location-dot absolute left-4 top-3.5 text-slate-400"></i>
                    <select name="branch_id" id="branch_id" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-0 outline-none text-slate-700 text-sm font-semibold transition bg-slate-50/50">
                        <option value="">Semua Cabang</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Pick up Date -->
            <div>
                <label for="pickup_date" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2.5">Tanggal Penjemputan</label>
                <div class="relative">
                    <i class="fa-regular fa-calendar absolute left-4 top-3.5 text-slate-400"></i>
                    <input type="date" name="pickup_date" id="pickup_date" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-0 outline-none text-slate-700 text-sm font-semibold transition bg-slate-50/50">
                </div>
            </div>

            <!-- Return Date -->
            <div>
                <label for="return_date" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2.5">Tanggal Pengembalian</label>
                <div class="relative">
                    <i class="fa-regular fa-calendar absolute left-4 top-3.5 text-slate-400"></i>
                    <input type="date" name="return_date" id="return_date" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-0 outline-none text-slate-700 text-sm font-semibold transition bg-slate-50/50">
                </div>
            </div>

            <!-- Submit Search Button -->
            <div>
                <button type="submit" class="w-full py-3.5 bg-slate-900 hover:bg-black text-white text-sm font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari Kendaraan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Features Section -->
<section id="features" class="py-28 bg-slate-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-20">
            <h2 class="text-xs font-bold text-red-600 uppercase tracking-widest mb-3">Mengapa Memilih Kami</h2>
            <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Standardisasi Layanan Sewa Terbaik</h3>
            <p class="text-slate-500 mt-4 leading-relaxed font-medium">Kami mengutamakan keselamatan, keamanan, dan kepuasan Anda dengan proses pemesanan yang disederhanakan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature Card 1 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100/80 shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl mb-6 transition-transform duration-300 group-hover:scale-110">
                    <i class="fa-solid fa-car"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-900 mb-2.5">Banyak Pilihan Mobil</h4>
                <p class="text-slate-500 text-sm leading-relaxed">Pilih dari berbagai jenis, tipe, dan merek mobil terbaru yang selalu dalam kondisi prima dan bersih terawat.</p>
            </div>

            <!-- Feature Card 2 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100/80 shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl mb-6 transition-transform duration-300 group-hover:scale-110">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-900 mb-2.5">Sopir Profesional</h4>
                <p class="text-slate-500 text-sm leading-relaxed">Sopir resmi bersertifikat yang berpengalaman luas, ramah, jujur, serta mengutamakan keselamatan berkendara.</p>
            </div>

            <!-- Feature Card 3 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100/80 shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl mb-6 transition-transform duration-300 group-hover:scale-110">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-900 mb-2.5">Booking 24 Jam Online</h4>
                <p class="text-slate-500 text-sm leading-relaxed">Kelola dan pesan armada sewa kapan saja secara instan melalui sistem online responsif kami.</p>
            </div>

            <!-- Feature Card 4 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100/80 shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl mb-6 transition-transform duration-300 group-hover:scale-110">
                    <i class="fa-regular fa-credit-card"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-900 mb-2.5">Pembayaran Transparan</h4>
                <p class="text-slate-500 text-sm leading-relaxed">Berbagai metode pembayaran aman tanpa biaya tersembunyi yang tertulis rinci dalam tagihan.</p>
            </div>

            <!-- Feature Card 5 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100/80 shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl mb-6 transition-transform duration-300 group-hover:scale-110">
                    <i class="fa-solid fa-store"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-900 mb-2.5">Banyak Cabang Strategis</h4>
                <p class="text-slate-500 text-sm leading-relaxed">Jaringan kantor operasional yang luas di berbagai titik penting untuk mempermudah serah terima armada.</p>
            </div>

            <!-- Feature Card 6 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100/80 shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl mb-6 transition-transform duration-300 group-hover:scale-110">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-900 mb-2.5">Asuransi Lengkap</h4>
                <p class="text-slate-500 text-sm leading-relaxed">Perjalanan bebas khawatir dengan proteksi asuransi komprehensif bagi kendaraan dan penumpang.</p>
            </div>
        </div>
    </div>
</section>

<!-- Popular Vehicles Section -->
<section class="py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16">
            <div>
                <h2 class="text-xs font-bold text-red-600 uppercase tracking-widest mb-3">Armada Populer</h2>
                <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Temukan Armada Terbaik Anda</h3>
            </div>
            <a href="{{ route('landing.vehicles') }}" class="text-slate-900 hover:text-red-600 font-bold text-sm flex items-center gap-2 group mt-4 md:mt-0 transition duration-200">
                Lihat Semua Armada <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1.5"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($vehicles as $vehicle)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100/80 hover:shadow-md transition-all duration-300 overflow-hidden group flex flex-col h-full">
                    <!-- Image Wrapper -->
                    <div class="overflow-hidden h-52 relative">
                        <img src="{{ $vehicle->getPrimaryImage() ? Storage::url($vehicle->getPrimaryImage()->path) : 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&q=80&w=600' }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-4 right-4 bg-slate-900/80 backdrop-blur-xs text-white text-[10px] font-bold tracking-widest uppercase px-3 py-1.5 rounded-full">
                            {{ $vehicle->category->name }}
                        </span>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 flex flex-col flex-1">
                        <h4 class="font-bold text-xl text-slate-900 mb-1.5">{{ $vehicle->brand }} {{ $vehicle->model }}</h4>
                        <p class="text-slate-400 text-xs font-semibold mb-6">Tahun {{ $vehicle->year }}</p>
                        
                        <!-- Mini Specs -->
                        <div class="flex items-center gap-4 text-xs font-bold text-slate-500 mb-6 border-y border-slate-50 py-3.5">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-couch text-slate-400 text-[13px]"></i> {{ $vehicle->seat_capacity }} Kursi
                            </span>
                            <div class="w-1.5 h-1.5 rounded-full bg-slate-200"></div>
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-gear text-slate-400 text-[13px]"></i> {{ ucfirst($vehicle->transmission) }}
                            </span>
                        </div>

                        <!-- Price & Action -->
                        <div class="flex items-center justify-between mt-auto">
                            <div>
                                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Mulai Dari</span>
                                <span class="text-slate-900 font-extrabold text-lg">Rp {{ number_format($vehicle->price_daily, 0, ',', '.') }}<span class="text-xs font-medium text-slate-400">/hari</span></span>
                            </div>
                            <a href="{{ route('landing.vehicle.detail', $vehicle->id) }}" class="px-5 py-3 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition duration-300">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-slate-500 py-10 font-medium">Belum ada armada mobil yang tersedia</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="bg-slate-950 text-white py-20 relative overflow-hidden">
    <!-- Decorative Glowing Circle -->
    <div class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-red-600/10 filter blur-3xl z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-10 text-center divide-y md:divide-y-0 md:divide-x divide-slate-800">
            <!-- Stat Item 1 -->
            <div class="pt-8 md:pt-0">
                <div class="text-4xl sm:text-5xl font-extrabold text-white mb-2.5 tracking-tight">{{ $stats['total_vehicles'] }}</div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Kendaraan</p>
            </div>
            <!-- Stat Item 2 -->
            <div class="pt-8 md:pt-0">
                <div class="text-4xl sm:text-5xl font-extrabold text-white mb-2.5 tracking-tight">{{ $stats['total_bookings'] }}</div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pemesanan Sukses</p>
            </div>
            <!-- Stat Item 3 -->
            <div class="pt-8 md:pt-0">
                <div class="text-4xl sm:text-5xl font-extrabold text-white mb-2.5 tracking-tight">{{ $stats['total_drivers'] }}</div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Sopir Profesional</p>
            </div>
            <!-- Stat Item 4 -->
            <div class="pt-8 md:pt-0">
                <div class="text-4xl sm:text-5xl font-extrabold text-white mb-2.5 tracking-tight">{{ $stats['total_branches'] }}</div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kantor Cabang</p>
            </div>
        </div>
    </div>
</section>

<!-- Branches Section -->
<section class="py-28 bg-slate-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-20">
            <h2 class="text-xs font-bold text-red-600 uppercase tracking-widest mb-3">Kantor Cabang</h2>
            <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Kunjungi Cabang Terdekat Kami</h3>
            <p class="text-slate-500 mt-4 leading-relaxed font-medium">Jaringan operasional kami siap menyambut kebutuhan sewa Anda di beberapa lokasi strategis.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($branches as $branch)
                <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center text-lg mb-6">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h4 class="font-bold text-xl text-slate-900 mb-3">{{ $branch->name }}</h4>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">{{ $branch->address }}</p>
                    
                    <div class="border-t border-slate-50 pt-5 space-y-3 text-xs font-bold text-slate-600">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-slate-400 text-[14px]"></i>
                            <span>{{ $branch->phone }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-regular fa-clock text-slate-400 text-[14px]"></i>
                            <span>{{ $branch->opening_hour }} - {{ $branch->closing_hour }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-slate-500 py-10 font-medium">Belum ada cabang operasional tersedia</p>
            @endforelse
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section id="faq" class="py-28 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20">
            <h2 class="text-xs font-bold text-red-600 uppercase tracking-widest mb-3">Pertanyaan Umum</h2>
            <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">Ada Pertanyaan? Temukan Jawabannya</h3>
        </div>

        <div class="divide-y divide-slate-100">
            <!-- FAQ Item 1 -->
            <div class="py-6">
                <details class="group cursor-pointer">
                    <summary class="flex justify-between items-center font-bold text-base sm:text-lg text-slate-900 list-none outline-none">
                        <span>Berapa usia minimum untuk menyewa mobil?</span>
                        <span class="text-slate-400 transition-transform duration-300 group-open:rotate-180">
                            <i class="fa-solid fa-chevron-down text-sm"></i>
                        </span>
                    </summary>
                    <p class="mt-4 text-slate-500 text-sm sm:text-base leading-relaxed font-medium">
                        Usia minimum penyewa adalah 21 tahun dengan menyertakan dokumen wajib berupa Kartu Tanda Penduduk (KTP) serta Surat Izin Mengemudi (SIM) golongan A yang masih aktif.
                    </p>
                </details>
            </div>

            <!-- FAQ Item 2 -->
            <div class="py-6">
                <details class="group cursor-pointer">
                    <summary class="flex justify-between items-center font-bold text-base sm:text-lg text-slate-900 list-none outline-none">
                        <span>Apakah harga sewa sudah termasuk asuransi?</span>
                        <span class="text-slate-400 transition-transform duration-300 group-open:rotate-180">
                            <i class="fa-solid fa-chevron-down text-sm"></i>
                        </span>
                    </summary>
                    <p class="mt-4 text-slate-500 text-sm sm:text-base leading-relaxed font-medium">
                        Ya, proteksi asuransi kecelakaan dasar sudah termasuk dalam harga sewa harian. Anda juga diperbolehkan untuk menambah opsi asuransi komprehensif penuh pada panel pemesanan jika dirasa perlu.
                    </p>
                </details>
            </div>

            <!-- FAQ Item 3 -->
            <div class="py-6">
                <details class="group cursor-pointer">
                    <summary class="flex justify-between items-center font-bold text-base sm:text-lg text-slate-900 list-none outline-none">
                        <span>Bagaimana kebijakan jika terjadi kerusakan selama perjalanan?</span>
                        <span class="text-slate-400 transition-transform duration-300 group-open:rotate-180">
                            <i class="fa-solid fa-chevron-down text-sm"></i>
                        </span>
                    </summary>
                    <p class="mt-4 text-slate-500 text-sm sm:text-base leading-relaxed font-medium">
                        Apabila terjadi insiden kerusakan ringan atau berat, mohon segera hubungi call center darurat cabang terdekat dalam waktu 1x24 jam untuk laporan berita acara agar asuransi dapat segera memproses klaim secara formal.
                    </p>
                </details>
            </div>
        </div>
    </div>
</section>

<!-- Call-to-Action (CTA) Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-slate-900 text-white rounded-3xl p-10 sm:p-16 lg:p-20 relative overflow-hidden shadow-2xl">
            <!-- Decorative Blurred Circle overlay -->
            <div class="absolute -right-10 -top-10 w-60 h-60 rounded-full bg-red-600/20 filter blur-3xl z-0"></div>
            <div class="absolute -left-10 -bottom-10 w-60 h-60 rounded-full bg-red-600/10 filter blur-3xl z-0"></div>

            <div class="relative z-10 max-w-3xl mx-auto text-center">
                <h3 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight mb-6">Siap untuk Memulai Perjalanan Anda?</h3>
                <p class="text-slate-300 font-medium text-lg leading-relaxed mb-10 max-w-xl mx-auto">
                    Dapatkan diskon khusus untuk penyewaan mingguan atau bulanan. Hubungi cabang kami atau klik di bawah ini sekarang.
                </p>
                <a href="{{ route('landing.vehicles') }}" class="px-8 py-4 bg-white text-slate-900 hover:bg-slate-100 font-bold rounded-2xl shadow-lg transition duration-300 inline-block">
                    Pesan Mobil Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Footer Section -->
<footer class="bg-slate-950 text-slate-400 py-16 border-t border-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-16">
            <!-- Col 1 -->
            <div class="md:col-span-4">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-red-600 text-white flex items-center justify-center">
                        <i class="fa-solid fa-car-rear text-sm"></i>
                    </div>
                    <span class="text-white font-extrabold text-lg tracking-tight">RENTAL<span class="text-red-500">MOBIL</span></span>
                </div>
                <p class="text-sm leading-relaxed text-slate-400 max-w-sm">
                    Penyedia jasa transportasi terpercaya yang berfokus pada kualitas armada terawat dan sopir bersertifikat profesional untuk seluruh wilayah strategis di Indonesia.
                </p>
            </div>

            <!-- Col 2 -->
            <div class="md:col-span-2 md:col-start-6">
                <h5 class="text-white font-bold text-sm tracking-wider uppercase mb-6">Layanan</h5>
                <ul class="space-y-3.5 text-sm">
                    <li><a href="{{ route('landing.vehicles') }}" class="hover:text-white transition duration-200">Sewa Lepas Kunci</a></li>
                    <li><a href="{{ route('landing.vehicles') }}" class="hover:text-white transition duration-200">Dengan Sopir Resmi</a></li>
                    <li><a href="#" class="hover:text-white transition duration-200">Asuransi Perjalanan</a></li>
                </ul>
            </div>

            <!-- Col 3 -->
            <div class="md:col-span-2">
                <h5 class="text-white font-bold text-sm tracking-wider uppercase mb-6">Perusahaan</h5>
                <ul class="space-y-3.5 text-sm">
                    <li><a href="{{ route('landing.about') }}" class="hover:text-white transition duration-200">Tentang Kami</a></li>
                    <li><a href="{{ route('landing.branches') }}" class="hover:text-white transition duration-200">Kantor Cabang</a></li>
                    <li><a href="{{ route('landing.contact') }}" class="hover:text-white transition duration-200">Hubungi Kami</a></li>
                </ul>
            </div>

            <!-- Col 4 -->
            <div class="md:col-span-3">
                <h5 class="text-white font-bold text-sm tracking-wider uppercase mb-6">Hubungi Kami</h5>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-center gap-2.5">
                        <i class="fa-solid fa-phone text-red-500 text-xs"></i>
                        <span>(021) 123-4567</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i class="fa-solid fa-envelope text-red-500 text-xs"></i>
                        <span>info@rental-mobil.id</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-slate-900 pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 font-bold gap-4">
            <p>&copy; {{ date('Y') }} Rental Mobil. Hak Cipta Dilindungi Undang-Undang.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-slate-300 transition">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-slate-300 transition">Kebijakan Privasi</a>
            </div>
        </div>
    </div>
</footer>
@endsection
