@extends('layouts.admin')

@section('title', 'Detail Pembayaran - Admin')
@section('header_title', 'Detail Pembayaran')

@section('admin_content')
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-start mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Detail Transaksi</h2>
                <div class="flex items-center gap-3 mt-1">
                    <span class="text-gray-500 font-mono text-sm uppercase">#{{ $payment->transaction_id ?? 'P-'.$payment->id }}</span>
                    <span class="badge-{{ $payment->status === 'success' || $payment->status === 'settlement' ? 'success' : ($payment->status === 'pending' ? 'warning' : 'danger') }}">
                        {{ ucfirst($payment->status) }}
                    </span>
                </div>
            </div>
            
            <div class="flex gap-3">
                @if($payment->status === 'pending')
                    <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 transition shadow-lg">Verifikasi</button>
                    </form>
                    <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-3 border border-red-600 text-red-600 rounded-xl font-bold hover:bg-red-50 transition">Tolak</button>
                    </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Payment Details -->
            <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100 flex flex-col">
                <h3 class="text-xl font-bold text-gray-900 mb-8 border-b pb-4">Informasi Pembayaran</h3>
                <div class="space-y-6 flex-1">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 font-bold uppercase tracking-wider">Metode</span>
                        <span class="font-extrabold text-gray-900 uppercase italic">{{ str_replace('_', ' ', $payment->payment_method) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 font-bold uppercase tracking-wider">Tipe</span>
                        <span class="font-extrabold text-gray-900 uppercase italic">{{ ucfirst($payment->payment_type) }}</span>
                    </div>
                    <div class="flex justify-between items-baseline pt-4 border-t border-gray-50">
                        <span class="text-gray-500 font-bold uppercase tracking-wider">Jumlah Bayar</span>
                        <span class="text-3xl font-extrabold text-red-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-xs text-gray-400 pt-4 italic">
                        <span>Waktu Transaksi</span>
                        <span>{{ $payment->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Booking Overview -->
            <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-8 border-b pb-4">Referensi Booking</h3>
                <div class="space-y-6">
                    <div class="bg-gray-50 p-6 rounded-2xl">
                        <div class="text-xs text-gray-500 font-bold uppercase tracking-widest mb-1">Nomor Booking</div>
                        <a href="{{ route('admin.bookings.show', $payment->booking->id) }}" class="text-xl font-extrabold text-red-600 hover:underline">
                            {{ $payment->booking->booking_number }}
                        </a>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold">
                                {{ substr($payment->booking->customer->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-900">{{ $payment->booking->customer->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $payment->booking->customer->user->email }}</div>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-50">
                            <div class="text-xs text-gray-500 font-bold italic mb-1 uppercase tracking-widest">Kendaraan</div>
                            <div class="font-bold text-gray-900">{{ $payment->booking->vehicle->brand }} {{ $payment->booking->vehicle->model }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($payment->proof_path)
            <div class="mt-8 bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Bukti Transfer</h3>
                <div class="max-w-md mx-auto rounded-xl overflow-hidden shadow-md">
                    <img src="{{ Storage::url($payment->proof_path) }}" alt="Bukti Transfer" class="w-full h-auto">
                </div>
            </div>
        @endif
    </div>
@endsection
