@extends('layouts.app')

@section('content')
<div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="mb-8">
        <h1 class="font-serif-luxury text-3xl font-bold text-pink-950">Checkout Pengiriman & Pembayaran</h1>
        <p class="text-xs text-gray-500 mt-1">Isi rincian alamat pengiriman dan pilih metode pembayaran resmi Parfum IDF.</p>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Form Shipping Address -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Shipping Address Card -->
                <div class="card-luxury p-6 space-y-4">
                    <h3 class="font-serif-luxury font-bold text-lg text-pink-950 pb-2 border-b border-pink-100 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-pink-600"></i> Alamat Pengiriman Pesanan
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Penerima *</label>
                            <input type="text" name="shipping_name" value="{{ old('shipping_name', $user->name) }}" required
                                class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Nomor Telepon / WA *</label>
                            <input type="text" name="shipping_phone" value="{{ old('shipping_phone', $user->phone ?? '08123456789') }}" required
                                class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Alamat Lengkap (Jalan, No. Rumah, RT/RW, Kecamatan) *</label>
                            <textarea name="shipping_address" rows="3" required
                                class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5">{{ old('shipping_address', $user->address ?? 'Jl. Mawar Indah No. 88') }}</textarea>
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Kota / Kabupaten *</label>
                            <input type="text" name="shipping_city" value="{{ old('shipping_city', 'Jakarta Selatan') }}" required
                                class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Kurir Pengiriman *</label>
                            <select name="shipping_courier" required class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5">
                                <option value="JNE Express (Reguler)">JNE Express (Reguler) - Rp 20.000</option>
                                <option value="JNE YES (Overnight)">JNE YES (Overnight) - Rp 35.000</option>
                                <option value="J&T Express">J&T Express - Rp 22.000</option>
                                <option value="SiCepat BEST">SiCepat BEST - Rp 30.000</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1 text-xs">Catatan untuk Penjual (Opsional)</label>
                        <input type="text" name="notes" placeholder="Contoh: Tolong beri pita kado / bungkus ekstra bubble wrap"
                            class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5">
                    </div>
                </div>

                <!-- Payment Method Information -->
                <div class="card-luxury p-6 space-y-4">
                    <h3 class="font-serif-luxury font-bold text-lg text-pink-950 pb-2 border-b border-pink-100 flex items-center gap-2">
                        <i class="fa-solid fa-credit-card text-pink-600"></i> Instruksi Pembayaran (Bank Transfer / QRIS)
                    </h3>

                    <div class="bg-amber-50/80 border border-amber-200 rounded-2xl p-4 text-xs space-y-3">
                        <p class="font-bold text-amber-900">Transfer Bank Resmi Parfum IDF:</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="bg-white p-3 rounded-xl border border-amber-200/60">
                                <span class="font-bold text-pink-950 block">Bank BCA</span>
                                <span class="font-mono text-sm text-pink-700 font-bold block mt-0.5">8830-1234-5678</span>
                                <span class="text-[10px] text-gray-500 block">a.n. PT PARFUM IDF INDONESIA</span>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-amber-200/60">
                                <span class="font-bold text-pink-950 block">Bank Mandiri</span>
                                <span class="font-mono text-sm text-pink-700 font-bold block mt-0.5">137-000-98765-4</span>
                                <span class="text-[10px] text-gray-500 block">a.n. PT PARFUM IDF INDONESIA</span>
                            </div>
                        </div>
                        <p class="text-[11px] text-amber-800">
                            * Setelah membuat pesanan, Anda dapat mengunggah bukti transfer pada halaman <strong>Pesanan Saya</strong> untuk diverifikasi admin.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Items Breakdown & Submission -->
            <div>
                <div class="card-luxury p-6 space-y-6 sticky top-28">
                    <h3 class="font-serif-luxury font-bold text-xl text-pink-950 pb-3 border-b border-pink-100">
                        Rincian Item Checkout
                    </h3>

                    <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                        @foreach($carts as $cart)
                            <div class="flex items-center justify-between text-xs gap-3">
                                <div class="flex items-center gap-2 truncate">
                                    <span class="w-5 h-5 rounded-full bg-pink-100 text-pink-700 font-bold text-[10px] flex items-center justify-center flex-shrink-0">
                                        {{ $cart->quantity }}x
                                    </span>
                                    <span class="font-semibold text-gray-800 truncate">{{ $cart->product->name }}</span>
                                </div>
                                <span class="font-bold text-pink-950 flex-shrink-0">Rp {{ number_format($cart->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-4 border-t border-pink-100 space-y-2 text-xs">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal Produk</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Estimasi Ongkir</span>
                            <span>Rp 20.000</span>
                        </div>
                        <div class="pt-3 border-t border-pink-100 flex justify-between items-center text-sm">
                            <span class="font-bold text-pink-950">Grand Total</span>
                            <span class="font-serif-luxury font-bold text-xl text-pink-900">
                                Rp {{ number_format($subtotal + 20000, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 rounded-full btn-pink-gold font-bold text-xs uppercase tracking-wider shadow-xl">
                        Buat Pesanan Sekarang
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
