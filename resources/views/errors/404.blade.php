@extends('layouts.app')

@section('content')
<div class="py-24 max-w-4xl mx-auto px-4 text-center space-y-6">
    <div class="w-24 h-24 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center mx-auto text-4xl shadow-inner font-serif-luxury font-bold">
        404
    </div>
    <h1 class="font-serif-luxury text-4xl font-bold text-pink-950">Aroma Halaman Tidak Ditemukan</h1>
    <p class="text-xs sm:text-sm text-gray-600 max-w-md mx-auto leading-relaxed">
        Maaf, halaman wewangian yang Anda cari tidak dapat ditemukan atau telah dipindahkan. Silakan kembali ke katalog utama Parfum IDF.
    </p>
    <div>
        <a href="{{ route('home') }}" class="inline-block px-8 py-3.5 rounded-full btn-pink-gold text-xs font-bold shadow-lg">
            &larr; Kembali ke Beranda Utama
        </a>
    </div>
</div>
@endsection
