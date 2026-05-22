@extends('layout')

@section('title', 'Admin Panel - Rental Mobil')

@section('content')
<div x-data="{ sidebarOpen: false }" class="flex h-screen bg-slate-50 overflow-hidden text-slate-800">

    <!-- Mobile sidebar backdrop -->
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm md:hidden" @click="sidebarOpen = false"></div>

    <!-- Sidebar -->
    <aside 
        class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-white shadow-xl transform transition-transform duration-300 md:relative md:translate-x-0 flex flex-col"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        
        <!-- Sidebar Header / Brand Logo -->
        <div class="h-20 flex items-center px-8 border-b border-slate-800/80 gap-3">
            <div class="w-9 h-9 rounded-xl bg-red-600 text-white flex items-center justify-center shadow-md">
                <i class="fa-solid fa-car-rear text-sm"></i>
            </div>
            <div class="text-lg font-bold tracking-tight text-white">
                RENTAL<span class="text-red-500 font-extrabold">MOBIL</span>
            </div>
        </div>

        <!-- Sidebar Navigation Menu -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto custom-scrollbar">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-red-600 text-white shadow-md shadow-red-600/10' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <i class="fa-solid fa-chart-pie text-[15px] w-5 text-center {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Dashboard</span>
            </a>

            <div class="pt-5 pb-1.5">
                <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Core Logistik</p>
            </div>

            <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition duration-200 {{ request()->routeIs('admin.bookings.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/10' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <i class="fa-solid fa-calendar-check text-[15px] w-5 text-center {{ request()->routeIs('admin.bookings.*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Bookings</span>
            </a>

            <a href="{{ route('admin.vehicles.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition duration-200 {{ request()->routeIs('admin.vehicles.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/10' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <i class="fa-solid fa-car text-[15px] w-5 text-center {{ request()->routeIs('admin.vehicles.*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Armada / Fleet</span>
            </a>
            
            <a href="{{ route('admin.drivers.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition duration-200 {{ request()->routeIs('admin.drivers.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/10' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <i class="fa-solid fa-user-tie text-[15px] w-5 text-center {{ request()->routeIs('admin.drivers.*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Drivers</span>
            </a>

            <div class="pt-5 pb-1.5">
                <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Manajemen</p>
            </div>

            <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition duration-200 {{ request()->routeIs('admin.payments.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/10' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <i class="fa-solid fa-credit-card text-[15px] w-5 text-center {{ request()->routeIs('admin.payments.*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Payments</span>
            </a>

            <a href="{{ route('admin.maintenance.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition duration-200 {{ request()->routeIs('admin.maintenance.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/10' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <i class="fa-solid fa-screwdriver-wrench text-[15px] w-5 text-center {{ request()->routeIs('admin.maintenance.*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Maintenance</span>
            </a>

            <div class="pt-5 pb-1.5">
                <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Sistem</p>
            </div>

            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/10' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <i class="fa-solid fa-users-gear text-[15px] w-5 text-center {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Pengguna</span>
            </a>

            <a href="{{ route('admin.branches.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition duration-200 {{ request()->routeIs('admin.branches.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/10' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <i class="fa-solid fa-building text-[15px] w-5 text-center {{ request()->routeIs('admin.branches.*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Cabang</span>
            </a>

            <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition duration-200 {{ request()->routeIs('admin.reports.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/10' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <i class="fa-solid fa-chart-line text-[15px] w-5 text-center {{ request()->routeIs('admin.reports.*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Laporan</span>
            </a>
        </nav>
        
        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-800/80 bg-slate-900/50">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2.5 px-4 py-3 bg-slate-800 hover:bg-red-600 text-slate-300 hover:text-white text-sm font-bold rounded-xl transition duration-200 cursor-pointer">
                    <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i>
                    <span>Keluar / Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Panel -->
    <div class="flex-1 flex flex-col min-w-0 bg-slate-50 h-screen overflow-y-auto">
        <!-- Top Sticky Header -->
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-100 px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between shadow-xs">
            <!-- Mobile Menu Toggle Button -->
            <button @click="sidebarOpen = true" class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-50 transition outline-none cursor-pointer">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>

            <!-- Topbar Workspace Breadcrumbs -->
            <div class="hidden md:flex flex-col">
                <h2 class="text-sm font-bold text-slate-900">@yield('header_title', 'Dashboard')</h2>
                <p class="text-xs text-slate-400 font-medium">Rental Mobil Management System</p>
            </div>

            <!-- Profile Info Widget -->
            <div class="flex items-center gap-3.5 ml-auto">
                <div class="text-right hidden sm:block">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ auth()->user()->role === 'admin' ? 'Administrator' : 'Staff Operasional' }}</div>
                    <div class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</div>
                </div>
                <div class="h-10 w-10 rounded-xl bg-red-50 text-red-600 font-extrabold flex items-center justify-center text-sm border border-red-100 shadow-xs">
                    {{ substr(auth()->user()->name, 0, 2) }}
                </div>
            </div>
        </header>

        <!-- Dynamic Admin Content View -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('admin_content')
        </main>
    </div>
</div>

<style>
/* Custom Scrollbar for sidebar navigation */
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: rgba(255, 255, 255, 0.08);
  border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background-color: rgba(255, 255, 255, 0.15);
}
</style>
@endsection
