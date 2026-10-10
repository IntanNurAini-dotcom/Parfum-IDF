@extends('layouts.app')

@section('content')
<div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Breadcrumb -->
    <nav class="flex text-xs text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-pink-600">Beranda</a>
        <span class="mx-2 text-pink-300">/</span>
        <a href="{{ route('catalog.index') }}" class="hover:text-pink-600">Katalog</a>
        <span class="mx-2 text-pink-300">/</span>
        <span class="text-pink-900 font-semibold truncate">{{ $product->name }}</span>
    </nav>

    <!-- Product Detail Section -->
    <div class="card-luxury p-6 sm:p-10 mb-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            
            <!-- Left Column: Image Showcase -->
            <div class="space-y-4">
                <div class="relative rounded-2xl overflow-hidden bg-gray-100 border border-pink-100 shadow-md">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-96 sm:h-[450px] object-cover">
                    <span class="absolute top-4 left-4 bg-rose-gold text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                        {{ $product->category->name }}
                    </span>
                    <span class="absolute top-4 right-4 bg-white/90 text-pink-950 text-xs font-bold px-3 py-1 rounded-full border border-pink-200">
                        {{ $product->size }}
                    </span>
                </div>
            </div>

            <!-- Right Column: Product Meta & Add to Cart Form -->
            <div class="space-y-6 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-pink-600 uppercase tracking-widest block">{{ $product->category->name }}</span>
                    <h1 class="font-serif-luxury text-3xl sm:text-4xl font-bold text-pink-950 mt-1">{{ $product->name }}</h1>
                    
                    <div class="flex items-center gap-4 mt-3">
                        <span class="font-serif-luxury text-3xl font-bold text-pink-900">{{ $product->formatted_price }}</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $product->stock > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                            {{ $product->stock > 0 ? 'Stok Tersedia (' . $product->stock . ' botol)' : 'Stok Habis' }}
                        </span>
                    </div>

                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mt-4 pt-4 border-t border-pink-100">
                        {{ $product->description }}
                    </p>

                    <!-- Scent Pyramid Notes Showcase -->
                    <div class="mt-6 p-5 rounded-2xl bg-pink-50/60 border border-pink-100 space-y-3">
                        <h4 class="font-serif-luxury font-bold text-sm text-pink-950 flex items-center gap-2">
                            <i class="fa-solid fa-layer-group text-amber-500"></i> Komposisi Piramida Aroma
                        </h4>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                            <div class="bg-white p-3 rounded-xl border border-pink-100">
                                <span class="text-[10px] font-bold text-pink-600 uppercase block">Top Notes</span>
                                <p class="text-gray-700 font-medium mt-0.5">{{ $product->top_notes ?? 'Segar, Buah sitrus' }}</p>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-pink-100">
                                <span class="text-[10px] font-bold text-pink-600 uppercase block">Middle Notes</span>
                                <p class="text-gray-700 font-medium mt-0.5">{{ $product->middle_notes ?? 'Bunga mekar, Rempah' }}</p>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-pink-100">
                                <span class="text-[10px] font-bold text-pink-600 uppercase block">Base Notes</span>
                                <p class="text-gray-700 font-medium mt-0.5">{{ $product->base_notes ?? 'Kayu hangat, Vanila' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.store') }}" method="POST" class="pt-6 border-t border-pink-100 space-y-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="flex items-center gap-4">
                        <label for="quantity" class="text-xs font-bold text-gray-700 uppercase tracking-wider">Kuantitas:</label>
                        <div class="flex items-center border border-pink-200 rounded-full overflow-hidden bg-white">
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                class="w-16 text-center border-none focus:ring-0 text-sm font-bold text-pink-950">
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-2">
                        @if($product->stock > 0)
                            <button type="submit" class="flex-1 py-3.5 px-6 rounded-full btn-pink-gold font-bold text-sm flex items-center justify-center gap-2">
                                <i class="fa-solid fa-bag-shopping"></i>
                                <span>Tambah ke Keranjang Belanja</span>
                            </button>
                        @else
                            <button type="button" disabled class="flex-1 py-3.5 px-6 rounded-full bg-gray-300 text-gray-500 font-bold text-sm cursor-not-allowed">
                                Stok Saat Ini Habis
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <div class="space-y-6">
            <div class="flex items-center justify-between border-b border-pink-200 pb-3">
                <h3 class="font-serif-luxury font-bold text-2xl text-pink-950">Wewangian Sejenis</h3>
                <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="text-xs font-bold text-pink-700 hover:underline">
                    Lihat Kategori Ini &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rel)
                    <div class="card-luxury overflow-hidden flex flex-col justify-between group">
                        <div class="relative overflow-hidden bg-gray-100">
                            <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-4 space-y-2">
                            <h4 class="font-serif-luxury font-bold text-base text-pink-950 truncate">
                                <a href="{{ route('catalog.show', $rel->slug) }}">{{ $rel->name }}</a>
                            </h4>
                            <p class="font-serif-luxury font-bold text-pink-900 text-sm">{{ $rel->formatted_price }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
