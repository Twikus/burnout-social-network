<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('home', absolute: false));
    }

    public function test_new_account_is_created_even_if_soft_deleted_exists(): void
    {
        // Créer un utilisateur et le soft delete
        $originalUser = User::factory()->create([
            'email' => 'test@example.com',
        ]);
        $originalUser->delete();

        // Essayer de créer un nouveau compte avec le même email
        $response = $this->post('/register', [
            'name' => 'New User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();

        // Vérifier qu'un nouveau compte a été créé
        $this->assertDatabaseCount('users', 2); // 2 comptes : 1 soft deleted + 1 nouveau

        // Vérifier que le nouvel utilisateur est différent de l'ancien
        $newUser = User::where('email', 'test@example.com')->whereNull('deleted_at')->first();
        $this->assertNotEquals($originalUser->id, $newUser->id);
        $this->assertEquals('New User', $newUser->name);
    }

    public function test_cannot_register_with_existing_active_email(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }
}
