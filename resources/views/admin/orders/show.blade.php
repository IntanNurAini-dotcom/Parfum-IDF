@extends('layouts.admin')

@section('title', 'Detail & Proses Pesanan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <span class="text-xs text-pink-600 font-bold uppercase tracking-widest block">Kelola Transaksi</span>
            <h2 class="font-serif-luxury font-bold text-2xl text-pink-950">Pesanan #{{ $order->order_number }}</h2>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-pink-600 hover:underline">&larr; Kembali ke Daftar Pesanan</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Cols: Details & Items -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Midtrans Payment Info Details Card -->
            <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm space-y-4 text-xs">
                <h3 class="font-serif-luxury font-bold text-lg text-pink-950 pb-2 border-b border-pink-100 flex items-center justify-between">
                    <span>Informasi Pembayaran Midtrans</span>
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase
                        {{ $order->isPaid() ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                        {{ $order->isPaid() ? 'LUNAS' : strtoupper($order->payment_status) }}
                    </span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="text-gray-400 block">Metode Pembayaran:</span>
                        <strong class="text-gray-900 text-sm block">{{ $order->formatted_payment_type }}</strong>
                    </div>

                    @if($order->va_number)
                        <div>
                            <span class="text-gray-400 block">Nomor Virtual Account:</span>
                            <strong class="font-mono text-amber-900 text-sm block">{{ $order->va_number }}</strong>
                        </div>
                    @elseif($order->payment_code)
                        <div>
                            <span class="text-gray-400 block">Kode Kasir (Gerai):</span>
                            <strong class="font-mono text-rose-900 text-sm block">{{ $order->payment_code }}</strong>
                        </div>
                    @endif

                    @if($order->paid_at)
                        <div>
                            <span class="text-gray-400 block">Waktu Lunas (Paid At):</span>
                            <strong class="text-emerald-700 text-xs block">{{ $order->paid_at->format('d M Y, H:i:s') }}</strong>
                        </div>
                    @endif

                    @if($order->payment_expired_at)
                        <div>
                            <span class="text-gray-400 block">Batas Waktu Pembayaran:</span>
                            <strong class="text-gray-800 text-xs block">{{ $order->payment_expired_at->format('d M Y, H:i:s') }}</strong>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Items Table -->
            <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm space-y-4">
                <h3 class="font-serif-luxury font-bold text-lg text-pink-950 pb-2 border-b border-pink-100">
                    Rincian Barang Parfum
                </h3>

                <div class="divide-y divide-pink-100 text-xs">
                    @foreach($order->items as $item)
                        <div class="py-3 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                @if($item->product)
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" class="w-12 h-12 object-cover rounded-xl border">
                                @else
                                    <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center font-bold">IDF</div>
                                @endif
                                <div>
                                    <strong class="font-serif-luxury text-sm text-pink-950 block">{{ $item->product_name }}</strong>
                                    <span class="text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <span class="font-serif-luxury font-bold text-pink-900 text-sm">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-100 pt-3 text-xs space-y-1">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal Produk:</span>
                        <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Ongkos Kirim ({{ $order->shipping_courier }}):</span>
                        <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm font-bold text-pink-950 pt-2 border-t border-gray-100">
                        <span>Grand Total:</span>
                        <span class="text-pink-600">{{ $order->formatted_grand_total }}</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm space-y-4 text-xs">
                <h3 class="font-serif-luxury font-bold text-lg text-pink-950 pb-2 border-b border-pink-100">
                    Tujuan Pengiriman & Kurir
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="text-gray-400 block">Penerima:</span>
                        <strong class="text-gray-900 text-sm block">{{ $order->shipping_name }}</strong>
                        <span class="text-gray-600 block">{{ $order->shipping_phone }}</span>
                    </div>

                    <div>
                        <span class="text-gray-400 block">Kurir Pengiriman:</span>
                        <strong class="text-gray-900 text-sm block">{{ $order->shipping_courier }}</strong>
                        <span class="text-gray-600 block">Ongkir: Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>

                    <div class="sm:col-span-2">
                        <span class="text-gray-400 block">Alamat Lengkap:</span>
                        <p class="text-gray-800 bg-pink-50/50 p-3 rounded-xl border border-pink-100 mt-1">
                            {{ $order->shipping_address }}, {{ $order->shipping_city }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Col: Update Status Form & Payment Proof Preview -->
        <div class="space-y-6">
            
            <!-- Payment Proof Card (If manual transfer) -->
            @if($order->payment_proof)
                <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm space-y-4">
                    <h3 class="font-serif-luxury font-bold text-lg text-pink-950 pb-2 border-b border-pink-100">
                        Bukti Transfer Manual
                    </h3>
                    <div class="space-y-3">
                        <img src="{{ $order->payment_proof_url }}" alt="Bukti Pembayaran" class="w-full h-56 object-cover rounded-xl border">
                        <a href="{{ $order->payment_proof_url }}" target="_blank" class="block w-full py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs text-center rounded-xl">
                            <i class="fa-solid fa-up-right-from-square mr-1"></i> Buka Gambar Ukuran Penuh
                        </a>
                    </div>
                </div>
            @endif

            <!-- Update Order & Payment Status Form -->
            <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm space-y-4">
                <h3 class="font-serif-luxury font-bold text-lg text-pink-950 pb-2 border-b border-pink-100">
                    Update Status & Resi
                </h3>

                <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Status Pembayaran</label>
                        <select name="payment_status" class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5">
                            <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>UNPAID (Belum Lunas)</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>PAID (Lunas)</option>
                            <option value="expired" {{ $order->payment_status === 'expired' ? 'selected' : '' }}>EXPIRED (Kadaluwarsa / Dibatalkan)</option>
                            <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>REFUNDED (Dikembalikan)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Status Pesanan</label>
                        <select name="order_status" class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5">
                            <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                            <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing (Dikemas)</option>
                            <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped (Dikirim)</option>
                            <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                            <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Nomor Resi Pengiriman (AWB)</label>
                        <input type="text" name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="Contoh: JNE1234567890"
                            class="w-full text-xs rounded-xl border-pink-200 focus:border-pink-500 p-2.5 font-mono">
                    </div>

                    <button type="submit" class="w-full py-3 rounded-full btn-pink-gold font-bold text-xs shadow-md">
                        Simpan Perubahan Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
