<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class AuthFullFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_customer_registration_saves_phone_and_assigns_customer_role()
    {
        $response = $this->post('/register', [
            'name' => 'Boutique Customer',
            'email' => 'boutique@example.com',
            'phone' => '081299998888',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();

        $user = User::where('email', 'boutique@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('Boutique Customer', $user->name);
        $this->assertEquals('081299998888', $user->phone);
        $this->assertEquals('customer', $user->role);
        $this->assertTrue($user->isCustomer());
    }

    public function test_registration_fails_on_duplicate_email()
    {
        User::factory()->create(['email' => 'duplicate@example.com']);

        $response = $this->post('/register', [
            'name' => 'Duplicate User',
            'email' => 'duplicate@example.com',
            'phone' => '08123456789',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_customer_login_redirects_to_home()
    {
        $customer = User::factory()->create([
            'email' => 'customer_test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
        ]);

        $response = $this->post('/login', [
            'email' => 'customer_test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($customer);
    }

    public function test_admin_login_redirects_to_admin_dashboard()
    {
        $admin = User::factory()->create([
            'email' => 'admin_test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin_test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_seeded_demo_admin_login_success()
    {
        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => 'admin12345',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
        $this->assertEquals('admin@gmail.com', auth()->user()->email);
    }

    public function test_seeded_demo_customer_login_success()
    {
        $response = $this->post('/login', [
            'email' => 'pembeli@gmail.com',
            'password' => 'pembeli12345',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertEquals('pembeli@gmail.com', auth()->user()->email);
    }

    public function test_invalid_login_credentials_fails()
    {
        $user = User::factory()->create([
            'email' => 'user_test@example.com',
            'password' => bcrypt('correct_password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'user_test@example.com',
            'password' => 'wrong_password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_guest_accessing_protected_route_redirected_to_login()
    {
        $response = $this->get('/checkout');
        $response->assertRedirect('/login');
    }

    public function test_customer_accessing_admin_panel_returns_403_forbidden()
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($customer)->get('/admin');

        $response->assertStatus(403);
    }

    public function test_forgot_password_sends_reset_link()
    {
        $user = User::factory()->create(['email' => 'reset_me@example.com']);

        $response = $this->post('/forgot-password', [
            'email' => 'reset_me@example.com',
        ]);

        $response->assertSessionHas('status');
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $this->assertAuthenticated();

        $response = $this->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
