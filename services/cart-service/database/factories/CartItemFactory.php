<?php

namespace Database\Factories;

use App\Models\CartItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    protected $model = CartItem::class;

    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 10),
            'product_id' => fake()->unique()->numberBetween(1, 1000),
            'quantity' => fake()->numberBetween(1, 5),
        ];
    }
}
