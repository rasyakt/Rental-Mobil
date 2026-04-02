@extends('layout')

@section('title', 'Riwayat Pesanan - Rental Mobil')

@section('content')
<div class="min-h-screen bg-gray-50 pb-12">
    <!-- Navbar Customer -->
    <nav class="bg-white shadow-sm mb-8 border-b border-gray-100 italic normal-case tracking-normal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-6">
                    <a href="/" class="text-2xl font-black text-red-600 tracking-tighter uppercase">RENTAL MOBIL</a>
                    <div class="hidden md:flex items-center gap-4 text-sm font-bold text-gray-400">
                        <a href="{{ route('customer.dashboard') }}" class="hover:text-red-600 transition">Beranda</a>
                        <a href="{{ route('customer.bookings.index') }}" class="text-red-600">Pesanan Saya</a>
                        <a href="{{ route('customer.profile.edit') }}" class="hover:text-red-600 transition">Profil</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-black text-gray-900 uppercase">Riwayat Perjalanan</h2>
                <p class="text-gray-500 mt-1 lowercase font-bold normal-case italic tracking-normal">Daftar lengkap seluruh pesanan rental mobil Anda.</p>
            </div>
            <a href="{{ route('landing.vehicles') }}" class="btn-primary flex items-center gap-2 italic uppercase">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Booking Baru
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-8 py-4 text-xs font-black text-gray-500 uppercase tracking-widest italic">KENDARAAN & No. BOOKING</th>
                            <th class="px-8 py-4 text-xs font-black text-gray-500 uppercase tracking-widest italic">JADWAL</th>
                            <th class="px-8 py-4 text-xs font-black text-gray-500 uppercase tracking-widest italic">TOTAL BIAYA</th>
                            <th class="px-8 py-4 text-xs font-black text-gray-500 uppercase tracking-widest italic">STATUS</th>
                            <th class="px-8 py-4 text-xs font-black text-gray-500 uppercase tracking-widest italic text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 normal-case tracking-normal">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50 transition group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="h-12 w-16 bg-gray-100 rounded-xl overflow-hidden shrink-0">
                                            @if($booking->vehicle->images->count() > 0)
                                                <img src="{{ Storage::url($booking->vehicle->images->first()->path) }}" alt="{{ $booking->vehicle->model }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-black text-gray-900 italic uppercase">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</div>
                                            <div class="text-xs text-red-600 font-bold uppercase tracking-tighter">#{{ $booking->booking_number }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm font-bold text-gray-900 italic uppercase">
                                        {{ $booking->pickup_date->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-gray-400 font-bold lowercase italic">
                                        {{ $booking->getDurationDays() }} HARI
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-lg font-black text-gray-900 italic">Rp {{ number_format($booking->final_price, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    @if($booking->status === 'confirmed')
                                        <span class="badge-success italic text-[10px] uppercase font-black tracking-widest">DIKONFIRMASI</span>
                                    @elseif($booking->status === 'pending')
                                        <span class="badge-warning italic text-[10px] uppercase font-black tracking-widest">PENDING</span>
                                    @elseif($booking->status === 'active')
                                        <span class="badge-success bg-red-600 text-white italic text-[10px] uppercase font-black tracking-widest shadow-sm">BERJALAN</span>
                                    @elseif($booking->status === 'completed')
                                        <span class="badge-success bg-gray-900 text-white italic text-[10px] uppercase font-black tracking-widest">SELESAI</span>
                                    @else
                                        <span class="badge-danger italic text-[10px] uppercase font-black tracking-widest">{{ $booking->status }}</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <a href="{{ route('customer.bookings.show', $booking->id) }}" class="inline-flex items-center gap-2 p-3 bg-white border border-gray-100 rounded-2xl hover:bg-red-600 hover:text-white transition shadow-sm font-black italic uppercase text-xs">
                                        DETAIL
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="h-20 w-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <h4 class="text-xl font-black text-gray-900 italic uppercase">Riwayat Kosong</h4>
                                        <p class="text-gray-400 font-bold lowercase italic text-sm mt-1 max-w-xs mx-auto">Anda belum pernah melakukan pemesanan kendaraan bersama kami.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6 font-black italic">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection
