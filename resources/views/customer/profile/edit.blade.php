@extends('layout')

@section('title', 'Profil Saya - Rental Mobil')

@section('content')
<div class="min-h-screen bg-gray-50 pb-12">
    <!-- Navbar Customer -->
    <nav class="bg-white shadow-sm mb-8 border-b border-gray-100 italic normal-case tracking-normal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-6">
                    <a href="/" class="text-2xl font-black text-red-600 tracking-tighter uppercase">RENTAL MOBIL</a>
                    <div class="hidden md:flex items-center gap-4 text-sm font-bold text-gray-400">
                        <a href="{{ route('customer.dashboard') }}" class="hover:text-red-600 transition">Beranda</a>
                        <a href="{{ route('customer.bookings.index') }}" class="hover:text-red-600 transition">Pesanan Saya</a>
                        <a href="{{ route('customer.profile.edit') }}" class="text-red-600">Profil</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <div class="h-24 w-24 bg-red-600 text-white flex items-center justify-center rounded-full mx-auto mb-4 text-4xl shadow-xl border-4 border-white transition hover:scale-110 duration-200">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <h2 class="text-3xl font-black text-gray-900 uppercase">Profil & Keamanan</h2>
            <p class="text-gray-500 mt-1 lowercase font-bold normal-case italic tracking-normal">Kelola informasi data diri dan keamanan akun Anda.</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-600 p-4 mb-8">
                <p class="text-green-700 italic font-black uppercase text-xs tracking-widest">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-10">
            <!-- Basic Info Form -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-10 overflow-hidden">
                <h3 class="text-xl font-black text-gray-900 italic tracking-tighter uppercase mb-8 pb-4 border-b border-gray-50">Informasi Dasar</h3>
                <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-6 normal-case tracking-normal not-italic font-medium">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-2 italic">Nama Lengkap</label>
                            <input type="text" name="name" id="name" required class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold" value="{{ old('name', $user->name) }}">
                        </div>
                        <div>
                            <label for="email" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-2 italic">Alamat Email</label>
                            <input type="email" name="email" id="email" required class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold" value="{{ old('email', $user->email) }}">
                        </div>
                        <div>
                            <label for="phone" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-2 italic">Nomor Telepon</label>
                            <input type="tel" name="phone" id="phone" required class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold" value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div>
                            <label for="city" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-2 italic">Kota</label>
                            <input type="text" name="city" id="city" class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold" value="{{ old('city', $user->city) }}">
                        </div>
                        <div class="md:col-span-2">
                            <label for="address" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-2 italic">Alamat Lengkap</label>
                            <textarea name="address" id="address" rows="3" class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold">{{ old('address', $user->address) }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="w-full py-5 bg-red-600 text-white rounded-2xl font-black italic uppercase tracking-widest shadow-lg hover:shadow-xl transition transform hover:scale-[1.02]">
                        SIMPAN PERUBAHAN PROFIL
                    </button>
                </form>
            </div>

            <!-- Security Info Form -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-10">
                <h3 class="text-xl font-black text-gray-900 italic tracking-tighter uppercase mb-8 pb-4 border-b border-gray-50">Keamanan & Password</h3>
                <form action="{{ route('customer.profile.password.update') }}" method="POST" class="space-y-6 normal-case tracking-normal not-italic font-medium">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="current_password" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-2 italic">Password Saat Ini</label>
                            <input type="password" name="current_password" id="current_password" required class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold" placeholder="••••••••">
                        </div>
                        <div>
                            <label for="password" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-2 italic">Password Baru</label>
                            <input type="password" name="password" id="password" required class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold" placeholder="••••••••">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-2 italic">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-600 focus:ring-0 transition font-bold" placeholder="••••••••">
                        </div>
                    </div>
                    <button type="submit" class="w-full py-5 bg-gray-900 text-white rounded-2xl font-black italic uppercase tracking-widest shadow-lg hover:shadow-xl transition transform hover:scale-[1.02]">
                        PERBARUI KEAMANAN AKUN
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
