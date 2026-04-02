@extends('layouts.admin')

@section('title', 'Detail Pengguna - Admin Panel')
@section('header_title', 'Profil & Aktivitas Pengguna')

@section('admin_content')
<div class="max-w-7xl mx-auto space-y-8">
    <div class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center gap-6">
            <div class="h-20 w-20 rounded-full bg-red-50 text-red-600 flex items-center justify-center font-bold text-3xl uppercase shadow-inner border-4 border-white">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                <div class="flex items-center gap-3 mt-1">
                    <span class="text-sm text-gray-500 font-mono">{{ $user->email }}</span>
                    <span class="badge-{{ $user->is_active ? 'success' : 'danger' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="px-6 py-2 bg-gray-900 text-white font-bold rounded-xl hover:bg-black transition shadow">
                Edit Profil
            </a>
            <a href="{{ route('admin.users.index') }}" class="px-6 py-2 bg-gray-50 text-gray-600 font-bold rounded-xl hover:bg-gray-100 transition border border-gray-200">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Akun & Akses -->
        <div class="space-y-8 lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="font-bold text-gray-900 mb-6 uppercase text-xs tracking-widest text-gray-400">Informasi Akses Sistem</h3>
                <div class="space-y-4">
                    <div>
                        <span class="text-xs text-gray-500 block mb-1">Peran Akses (Role)</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach($user->roles as $role)
                                <span class="px-3 py-1 bg-red-50 text-red-600 text-xs font-bold rounded-full uppercase">{{ $role->name }}</span>
                            @endforeach
                            @if($user->roles->isEmpty())
                                <span class="text-sm text-gray-400 italic">Belum ada role</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 block mb-1">Kantor Cabang</span>
                        <div class="font-bold text-gray-900">
                            {{ $user->branch ? $user->branch->name : 'Pusat / Seluruh Cabang' }}
                        </div>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 block mb-1">Akun Terdaftar Pada</span>
                        <div class="font-bold text-gray-900">{{ $user->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 block mb-1">Nomor Telepon</span>
                        <div class="font-bold text-gray-900 font-mono">{{ $user->phone ?: '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Audit Logs -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden h-full flex flex-col">
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900">Riwayat Aktivitas Sistem</h3>
                </div>
                <div class="p-0 overflow-y-auto flex-1 max-h-[500px]">
                    <ul class="divide-y divide-gray-50">
                        <!-- We assume an auditLogs relation or array is passed, fallback if not -->
                        @if(isset($user->auditLogs) && count($user->auditLogs) > 0)
                            @foreach($user->auditLogs as $log)
                            <li class="p-6 hover:bg-gray-50 transition">
                                <div class="flex justify-between items-start">
                                    <div class="font-bold text-gray-900">{{ $log->action }}</div>
                                    <span class="text-xs text-gray-400 font-mono">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-sm text-gray-500 mt-1">{{ $log->description }}</div>
                            </li>
                            @endforeach
                        @else
                            <li class="p-12 text-center text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="font-medium">Tidak ada riwayat aktivitas yang tercatat untuk pengguna ini.</p>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
