@extends('layouts.app')

@section('content')
<!-- Hero Section Pink Gold Luxury -->
<section class="relative bg-pink-gold-gradient text-white overflow-hidden py-16 lg:py-24">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#E8A5C8_1px,transparent_1px)] [background-size:16px_16px]"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <!-- Left Text Content -->
            <div class="space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-pink-300/30 text-amber-300 text-xs font-semibold tracking-widest uppercase backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span> {{ config('store.tagline') }}
                </div>

                <h1 class="font-serif-luxury text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight">
                    Pesona Aroma <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-300 via-amber-200 to-pink-400">Kemewahan Abadi</span>
                </h1>

                <p class="text-pink-100/80 text-sm sm:text-base leading-relaxed max-w-xl mx-auto lg:mx-0">
                    Racikan wewangian Haute Parfumerie dari konsentrat minyak murni pilihan. Hadirkan karisma elegan, keharuman berkesan, dan daya pikat yang tak terlupakan.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ route('catalog.index') }}" class="w-full sm:w-auto px-8 py-3.5 rounded-full btn-pink-gold font-semibold text-sm tracking-wider shadow-lg flex items-center justify-center gap-2">
                        <span>Jelajahi Katalog</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    <a href="#scent-pyramid" class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-white/10 hover:bg-white/20 border border-pink-200/40 text-white font-semibold text-sm tracking-wider backdrop-blur-md transition-all text-center">
                        Panduan Aroma
                    </a>
                </div>

                <!-- Dynamic Marketing Claims from config/store.php -->
                <div class="grid grid-cols-3 gap-6 pt-8 border-t border-white/20 max-w-md mx-auto lg:mx-0">
                    <div>
                        <p class="font-serif-luxury text-xl sm:text-2xl font-bold text-amber-300">{{ config('store.claims.longevity.value') }}</p>
                        <p class="text-[11px] text-pink-200/70 mt-0.5">{{ config('store.claims.longevity.label') }}</p>
                    </div>
                    <div>
                        <p class="font-serif-luxury text-xl sm:text-2xl font-bold text-amber-300">{{ config('store.claims.purity.value') }}</p>
                        <p class="text-[11px] text-pink-200/70 mt-0.5">{{ config('store.claims.purity.label') }}</p>
                    </div>
                    <div>
                        <p class="font-serif-luxury text-xl sm:text-2xl font-bold text-amber-300">{{ config('store.claims.ethical.value') }}</p>
                        <p class="text-[11px] text-pink-200/70 mt-0.5">{{ config('store.claims.ethical.label') }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Hero Image Showcase (Dynamic Featured Product from Database) -->
            <div class="relative flex justify-center">
                <div class="w-72 h-72 sm:w-96 sm:h-96 rounded-full bg-gradient-to-tr from-pink-500/20 to-amber-300/20 absolute blur-3xl"></div>
                
                @if($heroProduct)
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl border-2 border-pink-300/30 max-w-md w-full bg-white/5 backdrop-blur-md p-4 group">
                        <a href="{{ route('catalog.show', $heroProduct->slug) }}" class="block relative rounded-2xl overflow-hidden">
                            <img src="{{ $heroProduct->image_url }}" 
                                 alt="{{ $heroProduct->name }}" 
                                 class="w-full h-80 sm:h-96 object-cover rounded-2xl group-hover:scale-105 transition-transform duration-700">
                        </a>
                        
                        <div class="absolute bottom-8 left-8 right-8 p-4 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-pink-200/60 text-gray-900">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-pink-600 block">{{ $heroProduct->category->name }}</span>
                                    <h3 class="font-serif-luxury font-bold text-lg text-pink-950">
                                        <a href="{{ route('catalog.show', $heroProduct->slug) }}" class="hover:text-pink-600 transition-colors">{{ $heroProduct->name }}</a>
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-0.5 truncate max-w-[200px]">{{ $heroProduct->top_notes ?? 'Piramida Aroma Eksklusif' }}</p>
                                </div>
                                <span class="font-serif-luxury font-bold text-pink-700 text-base">{{ $heroProduct->formatted_price }}</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl border-2 border-pink-300/30 max-w-md w-full bg-white/5 backdrop-blur-md p-4">
                        <img src="{{ asset('images/placeholders/product-placeholder.svg') }}" 
                             alt="Hero Perfume Parfum IDF" 
                             class="w-full h-80 sm:h-96 object-cover rounded-2xl">
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Category Banner Section (Dynamic 2 Categories: Parfum IDF & Body Mist) -->
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-2xl mx-auto mb-12">
        <span class="text-xs font-bold uppercase tracking-[0.2em] text-pink-600 block mb-1">Koleksi Utama</span>
        <h2 class="font-serif-luxury text-3xl font-bold text-pink-950">Kategori Wewangian Utama</h2>
        <div class="w-16 h-0.5 bg-gradient-to-r from-pink-400 to-amber-400 mx-auto mt-3"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
        @foreach($categories as $category)
            <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" 
               class="card-luxury overflow-hidden group flex flex-col justify-between hover:shadow-2xl transition-all duration-300">
                <div class="relative h-64 overflow-hidden bg-gray-100">
                    <img src="{{ $category->image_url }}" 
                         alt="{{ $category->name }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-pink-950/85 via-pink-950/30 to-transparent"></div>
                    
                    <div class="absolute bottom-6 left-6 right-6 space-y-1">
                        <span class="text-xs font-bold text-amber-300 uppercase tracking-widest block">{{ $category->products_count }} Produk Tersedia</span>
                        <h3 class="font-serif-luxury font-bold text-2xl text-white group-hover:text-amber-200 transition-colors">{{ $category->name }}</h3>
                        <p class="text-xs text-pink-100/80 line-clamp-2 leading-relaxed pt-1">{{ $category->description }}</p>
                    </div>
                </div>
                <div class="p-4 bg-white flex justify-between items-center text-xs font-bold text-pink-950 border-t border-pink-100">
                    <span>Lihat Koleksi {{ $category->name }}</span>
                    <i class="fa-solid fa-arrow-right text-pink-600 group-hover:translate-x-1 transition-transform"></i>
                </div>
            </a>
        @endforeach
    </div>
</section>

<!-- Featured Products Section (Dynamic 4 Featured Products) -->
<section class="py-16 bg-pink-50/50 border-y border-pink-100/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12">
            <div>
                <span class="text-xs font-bold uppercase tracking-[0.2em] text-pink-600 block mb-1">Pilihan Kurator</span>
                <h2 class="font-serif-luxury text-3xl font-bold text-pink-950">Wewangian Unggulan</h2>
            </div>
            <a href="{{ route('catalog.index') }}" class="mt-4 md:mt-0 text-xs font-bold text-pink-700 hover:text-pink-900 flex items-center gap-1">
                <span>Lihat Semua Produk</span>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <div class="card-luxury overflow-hidden flex flex-col justify-between group">
                    <div class="relative overflow-hidden bg-gray-100">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-3 left-3 bg-rose-gold text-white text-[9px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider shadow">
                            Featured
                        </span>
                        <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-md text-pink-950 text-xs font-bold px-2.5 py-0.5 rounded-full border border-pink-200">
                            {{ $product->size }}
                        </span>
                    </div>

                    <div class="p-5 space-y-3 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-pink-600 uppercase tracking-widest block">{{ $product->category->name }}</span>
                            <h3 class="font-serif-luxury font-bold text-lg text-pink-950 mt-1 group-hover:text-pink-600 transition-colors">
                                <a href="{{ route('catalog.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="text-xs text-gray-500 line-clamp-2 mt-1.5 leading-relaxed">{{ $product->description }}</p>
                        </div>

                        <!-- Notes Pyramid Preview -->
                        <div class="pt-2 border-t border-pink-100/80 text-[10px] space-y-0.5">
                            <p class="text-gray-600 truncate"><span class="font-semibold text-pink-800">Top Notes:</span> {{ $product->top_notes ?? '-' }}</p>
                            <p class="text-gray-600 truncate"><span class="font-semibold text-pink-800">Base Notes:</span> {{ $product->base_notes ?? '-' }}</p>
                        </div>

                        <div class="pt-3 flex items-center justify-between border-t border-pink-100/80 gap-2">
                            <span class="font-serif-luxury font-bold text-base text-pink-900">{{ $product->formatted_price }}</span>
                            <div class="flex items-center gap-1.5">
                                @auth
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="w-8 h-8 rounded-full bg-pink-100 hover:bg-pink-600 hover:text-white text-pink-700 text-xs transition-colors flex items-center justify-center" title="Tambah ke Keranjang">
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="w-8 h-8 rounded-full bg-pink-100 hover:bg-pink-600 hover:text-white text-pink-700 text-xs transition-colors flex items-center justify-center" title="Tambah ke Keranjang">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </a>
                                @endauth
                                <a href="{{ route('catalog.show', $product->slug) }}" class="px-3.5 py-2 rounded-full btn-pink-gold text-xs font-semibold">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Scent Pyramid Guide Section -->
<section id="scent-pyramid" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-2xl mx-auto mb-16">
        <span class="text-xs font-bold uppercase tracking-[0.2em] text-pink-600 block mb-1">Edukasi Olfaktori</span>
        <h2 class="font-serif-luxury text-3xl font-bold text-pink-950">Memahami Piramida Aroma</h2>
        <p class="text-xs text-gray-600 mt-2">Setiap racikan Parfum IDF berkembang indah seiring berjalannya waktu melalui 3 tahapan aroma.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="card-luxury p-8 text-center space-y-4">
            <div class="w-14 h-14 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center mx-auto text-xl font-serif-luxury font-bold">
                01
            </div>
            <h3 class="font-serif-luxury font-bold text-xl text-pink-950">Top Notes</h3>
            <span class="inline-block text-[10px] font-bold text-amber-700 bg-amber-100 px-3 py-1 rounded-full">15-30 Menit Pertama</span>
            <p class="text-xs text-gray-600 leading-relaxed">
                Kesan pertama saat parfum disemprotkan. Biasanya terdiri dari aroma sitrus segar, buah manis, atau dedaunan hijau yang memikat pandangan pertama.
            </p>
        </div>

        <div class="card-luxury p-8 text-center space-y-4 border-pink-300">
            <div class="w-14 h-14 rounded-full bg-rose-gold text-white flex items-center justify-center mx-auto text-xl font-serif-luxury font-bold shadow-md">
                02
            </div>
            <h3 class="font-serif-luxury font-bold text-xl text-pink-950">Heart / Middle Notes</h3>
            <span class="inline-block text-[10px] font-bold text-pink-800 bg-pink-100 px-3 py-1 rounded-full">2 - 4 Jam Kemudian</span>
            <p class="text-xs text-gray-600 leading-relaxed">
                Jiwa utama dari wewangian. Muncul saat top notes mulai mereda, menghadirkan keanggunan aroma kelopak bunga, rempah-rempah halus, dan kemewahan alami.
            </p>
        </div>

        <div class="card-luxury p-8 text-center space-y-4">
            <div class="w-14 h-14 rounded-full bg-pink-950 text-amber-300 flex items-center justify-center mx-auto text-xl font-serif-luxury font-bold">
                03
            </div>
            <h3 class="font-serif-luxury font-bold text-xl text-pink-950">Base Notes</h3>
            <span class="inline-block text-[10px] font-bold text-purple-800 bg-purple-100 px-3 py-1 rounded-full">Hingga 24 Jam</span>
            <p class="text-xs text-gray-600 leading-relaxed">
                Pondasi akhir yang bertahan lama di kulit dan pakaian. Terdiri dari kayu cendana, amber, oud, vanila, dan musk yang memberikan kesan hangat dan mendalam.
            </p>
        </div>
    </div>
</section>
@endsection
