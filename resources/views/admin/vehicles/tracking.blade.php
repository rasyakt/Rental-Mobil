@extends('layouts.admin')

@section('title', 'Riwayat Kendaraan - Admin Panel')
@section('header_title', 'Riwayat & Pelacakan Kendaraan')

@section('admin_content')
<div class="max-w-7xl mx-auto space-y-8">
    <div class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center gap-6">
            <div class="h-20 w-32 rounded-lg bg-gray-100 overflow-hidden shadow-inner">
                @if($vehicle->images->count() > 0)
                    <img src="{{ Storage::url($vehicle->images->first()->path) }}" alt="{{ $vehicle->brand }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">No Image</div>
                @endif
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h2>
                <div class="flex items-center gap-3 mt-1">
                    <span class="font-mono text-gray-500 font-bold tracking-widest uppercase">{{ $vehicle->plate_number }}</span>
                    <span class="badge-{{ $vehicle->status === 'available' ? 'success' : ($vehicle->status === 'rented' ? 'warning' : 'danger') }}">{{ ucfirst($vehicle->status) }}</span>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.vehicles.show', $vehicle->id) }}" class="px-6 py-2 bg-gray-50 text-gray-600 font-bold rounded-xl hover:bg-gray-100 transition border border-gray-200">
            Kembali ke Detail
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Rental History -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-900">Riwayat Penyewaan</h3>
            </div>
            <div class="p-0 overflow-y-auto max-h-[500px]">
                <ul class="divide-y divide-gray-50">
                    @forelse($bookings as $booking)
                    <li class="p-6 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start mb-2">
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="font-bold text-red-600 hover:underline">#{{ $booking->booking_number }}</a>
                            <span class="badge-{{ $booking->status === 'completed' ? 'success' : ($booking->status === 'confirmed' ? 'warning' : 'danger') }}">{{ ucfirst($booking->status) }}</span>
                        </div>
                        <div class="text-sm font-bold text-gray-900">{{ $booking->customer->user->name }}</div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $booking->pickup_date->format('d M') }} - {{ $booking->return_date->format('d M Y') }}
                        </div>
                        @if($booking->with_driver && $booking->driver)
                            <div class="mt-2 text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded inline-block">Dengan Sopir: {{ $booking->driver->name }}</div>
                        @endif
                    </li>
                    @empty
                    <li class="p-6 text-center text-gray-500 italic">Belum ada riwayat penyewaan.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Maintenance History -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-900">Riwayat Pemeliharaan</h3>
            </div>
            <div class="p-0 overflow-y-auto max-h-[500px]">
                <ul class="divide-y divide-gray-50">
                    @forelse($maintenance as $maint)
                    <li class="p-6 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start mb-2">
                            <a href="{{ route('admin.maintenance.show', $maint->id) }}" class="font-bold text-red-600 hover:underline uppercase">{{ $maint->maintenance_type }}</a>
                            <span class="badge-{{ $maint->status === 'completed' ? 'success' : ($maint->status === 'in_progress' ? 'warning' : 'danger') }}">{{ ucfirst($maint->status) }}</span>
                        </div>
                        <div class="text-sm font-bold text-gray-900">{{ $maint->start_date->format('d M Y') }}</div>
                        <div class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $maint->description ?: 'Tidak ada deskripsi rinci.' }}</div>
                        <div class="mt-3 flex justify-between items-center text-xs">
                            <span class="font-mono text-gray-400">{{ number_format($maint->odometer, 0, ',', '.') }} KM</span>
                            <span class="font-bold text-gray-900">Rp {{ number_format($maint->cost, 0, ',', '.') }}</span>
                        </div>
                    </li>
                    @empty
                    <li class="p-6 text-center text-gray-500 italic">Belum ada riwayat pemeliharaan.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
