@extends('layouts.admin')

@section('title', 'Detail Pemeliharaan - Admin Panel')
@section('header_title', 'Detail Pekerjaan Pemeliharaan')

@section('admin_content')
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Service Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Overview Card -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10">
                    <div class="flex justify-between items-start mb-10">
                        <div>
                            <span class="text-xs font-black text-red-600 uppercase tracking-[0.4em] mb-3 block italic">Service Overview</span>
                            <h3 class="text-3xl font-black text-gray-900 italic uppercase leading-none">{{ $maintenance->maintenance_type }}</h3>
                        </div>
                        @if($maintenance->status === 'completed')
                            <span class="badge-success italic text-xs px-6 py-2 uppercase font-black tracking-widest">SELESAI</span>
                        @elseif($maintenance->status === 'scheduled')
                            <span class="badge-warning italic text-xs px-6 py-2 uppercase font-black tracking-widest">TERJADWAL</span>
                        @elseif($maintenance->status === 'in_progress')
                            <span class="badge-warning bg-blue-600 text-white italic text-xs px-6 py-2 uppercase font-black tracking-widest">PROSES</span>
                        @else
                            <span class="badge-danger italic text-xs px-6 py-2 uppercase font-black tracking-widest">{{ $maintenance->status }}</span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-6">
                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2 block italic">Tanggal Mulai</label>
                                <p class="text-lg font-black text-gray-900 italic uppercase underline decoration-red-600 decoration-4">
                                    {{ $maintenance->start_date->format('d M Y') }}
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2 block italic">Biaya Service</label>
                                <p class="text-3xl font-black text-gray-900 italic">Rp {{ number_format($maintenance->cost, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2 block italic">Tanggal Selesai (Estimasi)</label>
                                <p class="text-lg font-black text-gray-900 italic uppercase">
                                    {{ $maintenance->end_date ? $maintenance->end_date->format('d M Y') : '-' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2 block italic">Odometer (KM)</label>
                                <p class="text-lg font-black text-gray-900 italic uppercase">{{ number_format($maintenance->odometer, 0, ',', '.') }} KM</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 pt-10 border-t border-gray-50">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 block italic">Rincian Pekerjaan</label>
                        <div class="bg-gray-50 rounded-3xl p-8 italic normal-case tracking-normal font-bold text-gray-600 text-lg">
                            {{ $maintenance->description ?: 'Tidak ada deskripsi rincian pekerjaan.' }}
                        </div>
                    </div>
                </div>

                <!-- Parts Replacement if any -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10">
                    <h4 class="text-xl font-black text-gray-900 italic uppercase tracking-tighter mb-8">Suku Cadang & Komponen</h4>
                    @if($maintenance->parts_replaced)
                        <div class="space-y-4">
                            @foreach(json_decode($maintenance->parts_replaced) as $part)
                                <div class="flex justify-between items-center p-6 bg-gray-50 rounded-2xl group hover:bg-gray-900 hover:text-white transition duration-300">
                                    <div class="font-black italic uppercase italic">{{ $part->name }}</div>
                                    <div class="text-red-600 font-black group-hover:text-red-400">Rp {{ number_format($part->price, 0, ',', '.') }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 font-bold lowercase italic text-center py-8">Tidak ada data penggantian suku cadang.</p>
                    @endif
                </div>
            </div>

            <!-- Right Column: Vehicle Info -->
            <div class="space-y-8">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10 sticky top-8">
                    <h4 class="text-xl font-black text-gray-900 italic uppercase tracking-tighter mb-8">Informasi Kendaraan</h4>
                    <div class="aspect-video bg-gray-100 rounded-3xl overflow-hidden mb-8 shadow-inner">
                        @if($maintenance->vehicle->images->count() > 0)
                            <img src="{{ Storage::url($maintenance->vehicle->images->first()->path) }}" alt="{{ $maintenance->vehicle->model }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="space-y-6">
                        <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                            <span class="text-xs font-black text-gray-400 uppercase tracking-widest italic">Model</span>
                            <span class="font-black text-gray-900 italic uppercase">{{ $maintenance->vehicle->brand }} {{ $maintenance->vehicle->model }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                            <span class="text-xs font-black text-gray-400 uppercase tracking-widest italic">Plat Nomor</span>
                            <span class="px-3 py-1 bg-gray-900 text-white rounded font-black tracking-widest">{{ $maintenance->vehicle->plate_number }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                            <span class="text-xs font-black text-gray-400 uppercase tracking-widest italic">Kategori</span>
                            <span class="font-black text-red-600 italic uppercase">{{ $maintenance->vehicle->category->name }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.vehicles.show', $maintenance->vehicle->id) }}" class="w-full mt-8 py-4 bg-gray-50 text-gray-900 rounded-2xl font-black italic uppercase tracking-widest text-center block hover:bg-red-600 hover:text-white transition shadow-sm">
                        LIHAT RIWAYAT MOBIL
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
