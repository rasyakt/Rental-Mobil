@extends('layouts.admin')

@section('title', 'Admin Dashboard - Rental Mobil')
@section('header_title', 'Dashboard Overview')

@section('admin_content')
    <div class="max-w-7xl mx-auto">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 group hover:border-red-600 transition duration-300">
                <div class="text-xs font-black text-gray-400 uppercase tracking-[0.3em] mb-4 italic">Total Revenue</div>
                <div class="text-3xl font-black text-gray-900 italic">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                <div class="mt-4 flex items-center gap-2 text-xs font-black text-green-600 italic uppercase">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                    </svg>
                    +12% vs last month
                </div>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 group hover:border-red-600 transition duration-300">
                <div class="text-xs font-black text-gray-400 uppercase tracking-[0.3em] mb-4 italic">Live Bookings</div>
                <div class="text-3xl font-black text-gray-900 italic">{{ $stats['active_bookings'] }}</div>
                <div class="mt-4 flex items-center gap-2 text-xs font-black text-red-600 italic uppercase">
                    <span class="h-2 w-2 bg-red-600 rounded-full animate-pulse"></span>
                    Currently On-Road
                </div>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 group hover:border-red-600 transition duration-300">
                <div class="text-xs font-black text-gray-400 uppercase tracking-[0.3em] mb-4 italic">Available Fleet</div>
                <div class="text-3xl font-black text-gray-900 italic">{{ $stats['available_vehicles'] }}</div>
                <div class="mt-4 text-xs font-black text-gray-400 italic uppercase">
                    Total: {{ $stats['total_vehicles'] }} Vehicles
                </div>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 group hover:border-red-600 transition duration-300">
                <div class="text-xs font-black text-gray-400 uppercase tracking-[0.3em] mb-4 italic">Pending Task</div>
                <div class="text-3xl font-black text-gray-900 italic">{{ $stats['pending_bookings'] }}</div>
                <div class="mt-4 text-xs font-black text-yellow-600 italic uppercase">
                    Awaiting Confirmation
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Recent Activity Table -->
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="text-xl font-black text-gray-900 italic uppercase tracking-tighter">Recent Activities</h3>
                        <a href="{{ route('admin.bookings.index') }}" class="text-xs font-black text-red-600 uppercase tracking-widest italic hover:underline">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 font-black italic uppercase text-xs text-gray-500 tracking-widest italic">
                                <tr>
                                    <th class="px-10 py-5">Booking ID</th>
                                    <th class="px-10 py-5">Customer</th>
                                    <th class="px-10 py-5">Vehicle</th>
                                    <th class="px-10 py-5">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 normal-case tracking-normal not-italic font-medium text-sm">
                                @forelse($recentBookings as $booking)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-10 py-6 font-black italic uppercase text-red-600">#{{ $booking->booking_number }}</td>
                                        <td class="px-10 py-6 font-bold text-gray-900 italic uppercase">{{ $booking->customer->user->name }}</td>
                                        <td class="px-10 py-6 text-gray-500 font-bold italic uppercase">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</td>
                                        <td class="px-10 py-6">
                                            @if($booking->status === 'confirmed')
                                                <span class="badge-success italic text-[10px] uppercase font-black tracking-widest">OK</span>
                                            @elseif($booking->status === 'pending')
                                                <span class="badge-warning italic text-[10px] uppercase font-black tracking-widest">WAIT</span>
                                            @else
                                                <span class="bg-gray-900 text-white italic text-[10px] uppercase font-black px-3 py-1 rounded-lg tracking-widest">{{ $booking->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-10 py-12 text-center text-gray-400 italic font-bold">No active bookings yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quick Actions / Top Vehicles -->
            <div class="space-y-10">
                <div class="bg-gray-900 rounded-[2.5rem] p-10 shadow-xl relative overflow-hidden group">
                    <div class="relative z-10">
                        <h3 class="text-xl font-black text-white italic uppercase tracking-tighter mb-8">Admin Tools</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('admin.vehicles.create') }}" class="p-6 bg-white/5 rounded-3xl hover:bg-red-600 transition text-center group/btn shadow-inner">
                                <div class="text-white font-black italic uppercase text-xs tracking-widest">Add Car</div>
                            </a>
                            <a href="{{ route('admin.drivers.create') }}" class="p-6 bg-white/5 rounded-3xl hover:bg-red-600 transition text-center group/btn shadow-inner">
                                <div class="text-white font-black italic uppercase text-xs tracking-widest">Add Driver</div>
                            </a>
                            <a href="{{ route('admin.users.create') }}" class="p-6 bg-white/5 rounded-3xl hover:bg-red-600 transition text-center group/btn shadow-inner">
                                <div class="text-white font-black italic uppercase text-xs tracking-widest">Add User</div>
                            </a>
                            <a href="{{ route('admin.reports.index') }}" class="p-6 bg-white/5 rounded-3xl hover:bg-red-600 transition text-center group/btn shadow-inner">
                                <div class="text-white font-black italic uppercase text-xs tracking-widest">Export Log</div>
                            </a>
                        </div>
                    </div>
                    <!-- Decorative circle -->
                    <div class="absolute -bottom-20 -right-20 h-64 w-64 bg-red-600 rounded-full blur-[100px] opacity-10 group-hover:opacity-30 transition duration-500"></div>
                </div>

                <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100">
                    <h3 class="text-xl font-black text-gray-900 italic uppercase tracking-tighter mb-8">Top Fleet</h3>
                    <div class="space-y-6">
                        @foreach($topVehicles as $item)
                            <div class="flex items-center gap-4">
                                <div class="h-2 w-2 rounded-full bg-red-600"></div>
                                <div class="flex-1">
                                    <div class="text-sm font-black text-gray-900 italic uppercase">{{ $item->vehicle->brand }} {{ $item->vehicle->model }}</div>
                                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic">{{ $item->total }} Bookings</div>
                                </div>
                                <div class="text-xs font-black text-gray-900 italic">{{ number_format(($item->total / max($stats['total_bookings'], 1)) * 100, 0) }}%</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
