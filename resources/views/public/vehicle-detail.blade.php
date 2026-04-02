@extends('layout')

@section('title', 'Detail Kendaraan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-red-600">Rental Mobil</h1>
                <a href="{{ route('landing.vehicles') }}" class="text-red-600 hover:text-red-700">← Kembali</a>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">
                <div class="md:w-1/2">
                    <img src="https://via.placeholder.com/400x350" alt="{{ $vehicle->brand }}" class="w-full h-96 object-cover">
                </div>
                <div class="p-8 md:w-1/2">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $vehicle->brand }} {{ $vehicle->model }}</h1>
                    <div class="flex items-center gap-4 mb-6">
                        <span class="text-lg text-gray-600">{{ $vehicle->year }}</span>
                        <span class="badge-success">{{ $vehicle->category->name }}</span>
                    </div>

                    <div class="mb-6">
                        <p class="text-red-600 text-4xl font-bold mb-2">Rp {{ number_format($vehicle->price_daily, 0, ',', '.') }}/hari</p>
                        <p class="text-gray-600">Rp {{ number_format($vehicle->price_weekly, 0, ',', '.') }}/minggu | Rp {{ number_format($vehicle->price_monthly, 0, ',', '.') }}/bulan</p>
                    </div>

                    <div class="border-t border-b py-6 mb-6">
                        <h3 class="font-bold text-lg mb-4">Spesifikasi</h3>
                        <ul class="space-y-2 text-gray-600">
                            <li>🪑 Kapasitas: {{ $vehicle->seat_capacity }} penumpang</li>
                            <li>⚙️ Transmisi: {{ ucfirst($vehicle->transmission) }}</li>
                            <li>⛽ Bahan Bakar: {{ ucfirst($vehicle->fuel_type) }}</li>
                            <li>🎨 Warna: {{ $vehicle->color }}</li>
                            <li>📍 Cabang: {{ $vehicle->branch->name }}</li>
                        </ul>
                    </div>

                    @auth
                        <a href="{{ route('customer.bookings.create') }}" class="btn-primary block text-center">Pesan Sekarang</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary block text-center">Masuk untuk Pesan</a>
                    @endauth
                </div>
            </div>

            @if($vehicle->features->isNotEmpty())
                <div class="px-8 py-6 border-t">
                    <h3 class="font-bold text-lg mb-4">Fasilitas</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($vehicle->features as $feature)
                            <div class="flex items-center">
                                <span class="text-2xl mr-2">✓</span>
                                <span>{{ $feature->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        @if($similarVehicles->isNotEmpty())
            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-6">Kendaraan Serupa</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($similarVehicles as $similar)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover">
                            <img src="https://via.placeholder.com/300x200" alt="{{ $similar->brand }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold">{{ $similar->brand }} {{ $similar->model }}</h3>
                                <p class="text-red-600 font-bold mt-2">Rp {{ number_format($similar->price_daily, 0, ',', '.') }}/hari</p>
                                <a href="{{ route('landing.vehicle.detail', $similar->id) }}" class="text-red-600 hover:text-red-700 mt-3 inline-block">Lihat Detail →</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
