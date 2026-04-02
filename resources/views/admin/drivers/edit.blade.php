@extends('layouts.admin')

@section('title', 'Edit Profil Sopir - Admin')
@section('header_title', 'Edit Profil Supir')

@section('admin_content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Edit Profil Sopir</h2>
            <p class="text-gray-500 mt-1">Sopir: {{ $driver->name }}</p>
        </div>

        <form action="{{ route('admin.drivers.update', $driver->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            
            <!-- Personal Info Section -->
            <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Personal</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="name" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="Contoh: Budi Santoso" value="{{ old('name', $driver->name) }}">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                        <input type="email" name="email" id="email" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="budi@email.com" value="{{ old('email', $driver->email) }}">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="tel" name="phone" id="phone" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="081234567890" value="{{ old('phone', $driver->phone) }}">
                    </div>
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label>
                        <textarea name="address" id="address" rows="3" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="Jalan Raya No. 123...">{{ old('address', $driver->address) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Licensing Section -->
            <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Lisensi & Penugasan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="license_number" class="block text-sm font-bold text-gray-700 mb-2">Nomor SIM</label>
                        <input type="text" name="license_number" id="license_number" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition font-mono uppercase" placeholder="1234-5678-901234" value="{{ old('license_number', $driver->license_number) }}">
                    </div>
                    <div>
                        <label for="license_type" class="block text-sm font-bold text-gray-700 mb-2">Tipe SIM</label>
                        <select name="license_type" id="license_type" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition">
                            <option value="A" {{ $driver->license_type === 'A' ? 'selected' : '' }}>SIM A (Mobil Pribadi)</option>
                            <option value="B1" {{ $driver->license_type === 'B1' ? 'selected' : '' }}>SIM B1 (Bus/Truk Kecil)</option>
                            <option value="B2" {{ $driver->license_type === 'B2' ? 'selected' : '' }}>SIM B2 (Alat Berat)</option>
                        </select>
                    </div>
                    <div>
                        <label for="license_expiry_date" class="block text-sm font-bold text-gray-700 mb-2">Masa Berlaku SIM</label>
                        <input type="date" name="license_expiry_date" id="license_expiry_date" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" value="{{ old('license_expiry_date', $driver->license_expiry_date->format('Y-m-d')) }}">
                    </div>
                    <div>
                        <label for="branch_id" class="block text-sm font-bold text-gray-700 mb-2">Penempatan Cabang</label>
                        <select name="branch_id" id="branch_id" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition">
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ $driver->branch_id === $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="daily_rate" class="block text-sm font-bold text-gray-700 mb-2">Tarif Harian (Rp)</label>
                        <input type="number" name="daily_rate" id="daily_rate" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="150000" value="{{ old('daily_rate', $driver->daily_rate) }}">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-bold text-gray-700 mb-2">Status Kerja</label>
                        <select name="status" id="status" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition">
                            <option value="available" {{ $driver->status === 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="on_duty" {{ $driver->status === 'on_duty' ? 'selected' : '' }}>Sedang Bertugas</option>
                            <option value="off" {{ $driver->status === 'off' ? 'selected' : '' }}>Libur / Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 py-4 bg-red-600 text-white rounded-2xl font-bold shadow-lg hover:bg-red-700 transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.drivers.index') }}" class="px-8 py-4 bg-white border border-gray-200 text-gray-700 rounded-2xl font-bold hover:bg-gray-50 transition shadow-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
