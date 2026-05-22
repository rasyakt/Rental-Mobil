@extends('layouts.admin')

@section('title', 'Daftar Kendaraan - Admin')
@section('header_title', 'Kelola Kendaraan')

@section('admin_content')
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Kelola Kendaraan</h1>
                <p class="text-sm text-slate-500 font-medium">Kelola data seluruh unit armada sewa di semua cabang.</p>
            </div>
            <div>
                <a href="{{ route('admin.vehicles.create') }}" class="px-5 py-3 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Kendaraan</span>
                </a>
            </div>
        </div>

        <!-- Filter & Search Panel -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex flex-wrap gap-4 items-center">
            <!-- Search input -->
            <div class="flex-1 min-w-[260px] relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                <input type="text" placeholder="Cari merk, model, atau plat nomor..." class="w-full pl-11 pr-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl focus:border-slate-400 focus:bg-white outline-none text-slate-700 text-sm font-semibold transition">
            </div>
            
            <!-- Filters -->
            <div class="flex flex-wrap gap-3 items-center">
                <select class="px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl focus:border-slate-400 focus:bg-white outline-none text-slate-700 text-sm font-semibold transition cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="available">Tersedia</option>
                    <option value="rented">Disewa</option>
                    <option value="maintenance">Maintenance</option>
                </select>
                <select class="px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl focus:border-slate-400 focus:bg-white outline-none text-slate-700 text-sm font-semibold transition cursor-pointer">
                    <option value="">Semua Cabang</option>
                </select>
            </div>
        </div>

        <!-- Vehicles Table Container -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-400">Unit Kendaraan</th>
                            <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-400">Plat Nomor</th>
                            <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-400">Cabang</th>
                            <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-400">Harga Sewa / Hari</th>
                            <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-400">Status</th>
                            <th class="px-6 py-4.5 text-xs font-bold uppercase tracking-wider text-slate-400 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                        @forelse($vehicles as $vehicle)
                            <tr class="hover:bg-slate-50/40 transition duration-200">
                                <!-- Vehicle Details cell -->
                                <td class="px-6 py-4.5">
                                    <div class="flex items-center gap-4">
                                        <!-- Primary Image Thumbnail -->
                                        <div class="h-12 w-16 rounded-lg bg-slate-100 border border-slate-100 overflow-hidden flex-shrink-0 relative">
                                            @if($vehicle->getPrimaryImage())
                                                <img src="{{ Storage::url($vehicle->getPrimaryImage()->path) }}" alt="{{ $vehicle->model }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                    <i class="fa-solid fa-image text-lg"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 text-sm uppercase">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
                                            <div class="text-[10px] text-slate-400 font-bold tracking-widest uppercase mt-0.5">{{ $vehicle->category->name ?? 'Armada' }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Plat Number -->
                                <td class="px-6 py-4.5">
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-md text-xs font-mono font-bold tracking-wider uppercase border border-slate-200">
                                        {{ $vehicle->plat_number }}
                                    </span>
                                </td>
                                
                                <!-- Branch -->
                                <td class="px-6 py-4.5 text-slate-500 font-semibold text-xs">
                                    {{ $vehicle->branch->name ?? '-' }}
                                </td>
                                
                                <!-- Price Daily -->
                                <td class="px-6 py-4.5 font-bold text-slate-900">
                                    Rp {{ number_format($vehicle->price_daily, 0, ',', '.') }}
                                </td>
                                
                                <!-- Status badge -->
                                <td class="px-6 py-4.5">
                                    @if($vehicle->status === 'available')
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider rounded-md border border-emerald-100">Tersedia</span>
                                    @elseif($vehicle->status === 'rented')
                                        <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold uppercase tracking-wider rounded-md border border-blue-100">Disewa</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-rose-50 text-rose-700 text-[10px] font-bold uppercase tracking-wider rounded-md border border-rose-100">{{ $vehicle->status }}</span>
                                    @endif
                                </td>
                                
                                <!-- Action links -->
                                <td class="px-6 py-4.5 text-right">
                                    <div class="flex justify-end gap-1.5">
                                        <a href="{{ route('admin.vehicles.show', $vehicle->id) }}" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-900 hover:bg-slate-100 flex items-center justify-center transition" title="Lihat Detail">
                                            <i class="fa-solid fa-eye text-sm"></i>
                                        </a>
                                        <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-900 hover:bg-slate-100 flex items-center justify-center transition" title="Edit Unit">
                                            <i class="fa-solid fa-pen-to-square text-sm"></i>
                                        </a>
                                        <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus unit kendaraan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 flex items-center justify-center transition cursor-pointer" title="Hapus Unit">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-medium">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <div class="w-12 h-12 rounded-full bg-slate-50 text-slate-300 flex items-center justify-center text-xl">
                                            <i class="fa-solid fa-car-side"></i>
                                        </div>
                                        <p class="text-sm">Belum ada unit kendaraan sewa terdaftar.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $vehicles->links() }}
        </div>
    </div>
@endsection
