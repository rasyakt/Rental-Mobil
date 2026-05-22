@extends('layouts.admin')

@section('title', 'Jadwal Perawatan - Admin')
@section('header_title', 'Perawatan Armada')

@section('admin_content')
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Log Perawatan Armada</h2>
                <p class="text-gray-500 mt-1">Pantau kondisi dan jadwal servis berkala kendaraan.</p>
            </div>
            <a href="{{ route('admin.maintenance.create') }}" class="btn-primary flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Agenda
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase tracking-wider">Kendaraan</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase tracking-wider">Jenis Servis</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase tracking-wider">Biaya</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase tracking-wider">Tgl Selesai</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($maintenances as $maintenance)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900">{{ $maintenance->vehicle->brand }} {{ $maintenance->vehicle->model }}</div>
                                            <div class="text-xs text-gray-500 font-mono">{{ $maintenance->vehicle->plate_number }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ ucfirst($maintenance->maintenance_type) }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-xs">{{ $maintenance->description }}</div>
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    Rp {{ number_format($maintenance->cost, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($maintenance->status === 'completed')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">Selesai</span>
                                    @elseif($maintenance->status === 'scheduled')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">Terjadwal</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">Proses</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $maintenance->completion_date ? $maintenance->completion_date->format('d M Y') : '-' }}
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
                                            <a href="{{ route('admin.maintenance.show', $maintenance->id) }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-bold text-gray-600 hover:bg-slate-50 hover:text-slate-900 transition">
                                                <i class="fa-solid fa-eye w-4 text-center text-slate-400"></i>
                                                <span>Detail Perawatan</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-200 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <p class="text-lg font-bold">Belum ada riwayat perawatan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $maintenances->links() }}
        </div>
    </div>
@endsection
