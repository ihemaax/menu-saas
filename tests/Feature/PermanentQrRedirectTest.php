<?php

namespace Tests\Feature;

use App\Models\MenuSetting;
use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermanentQrRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_generates_permanent_qr_code_for_new_restaurant(): void
    {
        $restaurant = Restaurant::create([
            'name' => 'QR Restaurant',
        ]);

        $this->assertNotNull($restaurant->permanent_qr_code);
        $this->assertStringStartsWith('rest_', $restaurant->permanent_qr_code);
    }

    public function test_valid_permanent_qr_link_redirects_to_current_menu_slug(): void
    {
        $restaurant = Restaurant::create([
            'name' => 'The Tree',
        ]);

        MenuSetting::create([
            'restaurant_id' => $restaurant->id,
            'slug' => 'the-tree',
            'is_public' => true,
            'theme' => 'classy',
        ]);

        $response = $this->get(route('public.menu.redirect', ['code' => $restaurant->permanent_qr_code]));

        $response->assertRedirect(route('menu.show', ['slug' => 'the-tree']));
    }

    public function test_invalid_permanent_qr_link_returns_404(): void
    {
        $this->get(route('public.menu.redirect', ['code' => 'rest_invalid_code']))
            ->assertNotFound();
    }

    public function test_changing_slug_keeps_permanent_qr_and_redirects_to_new_slug(): void
    {
        $restaurant = Restaurant::create([
            'name' => 'The Tree',
        ]);

        $menuSetting = MenuSetting::create([
            'restaurant_id' => $restaurant->id,
            'slug' => 'the-tree',
            'is_public' => true,
            'theme' => 'classy',
        ]);

        $originalCode = $restaurant->permanent_qr_code;

        $menuSetting->update([
            'slug' => 'the-tree-cafe',
        ]);

        $this->assertSame($originalCode, $restaurant->fresh()->permanent_qr_code);

        $this->get(route('public.menu.redirect', ['code' => $originalCode]))
            ->assertRedirect(route('menu.show', ['slug' => 'the-tree-cafe']));
    }
}
