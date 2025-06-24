<?php

namespace App\Services\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Repositories\UserRepository;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthenticatorService
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Redirect to Google for authentication.
     *
     * @return RedirectResponse
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google after authentication.
     *
     * @return RedirectResponse
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('lp')->withErrors(['google' => $e->getMessage()]);
        }

        // Check if the user already exists in app by email or Google ID
        $user = $this->userRepository->getByEmailOrGoogleId($googleUser->getEmail(), $googleUser->getId());

        if (!$user) {
            // Create a new user if not found
            $user = $this->userRepository->create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'email_verified_at' => now(),
                'password' => bcrypt(Str::random(16)), // Random password for OAuth users
            ]);
        }

        // Log the user
        Auth::login($user, true);

        return redirect()->route('home');
    }
}
