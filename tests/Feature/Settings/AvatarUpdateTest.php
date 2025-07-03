<?php

namespace Tests\Feature\Settings;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AvatarUpdateTest extends TestCase
{
    protected array $uploadedFiles = [];

    /**
     * Set up the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure the avatars disk is set up for testing
        Storage::fake('avatars');
    }

    protected function tearDown(): void
    {
        // Supprimer tous les fichiers uploadés pendant les tests
        foreach ($this->uploadedFiles as $filePath) {
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        parent::tearDown();
    }

    public function test_avatar_can_be_updated(): void
    {
        $user = User::factory()->create();

        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this
            ->actingAs($user)
            ->post('/settings/profile/avatar', [
                'avatar_url' => $file
            ]);

        $response->assertSessionHasNoErrors();

        $uploadedPath = $user->getRawOriginal('avatar_url');
        if ($uploadedPath) {
            $this->uploadedFiles[] = $uploadedPath;
        }

        $fakeFile = Storage::disk('avatars')->files('avatars');
        $this->assertNotNull($fakeFile);
    }

    public function test_avatar_cant_be_updated_if_empty(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post('/settings/profile/avatar', [
                'avatar_url' => ''
            ]);

        $response->assertSessionHasErrors();

        $user->refresh();

        // Assert that the avatar_url has not changed
        $this->assertEquals('', $user->avatar_url);
    }

    public function test_avatar_cant_be_updated_if_more_maxsize(): void
    {
        $user = User::factory()->create();

        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpg')->size(4096); // 4MB

        $response = $this
            ->actingAs($user)
            ->post('/settings/profile/avatar', [
                'avatar_url' => $file
            ]);

        $response->assertSessionHasErrors();
    }

    public function test_avatar_cant_be_updated_if_not_image(): void
    {
        $user = User::factory()->create();

        Storage::fake('avatars');

        $file = UploadedFile::fake()->create('test-not-an-image.txt', 100); // Not an image

        $response = $this
            ->actingAs($user)
            ->post('/settings/profile/avatar', [
                'avatar_url' => $file
            ]);

        $response->assertSessionHasErrors();
    }

    public function test_user_avatar_is_deleted_when_account_is_deleted()
    {
        $user = User::factory()->create();

        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this
            ->actingAs($user)
            ->post('/settings/profile/avatar', [
                'avatar_url' => $file
            ]);

        $response->assertSessionHasNoErrors();

        $uploadedPath = $user->getRawOriginal('avatar_url');
        if ($uploadedPath) {
            $this->uploadedFiles[] = $uploadedPath;
        }

        $fakeFile = Storage::disk('avatars')->files('avatars');
        $this->assertNotNull($fakeFile);

        // Supprimer le compte
        $this->actingAs($user)
            ->delete('/settings/profile', [
                'password' => 'password',
            ]);

        $this->assertGuest();
        $this->assertSoftDeleted($user);

        $fakeFile = Storage::disk('avatars')->files('avatars');
        $this->assertEmpty($fakeFile);
    }
}
