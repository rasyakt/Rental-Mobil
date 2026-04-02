@extends('layouts.admin')

@section('title', 'Kelola Cabang - Admin')
@section('header_title', 'Branches')

@section('admin_content')
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Kelola Cabang</h2>
                <p class="text-gray-500 mt-1">Daftar lokasi operasional rental mobil.</p>
            </div>
            <a href="{{ route('admin.branches.create') }}" class="btn-primary flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Cabang
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($branches as $branch)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 flex flex-col">
                    <div class="p-6 flex-1">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-gray-900">{{ $branch->name }}</h3>
                            @if($branch->is_active)
                                <span class="badge-success">Aktif</span>
                            @else
                                <span class="badge-danger">Nonaktif</span>
                            @endif
                        </div>
                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ $branch->address }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                <span>{{ $branch->phone }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 flex justify-between gap-3 border-t">
                        <a href="{{ route('admin.branches.edit', $branch->id) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">Edit Cabang</a>
                        @if($branch->is_active)
                            <form action="{{ route('admin.branches.deactivate', $branch->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-sm">Nonaktifkan</button>
                            </form>
                        @else
                            <form action="{{ route('admin.branches.activate', $branch->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-700 font-medium text-sm">Aktifkan</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 bg-white rounded-xl shadow-sm text-center">
                    <p class="text-gray-500">Belum ada cabang terdaftar.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
