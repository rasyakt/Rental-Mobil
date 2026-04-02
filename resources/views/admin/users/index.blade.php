@extends('layouts.admin')

@section('title', 'Manajemen Pengguna - Admin')
@section('header_title', 'Pengguna')

@section('admin_content')
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Kontrol Akun Pengguna</h2>
                <p class="text-gray-500 mt-1">Kelola akses staff, admin, dan verifikasi pelanggan.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn-primary flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                </svg>
                Tambah User
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Pengguna</th>
                        <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Role / Akses</th>
                        <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Cabang</th>
                        <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Login Terakhir</th>
                        <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-8 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center font-bold shrink-0">
                                        {{ $user->getInitials() }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($user->roles as $role)
                                        <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-[10px] font-bold uppercase tracking-tighter">{{ $role->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-8 py-4 text-sm text-gray-600 font-medium">
                                {{ $user->branch->name ?? 'Global' }}
                            </td>
                            <td class="px-8 py-4">
                                @if($user->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">Blokir</span>
                                @endif
                            </td>
                            <td class="px-8 py-4 text-xs text-gray-400 italic">
                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah' }}
                            </td>
                            <td class="px-8 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 text-gray-400 hover:text-red-600 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
@endsection
