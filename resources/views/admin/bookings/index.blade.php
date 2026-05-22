@extends('layouts.admin')

@section('title', 'Kelola Booking - Admin')
@section('header_title', 'Bookings')

@section('admin_content')
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Kelola Booking</h1>
                <p class="text-sm text-slate-500 font-medium">Daftar semua permintaan dan status sewa kendaraan pelanggan.</p>
            </div>
        </div>

        <!-- Bookings Table Container -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-400">No. Booking</th>
                            <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-400">Pelanggan</th>
                            <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-400">Kendaraan</th>
                            <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-400">Jadwal Sewa</th>
                            <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-400">Total Harga</th>
                            <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-400">Status</th>
                            <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-400 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-slate-50/40 transition duration-200">
                                <!-- Booking Number -->
                                <td class="px-6 py-4.5">
                                    <span class="px-2.5 py-1 bg-red-50 text-red-600 rounded-md text-xs font-mono font-bold tracking-wider uppercase border border-red-100/50">
                                        #{{ $booking->booking_number }}
                                    </span>
                                </td>
                                
                                <!-- Customer details -->
                                <td class="px-6 py-4.5">
                                    <div class="text-slate-800 font-bold text-sm">{{ $booking->customer->user->name }}</div>
                                    <div class="text-slate-400 text-xs font-medium mt-0.5">{{ $booking->customer->user->email }}</div>
                                </td>
                                
                                <!-- Vehicle details -->
                                <td class="px-6 py-4.5">
                                    <div class="text-slate-700 font-bold text-xs uppercase">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold tracking-wider mt-0.5">{{ $booking->vehicle->plat_number }}</div>
                                </td>
                                
                                <!-- Date range schedule -->
                                <td class="px-6 py-4.5">
                                    <div class="text-slate-700 font-bold text-xs">{{ $booking->pickup_date->format('d M Y') }} - {{ $booking->return_date->format('d M Y') }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold mt-0.5 flex items-center gap-1">
                                        <i class="fa-regular fa-clock text-[9px]"></i>
                                        <span>{{ $booking->pickup_date->diffInDays($booking->return_date) }} Hari</span>
                                    </div>
                                </td>
                                
                                <!-- Price Daily -->
                                <td class="px-6 py-4.5 font-bold text-slate-900">
                                    Rp {{ number_format($booking->final_price, 0, ',', '.') }}
                                </td>
                                
                                <!-- Status badge -->
                                <td class="px-6 py-4.5">
                                    @if($booking->status === 'pending')
                                        <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-[10px] font-bold uppercase tracking-wider rounded-md border border-amber-100">Menunggu</span>
                                    @elseif($booking->status === 'confirmed')
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider rounded-md border border-emerald-100">Dikonfirmasi</span>
                                    @elseif($booking->status === 'active')
                                        <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold uppercase tracking-wider rounded-md border border-blue-100">Dalam Sewa</span>
                                    @elseif($booking->status === 'completed')
                                        <span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-[10px] font-bold uppercase tracking-wider rounded-md border border-slate-200">Selesai</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-rose-50 text-rose-700 text-[10px] font-bold uppercase tracking-wider rounded-md border border-rose-100">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </td>
                                
                                <!-- Action links -->
                                <td class="px-6 py-4.5 text-right">
                                    <div class="relative inline-block text-left" x-data="{ open: false, openUpwards: false }" @click.away="open = false">
                                        <button @click="open = !open; if(open) { $nextTick(() => { const rect = $el.getBoundingClientRect(); const viewportSpace = window.innerHeight - rect.bottom; const container = $el.closest('.overflow-x-auto') || $el.closest('table'); const containerRect = container ? container.getBoundingClientRect() : null; const containerSpace = containerRect ? (containerRect.bottom - rect.bottom) : 999; openUpwards = viewportSpace < 180 || containerSpace < 180; }) }" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-900 hover:bg-slate-100 flex items-center justify-center transition outline-none cursor-pointer">
                                            <i class="fa-solid fa-ellipsis-vertical text-sm"></i>
                                        </button>
                                        <div x-show="open" 
                                             x-transition:enter="transition ease-out duration-100" 
                                             x-transition:enter-start="transform opacity-0 scale-95" 
                                             x-transition:enter-end="transform opacity-100 scale-100" 
                                             x-transition:leave="transition ease-in duration-75" 
                                             x-transition:leave-start="transform opacity-100 scale-100" 
                                             x-transition:leave-end="transform opacity-0 scale-95" 
                                             :class="openUpwards ? 'bottom-full mb-1.5' : 'top-full mt-1.5'"
                                             class="absolute right-0 w-40 rounded-xl bg-white border border-slate-100 shadow-lg py-1.5 z-50 text-left"
                                             style="display: none;">
                                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                                                <i class="fa-solid fa-eye w-4 text-center text-slate-400"></i>
                                                <span>Detail Booking</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-400 font-medium">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <div class="w-12 h-12 rounded-full bg-slate-50 text-slate-300 flex items-center justify-center text-xl">
                                            <i class="fa-solid fa-receipt"></i>
                                        </div>
                                        <p class="text-sm">Belum ada transaksi sewa mobil masuk.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection
