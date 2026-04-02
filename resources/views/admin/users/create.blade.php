@extends('layouts.admin')

@section('title', 'Tambah Pengguna Baru - Admin Panel')
@section('header_title', 'Register Staff')

@section('admin_content')
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Account Information -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10">
                <h3 class="text-xl font-black text-gray-900 italic tracking-tighter uppercase mb-8 border-b border-gray-50 pb-4">Data Identitas</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 normal-case tracking-normal not-italic font-medium">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-3 italic">Nama Lengkap</label>
                        <input type="text" name="name" id="name" required class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-black italic uppercase" value="{{ old('name') }}" placeholder="Contoh: Admin Utama">
                    </div>
                    <div>
                        <label for="email" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-3 italic">Alamat Email</label>
                        <input type="email" name="email" id="email" required class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold" value="{{ old('email') }}" placeholder="email@rental-mobil.com">
                    </div>
                    <div>
                        <label for="phone" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-3 italic">Nomor Telepon</label>
                        <input type="tel" name="phone" id="phone" required class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold" value="{{ old('phone') }}" placeholder="0812XXXXXXXX">
                    </div>
                </div>
            </div>

            <!-- Credentials -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10">
                <h3 class="text-xl font-black text-gray-900 italic tracking-tighter uppercase mb-8 border-b border-gray-50 pb-4">Keamanan Akun</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 normal-case tracking-normal not-italic font-medium">
                    <div>
                        <label for="password" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-3 italic">Password</label>
                        <input type="password" name="password" id="password" required class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold" placeholder="••••••••">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-3 italic">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold" placeholder="••••••••">
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
                            <option value="" disabled selected>Pilih Role User</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ strtoupper($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="branch_id" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-3 italic">Penempatan Cabang</label>
                        <select name="branch_id" id="branch_id" class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-black italic uppercase">
                            <option value="">NON-CABANG (GLOBAL ADMIN)</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ strtoupper($branch->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full py-6 bg-red-600 text-white rounded-[2rem] font-black italic uppercase tracking-widest shadow-xl hover:shadow-2xl transition transform hover:scale-[1.01] duration-200">
                DAFTARKAN PENGGUNA BARU
            </button>
        </form>
    </div>
@endsection
