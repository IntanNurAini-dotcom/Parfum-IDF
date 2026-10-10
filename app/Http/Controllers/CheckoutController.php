<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('catalog.index')->with('error', 'Keranjang Anda masih kosong.');
        }

        $subtotal = $carts->sum(function ($item) {
            return $item->subtotal;
        });

        $user = Auth::user();

        return view('checkout.index', compact('carts', 'subtotal', 'user'));
    }

    public function process(Request $request, MidtransService $midtransService)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:30',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_courier' => 'required|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('catalog.index')->with('error', 'Keranjang kosong.');
        }

        // Validate stock
        foreach ($carts as $cart) {
            if ($cart->product->stock < $cart->quantity) {
                return back()->with('error', "Stok untuk produk '{$cart->product->name}' tidak mencukupi.");
            }
        }

        $subtotal = $carts->sum(function ($item) {
            return $item->subtotal;
        });

        // Simple shipping fee calculation based on courier selection
        $shippingCosts = [
            'JNE Express (Reguler)' => 20000,
            'JNE YES (Overnight)' => 35000,
            'J&T Express' => 22000,
            'SiCepat BEST' => 30000,
        ];

        $courier = $request->shipping_courier;
        $shippingCost = $shippingCosts[$courier] ?? 25000;
        $grandTotal = $subtotal + $shippingCost;

        $order = DB::transaction(function () use ($request, $carts, $subtotal, $shippingCost, $grandTotal) {
            $orderNumber = 'IDF-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $orderNumber,
                'total_amount' => $subtotal,
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_courier' => $request->shipping_courier,
                'shipping_cost' => $shippingCost,
                'grand_total' => $grandTotal,
                'payment_status' => 'unpaid',
                'order_status' => 'pending',
                'notes' => $request->notes,
                'payment_expired_at' => now()->addHours(24),
            ]);

            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'product_name' => $cart->product->name,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                    'subtotal' => $cart->subtotal,
                ]);

                // Reduce stock
                $cart->product->decrement('stock', $cart->quantity);
            }

            // Clear User Cart
            Cart::where('user_id', Auth::id())->delete();

            return $order;
        });

        // Generate Midtrans Snap token
        $midtransService->createSnapToken($order);

        return redirect()->route('orders.payment', $order->id)
            ->with('success', 'Pesanan Anda berhasil dibuat! Silakan pilih metode pembayaran.');
    }
}
