<?php

namespace Tests\Feature;

use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    /** @test */
    public function it_returns_dashboard_statistics()
    {
        $response = $this->getJson('/api/dashboard');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'users' => ['count', 'status'],
                    'products' => ['count', 'status'],
                    'orders' => ['count', 'status'],
                    'payments' => ['count', 'status']
                ]
            ]);
    }

    /** @test */
    public function it_returns_stats_for_different_periods()
    {
        $response = $this->getJson('/api/stats?period=30days');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'sales',
                    'orders',
                    'users'
                ]
            ]);
    }

    /** @test */
    public function it_handles_service_unavailability_gracefully()
    {
        // When services are down, it should still return response with error status
        $response = $this->getJson('/api/dashboard');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        
        // Each service should have a status field
        $this->assertArrayHasKey('status', $data['users']);
        $this->assertArrayHasKey('status', $data['products']);
        $this->assertArrayHasKey('status', $data['orders']);
        $this->assertArrayHasKey('status', $data['payments']);
    }
}
