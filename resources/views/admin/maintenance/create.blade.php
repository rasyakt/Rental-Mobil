@extends('layouts.admin')

@section('title', 'Tambah Jadwal Pemeliharaan - Admin Panel')
@section('header_title', 'Registrasi Servis Berkala / Perbaikan')

@section('admin_content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.maintenance.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-6 font-mono tracking-tight uppercase text-sm">Informasi Kendaraan & Servis</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="vehicle_id" class="block text-sm font-bold text-gray-700 mb-2">Pilih Kendaraan</label>
                    <select name="vehicle_id" id="vehicle_id" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition">
                        <option value="">-- Pilih Kendaraan --</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->plate_number }}) - Odo: {{ $vehicle->current_odometer }} KM</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="maintenance_type" class="block text-sm font-bold text-gray-700 mb-2">Tipe Servis / Pekerjaan</label>
                    <input type="text" name="maintenance_type" id="maintenance_type" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="Contoh: Ganti Oli Rutin, Ganti Ban, dll">
                </div>
                <div>
                    <label for="status" class="block text-sm font-bold text-gray-700 mb-2">Status Pemeliharaan</label>
                    <select name="status" id="status" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition">
                        <option value="scheduled">Terjadwal (Akan Datang)</option>
                        <option value="in_progress">Dalam Proses Pengerjaan</option>
                        <option value="completed">Selesai</option>
                    </select>
                </div>
                <div>
                    <label for="start_date" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Mulai Servis</label>
                    <input type="date" name="start_date" id="start_date" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-bold text-gray-700 mb-2">Estimasi Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition">
                </div>
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Rincian Pekerjaan</label>
                    <textarea name="description" id="description" rows="3" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="Tulis rincian keluhan atau pekerjaan servis..."></textarea>
                </div>
                <div>
                    <label for="odometer" class="block text-sm font-bold text-gray-700 mb-2">Odometer Kendaraan Saat Ini (KM)</label>
                    <input type="number" name="odometer" id="odometer" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="Contoh: 54000">
                </div>
                <div>
                    <label for="cost" class="block text-sm font-bold text-gray-700 mb-2">Estimasi / Biaya Servis (Rp)</label>
                    <input type="number" name="cost" id="cost" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" placeholder="Contoh: 1500000" value="0">
                </div>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 py-4 bg-red-600 text-white rounded-2xl font-bold shadow-lg hover:bg-red-700 transition">
                Simpan Jadwal Pemeliharaan
            </button>
            <a href="{{ route('admin.maintenance.index') }}" class="px-8 py-4 bg-white border border-gray-200 text-gray-700 rounded-2xl font-bold hover:bg-gray-50 transition shadow-sm">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
