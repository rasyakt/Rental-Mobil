@extends('layout')

@section('title', 'Rental Mobil - Pesan Kendaraan Dengan Mudah')

@section('content')
<!-- Navigation -->
<nav class="sticky top-0 z-50 glass-panel">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="text-3xl font-extrabold tracking-tight text-red-600">RENTAL MOBIL</div>
            <div class="hidden md:flex space-x-8">
                <a href="#" class="text-gray-600 hover:text-red-600 transition">Layanan</a>
                <a href="{{ route('landing.vehicles') }}" class="text-gray-600 hover:text-red-600 transition">Armada</a>
                <a href="{{ route('landing.branches') }}" class="text-gray-600 hover:text-red-600 transition">Cabang</a>
                <a href="{{ route('landing.faq') }}" class="text-gray-600 hover:text-red-600 transition">FAQ</a>
            </div>
            <div class="flex items-center space-x-4">
                @auth
                    <button onclick="document.getElementById('userMenu').classList.toggle('hidden')" class="text-gray-600">
                        {{ auth()->user()->name }}
                    </button>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn-outline">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-outline">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-primary">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-gradient text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="animate-fade-in">
                <h1 class="text-5xl md:text-6xl font-extrabold mb-6 leading-tight tracking-tight">Rental Mobil Mudah, Cepat, dan Profesional</h1>
                <p class="text-xl text-red-100 font-medium mb-10 leading-relaxed max-w-xl">Pesan kendaraan dengan sopir secara online, kapan saja dan di mana saja. Dengan armada terbaru dan driver profesional berpengalaman.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('landing.vehicles') }}" class="px-8 py-4 bg-white text-red-600 font-bold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition duration-300">Pesan Sekarang</a>
                    <a href="#features" class="px-8 py-4 border-2 border-white/50 text-white font-bold rounded-xl hover:bg-white/10 transition duration-300">Lihat Armada</a>
                </div>
            </div>
            <div class="text-center">
                <img src="https://via.placeholder.com/400x300" alt="Rental Car" class="rounded-lg shadow-xl">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center mb-12">Keunggulan Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-lg shadow-md card-hover">
                <div class="text-4xl mb-4">🚗</div>
                <h3 class="text-xl font-bold mb-2">Banyak Pilihan Mobil</h3>
                <p class="text-gray-600">Pilih dari berbagai jenis dan merek mobil sesuai kebutuhan Anda</p>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-md card-hover">
                <div class="text-4xl mb-4">👨</div>
                <h3 class="text-xl font-bold mb-2">Sopir Profesional</h3>
                <p class="text-gray-600">Sopir bersertifikat, berpengalaman, dan berkarakter baik</p>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-md card-hover">
                <div class="text-4xl mb-4">⏰</div>
                <h3 class="text-xl font-bold mb-2">Booking 24 Jam</h3>
                <p class="text-gray-600">Pesan kapan saja melalui aplikasi atau website kami</p>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-md card-hover">
                <div class="text-4xl mb-4">💳</div>
                <h3 class="text-xl font-bold mb-2">Pembayaran Fleksibel</h3>
                <p class="text-gray-600">Berbagai metode pembayaran untuk kemudahan Anda</p>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-md card-hover">
                <div class="text-4xl mb-4">🏪</div>
                <h3 class="text-xl font-bold mb-2">Banyak Cabang</h3>
                <p class="text-gray-600">Tersedia di berbagai lokasi strategis di Indonesia</p>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-md card-hover">
                <div class="text-4xl mb-4">🛡️</div>
                <h3 class="text-xl font-bold mb-2">Asuransi Lengkap</h3>
                <p class="text-gray-600">Perlindungan penuh untuk kendaraan Anda</p>
            </div>
        </div>
    </div>
</section>

<!-- Popular Vehicles Section -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold mb-12">Armada Populer</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($vehicles as $vehicle)
                <div class="bg-white rounded-lg shadow-md card-hover overflow-hidden">
                    <img src="https://via.placeholder.com/300x200" alt="{{ $vehicle->brand }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-1">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                        <p class="text-gray-500 text-sm mb-3">{{ $vehicle->category->name }}</p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-red-600 font-bold">Rp {{ number_format($vehicle->price_daily, 0, ',', '.') }}/hari</span>
                            <span class="badge-success">{{ $vehicle->seat_capacity }} Tempat</span>
                        </div>
                        <a href="{{ route('landing.vehicle.detail', $vehicle->id) }}" class="btn-primary block text-center">Lihat Detail</a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Belum ada kendaraan tersedia</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="bg-gray-900 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold mb-2">{{ $stats['total_vehicles'] }}</div>
                <p class="text-gray-400">Kendaraan</p>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">{{ $stats['total_bookings'] }}</div>
                <p class="text-gray-400">Booking</p>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">{{ $stats['total_drivers'] }}</div>
                <p class="text-gray-400">Sopir Profesional</p>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">{{ $stats['total_branches'] }}</div>
                <p class="text-gray-400">Cabang</p>
            </div>
        </div>
    </div>
