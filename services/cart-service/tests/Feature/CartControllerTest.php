<?php

namespace Tests\Feature;

use App\Models\CartItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_cart_items()
    {
        CartItem::factory()->count(3)->create(['user_id' => 1]);

        $response = $this->getJson('/api/cart');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data' => [
                    '*' => ['id', 'user_id', 'product_id', 'quantity']
                ]
            ]);
    }

    /** @test */
    public function it_can_add_item_to_cart()
    {
        $cartData = [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 2
        ];

        $response = $this->postJson('/api/cart', $cartData);

        $response->assertStatus(201)
            ->assertJson($cartData);

        $this->assertDatabaseHas('cart_items', $cartData);
    }

    /** @test */
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

    /** @test */
    public function it_can_update_cart_item_quantity()
    {
        $cartItem = CartItem::factory()->create([
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 2
        ]);

        $response = $this->putJson("/api/cart/{$cartItem->id}", [
            'quantity' => 5
        ]);

        $response->assertStatus(200)
            ->assertJson(['quantity' => 5]);

        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'quantity' => 5
        ]);
    }

    /** @test */
    public function it_can_delete_cart_item()
    {
        $cartItem = CartItem::factory()->create(['user_id' => 1]);

        $response = $this->deleteJson("/api/cart/{$cartItem->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('cart_items', [
            'id' => $cartItem->id
        ]);
    }

    /** @test */
    public function it_can_clear_entire_cart()
    {
        CartItem::factory()->count(3)->create(['user_id' => 1]);

        $response = $this->deleteJson('/api/cart/clear', [
            'user_id' => 1
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('cart_items', [
            'user_id' => 1
        ]);
    }

    /** @test */
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

        // Should fail due to unique constraint
        $response->assertStatus(422);
    }
}
