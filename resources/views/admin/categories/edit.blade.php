@extends('layouts.admin')

@section('title', 'Edit Kategori Fragrance')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-pink-100 p-8 shadow-sm space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-pink-100">
            <h2 class="font-serif-luxury font-bold text-xl text-pink-950">Form Edit Kategori Fragrance</h2>
            <a href="{{ route('admin.categories.index') }}" class="text-xs font-bold text-pink-600 hover:underline">&larr; Batal</a>
        </div>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Kategori *</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                    class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5">
            </div>

            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi Kategori</label>
                <textarea name="description" rows="3"
                    class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5">{{ old('description', $category->description) }}</textarea>
            </div>

            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Foto / Sampul Saat Ini</label>
                @if($category->image)
                    <img src="{{ str_starts_with($category->image, 'http') ? $category->image : asset('storage/' . $category->image) }}" alt="Category image" class="w-24 h-24 object-cover rounded-xl mb-2 border">
                @endif
                <input type="file" name="image" accept="image/*"
                    class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200">
            </div>

            <div class="pt-4 border-t border-pink-100 flex gap-3">
                <button type="submit" class="px-6 py-3 rounded-full btn-pink-gold font-bold text-xs">Perbarui Kategori</button>
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 rounded-full bg-gray-100 text-gray-700 font-bold text-xs">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