</section>

<!-- Branches Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold mb-12">Kantor Cabang Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($branches as $branch)
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-bold text-xl mb-3">{{ $branch->name }}</h3>
                    <p class="text-gray-600 mb-3">📍 {{ $branch->address }}</p>
                    <p class="text-gray-600 mb-2">📞 {{ $branch->phone }}</p>
                    <p class="text-gray-600 mb-3">⏰ {{ $branch->opening_hour }} - {{ $branch->closing_hour }}</p>
                </div>
            @empty
                <p class="text-gray-500">Belum ada cabang tersedia</p>
            @endforelse
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold mb-12 text-center">Pertanyaan Umum</h2>
        <div class="space-y-4">
            <details class="bg-gray-50 p-6 rounded-lg cursor-pointer">
                <summary class="font-bold text-lg text-gray-900">Berapa usia minimum untuk menyewa mobil?</summary>
                <p class="mt-4 text-gray-600">Usia minimum adalah 21 tahun dengan SIM yang masih berlaku dan fotokopi KTP.</p>
            </details>
            <details class="bg-gray-50 p-6 rounded-lg cursor-pointer">
                <summary class="font-bold text-lg text-gray-900">Apakah termasuk asuransi dalam harga sewa?</summary>
                <p class="mt-4 text-gray-600">Ya, asuransi dasar sudah termasuk dalam harga sewa. Anda dapat menambah asuransi komprehensif jika diinginkan.</p>
            </details>
            <details class="bg-gray-50 p-6 rounded-lg cursor-pointer">
                <summary class="font-bold text-lg text-gray-900">Bagaimana jika terjadi kerusakan pada mobil?</summary>
                <p class="mt-4 text-gray-600">Laporan akan dibuat dan ditangani sesuai polis asuransi. Biaya perbaikan akan ditanggung asuransi atau Anda sesuai kondisi polis.</p>
            </details>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="hero-gradient text-white py-20">
    <div class="max-w-4xl mx-auto text-center px-4">
        <h2 class="text-4xl font-bold mb-4">Siap untuk Memulai Perjalanan Anda?</h2>
        <p class="text-xl text-gray-100 mb-8">Pesan mobil impian Anda sekarang dan nikmati pengalaman berkendara yang tak terlupakan.</p>
        <a href="{{ route('landing.vehicles') }}" class="px-8 py-4 bg-white text-red-600 font-bold rounded-lg hover:bg-gray-100 transition inline-block">Pesan Mobil Sekarang</a>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-400 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div>
                <h4 class="text-white font-bold mb-4">Tentang Kami</h4>
                <p class="text-sm">Rental mobil terpercaya dengan armada terbaru dan sopir profesional. Melayani seluruh Indonesia.</p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Layanan</h4>
                <ul class="text-sm space-y-2">
                    <li><a href="#" class="hover:text-white transition">Sewa Mobil</a></li>
                    <li><a href="#" class="hover:text-white transition">Dengan Sopir</a></li>
                    <li><a href="#" class="hover:text-white transition">Asuransi Perjalanan</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Perusahaan</h4>
                <ul class="text-sm space-y-2">
                    <li><a href="{{ route('landing.about') }}" class="hover:text-white transition">Tentang</a></li>
                    <li><a href="{{ route('landing.branches') }}" class="hover:text-white transition">Cabang</a></li>
                    <li><a href="{{ route('landing.contact') }}" class="hover:text-white transition">Hubungi Kami</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Hubungi Kami</h4>
                <p class="text-sm mb-2">📞 (021) 123-4567</p>
                <p class="text-sm">✉️ info@rental-mobil.id</p>
            </div>
        </div>
        <div class="border-t border-gray-700 pt-8 text-center">
            <p class="text-sm">&copy; {{ date('Y') }} Rental Mobil. Semua hak dilindungi.</p>
        </div>
    </div>
</footer>
@endsection
