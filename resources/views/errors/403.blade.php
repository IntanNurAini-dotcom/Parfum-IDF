@extends('layouts.app')

@section('content')
<div class="py-24 max-w-4xl mx-auto px-4 text-center space-y-6">
    <div class="w-24 h-24 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center mx-auto text-4xl shadow-inner font-serif-luxury font-bold">
        403
    </div>
    <h1 class="font-serif-luxury text-4xl font-bold text-pink-950">Akses Terbatas (Hak Akses Ditolak)</h1>
    <p class="text-xs sm:text-sm text-gray-600 max-w-md mx-auto leading-relaxed">
        Anda tidak memiliki izin untuk mengakses area khusus ini. Silakan masuk menggunakan akun dengan wewenang yang sesuai.
    </p>
    <div>
        <a href="{{ route('home') }}" class="inline-block px-8 py-3.5 rounded-full btn-pink-gold text-xs font-bold shadow-lg">
            &larr; Kembali ke Beranda Utama
        </a>
    </div>
</div>
@endsection
