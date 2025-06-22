<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Tests\TestCase;

class GoogleAuthenticatorTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_authentication_redirects_to_google()
    {
        $response = $this->get('/auth/google/redirect');

        $response->assertRedirect();
        $this->assertStringContainsString('accounts.google.com', $response->getTargetUrl());
    }

    public function test_google_authentication_callback_creates_user()
    {
        // Create a mock of the Socialite user
        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')
            ->andReturn('123456789')
            ->shouldReceive('getName')
            ->andReturn('Test User')
            ->shouldReceive('getEmail')
            ->andReturn('test@example.com');

        // Create a mock of the Google provider
        $provider = Mockery::mock(GoogleProvider::class);
        $provider->shouldReceive('user')->andReturn($abstractUser);

        // Replace the Socialite implementation
        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        // Call the callback
        $response = $this->get('/auth/google/callback');

        // Verify that the user was created and authenticated
        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();

        // Verify that the user exists in the database
        $user = User::where('email', 'test@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('123456789', $user->google_id);
    }

    public function test_google_authentication_uses_existing_user()
    {
        // Create an existing user
        $existingUser = User::factory()->create([
            'name' => 'Existing User',
            'email' => 'existing@example.com',
            'google_id' => '123456789'
        ]);

        // Create a mock of the Socialite user
        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')
            ->andReturn('123456789')
            ->shouldReceive('getName')
            ->andReturn('Existing User')
            ->shouldReceive('getEmail')
            ->andReturn('existing@example.com');

        // Create a mock of the Google provider
        $provider = Mockery::mock(GoogleProvider::class);
        $provider->shouldReceive('user')->andReturn($abstractUser);

        // Replace the Socialite implementation
        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        // Call the callback
        $response = $this->get('/auth/google/callback');

        // Verify that the user was authenticated
        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertEquals($existingUser->id, Auth::id());
    }

    public function test_google_authentication_fails_with_exception()
    {
        // Create a mock of the Google provider that throws an exception
        $provider = Mockery::mock(GoogleProvider::class);
        $provider->shouldReceive('user')->andThrow(new \Exception('Invalid credentials'));

        // Replace the Socialite implementation
        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        // Call the callback
        $response = $this->get('/auth/google/callback');

        // Verify that there is a redirect with an error
        $response->assertRedirect(route('lp'));
        $this->assertGuest();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
