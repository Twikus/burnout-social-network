<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'email_verified_at',
        'avatar_url',
        'bio',
        'is_public',
        'last_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_active_at' => 'datetime',
            'is_public' => 'boolean',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Get the full URL for the user's avatar.
     */
    public function getAvatarUrlAttribute(): ?string
    {
        // Si l'attribut avatar_url existe en base
        if (!$this->attributes['avatar_url']) {
            return null;
        }

        // Si c'est déjà une URL complète, la retourner
        if (str_starts_with($this->attributes['avatar_url'], 'http')) {
            return $this->attributes['avatar_url'];
        }

        // Sinon, construire l'URL pour les fichiers stockés localement
        return Storage::disk('public')->url($this->attributes['avatar_url']);
    }
}
