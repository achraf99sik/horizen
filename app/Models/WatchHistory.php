<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class WatchHistory extends Model
{
    /** @use HasFactory<\Database\Factories\WatchHistoryFactory> */
    use HasFactory;

    /**
     * Get all videos in this watch history
     * @return HasMany<Video, Like>
     */
    public function video(): HasMany
    {
        return $this->hasMany(Video::class);
    }
    /**
     * Get the user who owns this watch history
     * @return HasMany<User, Like>
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
