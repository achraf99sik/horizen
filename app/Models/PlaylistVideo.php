<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class PlaylistVideo extends Model
{
    /** @use HasFactory<\Database\Factories\PlaylistVideoFactory> */
    use HasFactory;

    /**
     * Get the videos in this playlist
     * @return HasMany<Video, Playlist>
     */
    public function video(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    /**
     * Get the playlist
     * @return HasMany<Playlist, Video>
     */
    public function playlist(): HasMany
    {
        return $this->hasMany(Playlist::class);
    }
}
