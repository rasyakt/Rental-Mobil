@extends('layouts.admin')

@section('title', 'Kelola Sopir - Admin')
@section('header_title', 'Drivers')

@section('admin_content')
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Kelola Sopir</h2>
                <p class="text-gray-500 mt-1">Daftar personil sopir aktif.</p>
            </div>
            <a href="{{ route('admin.drivers.create') }}" class="btn-primary flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Sopir
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">Sopir</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">No. Lisensi</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">Cabang</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">Telepon</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($drivers as $driver)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-gray-200 overflow-hidden shrink-0">
                                            @if($driver->photo_path)
                                                <img src="{{ Storage::url($driver->photo_path) }}" alt="{{ $driver->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400 bg-red-50 text-red-600 font-bold uppercase">
                                                    {{ substr($driver->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900">{{ $driver->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $driver->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-mono text-sm uppercase">{{ $driver->license_number }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $driver->branch->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $driver->phone_number }}</td>
                                <td class="px-6 py-4">
                                    @if($driver->status === 'available')
                                        <span class="badge-success">Tersedia</span>
                                    @elseif($driver->status === 'on_duty')
                                        <span class="badge-warning">Bertugas</span>
                                    @else
                                        <span class="badge-danger">{{ ucfirst($driver->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.drivers.schedule', $driver->id) }}" class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg transition" title="Jadwal">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <p class="text-lg font-medium">Belum ada sopir terdaftar</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $drivers->links() }}
        </div>
    </div>
@endsection
