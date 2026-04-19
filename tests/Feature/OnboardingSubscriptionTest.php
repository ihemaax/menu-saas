<?php

namespace Tests\Feature;

use App\Models\MenuSetting;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OnboardingSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_assigns_free_trial_dates_when_restaurant_is_created(): void
    {
        config(['subscription.free_trial_days' => 30]);

        $user = User::factory()->create([
            'created_at' => now()->subDays(3),
        ]);

        $this->actingAs($user)
            ->post(route('onboarding.store'), [
                'restaurant_name' => 'مطعم تجريبي',
                'slug' => 'mat3am-tagreby',
                'is_public' => 1,
            ])
            ->assertRedirect(route('dashboard'));

        $restaurant = $user->refresh()->restaurant;

        $this->assertNotNull($restaurant);
        $this->assertSame('active', $restaurant->subscription_status);
        $this->assertTrue($restaurant->subscription_starts_at->equalTo($user->created_at));
        $this->assertTrue(
            $restaurant->subscription_ends_at->equalTo($user->created_at->copy()->addDays(30))
        );

        $this->assertDatabaseHas('menu_settings', [
            'restaurant_id' => $restaurant->id,
            'slug' => 'mat3am-tagreby',
            'is_public' => 1,
        ]);
    }

    public function test_it_does_not_create_another_free_trial_for_user_with_existing_restaurant(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('onboarding.store'), [
                'restaurant_name' => 'المطعم الأول',
                'slug' => 'first-restaurant',
                'is_public' => 1,
            ])
            ->assertRedirect(route('dashboard'));

        $existingRestaurantId = $user->refresh()->restaurant_id;
        $restaurantsCount = Restaurant::count();
        $menuSettingsCount = MenuSetting::count();

        $this->actingAs($user)
            ->post(route('onboarding.store'), [
                'restaurant_name' => 'المطعم الثاني',
                'slug' => 'second-restaurant',
                'is_public' => 1,
            ])
            ->assertRedirect(route('dashboard'));

        $this->assertSame($existingRestaurantId, $user->refresh()->restaurant_id);
        $this->assertSame($restaurantsCount, Restaurant::count());
        $this->assertSame($menuSettingsCount, MenuSetting::count());
    }
}
