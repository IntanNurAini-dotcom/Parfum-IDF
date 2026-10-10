<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ExpireOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically cancel unpaid orders that have reached their payment expiry time and restore product stock.';

    /**
     * Execute the console command.
     */
    public function handle(MidtransService $midtransService): int
    {
        $now = Carbon::now();

        // Find unpaid orders that have expired
        $expiredOrders = Order::where('payment_status', 'unpaid')
            ->where(function ($query) use ($now) {
                $query->where('payment_expired_at', '<=', $now)
                      ->orWhereNull('payment_expired_at')
                      ->where('created_at', '<=', $now->copy()->subHours(24));
            })
            ->get();

        $count = 0;
        foreach ($expiredOrders as $order) {
            // Check status with Midtrans API first if snap_token is present
            $status = $midtransService->getTransactionStatus($order->order_number);
            
            if ($status && isset($status['transaction_status'])) {
                $midtransService->updateOrderFromPaymentStatus($order, $status);
            } else {
                // Manually mark expired and restore stock
                $order->update([
                    'payment_status' => 'expired',
                    'order_status' => 'cancelled',
                ]);
                $midtransService->restoreStock($order);
            }
            $count++;
        }

        $this->info("Successfully processed and expired {$count} unpaid order(s).");

        return Command::SUCCESS;
    }
}
