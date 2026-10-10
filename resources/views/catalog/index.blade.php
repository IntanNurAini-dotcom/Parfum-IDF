@extends('layouts.app')

@section('content')
<div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Catalog Header -->
    <div class="mb-10 text-center md:text-left flex flex-col md:flex-row justify-between items-center gap-6 bg-pink-gold-gradient text-white p-8 rounded-3xl shadow-xl">
        <div>
            <span class="text-xs font-bold text-amber-300 uppercase tracking-widest block mb-1">Haute Parfumerie</span>
            <h1 class="font-serif-luxury text-3xl font-bold">Katalog Koleksi Wewangian</h1>
            <p class="text-xs text-pink-200/80 mt-1 max-w-md">Temukan racikan aroma eksklusif yang mengekspresikan karakter dan daya pikat pribadi Anda.</p>
        </div>

        <!-- Live Search Bar inside banner -->
        <form action="{{ route('catalog.index') }}" method="GET" class="w-full md:w-auto flex items-center gap-2">
            <div class="relative w-full md:w-72">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama parfum / notes..."
                    class="w-full pl-9 pr-4 py-2.5 text-xs text-gray-800 rounded-full border-none focus:ring-2 focus:ring-amber-300 shadow">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-pink-400 text-xs"></i>
            </div>
            <button type="submit" class="px-5 py-2.5 rounded-full bg-amber-400 hover:bg-amber-300 text-pink-950 font-bold text-xs shadow transition-colors">
                Cari
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Left Sidebar Filter -->
        <aside class="space-y-6">
            <div class="card-luxury p-6">
                <h3 class="font-serif-luxury font-bold text-lg text-pink-950 mb-4 pb-2 border-b border-pink-100">
                    <i class="fa-solid fa-sliders text-pink-500 mr-2 text-sm"></i> Filter Katalog
                </h3>

                <form action="{{ route('catalog.index') }}" method="GET" class="space-y-5">
                    @if(request('q'))
                        <input type="hidden" name="q" value="{{ request('q') }}">
                    @endif

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kategori</label>
                        <div class="space-y-1.5 text-xs">
                            <a href="{{ route('catalog.index', array_merge(request()->query(), ['category' => null])) }}" 
                                class="block px-3 py-2 rounded-lg transition-colors {{ !request('category') ? 'bg-pink-600 text-white font-bold' : 'text-gray-600 hover:bg-pink-50' }}">
                                Semua Kategori
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('catalog.index', array_merge(request()->query(), ['category' => $cat->slug])) }}" 
                                    class="block px-3 py-2 rounded-lg transition-colors {{ request('category') == $cat->slug ? 'bg-pink-600 text-white font-bold' : 'text-gray-600 hover:bg-pink-50' }}">
                                    {{ $cat->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div class="pt-4 border-t border-pink-100">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Rentang Harga (Rp)</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500">
                        </div>
                    </div>

                    <!-- Sorting Filter -->
                    <div class="pt-4 border-t border-pink-100">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Urutkan</label>
                        <select name="sort" class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Termurah</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Termahal</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama: A - Z</option>
                        </select>
                    </div>

                    <div class="pt-2 flex gap-2">
                        <button type="submit" class="w-full py-2.5 rounded-full btn-pink-gold text-xs font-bold">Terapkan Filter</button>
                        <a href="{{ route('catalog.index') }}" class="px-3 py-2.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold">Reset</a>
                    </div>
                </form>
            </div>
        </aside>

        <!-- Right Products Grid -->
        <main class="lg:col-span-3">
            @if($products->isEmpty())
                <div class="card-luxury p-12 text-center space-y-4">
                    <div class="w-16 h-16 rounded-full bg-pink-100 text-pink-400 flex items-center justify-center mx-auto text-2xl">
                        <i class="fa-solid fa-spray-can"></i>
                    </div>
                    <h3 class="font-serif-luxury font-bold text-xl text-pink-950">Produk Tidak Ditemukan</h3>
                    <p class="text-xs text-gray-500 max-w-sm mx-auto">Maaf, tidak ada wewangian yang sesuai dengan kriteria pencarian Anda. Coba ubah filter atau kata kunci.</p>
                    <a href="{{ route('catalog.index') }}" class="inline-block px-6 py-2.5 rounded-full btn-pink-gold text-xs font-bold mt-2">
                        Lihat Semua Parfum
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="card-luxury overflow-hidden flex flex-col justify-between group">
                            <div class="relative overflow-hidden bg-gray-100">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500">
                                @if($product->is_featured)
                                    <span class="absolute top-3 left-3 bg-rose-gold text-white text-[9px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                        Featured
                                    </span>
                                @endif
                                <span class="absolute top-3 right-3 bg-white/90 text-pink-950 text-[10px] font-bold px-2 py-0.5 rounded-full border border-pink-200">
                                    {{ $product->size }}
                                </span>
                            </div>

                            <div class="p-5 space-y-3 flex-grow flex flex-col justify-between">
                                <div>
                                    <span class="text-[9px] font-bold text-pink-600 uppercase tracking-widest block">{{ $product->category->name }}</span>
                                    <h3 class="font-serif-luxury font-bold text-lg text-pink-950 mt-0.5 group-hover:text-pink-600 transition-colors">
                                        <a href="{{ route('catalog.show', $product->slug) }}">{{ $product->name }}</a>
                                    </h3>
                                    <p class="text-xs text-gray-500 line-clamp-2 mt-1 leading-relaxed">{{ $product->description }}</p>
                                </div>

                                <div class="pt-2 text-[10px] text-gray-500 space-y-0.5 border-t border-pink-100">
                                    <p class="truncate"><strong class="text-pink-800">Top:</strong> {{ $product->top_notes ?? '-' }}</p>
                                    <p class="truncate"><strong class="text-pink-800">Base:</strong> {{ $product->base_notes ?? '-' }}</p>
                                </div>

                                <div class="pt-3 flex items-center justify-between border-t border-pink-100">
                                    <div>
                                        <span class="font-serif-luxury font-bold text-base text-pink-950 block">{{ $product->formatted_price }}</span>
                                        <span class="text-[10px] {{ $product->stock > 0 ? 'text-emerald-600' : 'text-rose-600 font-bold' }}">
                                            {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Stok Habis' }}
                                        </span>
                                    </div>
                                    <a href="{{ route('catalog.show', $product->slug) }}" class="px-3.5 py-2 rounded-full btn-pink-gold text-xs font-semibold">
                                        Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
