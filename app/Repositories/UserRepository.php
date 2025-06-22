<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

final class UserRepository extends BaseRepository
{
    public function __construct(
        protected User $user
    )
    {
        parent::__construct($this->user);
    }

    /**
     * Get a user by their email or Google ID.
     *
     * @param string $email
     * @param string|null $googleId
     * @return User|null
     */
    public function getByEmailOrGoogleId(string $email, ?string $googleId = null): ?User
    {
        return $this->user->where('email', $email)
                          ->orWhere('google_id', $googleId)
                          ->first();
    }
}
