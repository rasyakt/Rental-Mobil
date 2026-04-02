@extends('layout')

@section('title', 'Dashboard Saya - Rental Mobil')

@section('content')
<div class="min-h-screen bg-gray-50 pb-12">
    <!-- Navbar Customer -->
    <nav class="bg-white shadow-sm mb-8 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-6">
                    <a href="/" class="text-2xl font-extrabold text-red-600 tracking-tight">RENTAL MOBIL</a>
                    <div class="hidden md:flex items-center gap-4 text-sm font-semibold text-gray-500">
                        <a href="{{ route('customer.dashboard') }}" class="text-red-600 font-bold">Beranda</a>
                        <a href="{{ route('customer.bookings.index') }}" class="hover:text-red-600 transition">Pesanan Saya</a>
                        <a href="{{ route('customer.profile.edit') }}" class="hover:text-red-600 transition">Profil</a>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm font-bold text-gray-900 hidden sm:block">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-bold text-gray-500 hover:text-red-600 transition">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Welcome -->
        <div class="bg-red-600 rounded-3xl p-8 md:p-12 text-white mb-10 overflow-hidden relative shadow-2xl">
            <div class="relative z-10">
                <h2 class="text-3xl md:text-4xl font-extrabold mb-2 text-white">Halo, {{ explode(' ', auth()->user()->name)[0] }}!</h2>
                <p class="text-red-100 font-medium mb-8">Siap untuk petualangan berikutnya? Sewa mobil impianmu sekarang.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('landing.vehicles') }}" class="px-8 py-4 bg-white text-red-600 rounded-2xl font-bold shadow-lg hover:shadow-xl hover:-translate-y-1 transition transform duration-300">
                        Cari Mobil
                    </a>
                </div>
            </div>
            <!-- Abstract background shape -->
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-red-500 rounded-full opacity-20 blur-3xl"></div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 group hover:border-red-200 transition duration-300">
                <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Sewa Aktif</div>
                <div class="text-4xl font-extrabold text-gray-900">{{ $stats['active_bookings'] }}</div>
                <div class="mt-4 text-xs font-semibold text-red-600 bg-red-50 inline-block px-3 py-1 rounded-full">Unit Berjalan</div>
            </div>
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 group hover:border-blue-200 transition duration-300">
                <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Total Selesai</div>
                <div class="text-4xl font-extrabold text-gray-900">{{ $stats['completed_bookings'] }}</div>
                <div class="mt-4 text-xs font-semibold text-blue-600 bg-blue-50 inline-block px-3 py-1 rounded-full">Petualangan Selesai</div>
            </div>
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 group hover:border-green-200 transition duration-300">
                <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Total Transaksi</div>
                <div class="text-2xl font-extrabold text-gray-900">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</div>
                <div class="mt-4 text-xs font-semibold text-green-600 bg-green-50 inline-block px-3 py-1 rounded-full tracking-wide uppercase">Loyalty Member</div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                <h3 class="text-xl font-extrabold text-gray-900">5 Pesanan Terakhir</h3>
                <a href="{{ route('customer.bookings.index') }}" class="text-sm font-semibold text-red-600 hover:underline">Semua Pesanan</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($bookings as $booking)
                    <div class="p-8 hover:bg-gray-50 transition group">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div class="flex items-center gap-6">
                                <div class="h-20 w-24 bg-gray-100 rounded-2xl overflow-hidden shrink-0 shadow-sm transition group-hover:scale-105 duration-300">
                                    @if($booking->vehicle->images->count() > 0)
                                        <img src="{{ Storage::url($booking->vehicle->images->first()->path) }}" alt="{{ $booking->vehicle->model }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.477 12.89L13.477 12.89C14.004 12.362 14.858 12.362 15.385 12.89L15.385 12.89C15.913 13.417 15.913 14.271 15.385 14.799L15.385 14.799C14.858 15.326 14.004 15.326 13.477 14.799L13.477 14.799C12.95 14.271 12.95 13.417 13.477 12.89ZM13.477 12.89L13.477 12.89C14.004 12.362 14.858 12.362 15.385 12.89L15.385 12.89C15.913 13.417 15.913 14.271 15.385 14.799L15.385 14.799C14.858 15.326 14.004 15.326 13.477 14.799L13.477 14.799C12.95 14.271 12.95 13.417 13.477 12.89Z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900 leading-tight">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</h4>
                                    <div class="flex items-center gap-2 mt-1 text-sm text-gray-500 font-bold">
                                        <span>{{ $booking->pickup_date->format('d M Y') }}</span>
                                        <span class="text-gray-300">•</span>
                                        <span>{{ $booking->getDurationDays() }} Hari</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between md:justify-end gap-8">
                                <div class="text-right">
                                    <div class="text-lg font-bold text-slate-900">Rp {{ number_format($booking->final_price, 0, ',', '.') }}</div>
                                    <div class="mt-1">
                                        @if($booking->status === 'confirmed')
                                            <span class="badge-success">PESANAN DISIAPKAN</span>
                                        @elseif($booking->status === 'pending')
                                            <span class="badge-warning">MENUNGGU KONFIRMASI</span>
                                        @elseif($booking->status === 'active')
                                            <span class="badge-success bg-red-600 text-white">SEDANG DISewa</span>
                                        @else
                                            <span class="badge-danger">{{ $booking->status }}</span>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('customer.bookings.show', $booking->id) }}" class="p-3 bg-gray-900 text-white rounded-2xl hover:bg-red-600 transition shadow-lg shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-20 text-center">
                        <div class="h-24 w-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Petualangan</h4>
                        <p class="text-gray-500 mb-8 max-w-sm mx-auto font-medium">Anda belum pernah menyewa mobil. Cari moda transportasi terbaik Anda sekarang.</p>
                        <a href="{{ route('landing.vehicles') }}" class="px-10 py-4 top-0 bg-red-600 text-white rounded-2xl font-bold shadow-lg hover:shadow-xl transition hover:-translate-y-1 block max-w-max mx-auto">Mulai Petualangan</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
