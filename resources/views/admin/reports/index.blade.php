@extends('layouts.admin')

@section('title', 'Laporan Operasional - Admin')
@section('header_title', 'Laporan Operasional')

@section('admin_content')
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Analisis Operasional</h2>
                <p class="text-gray-500 mt-1">Data statistik dan performa bisnis secara real-time.</p>
            </div>
            <div class="flex gap-3">
                <button class="px-6 py-3 bg-gray-900 text-white rounded-xl font-bold shadow-lg hover:bg-gray-800 transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    Export Laporan
                </button>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 italic">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Total Pendapatan</span>
                <span class="text-2xl font-extrabold text-red-600">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</span>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 italic">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Total Pesanan</span>
                <span class="text-2xl font-extrabold text-gray-900">{{ number_format($stats['total_bookings']) }}</span>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 italic">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Ketersediaan Armada</span>
                <span class="text-2xl font-extrabold text-gray-900">{{ number_format($stats['total_vehicles']) }} Unit</span>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 italic">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Personil Sopir</span>
                <span class="text-2xl font-extrabold text-gray-900">{{ number_format($stats['total_drivers']) }} Orang</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Transactions Table -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-900">Transaksi Terbaru</h3>
                    <a href="{{ route('admin.payments.index') }}" class="text-sm font-bold text-red-600 hover:underline">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">ID Transaksi</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Waktu</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Jumlah</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($stats['recent_revenue'] as $payment)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-8 py-4 font-mono text-xs text-gray-600 uppercase">{{ $payment->transaction_id ?? 'P-'.$payment->id }}</td>
                                    <td class="px-8 py-4 text-sm text-gray-900 font-medium">{{ $payment->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-8 py-4 text-sm font-extrabold text-green-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td class="px-8 py-4">
                                        <span class="badge-success italic text-[10px]">Berhasil</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Report Navigation -->
            <div class="space-y-6">
                <div class="bg-gray-900 text-white rounded-2xl shadow-xl p-8 overflow-hidden relative">
                    <div class="relative z-10">
                        <h3 class="text-xl font-bold mb-4">Butuh Analisis Mendalam?</h3>
                        <p class="text-gray-400 text-sm mb-6 leading-relaxed">Gunakan modul laporan spesifik untuk melihat tren performa berdasarkan kategori data.</p>
                        <div class="space-y-3">
                            <a href="{{ route('admin.reports.revenue') }}" class="flex items-center justify-between p-4 bg-white/10 rounded-xl hover:bg-white/20 transition group">
                                <span class="font-bold">Laporan Keuangan</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-hover:text-white transition" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.reports.bookings') }}" class="flex items-center justify-between p-4 bg-white/10 rounded-xl hover:bg-white/20 transition group">
                                <span class="font-bold">Laporan Pesanan</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-hover:text-white transition" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.reports.vehicles') }}" class="flex items-center justify-between p-4 bg-white/10 rounded-xl hover:bg-white/20 transition group">
                                <span class="font-bold">Okupansi Armada</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-hover:text-white transition" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
