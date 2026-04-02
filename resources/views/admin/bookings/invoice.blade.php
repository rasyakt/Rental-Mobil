@extends('layouts.admin')

@section('title', 'Invoice Pesanan - Admin Panel')
@section('header_title', 'Invoice Pesanan')

@section('admin_content')
<div class="max-w-4xl mx-auto my-8">
    <div class="flex justify-between items-center mb-8 pr-4">
        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="flex items-center gap-2 text-gray-500 hover:text-red-600 font-bold transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            Kembali
        </a>
        <button onclick="window.print()" class="px-6 py-2 bg-gray-900 text-white rounded-xl font-bold hover:bg-black transition shadow">
            Cetak Invoice
        </button>
    </div>

    <!-- Invoice Card -->
    <div class="bg-white shadow border border-gray-100 print:shadow-none print:border-none">
        <!-- Invoice Header -->
        <div class="p-10 border-b border-gray-100 flex justify-between items-start bg-gray-50">
            <div>
                <h1 class="text-4xl font-extrabold text-red-600 mb-2">INVOICE</h1>
                <p class="text-gray-500 font-mono">#{{ $booking->booking_number }}</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-bold text-gray-900">Rental Mobil HYPE</h2>
                <p class="text-gray-500">Jl. Jendral Sudirman No. 12<br>Jakarta Pusat, 12345<br>Telp: (021) 123-4567</p>
            </div>
        </div>

        <!-- Billing Info -->
        <div class="p-10 grid grid-cols-2 gap-8 border-b border-gray-100">
            <div>
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">Ditagihkan Kepada</h3>
                <h4 class="text-lg font-bold text-gray-900">{{ $booking->customer->user->name }}</h4>
                <p class="text-gray-500">{{ $booking->customer->address ?: '-' }}</p>
                <p class="text-gray-500">{{ $booking->customer->phone }}</p>
                <p class="text-gray-500">{{ $booking->customer->user->email }}</p>
            </div>
            <div class="text-right">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">Detail Transaksi</h3>
                <div class="space-y-1">
                    <p class="text-gray-600"><span class="font-bold">Tanggal Invoice:</span> {{ now()->format('d M Y') }}</p>
                    <p class="text-gray-600"><span class="font-bold">Status:</span> 
                        <span class="text-{{ $booking->payment && $booking->payment->status === 'success' ? 'green' : 'red' }}-600 font-bold uppercase">
                            {{ $booking->payment ? ($booking->payment->status === 'success' ? 'LUNAS' : 'BELUM LUNAS') : 'BELUM LUNAS' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Itemized List -->
        <div class="p-10">
            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Rincian Layanan</h3>
            <div class="overflow-hidden border border-gray-100 rounded-xl">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Harga Satuan</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Durasi/Jumlah</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <!-- Vehicle Rental -->
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">Sewa Kendaraan</div>
                                <div class="text-sm text-gray-500">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }} ({{ $booking->vehicle->plate_number }})</div>
                            </td>
                            <td class="px-6 py-4 text-right text-gray-600">Rp {{ number_format($booking->vehicle->daily_rate, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-right text-gray-600">{{ $booking->getDurationDays() }} Hari</td>
                            <td class="px-6 py-4 text-right font-bold text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        </tr>
                        
                        <!-- Driver Service -->
                        @if($booking->with_driver)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">Layanan Sopir</div>
                                <div class="text-sm text-gray-500">
                                    {{ $booking->driver ? $booking->driver->name : 'Staff Sopir' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-gray-600">
                                Rp {{ number_format($booking->driver ? $booking->driver->daily_rate : ($booking->additional_charges / $booking->getDurationDays()), 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right text-gray-600">{{ $booking->getDurationDays() }} Hari</td>
                            <td class="px-6 py-4 text-right font-bold text-gray-900">Rp {{ number_format($booking->additional_charges, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Tax & Totals -->
            <div class="mt-8 flex justify-end">
                <div class="w-1/2 space-y-3">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span class="font-medium">Rp {{ number_format($booking->total_price + $booking->additional_charges, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Pajak (11%)</span>
                        <span class="font-medium">Rp {{ number_format($booking->tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="pt-4 border-t border-gray-100 flex justify-between items-baseline">
                        <span class="text-lg font-bold text-gray-900">Total Tagihan</span>
                        <span class="text-2xl font-extrabold text-red-600">Rp {{ number_format($booking->final_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-10 bg-gray-50 border-t border-gray-100 text-center text-sm text-gray-500">
            <p>Terima kasih telah menggunakan layanan Rental Mobil HYPE. Harap simpan invoice ini sebagai bukti transaksi yang sah.</p>
        </div>
    </div>
</div>
@endsection
