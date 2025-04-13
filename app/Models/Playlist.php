<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Playlist extends Model
{
    /** @use HasFactory<\Database\Factories\PlaylistFactory> */
    use HasFactory;

    /**
     * Get the user who made this playlist
     *
     * @return BelongsTo<User, playlist>
     */
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
