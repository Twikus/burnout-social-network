<?php

namespace App\Services\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UpdateUserService
{
    public function updateAvatar($request): User
    {
        $user = $request->user();

        $oldAvatarPath = $user->getRawOriginal('avatar_url');

        // If the user has an old avatar, delete it from storage
        if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
            Storage::disk('public')->delete($oldAvatarPath);
        }

        // Store the new avatar file in the 'avatars' directory within the public disk
        $avatarPath = $request->file('avatar_url')->store('avatars', 'public');

        $user->update([
            'avatar_url' => $avatarPath,
        ]);

        return $user->refresh();
    }
}
