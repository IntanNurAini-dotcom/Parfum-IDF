@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="space-y-8">
    
    <!-- Top Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Revenue Card -->
        <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-gray-500 font-semibold block">Total Pendapatan (Lunas)</span>
                <h3 class="font-serif-luxury font-bold text-2xl text-pink-950 mt-1">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-wallet"></i>
            </div>
        </div>

        <!-- Pending Orders Card -->
        <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-gray-500 font-semibold block">Pesanan Pending</span>
                <h3 class="font-serif-luxury font-bold text-2xl text-amber-600 mt-1">
                    {{ $pendingOrders }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-clock"></i>
            </div>
        </div>

        <!-- Total Products Card -->
        <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-gray-500 font-semibold block">Total Produk Parfum</span>
                <h3 class="font-serif-luxury font-bold text-2xl text-pink-900 mt-1">
                    {{ $totalProducts }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-pink-100 text-pink-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-spray-can"></i>
            </div>
        </div>

        <!-- Total Customers Card -->
        <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-gray-500 font-semibold block">Total Pelanggan</span>
                <h3 class="font-serif-luxury font-bold text-2xl text-purple-900 mt-1">
                    {{ $totalCustomers }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-6 space-y-4">
        <div class="flex justify-between items-center pb-3 border-b border-pink-100">
            <h3 class="font-serif-luxury font-bold text-lg text-pink-950">
                Pesanan Terbaru Masuk
            </h3>
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-pink-600 hover:underline">
                Lihat Semua Pesanan &rarr;
            </a>
        </div>

        @if($recentOrders->isEmpty())
            <p class="text-xs text-gray-500 py-4 text-center">Belum ada pesanan terbaru.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-gray-700">
                    <thead class="bg-pink-50/50 uppercase font-bold text-[10px] text-pink-900 tracking-wider">
                        <tr>
                            <th class="p-3">No. Pesanan</th>
                            <th class="p-3">Pelanggan</th>
                            <th class="p-3">Total Bayar</th>
                            <th class="p-3">Status Bayar</th>
                            <th class="p-3">Status Pesanan</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-pink-100">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-pink-50/30 transition-colors">
                                <td class="p-3 font-mono font-bold text-pink-950">{{ $order->order_number }}</td>
                                <td class="p-3">{{ $order->shipping_name }}</td>
                                <td class="p-3 font-bold text-pink-900">{{ $order->formatted_grand_total }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                        {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $order->payment_status }}
                                    </span>
                                </td>
                                <td class="p-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-purple-100 text-purple-800">
                                        {{ $order->order_status }}
                                    </span>
                                </td>
                                <td class="p-3">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="px-3 py-1 rounded-full btn-pink-gold text-[10px] font-bold">
                                        Kelola
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
