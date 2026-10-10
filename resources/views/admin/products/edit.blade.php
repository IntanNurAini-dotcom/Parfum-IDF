@extends('layouts.admin')

@section('title', 'Edit Produk Parfum')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-pink-100 p-8 shadow-sm space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-pink-100">
            <h2 class="font-serif-luxury font-bold text-xl text-pink-950">Form Edit Produk Parfum</h2>
            <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-pink-600 hover:underline">&larr; Batal</a>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Parfum *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                        class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Kategori Fragrance *</label>
                    <select name="category_id" required class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Ukuran Botol (ML) *</label>
                    <input type="text" name="size" value="{{ old('size', $product->size) }}" required
                        class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Harga Produk (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required
                        class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Stok Botol *</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required
                        class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5">
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi & Karakter Parfum *</label>
                <textarea name="description" rows="3" required
                    class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Scent Pyramid Notes -->
            <div class="p-4 bg-pink-50/50 rounded-2xl border border-pink-100 space-y-3">
                <h4 class="font-serif-luxury font-bold text-sm text-pink-950">Komposisi Piramida Aroma</h4>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block font-bold text-pink-800 uppercase tracking-wider mb-1">Top Notes</label>
                        <input type="text" name="top_notes" value="{{ old('top_notes', $product->top_notes) }}"
                            class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2">
                    </div>

                    <div>
                        <label class="block font-bold text-pink-800 uppercase tracking-wider mb-1">Middle Notes</label>
                        <input type="text" name="middle_notes" value="{{ old('middle_notes', $product->middle_notes) }}"
                            class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2">
                    </div>

                    <div>
                        <label class="block font-bold text-pink-800 uppercase tracking-wider mb-1">Base Notes</label>
                        <input type="text" name="base_notes" value="{{ old('base_notes', $product->base_notes) }}"
                            class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2">
                    </div>
                </div>
            </div>

            <!-- Image upload & Toggles -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Foto Saat Ini</label>
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-20 h-20 object-cover rounded-xl mb-2 border">
                    <input type="file" name="image" accept="image/*"
                        class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200">
                </div>

                <div class="flex items-center space-x-6 pt-4">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="rounded text-pink-600 focus:ring-pink-500">
                        <span class="ml-2 font-bold text-gray-700">Featured</span>
                    </label>

                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="rounded text-pink-600 focus:ring-pink-500">
                        <span class="ml-2 font-bold text-gray-700">Status Aktif</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-pink-100 flex gap-3">
                <button type="submit" class="px-6 py-3 rounded-full btn-pink-gold font-bold text-xs">Perbarui Produk Parfum</button>
                <a href="{{ route('admin.products.index') }}" class="px-6 py-3 rounded-full bg-gray-100 text-gray-700 font-bold text-xs">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
