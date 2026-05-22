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
                <table class="w-full text-left whitespace-nowrap">
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
                                                <div class="w-full h-full flex items-center justify-center bg-red-50 text-red-600 font-bold uppercase">
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
                                            <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-bold text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition">
                                                <i class="fa-solid fa-pen-to-square w-4 text-center text-gray-400"></i>
                                                <span>Edit Profil</span>
                                            </a>
                                            <a href="{{ route('admin.drivers.schedule', $driver->id) }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-bold text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition">
                                                <i class="fa-solid fa-calendar-days w-4 text-center text-gray-400"></i>
                                                <span>Lihat Jadwal</span>
                                            </a>
                                        </div>
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
