<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_loads_with_analytics_sections()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('backend.home'));

        $response->assertOk();
        $response->assertSeeText('Visitor Analytics');
        $response->assertSeeText('Mobil Terpopuler');
        $response->assertSeeText('Jenis Leads');
    }

    public function test_dashboard_stats_endpoint_returns_periodic_data()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('backend.dashboard.stats', ['period' => '30']));

        $response->assertOk();
        $response->assertJsonStructure([
            'period',
            'kpis',
            'chart',
            'popular_products',
            'lead_types',
            'recent_leads',
        ]);
    }
}
