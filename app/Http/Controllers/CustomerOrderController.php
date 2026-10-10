<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorizeOrderAccess($order);

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    public function payment(Order $order, MidtransService $midtransService)
    {
        $this->authorizeOrderAccess($order);

        $order->load('items.product');

        // Check if payment has expired
        if ($order->isExpired()) {
            if ($order->payment_status !== 'expired') {
                $order->update([
                    'payment_status' => 'expired',
                    'order_status' => 'cancelled',
                ]);
                $midtransService->restoreStock($order);
            }
        } else {
            // Fetch live status from Midtrans API if available
            $status = $midtransService->getTransactionStatus($order->order_number);
            if ($status) {
                $midtransService->updateOrderFromPaymentStatus($order, $status);
                $order->refresh();
            }

            // Generate Snap token if missing
            if (!$order->snap_token && !$order->isPaid() && !$order->isExpired()) {
                $midtransService->createSnapToken($order);
                $order->refresh();
            }
        }

        $clientKey = config('services.midtrans.client_key', env('MIDTRANS_CLIENT_KEY', ''));
        $snapUrl = config('services.midtrans.is_production', false)
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';

        return view('orders.payment', compact('order', 'clientKey', 'snapUrl'));
    }

    public function checkStatus(Order $order, MidtransService $midtransService): JsonResponse
    {
        $this->authorizeOrderAccess($order);

        if (!$order->isPaid() && !$order->isExpired()) {
            $status = $midtransService->getTransactionStatus($order->order_number);
            if ($status) {
                $midtransService->updateOrderFromPaymentStatus($order, $status);
                $order->refresh();
            }
        }

        return response()->json([
            'order_number' => $order->order_number,
            'payment_status' => $order->payment_status,
            'order_status' => $order->order_status,
            'is_paid' => $order->isPaid(),
            'is_expired' => $order->isExpired(),
            'payment_type' => $order->payment_type,
            'payment_bank' => $order->payment_bank,
            'va_number' => $order->va_number,
            'payment_code' => $order->payment_code,
            'payment_qr_url' => $order->payment_qr_url,
            'payment_deeplink_url' => $order->payment_deeplink_url,
            'formatted_total' => $order->formatted_grand_total,
        ]);
    }

    public function updatePaymentMethod(Order $order, MidtransService $midtransService)
    {
        $this->authorizeOrderAccess($order);

        if ($order->isPaid()) {
            return back()->with('error', 'Pesanan ini sudah lunas.');
        }

        // Reset payment details to allow selecting a new payment method via Snap
        $order->update([
            'snap_token' => null,
            'payment_type' => null,
            'payment_bank' => null,
            'va_number' => null,
            'payment_code' => null,
            'payment_qr_url' => null,
            'payment_deeplink_url' => null,
        ]);

        $midtransService->createSnapToken($order);

        return redirect()->route('orders.payment', $order->id)
            ->with('success', 'Silakan pilih metode pembayaran baru.');
    }

    public function uploadPaymentProof(Request $request, Order $order)
    {
        $this->authorizeOrderAccess($order);

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($order->payment_proof) {
            Storage::disk('public')->delete($order->payment_proof);
        }

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $order->update([
            'payment_proof' => $path,
            'payment_type' => 'manual_transfer',
            'payment_status' => 'unpaid',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Tim admin Parfum IDF akan segera memverifikasi pesanan Anda.');
    }

    protected function authorizeOrderAccess(Order $order): void
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat detail pembayaran pesanan ini.');
        }
    }
}
