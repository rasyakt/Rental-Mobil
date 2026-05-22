@extends('layouts.admin')

@section('title', 'Admin Dashboard - Rental Mobil')
@section('header_title', 'Dashboard Overview')

@section('admin_content')
    <div class="max-w-7xl mx-auto space-y-8">
        
        <!-- Welcome banner or notice if any -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Selamat Datang, {{ auth()->user()->name }}</h1>
                <p class="text-sm text-slate-500 font-medium">Berikut adalah overview operasional rental mobil hari ini.</p>
            </div>
            <div class="text-xs font-bold text-slate-400 bg-white border border-slate-100 rounded-xl px-4 py-2.5 shadow-xs">
                <i class="fa-solid fa-clock text-slate-400 mr-1.5"></i> {{ date('d M Y, H:i') }} WIB
            </div>
        </div>

        <!-- Operational Statistics Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Revenue -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Total Pendapatan</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i class="fa-solid fa-money-bill-wave text-sm"></i>
                    </div>
                </div>
                <div class="text-2xl font-extrabold text-slate-900 tracking-tight">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                <div class="mt-3 flex items-center gap-1 text-[11px] font-bold text-emerald-600">
                    <i class="fa-solid fa-arrow-up-right"></i>
                    <span>+12% Bulan Ini</span>
                </div>
            </div>

            <!-- Active Bookings -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Sewa Aktif</span>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class="fa-solid fa-route text-sm animate-pulse"></i>
                    </div>
                </div>
                <div class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $stats['active_bookings'] }}</div>
                <div class="mt-3 flex items-center gap-1.5 text-[11px] font-bold text-blue-600">
                    <span class="h-2 w-2 bg-blue-600 rounded-full animate-ping"></span>
                    <span>Dalam Perjalanan</span>
                </div>
            </div>

            <!-- Available Fleet -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Armada Tersedia</span>
                    <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                        <i class="fa-solid fa-car text-sm"></i>
                    </div>
                </div>
                <div class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $stats['available_vehicles'] }}</div>
                <div class="mt-3 text-[11px] font-bold text-slate-400">
                    Total Armada: {{ $stats['total_vehicles'] }} unit
                </div>
            </div>

            <!-- Pending Bookings -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Menunggu Konfirmasi</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                        <i class="fa-solid fa-bell text-sm"></i>
                    </div>
                </div>
                <div class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $stats['pending_bookings'] }}</div>
                <div class="mt-3 text-[11px] font-bold text-amber-600 flex items-center gap-1">
                    <i class="fa-solid fa-hourglass-half text-[10px]"></i>
                    <span>Perlu Tindakan Cepat</span>
                </div>
            </div>
        </div>

        <!-- Detailed Workspace Layout Split -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Side: Recent Bookings Activity Table -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-8 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Aktivitas Booking Terbaru</h3>
                        <a href="{{ route('admin.bookings.index') }}" class="text-xs font-bold text-red-600 hover:text-red-700 hover:underline flex items-center gap-1">
                            <span>Lihat Semua</span> <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100">
                                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">ID Booking</th>
                                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Pelanggan</th>
                                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Kendaraan</th>
                                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                                @forelse($recentBookings as $booking)
                                    <tr class="hover:bg-slate-50/40 transition">
                                        <td class="px-8 py-4.5 font-mono text-xs font-bold text-red-600">
                                            #{{ $booking->booking_number }}
                                        </td>
                                        <td class="px-8 py-4.5">
                                            <div class="text-slate-800 font-bold text-sm">{{ $booking->customer->user->name }}</div>
                                            <div class="text-slate-400 text-xs font-medium">{{ $booking->customer->user->email }}</div>
                                        </td>
                                        <td class="px-8 py-4.5">
                                            <div class="text-slate-700 font-bold text-xs uppercase">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</div>
                                            <div class="text-[10px] text-slate-400 font-bold tracking-wider mt-0.5">{{ $booking->vehicle->plat_number }}</div>
                                        </td>
                                        <td class="px-8 py-4.5">
                                            @if($booking->status === 'confirmed')
                                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider rounded-md border border-emerald-100">Diterima</span>
                                            @elseif($booking->status === 'pending')
                                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-[10px] font-bold uppercase tracking-wider rounded-md border border-amber-100">Menunggu</span>
                                            @else
                                                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-[10px] font-bold uppercase tracking-wider rounded-md">{{ $booking->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-10 text-center text-slate-400 font-medium"> Belum ada data pemesanan masuk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Side: Fast Admin Actions & Top Fleet Statistics -->
            <div class="space-y-6">
                <!-- Actions Grid Panel -->
                <div class="bg-slate-900 rounded-2xl p-6 shadow-md relative overflow-hidden group">
                    <div class="relative z-10">
                        <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-6">Pintasan Admin</h3>
                        <div class="grid grid-cols-2 gap-3.5">
                            <a href="{{ route('admin.vehicles.create') }}" class="p-4 bg-white/5 rounded-xl hover:bg-red-600/95 transition duration-200 text-center group/btn shadow-inner border border-white/5 flex flex-col items-center justify-center gap-2">
                                <i class="fa-solid fa-car text-white text-base"></i>
                                <span class="text-white font-bold text-xs">Tambah Mobil</span>
                            </a>
                            <a href="{{ route('admin.drivers.create') }}" class="p-4 bg-white/5 rounded-xl hover:bg-red-600/95 transition duration-200 text-center group/btn shadow-inner border border-white/5 flex flex-col items-center justify-center gap-2">
                                <i class="fa-solid fa-user-tie text-white text-base"></i>
                                <span class="text-white font-bold text-xs">Tambah Sopir</span>
                            </a>
                            <a href="{{ route('admin.users.create') }}" class="p-4 bg-white/5 rounded-xl hover:bg-red-600/95 transition duration-200 text-center group/btn shadow-inner border border-white/5 flex flex-col items-center justify-center gap-2">
                                <i class="fa-solid fa-user-gear text-white text-base"></i>
                                <span class="text-white font-bold text-xs">Tambah User</span>
                            </a>
                            <a href="{{ route('admin.reports.index') }}" class="p-4 bg-white/5 rounded-xl hover:bg-red-600/95 transition duration-200 text-center group/btn shadow-inner border border-white/5 flex flex-col items-center justify-center gap-2">
                                <i class="fa-solid fa-file-invoice-dollar text-white text-base"></i>
                                <span class="text-white font-bold text-xs">Laporan Log</span>
                            </a>
                        </div>
                    </div>
                    <!-- Decorative back glow circle -->
                    <div class="absolute -bottom-20 -right-20 h-52 w-52 bg-red-600 rounded-full blur-[90px] opacity-10 group-hover:opacity-20 transition duration-500"></div>
                </div>

                <!-- Top Fleet Statistics List -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-6">Armada Terlaris</h3>
                    <div class="space-y-4.5">
                        @forelse($topVehicles as $item)
                            <div class="flex items-center gap-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-red-500 shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-bold text-slate-800 truncate uppercase">{{ $item->vehicle->brand }} {{ $item->vehicle->model }}</div>
                                    <div class="text-[10px] font-bold text-slate-400 mt-0.5">{{ $item->total }} Pemesanan</div>
                                </div>
                                <div class="text-xs font-bold text-slate-700 bg-slate-50 border border-slate-100 rounded-md px-2 py-0.5">
                                    {{ number_format(($item->total / max($stats['total_bookings'], 1)) * 100, 0) }}%
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 font-medium py-2">Belum ada statistik armada terlaris.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
