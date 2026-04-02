@extends('layouts.admin')

@section('title', 'Kelola Booking - Admin')
@section('header_title', 'Bookings')

@section('admin_content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Kelola Booking</h2>
            <p class="text-gray-500 mt-1">Daftar semua permintaan sewa kendaraan.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">No. Booking</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Pelanggan</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Kendaraan</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Jadwal Sewa</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Total Harga</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-mono text-sm font-bold text-red-600">{{ $booking->booking_number }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $booking->customer->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $booking->customer->user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-gray-900 font-medium">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</div>
                                <div class="text-xs text-gray-500 uppercase">{{ $booking->vehicle->plat_number }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700">{{ $booking->pickup_date->format('d M Y') }} - {{ $booking->return_date->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $booking->pickup_date->diffInDays($booking->return_date) }} Hari</div>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                Rp {{ number_format($booking->final_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($booking->status === 'pending')
                                    <span class="badge-warning">Pending</span>
                                @elseif($booking->status === 'confirmed')
                                    <span class="badge-success">Dikonfirmasi</span>
                                @elseif($booking->status === 'active')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Dalam Sewa</span>
                                @elseif($booking->status === 'completed')
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">Selesai</span>
                                @else
                                    <span class="badge-danger">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg transition" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="text-lg font-medium">Belum ada booking</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection
