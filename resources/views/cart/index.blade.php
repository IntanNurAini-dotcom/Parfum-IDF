@extends('layouts.app')

@section('content')
<div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="mb-8">
        <h1 class="font-serif-luxury text-3xl font-bold text-pink-950">Keranjang Belanja Mewah</h1>
        <p class="text-xs text-gray-500 mt-1">Kelola daftar wewangian impian Anda sebelum melakukan proses pemesanan.</p>
    </div>

    @if($carts->isEmpty())
        <div class="card-luxury p-12 text-center space-y-4">
            <div class="w-20 h-20 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center mx-auto text-3xl">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <h3 class="font-serif-luxury font-bold text-2xl text-pink-950">Keranjang Anda Masih Kosong</h3>
            <p class="text-xs text-gray-500 max-w-sm mx-auto">Jelajahi koleksi wewangian kami dan pilih parfum favorit yang sesuai dengan karakter Anda.</p>
            <a href="{{ route('catalog.index') }}" class="inline-block px-8 py-3 rounded-full btn-pink-gold text-xs font-bold mt-2">
                Mulai Berbelanja Parfum
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Items Table / List -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($carts as $cart)
                    <div class="card-luxury p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <img src="{{ $cart->product->image_url }}" alt="{{ $cart->product->name }}" class="w-20 h-20 object-cover rounded-xl border border-pink-100 flex-shrink-0">
                            <div>
                                <span class="text-[10px] font-bold text-pink-600 uppercase tracking-widest block">{{ $cart->product->category->name }}</span>
                                <h4 class="font-serif-luxury font-bold text-base text-pink-950">
                                    <a href="{{ route('catalog.show', $cart->product->slug) }}">{{ $cart->product->name }}</a>
                                </h4>
                                <p class="text-xs text-gray-500 mt-0.5">Ukuran: {{ $cart->product->size }}</p>
                                <p class="font-serif-luxury font-bold text-pink-900 text-sm mt-1">{{ $cart->product->formatted_price }}</p>
                            </div>
                        </div>

                        <!-- Quantity Update Form -->
                        <div class="flex items-center gap-4 w-full sm:w-auto justify-between sm:justify-end">
                            <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <label for="qty-{{ $cart->id }}" class="text-xs text-gray-500">Qty:</label>
                                <input type="number" id="qty-{{ $cart->id }}" name="quantity" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->stock }}"
                                    class="w-16 text-center text-xs font-bold border-pink-200 rounded-lg p-1.5 focus:border-pink-500"
                                    onchange="this.form.submit()">
                            </form>

                            <!-- Subtotal item -->
                            <div class="text-right">
                                <span class="text-[10px] text-gray-400 block">Subtotal</span>
                                <span class="font-serif-luxury font-bold text-sm text-pink-950">Rp {{ number_format($cart->subtotal, 0, ',', '.') }}</span>
                            </div>

                            <!-- Delete item form -->
                            <form action="{{ route('cart.destroy', $cart->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus item ini dari keranjang?')" class="text-gray-400 hover:text-rose-600 p-2 text-sm transition-colors" title="Hapus">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary Card -->
            <div>
                <div class="card-luxury p-6 space-y-6 sticky top-28">
                    <h3 class="font-serif-luxury font-bold text-xl text-pink-950 pb-3 border-b border-pink-100">
                        Ringkasan Pesanan
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal Produk ({{ $carts->sum('quantity') }} item)</span>
                            <span class="font-bold text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Estimasi Ongkos Kirim</span>
                            <span class="text-gray-400 italic">Dihitung saat checkout</span>
                        </div>
                        <div class="pt-3 border-t border-pink-100 flex justify-between items-center text-sm">
                            <span class="font-bold text-pink-950">Total Sementara</span>
                            <span class="font-serif-luxury font-bold text-xl text-pink-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="w-full py-3.5 rounded-full btn-pink-gold font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-2 shadow-lg">
                        <span>Lanjut ke Checkout</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                    <div class="text-[11px] text-gray-500 space-y-2 pt-2 border-t border-pink-100">
                        <p class="flex items-center gap-2"><i class="fa-solid fa-shield-halved text-pink-500"></i> Transaksi Aman & Terenkripsi</p>
                        <p class="flex items-center gap-2"><i class="fa-solid fa-truck-fast text-pink-500"></i> Pengiriman Cepat & Berasuransi</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
