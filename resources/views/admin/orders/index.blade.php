@extends('layouts.admin')

@section('title', 'Kelola Pesanan Pelanggan')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="font-serif-luxury font-bold text-2xl text-pink-950">Manajemen Pesanan Masuk</h2>
            <p class="text-xs text-gray-500 mt-0.5">Kelola konfirmasi pembayaran Midtrans, pengiriman paket, dan status pesanan.</p>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white p-4 rounded-2xl border border-pink-100 shadow-sm">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-xs">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari No. Pesanan / Penerima / VA..."
                class="rounded-xl border-pink-200 focus:border-pink-500 text-xs p-2">
            
            <select name="status" class="rounded-xl border-pink-200 focus:border-pink-500 text-xs p-2">
                <option value="">-- Semua Status Pesanan --</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <select name="payment_status" class="rounded-xl border-pink-200 focus:border-pink-500 text-xs p-2">
                <option value="">-- Status Pembayaran --</option>
                <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid (Belum Lunas)</option>
                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid (Lunas)</option>
                <option value="expired" {{ request('payment_status') == 'expired' ? 'selected' : '' }}>Expired / Dibatalkan</option>
                <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>

            <button type="submit" class="px-4 py-2 rounded-xl btn-pink-gold font-bold text-xs">Cari Pesanan</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-700">
                <thead class="bg-pink-50/70 uppercase font-bold text-[10px] text-pink-900 tracking-wider">
                    <tr>
                        <th class="p-4">No. Pesanan</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Penerima & HP</th>
                        <th class="p-4">Metode & Bank / VA</th>
                        <th class="p-4">Total Bayar</th>
                        <th class="p-4">Status Bayar</th>
                        <th class="p-4">Status Pesanan</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-pink-100">
                    @foreach($orders as $order)
                        <tr class="hover:bg-pink-50/20 transition-colors">
                            <td class="p-4 font-mono font-bold text-pink-950">#{{ $order->order_number }}</td>
                            <td class="p-4 text-gray-500">
                                {{ $order->created_at->format('d M Y H:i') }}
                                @if($order->paid_at)
                                    <span class="block text-[9px] text-emerald-600 font-semibold mt-0.5">Lunas: {{ $order->paid_at->format('H:i') }}</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <strong class="text-gray-900 block">{{ $order->shipping_name }}</strong>
                                <span class="text-[10px] text-gray-500">{{ $order->shipping_phone }}</span>
                            </td>
                            <td class="p-4">
                                <span class="font-bold text-gray-800 block text-[11px]">{{ $order->formatted_payment_type }}</span>
                                @if($order->va_number)
                                    <span class="font-mono text-[10px] text-amber-700 block">VA: {{ $order->va_number }}</span>
                                @elseif($order->payment_code)
                                    <span class="font-mono text-[10px] text-rose-700 block">Kode: {{ $order->payment_code }}</span>
                                @endif
                            </td>
                            <td class="p-4 font-serif-luxury font-bold text-pink-900 text-sm">{{ $order->formatted_grand_total }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase
                                    @switch($order->payment_status)
                                        @case('paid') bg-emerald-100 text-emerald-800 border border-emerald-300 @break
                                        @case('expired') bg-rose-100 text-rose-800 border border-rose-300 @break
                                        @default bg-amber-100 text-amber-800 border border-amber-300
                                    @endswitch">
                                    {{ $order->payment_status === 'paid' ? 'LUNAS' : strtoupper($order->payment_status) }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-purple-100 text-purple-800 border border-purple-200">
                                    {{ $order->order_status }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="px-3 py-1.5 rounded-lg btn-pink-gold text-xs font-bold">
                                    Kelola Pesanan
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
