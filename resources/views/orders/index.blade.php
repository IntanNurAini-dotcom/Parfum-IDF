@extends('layouts.app')

@section('content')
<div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="mb-8">
        <h1 class="font-serif-luxury text-3xl font-bold text-pink-950">Pesanan Saya</h1>
        <p class="text-xs text-gray-500 mt-1">Pantau status transaksi, instruksi pembayaran Midtrans, dan nomor resi pengiriman Anda.</p>
    </div>

    @if($orders->isEmpty())
        <div class="card-luxury p-12 text-center space-y-4">
            <div class="w-16 h-16 rounded-full bg-pink-100 text-pink-400 flex items-center justify-center mx-auto text-2xl">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <h3 class="font-serif-luxury font-bold text-xl text-pink-950">Belum Ada Riwayat Pesanan</h3>
            <p class="text-xs text-gray-500 max-w-sm mx-auto">Anda belum pernah melakukan pemesanan parfum di Parfum IDF.</p>
            <a href="{{ route('catalog.index') }}" class="inline-block px-6 py-2.5 rounded-full btn-pink-gold text-xs font-bold mt-2">
                Mulai Berbelanja
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="card-luxury p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div class="space-y-2">
                        <div class="flex items-center gap-3">
                            <span class="font-mono font-bold text-sm text-pink-950">#{{ $order->order_number }}</span>
                            <span class="text-[10px] text-gray-400">• {{ $order->created_at->format('d M Y H:i') }}</span>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            <!-- Payment Status Badge -->
                            @if($order->isPaid())
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-300">
                                    <i class="fa-solid fa-check-circle mr-1"></i> LUNAS
                                </span>
                            @elseif($order->isExpired())
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-100 text-rose-800 border border-rose-300">
                                    <i class="fa-solid fa-circle-xmark mr-1"></i> DIBATALKAN / KADALUWARSA
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-900 border border-amber-300">
                                    <i class="fa-solid fa-clock mr-1"></i> MENUNGGU PEMBAYARAN
                                </span>
                            @endif

                            <!-- Order Status Badge -->
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                @switch($order->order_status)
                                    @case('completed') bg-emerald-50 text-emerald-700 border border-emerald-200 @break
                                    @case('shipped') bg-blue-50 text-blue-700 border border-blue-200 @break
                                    @case('processing') bg-purple-50 text-purple-700 border border-purple-200 @break
                                    @case('cancelled') bg-rose-50 text-rose-700 border border-rose-200 @break
                                    @default bg-gray-50 text-gray-700 border border-gray-200
                                @endswitch">
                                Status: {{ strtoupper($order->order_status) }}
                            </span>

                            @if($order->payment_type)
                                <span class="text-[10px] font-semibold text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full">
                                    {{ $order->formatted_payment_type }}
                                </span>
                            @endif
                        </div>

                        <p class="text-xs text-gray-600">
                            {{ $order->items->count() }} item • Total: <strong class="text-pink-900 font-serif-luxury text-base">{{ $order->formatted_grand_total }}</strong>
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                        @if($order->isUnpaid())
                            <a href="{{ route('orders.payment', $order->id) }}" class="w-full md:w-auto px-5 py-2.5 rounded-full bg-pink-gold-gradient text-white text-xs font-bold text-center shadow-md hover:scale-105 transition-transform">
                                <i class="fa-solid fa-credit-card mr-1.5"></i> Bayar Sekarang
                            </a>
                        @else
                            <a href="{{ route('orders.payment', $order->id) }}" class="w-full md:w-auto px-4 py-2 rounded-full bg-pink-50 text-pink-800 border border-pink-200 text-xs font-bold text-center hover:bg-pink-100 transition-colors">
                                <i class="fa-solid fa-receipt mr-1"></i> Detail Pembayaran
                            </a>
                        @endif

                        <a href="{{ route('orders.show', $order->id) }}" class="w-full md:w-auto px-4 py-2 rounded-full bg-gray-100 text-gray-700 text-xs font-bold text-center hover:bg-gray-200 transition-colors">
                            Detail Rincian
                        </a>
                    </div>
                </div>
            @endforeach

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
