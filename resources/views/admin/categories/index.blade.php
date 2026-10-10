@extends('layouts.admin')

@section('title', 'Manajemen Kategori Fragrance')

@section('content')
<div class="space-y-6">
    
    <div class="flex justify-between items-center">
        <div>
            <h2 class="font-serif-luxury font-bold text-2xl text-pink-950">Kelola Kategori Fragrance</h2>
            <p class="text-xs text-gray-500 mt-0.5">Daftar seluruh kelompok wewangian Parfum IDF.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="px-5 py-2.5 rounded-full btn-pink-gold font-bold text-xs flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Kategori Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs text-gray-700">
            <thead class="bg-pink-50/70 uppercase font-bold text-[10px] text-pink-900 tracking-wider">
                <tr>
                    <th class="p-4">Gambar</th>
                    <th class="p-4">Nama Kategori</th>
                    <th class="p-4">Slug</th>
                    <th class="p-4">Jumlah Produk</th>
                    <th class="p-4">Deskripsi</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-pink-100">
                @foreach($categories as $category)
                    <tr class="hover:bg-pink-50/20 transition-colors">
                        <td class="p-4">
                            @if($category->image)
                                <img src="{{ str_starts_with($category->image, 'http') ? $category->image : asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-12 h-12 object-cover rounded-xl border border-pink-100">
                            @else
                                <div class="w-12 h-12 rounded-xl bg-pink-100 flex items-center justify-center text-pink-400 font-bold text-xs">No Pic</div>
                            @endif
                        </td>
                        <td class="p-4 font-bold text-pink-950 text-sm">{{ $category->name }}</td>
                        <td class="p-4 font-mono text-gray-500">{{ $category->slug }}</td>
                        <td class="p-4">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-pink-100 text-pink-800">
                                {{ $category->products_count }} Produk
                            </span>
                        </td>
                        <td class="p-4 max-w-xs truncate text-gray-500">{{ $category->description ?? '-' }}</td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="px-3 py-1.5 rounded-lg bg-amber-100 text-amber-900 hover:bg-amber-200 text-xs font-bold">
                                Edit
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus kategori ini beserta seluruh produk di dalamnya?')">
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

        <div class="p-4">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection
