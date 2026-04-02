@extends('layouts.admin')

@section('title', 'Edit Cabang - Admin')
@section('header_title', 'Edit Cabang')

@section('admin_content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 font-mono tracking-tight text-sm uppercase text-gray-400">
            <h2 class="text-3xl font-bold text-gray-900 normal-case">Edit Cabang</h2>
            <p class="text-gray-500 mt-1 normal-case font-bold">{{ $branch->name }}</p>
        </div>

        <form action="{{ route('admin.branches.update', $branch->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6 font-mono tracking-tight uppercase text-sm">Informasi Lokasi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Cabang</label>
                        <input type="text" name="name" id="name" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="Contoh: Cabang Jakarta Pusat" value="{{ old('name', $branch->name) }}">
                    </div>
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label>
                        <textarea name="address" id="address" rows="3" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="Jalan Sudirman No. 45...">{{ old('address', $branch->address) }}</textarea>
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon Cabang</label>
                        <input type="tel" name="phone" id="phone" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="021-1234567" value="{{ old('phone', $branch->phone) }}">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Operasional</label>
                        <input type="email" name="email" id="email" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="jakarta@rentalmobil.com" value="{{ old('email', $branch->email) }}">
                    </div>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 py-4 bg-red-600 text-white rounded-2xl font-bold shadow-lg hover:bg-red-700 transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.branches.index') }}" class="px-8 py-4 bg-white border border-gray-200 text-gray-700 rounded-2xl font-bold hover:bg-gray-50 transition shadow-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
