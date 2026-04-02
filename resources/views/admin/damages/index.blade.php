@extends('layouts.admin')

@section('title', 'Laporan Kerusakan & Kendala - Admin Panel')
@section('header_title', 'Laporan Kerusakan Kendaraan')

@section('admin_content')
<div class="max-w-7xl mx-auto space-y-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 uppercase italic">Laporan Kerusakan / Kendala (Insiden)</h2>
            <p class="text-gray-500 mt-1">Daftar permintaan perbaikan atau klaim asuransi atas kerusakan fisik maupun mesin.</p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.maintenance.index') }}" class="px-6 py-3 bg-white text-gray-700 rounded-2xl font-bold hover:bg-gray-50 transition border border-gray-200">
                Kembali ke Pemeliharaan Rutin
            </a>
            <a href="{{ route('admin.maintenance.create') }}" class="px-6 py-3 bg-red-600 text-white rounded-2xl font-bold hover:bg-red-700 transition shadow-lg flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Buat Laporan Baru
            </a>
        </div>
    </div>

    <!-- Empty State for now since no explicit damages data is mapped in controller yet -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-16 text-center text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-gray-200 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <h3 class="text-xl font-bold text-gray-900 mb-2 uppercase italic tracking-widest">Aman Terkendali</h3>
            <p class="mb-6">Belum ada laporan kerusakan, klaim asuransi, atau insiden yang masuk untuk saat ini.</p>
            <a href="{{ route('admin.maintenance.index') }}" class="px-8 py-3 bg-gray-900 text-white rounded-xl font-bold hover:bg-black transition text-sm">Lihat Perbaikan Rutin</a>
        </div>
    </div>
</div>
@endsection
