<?php

namespace Tests\Feature;

use App\Models\CartItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_list_cart_items()
    {
        CartItem::factory()->count(3)->create(['user_id' => 1]);

        $response = $this->getJson('/api/cart?user_id=1');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => ['id', 'user_id', 'product_id', 'quantity']
                ]
            ]);
    }

    #[Test]
    public function it_can_add_item_to_cart()
    {
        $cartData = [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 2
        ];

        $response = $this->postJson('/api/cart', $cartData);

        $response->assertStatus(201)
            ->assertJsonFragment($cartData);

        $this->assertDatabaseHas('cart_items', $cartData);
    }

    #[Test]
    public function it_validates_quantity_is_positive()
    {
        $response = $this->postJson('/api/cart', [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 0
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['quantity']);
    }

    #[Test]
    public function it_can_update_cart_item_quantity()
    {
        $cartItem = CartItem::factory()->create(['quantity' => 1]);

        $response = $this->putJson("/api/cart/{$cartItem->id}", [
            'quantity' => 5
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['quantity' => 5]);

        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'quantity' => 5
        ]);
    }

    #[Test]
    public function it_can_delete_cart_item()
    {
        $cartItem = CartItem::factory()->create();

        $response = $this->deleteJson("/api/cart/{$cartItem->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('cart_items', [
            'id' => $cartItem->id
        ]);
    }

    #[Test]
    public function it_can_clear_entire_cart()
    {
        CartItem::factory()->count(3)->create(['user_id' => 1]);

        $response = $this->deleteJson('/api/cart/clear/1');

        $response->assertStatus(200);

        $this->assertDatabaseMissing('cart_items', ['user_id' => 1]);
    }

    #[Test]
    public function it_prevents_duplicate_cart_items()
    {
        CartItem::factory()->create([
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 2
        ]);

        $response = $this->postJson('/api/cart', [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 3
        ]);

        $response->assertStatus(201);
        
        $this->assertEquals(1, CartItem::where('user_id', 1)->where('product_id', 1)->count());
    }
}
