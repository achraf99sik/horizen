<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Kyojin\JWT\Traits\HasJWT;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

final class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasJWT, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    public function payload(): array
    {
        return [
            'role' => $this->role ?? 'user', // your custom payload values
        ];
    }

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
        ];
    }
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    // Comments written by the user
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // User information (about, date_birth, etc.)
    public function info(): HasOne
    {
        return $this->hasOne(UserInfo::class);
    }

    // Playlists created by the user
    public function playlists(): HasMany
    {
        return $this->hasMany(Playlist::class);
    }
}
