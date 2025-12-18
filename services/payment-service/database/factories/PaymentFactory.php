<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'order_id' => fake()->numberBetween(1, 100),
            'user_id' => 1,
            'amount' => fake()->numberBetween(1000, 10000),
            'payment_method' => fake()->randomElement(['card', 'cash', 'online']),
            'status' => fake()->randomElement(['pending', 'completed', 'failed', 'refunded']),
            'transaction_id' => fake()->uuid(),
        ];
    }
}
