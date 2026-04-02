@extends('layouts.admin')

@section('title', 'Jadwal Sopir - Admin Panel')
@section('header_title', 'Jadwal Tugas Supir')

@section('admin_content')
<div class="max-w-7xl mx-auto space-y-8">
    <div class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center gap-4">
            <div class="h-16 w-16 rounded-full bg-red-50 text-red-600 flex items-center justify-center font-bold text-2xl uppercase">
                {{ substr($driver->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $driver->name }}</h2>
                <div class="text-sm text-gray-500 mt-1">
                    <span class="font-mono">{{ $driver->phone }}</span> &bull; 
                    <span class="badge-{{ $driver->status === 'available' ? 'success' : ($driver->status === 'on_duty' ? 'warning' : 'danger') }}">{{ ucfirst($driver->status) }}</span>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.drivers.show', $driver->id) }}" class="px-6 py-2 bg-gray-50 text-gray-600 font-bold rounded-xl hover:bg-gray-100 transition border border-gray-200">
            Kembali ke Profil
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50">
            <h3 class="font-bold text-gray-900">Riwayat & Jadwal Penugasan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-gray-100">
                        <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Waktu Penugasan</th>
                        <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Detail Pesanan</th>
                        <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Pelanggan</th>
                        <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Status Tugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50 transition group">
                        <td class="px-8 py-5">
                            <div class="font-bold text-gray-900 mb-1">{{ $booking->pickup_date->format('d M Y, H:i') }}</div>
                            <div class="text-xs text-red-600 font-bold uppercase tracking-widest">S/D</div>
                            <div class="font-bold text-gray-900 mt-1">{{ $booking->return_date->format('d M Y, H:i') }}</div>
                        </td>
                        <td class="px-8 py-5">
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="font-bold text-red-600 hover:underline mb-1 inline-block">#{{ $booking->booking_number }}</a>
                            <div class="text-sm font-medium text-gray-900">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</div>
                            <div class="text-xs text-gray-500 font-mono">{{ $booking->vehicle->plate_number }}</div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="font-bold text-gray-900">{{ $booking->customer->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $booking->customer->phone }}</div>
                        </td>
                        <td class="px-8 py-5">
                            @if($booking->status === 'completed')
                                <span class="badge-success">Selesai</span>
                            @elseif($booking->status === 'confirmed' && $booking->pickup_date > now())
                                <span class="badge-warning">Akan Datang</span>
                            @elseif($booking->status === 'confirmed' && $booking->pickup_date <= now() && $booking->return_date >= now())
                                <span class="badge-warning bg-blue-100 text-blue-600 border-blue-200">Sedang Berjalan</span>
                            @else
                                <span class="badge-danger">{{ ucfirst($booking->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-12 text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="font-bold">Belum ada riwayat penugasan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
