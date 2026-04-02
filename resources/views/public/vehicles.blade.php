@extends('layout')

@section('title', 'Daftar Kendaraan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-red-600">Rental Mobil</h1>
                <a href="/" class="text-red-600 hover:text-red-700">← Kembali</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold mb-8">Daftar Kendaraan</h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <input type="text" placeholder="Cari mobil..." class="px-4 py-2 border rounded-lg">
            <select class="px-4 py-2 border rounded-lg">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <button class="btn-primary">Cari</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($vehicles as $vehicle)
                <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover">
                    <img src="https://via.placeholder.com/300x200" alt="{{ $vehicle->brand }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-lg">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                        <p class="text-gray-500 text-sm mb-3">{{ $vehicle->category->name }} • {{ $vehicle->year }}</p>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600">🪑 {{ $vehicle->seat_capacity }} penumpang</span>
                            <span class="text-sm text-gray-600">⚙️ {{ ucfirst($vehicle->transmission) }}</span>
                        </div>
                        <div class="border-t pt-3 mt-3">
                            <p class="text-red-600 font-bold mb-3">Rp {{ number_format($vehicle->price_daily, 0, ',', '.') }}/hari</p>
                            <a href="{{ route('landing.vehicle.detail', $vehicle->id) }}" class="btn-primary block text-center text-sm">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">Tidak ada kendaraan tersedia</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $vehicles->links() }}
        </div>
    </div>
</div>
@endsection
