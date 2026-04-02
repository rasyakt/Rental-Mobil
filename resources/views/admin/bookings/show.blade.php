@extends('layouts.admin')

@section('title', 'Detail Pesanan - Admin')
@section('header_title', 'Detail Pesanan')

@section('admin_content')
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-start mb-8">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <h2 class="text-3xl font-bold text-gray-900">#{{ $booking->booking_number }}</h2>
                    <span class="badge-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'danger') }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
                <p class="text-gray-500 font-medium">Dipesan pada {{ $booking->created_at->format('d M Y, H:i') }}</p>
            </div>
            
            <div class="flex gap-3">
                @if($booking->status === 'pending')
                    <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-primary space-x-2">Konfirmasi Pesanan</button>
                    </form>
                    <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-3 border border-red-600 text-red-600 rounded-xl font-bold hover:bg-red-50 transition">Tolak</button>
                    </form>
                @endif
                <a href="{{ route('admin.bookings.invoice', $booking->id) }}" class="p-3 bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition flex items-center gap-2 px-6 shadow-sm font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 font-bold" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                    </svg>
                    Invoice
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Order Info -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Vehicle & Schedule Info -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 p-8">
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="w-full md:w-1/3 aspect-video rounded-xl bg-gray-100 overflow-hidden">
                            @if($booking->vehicle->images->count() > 0)
                                <img src="{{ Storage::url($booking->vehicle->images->first()->path) }}" alt="{{ $booking->vehicle->brand }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</h3>
                            <div class="flex items-center gap-2 mb-6">
                                <span class="badge-success">{{ $booking->vehicle->category->name }}</span>
                                <span class="text-gray-500 font-mono text-sm uppercase">{{ $booking->vehicle->plate_number }}</span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-8">
                                <div>
                                    <span class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1 block">Tgl Penjemputan</span>
                                    <span class="text-lg font-bold text-gray-900">{{ $booking->pickup_date->format('d M Y, H:i') }}</span>
                                    <span class="text-xs text-gray-500 block mt-1 line-clamp-1">{{ $booking->pickup_address }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1 block">Tgl Pengembalian</span>
                                    <span class="text-lg font-bold text-gray-900">{{ $booking->return_date->format('d M Y, H:i') }}</span>
                                    <span class="text-xs text-gray-500 block mt-1 line-clamp-1">{{ $booking->return_address }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Billing Breakdown -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 bg-gray-50 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900">Rincian Pembayaran</h3>
                    </div>
                    <div class="p-8 space-y-4">
                        <div class="flex justify-between text-gray-600">
                            <span>Sewa Kendaraan ({{ $booking->getDurationDays() }} Hari)</span>
                            <span class="font-medium">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                        @if($booking->with_driver)
                            <div class="flex justify-between text-gray-600">
                                <span>Layanan Sopir</span>
                                <span class="font-medium">Rp {{ number_format($booking->additional_charges, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-gray-600">
                            <span>Pajak & Biaya Layanan</span>
                            <span class="font-medium">Rp {{ number_format($booking->tax, 0, ',', '.') }}</span>
                        </div>
                        <div class="pt-6 border-t border-gray-100 flex justify-between items-baseline">
                            <span class="text-lg font-bold text-gray-900">Total Akhir</span>
                            <span class="text-3xl font-extrabold text-red-600">Rp {{ number_format($booking->final_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Secondary Info -->
            <div class="space-y-8">
                <!-- Customer Profile -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                    <h3 class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-6">Informasi Pelanggan</h3>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="h-12 w-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center font-bold text-xl uppercase">
                            {{ substr($booking->customer->user->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-gray-900 text-lg">{{ $booking->customer->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $booking->customer->user->email }}</div>
                        </div>
                    </div>
                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Telepon</span>
                            <span class="font-bold text-gray-900">{{ $booking->customer->phone }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">No. ID (KTP)</span>
                            <span class="font-bold text-gray-900">{{ $booking->customer->id_number ?: 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Assignment Info -->
                @if($booking->with_driver)
                    <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                        <h3 class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-6">Penugasan Sopir</h3>
                        @if($booking->driver_id)
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 rounded-full bg-gray-100 overflow-hidden">
                                    @if($booking->driver->photo_path)
                                        <img src="{{ Storage::url($booking->driver->photo_path) }}" alt="{{ $booking->driver->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">{{ $booking->driver->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->driver->phone }}</div>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center py-4">
                                <p class="text-sm text-gray-500 mb-4">Sopir belum ditugaskan</p>
                                <button class="w-full py-3 bg-gray-900 text-white rounded-xl font-bold text-sm tracking-wide">Tugaskan Sopir</button>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
