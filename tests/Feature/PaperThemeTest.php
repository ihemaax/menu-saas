<?php

namespace Tests\Feature;

use App\Models\MenuSetting;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaperThemeTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_menu_renders_with_paper_theme(): void
    {
        $restaurant = Restaurant::create([
            'name' => 'El-Nerwegy Barber Shop',
            'subscription_status' => 'active',
        ]);

        MenuSetting::create([
            'restaurant_id' => $restaurant->id,
            'slug' => 'el-nerwegy',
            'is_public' => true,
            'theme' => 'paper',
        ]);

        $response = $this->get(route('menu.show', ['slug' => 'el-nerwegy']));

        $response->assertOk();
        $response->assertSee('outer-frame');
        $response->assertSee('themeToggle');
        $response->assertSee('searchInput');
        $response->assertSee('menuCategories');
        $response->assertSee('productModal');
        $response->assertSee('El-Nerwegy Barber Shop');
    }

    public function test_owner_can_set_theme_to_paper(): void
    {
        $restaurant = Restaurant::create([
            'name' => 'The Olives',
            'subscription_status' => 'active',
        ]);

        $menuSetting = MenuSetting::create([
            'restaurant_id' => $restaurant->id,
            'slug' => 'the-olives',
            'is_public' => true,
            'theme' => 'classy',
        ]);

        $user = User::factory()->create([
            'restaurant_id' => $restaurant->id,
        ]);

        $response = $this->actingAs($user)
            ->put(route('settings.menu.update'), [
                'slug' => 'the-olives',
                'is_public' => '1',
                'theme' => 'paper',
            ]);

        $response->assertRedirect();
        $this->assertEquals('paper', $menuSetting->fresh()->theme);
    }
}
