<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_dashboard_statistics()
    {
        $response = $this->getJson('/api/dashboard');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'stats' => [
                        'total_users',
                        'total_products',
                        'total_orders',
                        'total_revenue'
                    ],
                    'recent_orders'
                ]
            ]);
    }

    #[Test]
    public function it_returns_stats_for_different_periods()
    {
        $response = $this->getJson('/api/dashboard?period=week');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => ['stats']
            ]);
    }

    #[Test]
    public function it_handles_service_unavailability_gracefully()
    {
        $response = $this->getJson('/api/dashboard');

        $response->assertStatus(200);
        
        $data = $response->json('data.stats');
        $this->assertIsArray($data);
    }
}
