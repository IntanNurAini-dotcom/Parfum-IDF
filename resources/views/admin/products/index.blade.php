@extends('layouts.admin')

@section('title', 'Manajemen Produk Parfum')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="font-serif-luxury font-bold text-2xl text-pink-950">Katalog Produk Parfum Admin</h2>
            <p class="text-xs text-gray-500 mt-0.5">Kelola data seluruh varian parfum, stok, piramida aroma, dan harga.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="px-5 py-2.5 rounded-full btn-pink-gold font-bold text-xs flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Parfum Baru
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-pink-100 shadow-sm">
        <form action="{{ route('admin.products.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama parfum..."
                class="rounded-xl border-pink-200 focus:border-pink-500 text-xs p-2">
            
            <select name="category" class="rounded-xl border-pink-200 focus:border-pink-500 text-xs p-2">
                <option value="">-- Semua Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 rounded-xl btn-pink-gold font-bold text-xs">Filter Produk</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-700">
                <thead class="bg-pink-50/70 uppercase font-bold text-[10px] text-pink-900 tracking-wider">
                    <tr>
                        <th class="p-4">Foto</th>
                        <th class="p-4">Nama Parfum</th>
                        <th class="p-4">Kategori & Ukuran</th>
                        <th class="p-4">Harga</th>
                        <th class="p-4">Stok</th>
                        <th class="p-4">Piramida Aroma (Notes)</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-pink-100">
                    @foreach($products as $product)
                        <tr class="hover:bg-pink-50/20 transition-colors">
                            <td class="p-4">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-xl border border-pink-100">
                            </td>
                            <td class="p-4">
                                <strong class="font-serif-luxury text-sm text-pink-950 block">{{ $product->name }}</strong>
                                @if($product->is_featured)
                                    <span class="inline-block bg-amber-100 text-amber-800 text-[9px] font-bold px-2 py-0.5 rounded-full mt-0.5">Featured</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="block font-semibold text-gray-800">{{ $product->category->name }}</span>
                                <span class="text-[10px] text-gray-500">{{ $product->size }}</span>
                            </td>
                            <td class="p-4 font-bold text-pink-900 font-serif-luxury text-sm">{{ $product->formatted_price }}</td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $product->stock > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $product->stock }} botol
                                </span>
                            </td>
                            <td class="p-4 max-w-xs text-[11px] text-gray-500">
                                <p class="truncate"><strong class="text-pink-800">Top:</strong> {{ $product->top_notes ?? '-' }}</p>
                                <p class="truncate"><strong class="text-pink-800">Base:</strong> {{ $product->base_notes ?? '-' }}</p>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $product->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $product->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="px-3 py-1.5 rounded-lg bg-amber-100 text-amber-900 hover:bg-amber-200 text-xs font-bold">
                                    Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus produk parfum ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-100 text-rose-800 hover:bg-rose-200 text-xs font-bold">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
