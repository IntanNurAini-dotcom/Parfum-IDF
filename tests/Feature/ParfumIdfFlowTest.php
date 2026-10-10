<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ParfumIdfFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_customer_registration_and_login()
    {
        $response = $this->post('/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('users', ['email' => 'budi@example.com']);
    }

    public function test_complete_e2e_shopping_flow()
    {
        Storage::fake('public');

        // 1. Customer login
        $customer = User::where('email', 'pembeli@gmail.com')->first();
        $this->actingAs($customer);

        // 2. View homepage and catalog
        $this->get('/')->assertStatus(200);
        $this->get('/katalog')->assertStatus(200);

        // 3. View product detail
        $product = Product::first();
        $this->get("/produk/{$product->slug}")->assertStatus(200);

        // 4. Add to cart
        $cartResponse = $this->post('/keranjang', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
        $cartResponse->assertRedirect(route('cart.index'));
        $this->assertDatabaseHas('carts', [
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        // 5. Checkout
        $this->get('/checkout')->assertStatus(200);
        $checkoutResponse = $this->post('/checkout', [
            'shipping_name' => 'Siti Nurhaliza',
            'shipping_phone' => '089876543210',
            'shipping_address' => 'Jl. Mawar Merah No. 12',
            'shipping_city' => 'Jakarta Selatan',
            'shipping_courier' => 'JNE Express (Reguler)',
            'notes' => 'Tolong bungkus rapi',
        ]);

        $order = Order::latest()->first();
        $checkoutResponse->assertRedirect(route('orders.payment', $order->id));
        $this->assertEquals('pending', $order->order_status);
        $this->assertEquals('unpaid', $order->payment_status);

        // 6. Upload payment proof
        $file = UploadedFile::fake()->image('proof.jpg');
        $uploadResponse = $this->post("/pesanan/{$order->id}/bukti-bayar", [
            'payment_proof' => $file,
        ]);

        $uploadResponse->assertSessionHasNoErrors();
        $order->refresh();
        $this->assertNotNull($order->payment_proof);

        // 7. Admin Login & Update Order Status
        $admin = User::where('email', 'admin@gmail.com')->first();
        $this->actingAs($admin);

        $this->get('/admin')->assertStatus(200);
        $this->get('/admin/orders')->assertStatus(200);
        $this->get("/admin/orders/{$order->id}")->assertStatus(200);

        $updateResponse = $this->patch("/admin/orders/{$order->id}/status", [
            'payment_status' => 'paid',
            'order_status' => 'shipped',
            'tracking_number' => 'JNE-IDF-889911',
        ]);

        $updateResponse->assertSessionHasNoErrors();
        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('shipped', $order->order_status);
        $this->assertEquals('JNE-IDF-889911', $order->tracking_number);
    }
}
