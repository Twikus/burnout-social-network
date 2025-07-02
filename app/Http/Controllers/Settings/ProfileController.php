<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use App\Http\Requests\Settings\StoreAvatarRequest;
use App\Services\Settings\UpdateUserService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{

    private $updateUserService;

    public function __construct(UpdateUserService $updateUserService)
    {
        $this->updateUserService = $updateUserService;
    }

    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/Profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status')
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return to_route('profile.edit')->with([
            'success' => 'Profil mis à jour avec succès',
            'user' => $request->user()
        ]);
    }

    /**
     * Update the user's avatar.
     */
    public function updateAvatar(StoreAvatarRequest $request): RedirectResponse
    {
        if (!$request->validated()) {
            return redirect('/settings/profile')->withErrors([
                'avatar' => 'Erreur lors de la validation de l\'avatar. Veuillez réessayer.'
            ]);
        }

        $userUpdated = $this->updateUserService->updateAvatar($request);

        return redirect()->route('profile.edit')->with([
            'success' => 'Avatar mis à jour avec succès',
            'user' => $userUpdated
        ]);
    }

    /**
     * Delete the user's profile.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
