<?php

namespace Tests\Feature;

use App\Models\MenuSetting;
use App\Models\MenuVisit;
use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuVisitTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_menu_visit_is_recorded_once_per_recent_visitor(): void
    {
        $restaurant = Restaurant::create([
            'name' => 'Visit Test Restaurant',
            'subscription_status' => 'active',
        ]);

        MenuSetting::create([
            'restaurant_id' => $restaurant->id,
            'slug' => 'visit-test',
            'is_public' => true,
            'theme' => 'classy',
        ]);

        $headers = [
            'User-Agent' => 'Mozilla/5.0 iPhone Safari',
            'Accept-Language' => 'ar-EG',
            'Referer' => 'https://wa.me/example',
        ];

        $this->withServerVariables(['REMOTE_ADDR' => '10.10.10.10'])
            ->get(route('menu.show', 'visit-test'), $headers)
            ->assertOk();

        $this->withServerVariables(['REMOTE_ADDR' => '10.10.10.10'])
            ->get(route('menu.show', 'visit-test'), $headers)
            ->assertOk();

        $this->assertDatabaseCount('menu_visits', 1);
        $this->assertDatabaseHas('menu_visits', [
            'restaurant_id' => $restaurant->id,
            'device_type' => 'mobile',
            'source' => 'whatsapp',
        ]);
    }

    public function test_bot_preview_is_not_recorded_as_visit(): void
    {
        $restaurant = Restaurant::create([
            'name' => 'Bot Test Restaurant',
            'subscription_status' => 'active',
        ]);

        MenuSetting::create([
            'restaurant_id' => $restaurant->id,
            'slug' => 'bot-test',
            'is_public' => true,
            'theme' => 'classy',
        ]);

        $this->get(route('menu.show', 'bot-test'), [
            'User-Agent' => 'facebookexternalhit/1.1',
        ])->assertOk();

        $this->assertSame(0, MenuVisit::query()->count());
    }
}
