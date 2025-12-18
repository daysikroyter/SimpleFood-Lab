<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_list_all_orders()
    {
        Order::factory()->count(3)->create();

        $response = $this->getJson('/api/orders');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => ['id', 'user_id', 'status', 'total_amount']
                    ]
                ]
            ]);
    }

    #[Test]
    public function it_can_create_an_order_with_items()
    {
        $orderData = [
            'user_id' => 1,
            'delivery_address' => '123 Main St',
            'phone' => '+79991234567',
            'items' => [
                ['product_id' => 1, 'quantity' => 2, 'price' => 500],
                ['product_id' => 2, 'quantity' => 1, 'price' => 800]
            ]
        ];

        $response = $this->postJson('/api/orders', $orderData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'data' => ['id', 'user_id', 'status', 'total_amount']
            ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => 1,
            'delivery_address' => '123 Main St'
        ]);
    }

    #[Test]
    public function it_validates_required_order_fields()
    {
        $response = $this->postJson('/api/orders', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['user_id', 'delivery_address', 'items']);
    }

    #[Test]
    public function it_can_show_single_order_with_items()
    {
        $order = Order::factory()->create();
        OrderItem::factory()->count(2)->create(['order_id' => $order->id]);

        $response = $this->getJson("/api/orders/{$order->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'user_id',
                    'status',
                    'items' => [
                        '*' => ['id', 'product_id', 'quantity', 'price']
                    ]
                ]
            ]);
    }

    #[Test]
    public function it_can_update_order_status()
    {
        $order = Order::factory()->create(['status' => 'pending']);

        $response = $this->putJson("/api/orders/{$order->id}", [
            'status' => 'processing'
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 'processing']);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'processing'
        ]);
    }

    #[Test]
    public function it_validates_order_status_values()
    {
        $order = Order::factory()->create();

        $response = $this->putJson("/api/orders/{$order->id}", [
            'status' => 'invalid_status'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['status']);
    }

    #[Test]
    public function it_can_delete_an_order()
    {
        $order = Order::factory()->create();

        $response = $this->deleteJson("/api/orders/{$order->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Order deleted successfully'
            ]);

        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}
