@extends('layouts.admin')

@section('title', 'Edit Kendaraan - Admin')
@section('header_title', 'Edit Kendaraan')

@section('admin_content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Edit Kendaraan</h2>
            <p class="text-gray-500 mt-1">Ubah informasi unit kendaraan <strong>{{ $vehicle->brand }} {{ $vehicle->model }}</strong>.</p>
        </div>

        <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-2 text-gray-900">
                    <span class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-sm">1</span>
                    Informasi Dasar
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Merk Kendaraan</label>
                        <input type="text" name="brand" value="{{ old('brand', $vehicle->brand) }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Model / Tipe</label>
                        <input type="text" name="model" value="{{ old('model', $vehicle->model) }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="category_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $vehicle->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cabang Lokasi</label>
                        <select name="branch_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ $vehicle->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Plat Nomor</label>
                        <input type="text" name="plat_number" value="{{ old('plat_number', $vehicle->plat_number) }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none uppercase">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                        <input type="number" name="year" value="{{ old('year', $vehicle->year) }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-2 text-gray-900">
                    <span class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-sm">2</span>
                    Spesifikasi & Teknis
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Warna</label>
                        <input type="text" name="color" value="{{ old('color', $vehicle->color) }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kapasitas</label>
                        <input type="number" name="seat_capacity" value="{{ old('seat_capacity', $vehicle->seat_capacity) }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Transmisi</label>
                        <select name="transmission" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                            <option value="automatic" {{ $vehicle->transmission == 'automatic' ? 'selected' : '' }}>Automatic</option>
                            <option value="manual" {{ $vehicle->transmission == 'manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bahan Bakar</label>
                        <input type="text" name="fuel_type" value="{{ old('fuel_type', $vehicle->fuel_type) }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total KM</label>
                        <input type="number" name="total_km" value="{{ old('total_km', $vehicle->total_km) }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Unit</label>
                        <select name="status" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none font-bold {{ $vehicle->status == 'available' ? 'text-green-600' : ($vehicle->status == 'rented' ? 'text-yellow-600' : 'text-red-600') }}">
                            <option value="available" {{ $vehicle->status == 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="maintenance" {{ $vehicle->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="rented" {{ $vehicle->status == 'rented' ? 'selected' : '' }}>Sedang Disewa</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-2 text-gray-900">
                    <span class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-sm">3</span>
                    Informasi Harga (Rp)
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Sewa Harian</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2 text-gray-400">Rp</span>
                            <input type="number" name="price_daily" value="{{ old('price_daily', (int)$vehicle->price_daily) }}" required class="w-full pl-12 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none font-semibold">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sewa Sopir Harian</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2 text-gray-400">Rp</span>
                            <input type="number" name="price_driver_daily" value="{{ old('price_driver_daily', (int)$vehicle->price_driver_daily) }}" class="w-full pl-12 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.vehicles.index') }}" class="btn-secondary rounded-lg px-8">Batal</a>
                <button type="submit" class="btn-primary rounded-lg px-12">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
