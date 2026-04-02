@extends('layouts.admin')

@section('title', 'Profil Sopir - Admin')
@section('header_title', 'Profil Supir')

@section('admin_content')
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start mb-8 gap-6">
            <div class="flex items-center gap-6">
                <div class="h-24 w-24 rounded-full bg-red-50 overflow-hidden border-4 border-white shadow-md">
                    @if($driver->photo_path)
                        <img src="{{ Storage::url($driver->photo_path) }}" alt="{{ $driver->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-red-600 text-3xl font-extrabold uppercase">
                            {{ substr($driver->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">{{ $driver->name }}</h2>
                    <div class="flex items-center gap-3 mt-1">
                        @if($driver->status === 'available')
                            <span class="badge-success">Tersedia</span>
                        @elseif($driver->status === 'on_duty')
                            <span class="badge-warning">Sedang Bertugas</span>
                        @else
                            <span class="badge-danger">{{ ucfirst($driver->status) }}</span>
                        @endif
                        <span class="text-gray-500 font-medium">|</span>
                        <span class="text-gray-600">Cabang: {{ $driver->branch->name }}</span>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="p-3 bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition flex items-center gap-2 px-6 shadow-sm font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Edit Profil
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Personal & Professional Info -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-8 border-b pb-4">Informasi Personal</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <span class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1 block">Email</span>
                            <span class="text-lg font-bold text-gray-900">{{ $driver->email }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1 block">Telepon</span>
                            <span class="text-lg font-bold text-gray-900">{{ $driver->phone }}</span>
                        </div>
                        <div class="md:col-span-2">
                            <span class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1 block">Alamat Lengkap</span>
                            <span class="text-lg font-bold text-gray-900">{{ $driver->address }}, {{ $driver->city }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-8 border-b pb-4">Lisensi & Sertifikasi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <span class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1 block">Nomor Lisensi (SIM)</span>
                            <span class="text-lg font-bold text-gray-900 font-mono">{{ $driver->license_number }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1 block">Tipe Lisensi</span>
                            <span class="text-lg font-bold text-gray-900 uppercase">{{ $driver->license_type }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1 block">Berlaku Hingga</span>
                            <span class="text-lg font-bold text-gray-900 {{ $driver->licenseIsValid() ? 'text-green-600' : 'text-red-600' }}">
                                {{ $driver->license_expiry_date->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Stats & Actions -->
            <div class="space-y-8">
                <!-- Trip Summary -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100 relative overflow-hidden">
                    <h3 class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-6">Ringkasan Kinerja</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-xl">
                            <span class="text-xs text-gray-500 block mb-1 font-bold italic">Total Perjalanan</span>
                            <span class="text-2xl font-bold text-gray-900">{{ $driver->total_trips }}</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl">
                            <span class="text-xs text-gray-500 block mb-1 font-bold italic">Rating</span>
                            <div class="flex items-center gap-1">
                                <span class="text-2xl font-extrabold text-blue-600">{{ number_format($driver->rating, 1) }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-1.171 1.827-1.902 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.73.709-2.202-.197-1.902-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.381-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daily Rate -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                    <h3 class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-4">Tarif Layanan</h3>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-red-600">Rp {{ number_format($driver->daily_rate, 0, ',', '.') }}</span>
                        <span class="text-gray-500 font-medium">/hari</span>
                    </div>
                </div>

                <!-- Fast Actions -->
                <div class="space-y-3">
                    <a href="{{ route('admin.drivers.schedule', $driver->id) }}" class="w-full py-4 bg-gray-900 text-white rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-gray-800 transition">
                        Lihat Jadwal Tugas
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
