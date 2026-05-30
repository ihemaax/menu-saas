<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Contracts\User as GoogleUser;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;

class GoogleAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_has_google_login_link(): void
    {
        $this->get('/login')
            ->assertStatus(200)
            ->assertSee(route('auth.google.redirect'), false);
    }

    public function test_register_screen_has_google_registration_link(): void
    {
        $this->get('/register')
            ->assertStatus(200)
            ->assertSee(route('auth.google.redirect'), false);
    }

    public function test_google_callback_creates_and_authenticates_a_new_user(): void
    {
        $provider = Mockery::mock();
        $googleUser = Mockery::mock(GoogleUser::class);

        $googleUser->shouldReceive('getEmail')->andReturn('Owner@Example.com');
        $googleUser->shouldReceive('getName')->andReturn('Google Owner');

        $provider->shouldReceive('stateless')->once()->andReturnSelf();
        $provider->shouldReceive('user')->once()->andReturn($googleUser);

        Socialite::shouldReceive('driver')->once()->with('google')->andReturn($provider);

        $response = $this->get(route('auth.google.callback'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'name' => 'Google Owner',
            'email' => 'owner@example.com',
        ]);
        $response->assertRedirect(route('onboarding.create', absolute: false));
    }

    public function test_google_callback_authenticates_an_existing_user(): void
    {
        $user = User::factory()->create([
            'email' => 'owner@example.com',
        ]);

        $provider = Mockery::mock();
        $googleUser = Mockery::mock(GoogleUser::class);

        $googleUser->shouldReceive('getEmail')->andReturn('owner@example.com');
        $provider->shouldReceive('stateless')->once()->andReturnSelf();
        $provider->shouldReceive('user')->once()->andReturn($googleUser);

        Socialite::shouldReceive('driver')->once()->with('google')->andReturn($provider);

        $this->get(route('auth.google.callback'));

        $this->assertAuthenticatedAs($user);
    }
}
