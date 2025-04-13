<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class UserInfo extends Model
{
    /** @use HasFactory<\Database\Factories\UserInfoFactory> */
    use HasFactory;

    /**
     * Get user with user info
     * @return HasOne<User, UserInfo>
     */
    public function user(): HasOne
    {
        return $this->HasOne(User::class);
    }

    /**
     * Get nationality of a given user
     * @return HasOne<Nationality, UserInfo>
     */
    public function nationality(): HasOne
    {
        return $this->HasOne(Nationality::class);
    }
}
