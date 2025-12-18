<?php

namespace Tests\Feature;

use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_list_all_payments()
    {
        Payment::factory()->count(3)->create();

        $response = $this->getJson('/api/payments');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => ['id', 'order_id', 'user_id', 'amount', 'status']
                    ]
                ]
            ]);
    }

    #[Test]
    public function it_can_create_a_payment()
    {
        $paymentData = [
            'order_id' => 1,
            'user_id' => 1,
            'amount' => 1500.00,
            'payment_method' => 'card'
        ];

        $response = $this->postJson('/api/payments', $paymentData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'data' => ['id', 'order_id', 'amount', 'status']
            ]);

        $this->assertDatabaseHas('payments', [
            'order_id' => 1,
            'amount' => 1500.00
        ]);
    }

    #[Test]
    public function it_validates_required_payment_fields()
    {
        $response = $this->postJson('/api/payments', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['order_id', 'user_id', 'amount', 'payment_method']);
    }

    #[Test]
    public function it_validates_amount_is_positive()
    {
        $response = $this->postJson('/api/payments', [
            'order_id' => 1,
            'user_id' => 1,
            'amount' => -100,
            'payment_method' => 'card'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['amount']);
    }

    #[Test]
    public function it_validates_payment_method()
    {
        $response = $this->postJson('/api/payments', [
            'order_id' => 1,
            'user_id' => 1,
            'amount' => 100,
            'payment_method' => 'invalid_method'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['payment_method']);
    }

    #[Test]
    public function it_can_show_single_payment()
    {
        $payment = Payment::factory()->create();

        $response = $this->getJson("/api/payments/{$payment->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => ['id', 'order_id', 'user_id', 'amount', 'status']
            ]);
    }

    #[Test]
    public function it_can_filter_payments_by_user()
    {
        Payment::factory()->count(2)->create(['user_id' => 1]);
        Payment::factory()->count(3)->create(['user_id' => 2]);

        $response = $this->getJson('/api/payments?user_id=1');

        $response->assertStatus(200);
        
        $data = $response->json('data.data');
        $this->assertCount(2, $data);
    }

    #[Test]
    public function it_can_filter_payments_by_status()
    {
        Payment::factory()->count(2)->create(['status' => 'completed']);
        Payment::factory()->count(3)->create(['status' => 'pending']);

        $response = $this->getJson('/api/payments?status=completed');

        $response->assertStatus(200);
        
        $data = $response->json('data.data');
        $this->assertCount(2, $data);
    }

    #[Test]
    public function it_returns_404_for_non_existent_payment()
    {
        $response = $this->getJson('/api/payments/999');

        $response->assertStatus(404);
    }
}
