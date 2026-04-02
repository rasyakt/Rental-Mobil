@extends('layouts.admin')

@section('title', 'Detail Kendaraan - Admin')
@section('header_title', 'Detail Kendaraan')

@section('admin_content')
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h2>
                <div class="flex items-center gap-3 mt-1">
                    <span class="badge-success">{{ $vehicle->category->name }}</span>
                    <span class="text-gray-500">•</span>
                    <span class="text-gray-500 font-mono text-sm uppercase">{{ $vehicle->plate_number }}</span>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="p-2 bg-white border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 transition flex items-center gap-2 px-4 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Edit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Media & Specs -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Image Gallery Placeholder -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="aspect-video bg-gray-100 flex items-center justify-center relative">
                        @if($vehicle->images->count() > 0)
                            <img src="{{ Storage::url($vehicle->images->first()->path) }}" alt="{{ $vehicle->model }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex flex-col items-center text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="font-medium mt-2">Gambar Tidak Tersedia</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Detailed Specs -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Spesifikasi Detail</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <span class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1 block">Tahun</span>
                            <span class="text-lg font-bold text-gray-900">{{ $vehicle->year }}</span>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <span class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1 block">Transmisi</span>
                            <span class="text-lg font-bold text-gray-900">{{ ucfirst($vehicle->transmission) }}</span>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <span class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1 block">Bahan Bakar</span>
                            <span class="text-lg font-bold text-gray-900">{{ ucfirst($vehicle->fuel_type) }}</span>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <span class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1 block">Kapasitas</span>
                            <span class="text-lg font-bold text-gray-900">{{ $vehicle->seats }} Baris / Kursi</span>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <span class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1 block">Warna</span>
                            <span class="text-lg font-bold text-gray-900">{{ ucfirst($vehicle->color) }}</span>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <span class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1 block">Lokasi</span>
                            <span class="text-lg font-bold text-gray-900">{{ $vehicle->branch->name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Stats & Quick Actions -->
            <div class="space-y-8">
                <!-- Pricing Card -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4">
                        @if($vehicle->status === 'available')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">Tersedia</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 uppercase">{{ $vehicle->status }}</span>
                        @endif
                    </div>
                    <h3 class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-4">Harga Sewa</h3>
                    <div class="flex items-baseline gap-2 mb-8">
                        <span class="text-4xl font-extrabold text-red-600">Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}</span>
                        <span class="text-gray-500 font-medium">/hari</span>
                    </div>

                    <div class="space-y-4 pt-6 border-t border-gray-100">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Terakhir diservis</span>
                            <span class="font-bold text-gray-900">{{ $vehicle->last_service_date ? $vehicle->last_service_date->format('d M Y') : 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Target servis berikutnya</span>
                            <span class="font-bold text-gray-900">{{ $vehicle->next_service_date ? $vehicle->next_service_date->format('d M Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Stats Overview -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Performa Unit</h3>
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600 font-medium">Okupansi Bulan Ini</span>
                                <span class="text-gray-900 font-bold">85%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-red-500 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 p-4 rounded-xl">
                            <span class="text-sm font-medium text-gray-600">Total Booking</span>
                            <span class="text-2xl font-bold text-gray-900">124</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
