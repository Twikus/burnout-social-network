<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\GoogleAuthenticatorService;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    private $googleAuthenticatorService;

    public function __construct(GoogleAuthenticatorService $googleAuthenticatorService)
    {
        $this->googleAuthenticatorService = $googleAuthenticatorService;
    }

    public function redirectToGoogle()
    {
        return $this->googleAuthenticatorService->redirectToGoogle();
    }

    public function handleGoogleCallback(Request $request)
    {
        return $this->googleAuthenticatorService->handleGoogleCallback();
    }
}
