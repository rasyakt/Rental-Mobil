@extends('layouts.admin')

@section('title', 'Edit Pesanan - Admin Panel')
@section('header_title', 'Edit Data Pesanan')

@section('admin_content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 font-mono tracking-tight text-sm uppercase text-gray-400">
        <h2 class="text-3xl font-bold text-gray-900 normal-case">Edit Booking #{{ $booking->booking_number }}</h2>
        <p class="text-gray-500 mt-1 normal-case font-bold">{{ $booking->customer->user->name }} - {{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</p>
    </div>

    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-6 font-mono tracking-tight uppercase text-sm">Informasi Pesanan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="pickup_date" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Penjemputan</label>
                    <input type="datetime-local" name="pickup_date" id="pickup_date" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" value="{{ old('pickup_date', $booking->pickup_date->format('Y-m-d\TH:i')) }}">
                </div>
                <div>
                    <label for="return_date" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Pengembalian</label>
                    <input type="datetime-local" name="return_date" id="return_date" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition" value="{{ old('return_date', $booking->return_date->format('Y-m-d\TH:i')) }}">
                </div>
                <div class="md:col-span-2">
                    <label for="pickup_address" class="block text-sm font-bold text-gray-700 mb-2">Alamat Penjemputan</label>
                    <textarea name="pickup_address" id="pickup_address" rows="3" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition">{{ old('pickup_address', $booking->pickup_address) }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label for="return_address" class="block text-sm font-bold text-gray-700 mb-2">Alamat Pengembalian</label>
                    <textarea name="return_address" id="return_address" rows="3" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition">{{ old('return_address', $booking->return_address) }}</textarea>
                </div>
                <div>
                    <label for="status" class="block text-sm font-bold text-gray-700 mb-2">Status Pesanan</label>
                    <select name="status" id="status" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition">
                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Konfirmasi / Aktif</option>
                        <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                @if($booking->with_driver)
                <div>
                    <label for="driver_id" class="block text-sm font-bold text-gray-700 mb-2">Sopir</label>
                    <select name="driver_id" id="driver_id" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 transition">
                        <option value="">-- Pilih Sopir --</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" {{ $booking->driver_id === $driver->id ? 'selected' : '' }}>{{ $driver->name }} (Rp {{ number_format($driver->daily_rate, 0, ',', '.') }}/hari)</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 py-4 bg-red-600 text-white rounded-2xl font-bold shadow-lg hover:bg-red-700 transition">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="px-8 py-4 bg-white border border-gray-200 text-gray-700 rounded-2xl font-bold hover:bg-gray-50 transition shadow-sm">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
