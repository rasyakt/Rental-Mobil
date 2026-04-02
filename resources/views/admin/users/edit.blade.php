@extends('layouts.admin')

@section('title', 'Edit Pengguna - Admin Panel')
@section('header_title', 'Edit Staff')

@section('admin_content')
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Account Information -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10 overflow-hidden relative">
                <div class="absolute top-0 right-0 p-8">
                    <div class="h-20 w-20 bg-red-50 text-red-600 flex items-center justify-center rounded-full text-2xl font-black italic">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </div>
                
                <h3 class="text-xl font-black text-gray-900 italic tracking-tighter uppercase mb-8 border-b border-gray-50 pb-4">Informasi Akun</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 normal-case tracking-normal not-italic font-medium">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-3 italic">Nama Lengkap</label>
                        <input type="text" name="name" id="name" required class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-black italic uppercase" value="{{ old('name', $user->name) }}">
                    </div>
                    <div>
                        <label for="email" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-3 italic">Alamat Email</label>
                        <input type="email" name="email" id="email" required class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold" value="{{ old('email', $user->email) }}">
                    </div>
                    <div>
                        <label for="phone" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-3 italic">Nomor Telepon</label>
                        <input type="tel" name="phone" id="phone" required class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold" value="{{ old('phone', $user->phone) }}">
                    </div>
                </div>
            </div>

            <!-- Role & Permissions -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10">
                <h3 class="text-xl font-black text-gray-900 italic tracking-tighter uppercase mb-8 border-b border-gray-50 pb-4">Wewenang & Akses</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 normal-case tracking-normal not-italic font-medium">
                    <div>
                        <label for="role" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-3 italic">Peran (Role)</label>
                        <select name="role_id" id="role" required class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-black italic uppercase">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->roles->pluck('id')->contains($role->id) ? 'selected' : '' }}>
                                    {{ strtoupper($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="branch_id" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-3 italic">Penempatan Cabang</label>
                        <select name="branch_id" id="branch_id" class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-black italic uppercase">
                            <option value="">NON-CABANG (GLOBAL)</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ $user->branch_id == $branch->id ? 'selected' : '' }}>
                                    {{ strtoupper($branch->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-4 italic">Status Akun</label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }} class="hidden">
                                <div class="px-8 py-4 rounded-2xl border-2 border-gray-100 font-black italic uppercase text-sm transition group-hover:border-red-600 group-has-[:checked]:bg-red-600 group-has-[:checked]:text-white group-has-[:checked]:border-red-600">AKTIF</div>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="is_active" value="0" {{ !$user->is_active ? 'checked' : '' }} class="hidden">
                                <div class="px-8 py-4 rounded-2xl border-2 border-gray-100 font-black italic uppercase text-sm transition group-hover:border-red-600 group-has-[:checked]:bg-gray-900 group-has-[:checked]:text-white group-has-[:checked]:border-gray-900">NON-AKTIF</div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-6">
                <button type="submit" class="flex-1 py-5 bg-red-600 text-white rounded-3xl font-black italic uppercase tracking-widest shadow-xl hover:shadow-2xl transition transform hover:scale-[1.02] duration-200">
                    SIMPAN PERUBAHAN AKUN
                </button>
                <button type="button" onclick="confirm('Apakah Anda yakin ingin menghapus user ini?') && document.getElementById('delete-form').submit()" class="px-10 py-5 bg-white text-gray-400 rounded-3xl font-black italic uppercase tracking-widest border-2 border-gray-50 hover:bg-red-50 hover:text-red-600 hover:border-red-600 transition duration-200">
                    HAPUS USER
                </button>
            </div>
        </form>

        <form id="delete-form" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection
