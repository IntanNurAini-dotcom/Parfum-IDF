@extends('layouts.app')

@section('content')
<div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <span class="text-xs text-pink-600 font-bold uppercase tracking-widest block">Rincian Transaksi</span>
            <h1 class="font-serif-luxury text-3xl font-bold text-pink-950">Pesanan {{ $order->order_number }}</h1>
            <p class="text-xs text-gray-500 mt-1">Dibuat pada {{ $order->created_at->format('d F Y, H:i') }} WIB</p>
        </div>

        <a href="{{ route('orders.index') }}" class="text-xs font-bold text-pink-700 hover:underline">
            &larr; Kembali ke Daftar Pesanan
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Items Breakdown & Delivery Status -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Items Table Card -->
            <div class="card-luxury p-6 space-y-4">
                <h3 class="font-serif-luxury font-bold text-lg text-pink-950 pb-2 border-b border-pink-100">
                    Item Parfum yang Dipesan
                </h3>

                <div class="divide-y divide-pink-100">
                    @foreach($order->items as $item)
                        <div class="py-3 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                @if($item->product)
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" class="w-14 h-14 object-cover rounded-xl border border-pink-100">
                                @else
                                    <div class="w-14 h-14 bg-pink-100 rounded-xl flex items-center justify-center text-pink-500 text-xs font-bold">IDF</div>
                                @endif
                                <div>
                                    <h4 class="font-serif-luxury font-bold text-sm text-pink-950">{{ $item->product_name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <span class="font-serif-luxury font-bold text-sm text-pink-900">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipping Information & Tracking Number Card -->
            <div class="card-luxury p-6 space-y-4">
                <h3 class="font-serif-luxury font-bold text-lg text-pink-950 pb-2 border-b border-pink-100">
                    Informasi Pengiriman
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-gray-400 block">Penerima:</span>
                        <strong class="text-gray-800 text-sm block">{{ $order->shipping_name }}</strong>
                        <span class="text-gray-600 block">{{ $order->shipping_phone }}</span>
                    </div>

                    <div>
                        <span class="text-gray-400 block">Kurir & Ongkir:</span>
                        <strong class="text-gray-800 text-sm block">{{ $order->shipping_courier }}</strong>
                        <span class="text-gray-600 block">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>

                    <div class="sm:col-span-2">
                        <span class="text-gray-400 block">Alamat Tujuan:</span>
                        <p class="text-gray-700 bg-pink-50/50 p-3 rounded-xl border border-pink-100 mt-1">
                            {{ $order->shipping_address }}, {{ $order->shipping_city }}
                        </p>
                    </div>

                    @if($order->tracking_number)
                        <div class="sm:col-span-2 bg-emerald-50 border border-emerald-200 p-4 rounded-xl text-emerald-900">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 block">Nomor Resi Pengiriman (AWB)</span>
                            <strong class="font-mono text-lg block text-emerald-800 mt-0.5">{{ $order->tracking_number }}</strong>
                            <span class="text-[11px] text-emerald-700 block mt-1">Gunakan nomor resi ini untuk melacak lokasi paket di situs resmi kurir.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Payment Status & Upload Proof Form -->
        <div class="space-y-6">
            <div class="card-luxury p-6 space-y-6">
                <h3 class="font-serif-luxury font-bold text-xl text-pink-950 pb-3 border-b border-pink-100">
                    Status Pembayaran
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Status Bayar:</span>
                        <span class="font-bold uppercase px-2.5 py-0.5 rounded-full text-[10px]
                            {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ $order->payment_status }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Status Pesanan:</span>
                        <span class="font-bold uppercase px-2.5 py-0.5 rounded-full text-[10px] bg-purple-100 text-purple-800">
                            {{ $order->order_status }}
                        </span>
                    </div>

                    <div class="pt-3 border-t border-pink-100 flex justify-between items-center text-sm">
                        <span class="font-bold text-pink-950">Grand Total</span>
                        <span class="font-serif-luxury font-bold text-xl text-pink-900">{{ $order->formatted_grand_total }}</span>
                    </div>
                </div>

                <!-- Proof of Payment Upload Form -->
                <div class="pt-4 border-t border-pink-100 space-y-4">
                    <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">Unggah Bukti Transfer Bank</h4>

                    @if($order->payment_proof)
                        <div class="bg-gray-50 p-3 rounded-xl border border-pink-100 text-center space-y-2">
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2.5 py-0.5 rounded-full block w-fit mx-auto">
                                Bukti Terunggah
                            </span>
                            <img src="{{ $order->payment_proof_url }}" alt="Bukti Transfer" class="w-full h-40 object-cover rounded-lg border">
                        </div>
                    @endif

                    <form action="{{ route('orders.upload_proof', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div>
                            <input type="file" name="payment_proof" accept="image/*" required
                                class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200">
                            <span class="text-[10px] text-gray-400 block mt-1">Format: JPG, PNG, WEBP (Max 2MB)</span>
                        </div>
                        
                        <button type="submit" class="w-full py-3 rounded-full btn-pink-gold text-xs font-bold shadow-md">
                            {{ $order->payment_proof ? 'Ganti Bukti Transfer' : 'Unggah Bukti Pembayaran' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
