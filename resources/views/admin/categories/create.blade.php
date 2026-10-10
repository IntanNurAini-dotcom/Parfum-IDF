@extends('layouts.admin')

@section('title', 'Tambah Kategori Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-pink-100 p-8 shadow-sm space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-pink-100">
            <h2 class="font-serif-luxury font-bold text-xl text-pink-950">Form Tambah Kategori Fragrance</h2>
            <a href="{{ route('admin.categories.index') }}" class="text-xs font-bold text-pink-600 hover:underline">&larr; Batal</a>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Kategori *</label>
                <input type="text" name="name" required placeholder="Contoh: Extrait de Parfum"
                    class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5">
            </div>

            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi Kategori</label>
                <textarea name="description" rows="3" placeholder="Jelaskan karakteristik konsentrasi aroma..."
                    class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5"></textarea>
            </div>

            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Foto / Sampul Kategori</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200">
            </div>

            <div class="pt-4 border-t border-pink-100 flex gap-3">
                <button type="submit" class="px-6 py-3 rounded-full btn-pink-gold font-bold text-xs">Simpan Kategori</button>
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 rounded-full bg-gray-100 text-gray-700 font-bold text-xs">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
