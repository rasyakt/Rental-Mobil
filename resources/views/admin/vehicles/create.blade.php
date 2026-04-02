@extends('layouts.admin')

@section('title', 'Tambah Kendaraan Baru - Admin')
@section('header_title', 'Tambah Kendaraan')

@section('admin_content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Tambah Kendaraan</h2>
            <p class="text-gray-500 mt-1">Lengkapi informasi di bawah untuk menambahkan unit kendaraan baru.</p>
        </div>

        <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-sm">1</span>
                    Informasi Dasar
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Merk Kendaraan</label>
                        <input type="text" name="brand" required placeholder="Contoh: Toyota" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Model / Tipe</label>
                        <input type="text" name="model" required placeholder="Contoh: Avanza Veloz" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="category_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cabang Lokasi</label>
                        <select name="branch_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                            <option value="">Pilih Cabang</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Plat Nomor</label>
                        <input type="text" name="plat_number" required placeholder="Contoh: B 1234 ABC" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none uppercase">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                        <input type="number" name="year" required placeholder="2023" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-sm">2</span>
                    Spesifikasi & Teknis
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Warna</label>
                        <input type="text" name="color" required placeholder="Hitam" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kapasitas Penumpang</label>
                        <input type="number" name="seat_capacity" required placeholder="7" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Transmisi</label>
                        <select name="transmission" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                            <option value="automatic">Automatic</option>
                            <option value="manual">Manual</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bahan Bakar</label>
                        <input type="text" name="fuel_type" required placeholder="Pertalite / Diesel" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total KM (ODO)</label>
                        <input type="number" name="total_km" required value="0" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Unit</label>
                        <select name="status" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                            <option value="available">Tersedia</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="rented">Sedang Disewa</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-sm">3</span>
                    Informasi Harga (Rp)
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Sewa Harian</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2 text-gray-400">Rp</span>
                            <input type="number" name="price_daily" required placeholder="350000" class="w-full pl-12 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sewa Sopir Harian (Opsional)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2 text-gray-400">Rp</span>
                            <input type="number" name="price_driver_daily" value="0" class="w-full pl-12 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Sewa Mingguan</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2 text-gray-400">Rp</span>
                            <input type="number" name="price_weekly" value="0" class="w-full pl-12 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.vehicles.index') }}" class="btn-secondary rounded-lg px-8">Batal</a>
                <button type="submit" class="btn-primary rounded-lg px-12">Simpan Unit</button>
            </div>
        </form>
    </div>
@endsection
