<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    /**
     * Handle Midtrans payment notification webhooks.
     * Route: POST /api/midtrans/notification
     */
    public function handle(Request $request, MidtransService $midtransService): JsonResponse
    {
        $payload = $request->all();
        $orderNumber = $payload['order_id'] ?? null;

        if (!$orderNumber) {
            return response()->json([
                'status' => 'error',
                'message' => 'Missing order_id in notification payload',
            ], 400);
        }

        // 1. Verify Midtrans SHA512 Signature
        if (!$midtransService->verifyNotificationSignature($payload)) {
            Log::warning("Midtrans Webhook Invalid Signature for Order: {$orderNumber}");
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid signature key',
            ], 403);
        }

        // 2. Find Order
        $order = Order::where('order_number', $orderNumber)->first();

        if (!$order) {
            Log::warning("Midtrans Webhook Order Not Found: {$orderNumber}");
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        // 3. Idempotent Handling
        $transactionStatus = $payload['transaction_status'] ?? '';
        if ($order->isPaid() && in_array($transactionStatus, ['settlement', 'capture'])) {
            return response()->json([
                'status' => 'success',
                'message' => 'Order is already marked as paid (idempotent)',
            ]);
        }

        // 4. Update Order State & Restore Stock if Cancelled/Expired
        $midtransService->updateOrderFromPaymentStatus($order, $payload);

        return response()->json([
            'status' => 'success',
            'message' => 'Notification processed successfully',
        ]);
    }
}
