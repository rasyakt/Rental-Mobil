@extends('layout')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-red-600 mb-4">404</h1>
        <p class="text-2xl text-gray-800 mb-4">Halaman Tidak Ditemukan</p>
        <p class="text-gray-600 mb-8">Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan.</p>
        <a href="/" class="btn-primary inline-block">Kembali ke Beranda</a>
    </div>
</div>
@endsection
