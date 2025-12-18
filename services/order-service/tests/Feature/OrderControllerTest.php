<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a user for foreign key
        User::factory()->create(['id' => 1]);
    }

        #[Test]
    public function it_can_list_all_orders()
    {
        Order::factory()->count(3)->create(['user_id' => 1]);

        $response = $this->getJson('/api/orders');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => ['id', 'user_id', 'total_price', 'status']
                    ]
                ]
            ]);
    }

        #[Test]
    public function it_can_create_an_order_with_items()
    {
        $orderData = [
            'user_id' => 1,
            'customer_name' => 'John Doe',
            'phone' => '+1234567890',
            'address' => '123 Main St',
            'total_price' => 2400,
            'payment_method' => 'card',
            'items' => [
                [
                    'product_id' => 1,
                    'product_title' => 'Margherita Pizza',
                    'unit_price' => 1200,
                    'quantity' => 2,
                    'line_total' => 2400
                ]
            ]
        ];

        $response = $this->postJson('/api/orders', $orderData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'data' => ['id', 'user_id', 'total_price', 'status', 'items']
            ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => 1,
            'customer_name' => 'John Doe',
            'total_price' => 2400
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => 1,
            'quantity' => 2
        ]);
    }

        #[Test]
    public function it_validates_required_order_fields()
    {
        $response = $this->postJson('/api/orders', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'user_id', 'customer_name', 'items'
            ]);
    }

        #[Test]
    public function it_can_show_single_order_with_items()
    {
        $order = Order::factory()->create(['user_id' => 1]);
        OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => 1
        ]);

        $response = $this->getJson("/api/orders/{$order->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id', 'user_id', 'total_price', 'items' => [
                        '*' => ['id', 'product_id', 'quantity']
                    ]
                ]
            ]);
    }

        #[Test]
    public function it_can_update_order_status()
    {
        $order = Order::factory()->create([
            'user_id' => 1,
            'status' => 'new'
        ]);

        $response = $this->putJson("/api/orders/{$order->id}/status", [
            'status' => 'confirmed'
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 'confirmed']);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'confirmed'
        ]);
    }

        #[Test]
    public function it_validates_order_status_values()
    {
        $order = Order::factory()->create(['user_id' => 1]);

        $response = $this->putJson("/api/orders/{$order->id}/status", [
            'status' => 'invalid_status'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['status']);
    }

        #[Test]
    public function it_can_delete_an_order()
    {
        $order = Order::factory()->create(['user_id' => 1]);
        OrderItem::factory()->create(['order_id' => $order->id]);

        $response = $this->deleteJson("/api/orders/{$order->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('orders', [
            'id' => $order->id
        ]);

        // Items should be cascade deleted
        $this->assertDatabaseMissing('order_items', [
            'order_id' => $order->id
        ]);
    }
}
