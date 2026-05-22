@extends('layouts.admin')

@section('title', 'Kelola Pembayaran - Admin')
@section('header_title', 'Payments')

@section('admin_content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Kelola Pembayaran</h2>
            <p class="text-gray-500 mt-1">Daftar transaksi dan verifikasi pembayaran pelanggan.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">ID Transaksi</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">Booking</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">Pelanggan</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">Metode</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">Jumlah</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-mono text-sm uppercase text-gray-600">{{ $payment->transaction_id ?? 'Manual-'.$payment->id }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.bookings.show', $payment->booking_id) }}" class="text-red-600 font-bold hover:underline">
                                        {{ $payment->booking->booking_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $payment->booking->customer->user->name }}</div>
                                    <div class="text-xs text-gray-500">via {{ ucfirst($payment->payment_type) }}</div>
                                </td>
                                <td class="px-6 py-4 uppercase text-sm font-medium text-gray-700">
                                    {{ str_replace('_', ' ', $payment->payment_method) }}
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($payment->status === 'pending')
                                        <span class="badge-warning">Menunggu</span>
                                    @elseif($payment->status === 'success' || $payment->status === 'settlement')
                                        <span class="badge-success">Berhasil</span>
                                    @elseif($payment->status === 'failed' || $payment->status === 'expire')
                                        <span class="badge-danger">Gagal</span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">{{ ucfirst($payment->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.payments.show', $payment->id) }}" class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg transition" title="Detail">
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        <p class="text-lg font-medium">Belum ada transaksi pembayaran</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $payments->links() }}
        </div>
    </div>
@endsection
