@extends('layouts.app')

@section('content')
<div class="py-24 max-w-4xl mx-auto px-4 text-center space-y-6">
    <div class="w-24 h-24 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto text-4xl shadow-inner font-serif-luxury font-bold">
        500
    </div>
    <h1 class="font-serif-luxury text-4xl font-bold text-pink-950">Terjadi Kesalahan Server</h1>
    <p class="text-xs sm:text-sm text-gray-600 max-w-md mx-auto leading-relaxed">
        Sistem kami sedang mengalami penyesuaian teknis sejenak. Silakan coba memuat ulang halaman beberapa saat lagi.
    </p>
    <div>
        <a href="{{ route('home') }}" class="inline-block px-8 py-3.5 rounded-full btn-pink-gold text-xs font-bold shadow-lg">
            &larr; Kembali ke Beranda Utama
        </a>
    </div>
</div>
@endsection
