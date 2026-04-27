<?php

namespace Tests\Feature;

use App\Models\MenuSetting;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QrPrintDesignTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_open_qr_print_design_preview(): void
    {
        [$user, $restaurant] = $this->createOwnerWithRestaurant();

        $response = $this->actingAs($user)->get(route('settings.menu.qr-design.preview'));

        $response->assertOk();
        $response->assertSee($restaurant->name);
        $response->assertDontSee($restaurant->permanentQrUrl(), false);
        $response->assertDontSee('Powered by Osirix', false);
        $response->assertDontSee('Designed by Osirix', false);
    }

    public function test_owner_can_download_qr_print_design_file(): void
    {
        [$user] = $this->createOwnerWithRestaurant();

        $response = $this->actingAs($user)->get(route('settings.menu.qr-design.download'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/html; charset=UTF-8');
        $response->assertHeader('Content-Disposition');
    }

    private function createOwnerWithRestaurant(): array
    {
        $restaurant = Restaurant::create([
            'name' => 'The Olive Lounge',
        ]);

        MenuSetting::create([
            'restaurant_id' => $restaurant->id,
            'slug' => 'the-olive-lounge',
            'is_public' => true,
            'theme' => 'classy',
        ]);

        $user = User::factory()->create([
            'restaurant_id' => $restaurant->id,
        ]);

        return [$user, $restaurant];
    }
}
