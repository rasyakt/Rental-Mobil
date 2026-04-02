@extends('layouts.admin')

@section('title', 'Daftar Kendaraan - Admin')
@section('header_title', 'Kelola Kendaraan')

@section('admin_content')
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Kelola Kendaraan</h2>
                <p class="text-gray-500 mt-1">Daftar semua unit kendaraan di seluruh cabang.</p>
            </div>
            <a href="{{ route('admin.vehicles.create') }}" class="btn-primary flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Kendaraan
            </a>
        </div>

        <!-- Filter & Search (Mockup) -->
        <div class="bg-white p-4 rounded-xl shadow-sm mb-6 flex flex-wrap gap-4 items-center">
            <div class="flex-1 min-w-[200px]">
                <input type="text" placeholder="Cari merk, model, atau plat nomor..." class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none">
            </div>
            <select class="px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-red-500">
                <option value="">Semua Status</option>
                <option value="available">Tersedia</option>
                <option value="rented">Disewa</option>
                <option value="maintenance">Maintenance</option>
            </select>
            <select class="px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-red-500">
                <option value="">Semua Cabang</option>
                {{-- @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach --}}
            </select>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Kendaraan</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Plat Nomor</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Cabang</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Harga/Hari</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($vehicles as $vehicle)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-16 rounded bg-gray-200 overflow-hidden flex-shrink-0">
                                        @if($vehicle->getPrimaryImage())
                                            <img src="{{ Storage::url($vehicle->getPrimaryImage()->image_path) }}" alt="{{ $vehicle->model }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
                                        <div class="text-xs text-gray-500 uppercase font-medium">{{ $vehicle->category->name ?? 'Uncategorized' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-sm uppercase">{{ $vehicle->plat_number }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $vehicle->branch->name ?? '-' }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($vehicle->price_daily, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($vehicle->status === 'available')
                                    <span class="badge-success">Tersedia</span>
                                @elseif($vehicle->status === 'rented')
                                    <span class="badge-warning">Sedang Disewa</span>
                                @else
                                    <span class="badge-danger">{{ ucfirst($vehicle->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.vehicles.show', $vehicle->id) }}" class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg transition" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <p class="text-lg font-medium">Belum ada unit kendaraan</p>
                                    <p class="text-sm">Klik tombah "Tambah Kendaraan" untuk memulai.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $vehicles->links() }}
        </div>
    </div>
@endsection
