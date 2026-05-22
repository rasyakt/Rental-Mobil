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
                <table class="w-full text-left whitespace-nowrap">
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
                                    <div class="relative inline-block text-left" x-data="{ open: false, openUpwards: false }" @click.away="open = false">
                                        <button @click="open = !open; if(open) { $nextTick(() => { const rect = $el.getBoundingClientRect(); const viewportSpace = window.innerHeight - rect.bottom; const container = $el.closest('.overflow-x-auto') || $el.closest('table'); const containerRect = container ? container.getBoundingClientRect() : null; const containerSpace = containerRect ? (containerRect.bottom - rect.bottom) : 999; openUpwards = viewportSpace < 180 || containerSpace < 180; }) }" class="w-8 h-8 rounded-lg text-gray-400 hover:text-gray-900 hover:bg-gray-100 flex items-center justify-center transition outline-none cursor-pointer">
                                            <i class="fa-solid fa-ellipsis-vertical text-sm"></i>
                                        </button>
                                        <div x-show="open" 
                                             x-transition:enter="transition ease-out duration-100" 
                                             x-transition:enter-start="transform opacity-0 scale-95" 
                                             x-transition:enter-end="transform opacity-100 scale-100" 
                                             x-transition:leave="transition ease-in duration-75" 
                                             x-transition:leave-start="transform opacity-100 scale-100" 
                                             x-transition:leave-end="transform opacity-0 scale-95" 
                                             :class="openUpwards ? 'bottom-full mb-1.5' : 'top-full mt-1.5'"
                                             class="absolute right-0 w-40 rounded-xl bg-white border border-gray-100 shadow-lg py-1.5 z-50 text-left"
                                             style="display: none;">
                                            <a href="{{ route('admin.payments.show', $payment->id) }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-bold text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition">
                                                <i class="fa-solid fa-eye w-4 text-center text-slate-400"></i>
                                                <span>Detail</span>
                                            </a>
                                        </div>
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
