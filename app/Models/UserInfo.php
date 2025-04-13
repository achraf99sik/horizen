<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class UserInfo extends Model
{
    use HasFactory;

    /**
     * Get the user that owns this user info.
     *
     * @return BelongsTo<User, UserInfo>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the nationality of this user.
     *
     * @return BelongsTo<Nationality, UserInfo>
     */
    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Nationality::class);
    }
}
