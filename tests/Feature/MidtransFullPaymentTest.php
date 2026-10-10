<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Services\MidtransService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class MidtransFullPaymentTest extends TestCase
{
    use RefreshDatabase;

    protected User $customer;
    protected User $admin;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = User::factory()->create(['role' => 'customer']);
        $this->admin = User::factory()->create(['role' => 'admin']);

        $category = Category::create([
            'name' => 'Extrait de Parfum',
            'slug' => 'extrait-de-parfum',
            'description' => 'Luxury extrait',
        ]);

        $this->product = Product::create([
            'category_id' => $category->id,
            'name' => 'Rose Impériale',
            'slug' => 'rose-imperiale',
            'price' => 500000,
            'stock' => 10,
            'size' => '50ml',
            'description' => 'Luxury Rose',
            'image' => 'products/sample.jpg',
        ]);
    }

    protected function createSampleOrder(array $attributes = []): Order
    {
        $order = Order::create(array_merge([
            'user_id' => $this->customer->id,
            'order_number' => 'IDF-TEST-' . rand(1000, 9999),
            'total_amount' => 500000,
            'shipping_name' => 'Test Receiver',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Test No. 12',
            'shipping_city' => 'Jakarta',
            'shipping_courier' => 'JNE Express (Reguler)',
            'shipping_cost' => 20000,
            'grand_total' => 520000,
            'payment_status' => 'unpaid',
            'order_status' => 'pending',
            'payment_expired_at' => now()->addHours(24),
        ], $attributes));

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'quantity' => 1,
            'price' => 500000,
            'subtotal' => 500000,
        ]);

        return $order;
    }

    public function test_customer_can_view_own_payment_detail_page()
    {
        $order = $this->createSampleOrder();

        $response = $this->actingAs($this->customer)->get("/pesanan/{$order->id}/pembayaran");

        $response->assertStatus(200);
        $response->assertSee($order->order_number);
        $response->assertSee('Ringkasan Rincian Pesanan');
    }

    public function test_customer_cannot_view_other_customers_payment_detail()
    {
        $otherCustomer = User::factory()->create(['role' => 'customer']);
        $order = $this->createSampleOrder();

        $response = $this->actingAs($otherCustomer)->get("/pesanan/{$order->id}/pembayaran");

        $response->assertStatus(403);
    }

    public function test_payment_status_check_endpoint_returns_json()
    {
        $order = $this->createSampleOrder([
            'payment_type' => 'bank_transfer',
            'payment_bank' => 'bca',
            'va_number' => '12345678901',
        ]);

        $response = $this->actingAs($this->customer)->getJson("/pesanan/{$order->id}/check-status");

        $response->assertStatus(200);
        $response->assertJson([
            'order_number' => $order->order_number,
            'payment_status' => 'unpaid',
            'is_paid' => false,
            'va_number' => '12345678901',
        ]);
    }

    public function test_midtrans_service_snap_token_generation()
    {
        $order = $this->createSampleOrder();
        $midtransService = new MidtransService();

        $token = $midtransService->createSnapToken($order);

        $this->assertNotEmpty($token);
        $order->refresh();
        $this->assertEquals($token, $order->snap_token);
        $this->assertNotNull($order->payment_expired_at);
    }

    public function test_midtrans_webhook_settlement_updates_order_to_paid()
    {
        $order = $this->createSampleOrder();

        $payload = [
            'order_id' => $order->order_number,
            'status_code' => '200',
            'gross_amount' => '520000.00',
            'transaction_status' => 'settlement',
            'payment_type' => 'bank_transfer',
            'va_numbers' => [
                ['bank' => 'bca', 'va_number' => '888899990000']
            ],
            'signature_key' => 'mock_signature',
        ];

        $response = $this->postJson('/api/midtrans/notification', $payload);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);

        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('processing', $order->order_status);
        $this->assertEquals('888899990000', $order->va_number);
        $this->assertNotNull($order->paid_at);
    }

    public function test_midtrans_webhook_expire_cancels_order_and_restores_stock()
    {
        $initialStock = $this->product->stock;
        $order = $this->createSampleOrder();

        // Reduce stock when order was placed
        $this->product->decrement('stock', 1);

        $payload = [
            'order_id' => $order->order_number,
            'status_code' => '202',
            'gross_amount' => '520000.00',
            'transaction_status' => 'expire',
            'payment_type' => 'bank_transfer',
            'signature_key' => 'mock_signature',
        ];

        $response = $this->postJson('/api/midtrans/notification', $payload);

        $response->assertStatus(200);

        $order->refresh();
        $this->assertEquals('expired', $order->payment_status);
        $this->assertEquals('cancelled', $order->order_status);

        // Check stock restored
        $this->product->refresh();
        $this->assertEquals($initialStock, $this->product->stock);
    }

    public function test_scheduled_expire_orders_command_cancels_expired_unpaid_orders()
    {
        $initialStock = $this->product->stock;
        $this->product->decrement('stock', 1);

        $expiredOrder = $this->createSampleOrder([
            'payment_status' => 'unpaid',
            'payment_expired_at' => now()->subHour(),
        ]);

        $this->artisan('orders:expire')
            ->assertExitCode(0);

        $expiredOrder->refresh();
        $this->assertEquals('expired', $expiredOrder->payment_status);
        $this->assertEquals('cancelled', $expiredOrder->order_status);

        $this->product->refresh();
        $this->assertEquals($initialStock, $this->product->stock);
    }

    public function test_admin_can_view_order_payment_details_and_filter()
    {
        $order = $this->createSampleOrder([
            'payment_type' => 'bank_transfer',
            'payment_bank' => 'bca',
            'va_number' => '12345678901',
            'payment_status' => 'paid',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/orders?payment_status=paid');

        $response->assertStatus(200);
        $response->assertSee('#' . $order->order_number);
        $response->assertSee('VA: 12345678901');

        $showResponse = $this->actingAs($this->admin)->get("/admin/orders/{$order->id}");
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Informasi Pembayaran Midtrans');
        $showResponse->assertSee('12345678901');
    }
}
