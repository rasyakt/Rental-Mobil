@extends('layouts.admin')

@section('title', 'Tambah Sopir Baru - Admin')
@section('header_title', 'Registrasi Sopir')

@section('admin_content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Tambah Sopir Baru</h2>
            <p class="text-gray-500 mt-1">Lengkapi informasi untuk mendaftarkan personil sopir baru.</p>
        </div>

        <form action="{{ route('admin.drivers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <!-- Personal Info Section -->
            <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Personal</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="name" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="Contoh: Budi Santoso" value="{{ old('name') }}">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                        <input type="email" name="email" id="email" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="budi@email.com" value="{{ old('email') }}">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="tel" name="phone" id="phone" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="081234567890" value="{{ old('phone') }}">
                    </div>
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label>
                        <textarea name="address" id="address" rows="3" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="Jalan Raya No. 123...">{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Licensing Section -->
            <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Lisensi & Penugasan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="license_number" class="block text-sm font-bold text-gray-700 mb-2">Nomor SIM</label>
                        <input type="text" name="license_number" id="license_number" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition font-mono uppercase" placeholder="1234-5678-901234" value="{{ old('license_number') }}">
                    </div>
                    <div>
                        <label for="license_type" class="block text-sm font-bold text-gray-700 mb-2">Tipe SIM</label>
                        <select name="license_type" id="license_type" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition">
                            <option value="A">SIM A (Mobil Pribadi)</option>
                            <option value="B1">SIM B1 (Bus/Truk Kecil)</option>
                            <option value="B2">SIM B2 (Alat Berat)</option>
                        </select>
                    </div>
                    <div>
                        <label for="license_expiry_date" class="block text-sm font-bold text-gray-700 mb-2">Masa Berlaku SIM</label>
                        <input type="date" name="license_expiry_date" id="license_expiry_date" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" value="{{ old('license_expiry_date') }}">
                    </div>
                    <div>
                        <label for="branch_id" class="block text-sm font-bold text-gray-700 mb-2">Penempatan Cabang</label>
                        <select name="branch_id" id="branch_id" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition">
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="daily_rate" class="block text-sm font-bold text-gray-700 mb-2">Tarif Harian (Rp)</label>
                        <input type="number" name="daily_rate" id="daily_rate" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="150000" value="{{ old('daily_rate', 150000) }}">
                    </div>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 py-4 bg-red-600 text-white rounded-2xl font-bold shadow-lg hover:bg-red-700 transition">
                    Simpan Data Sopir
                </button>
                <a href="{{ route('admin.drivers.index') }}" class="px-8 py-4 bg-white border border-gray-200 text-gray-700 rounded-2xl font-bold hover:bg-gray-50 transition shadow-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
