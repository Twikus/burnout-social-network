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

        // Supprimer l'ancien avatar s'il existe
        if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
            Storage::disk('public')->delete($oldAvatarPath);
        }

        // Stocker le nouvel avatar
        $avatarPath = $request->file('avatar_url')->store('avatars', 'public');

        // Mettre à jour l'utilisateur avec le nouveau chemin de l'avatar (storage/app/public/avatars)
        $user->update([
            'avatar_url' => $avatarPath,
        ]);

        return $user->refresh();
    }
}
