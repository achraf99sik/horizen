<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Nationality extends Model
{
    /**
     * Get all the users with this nationality
     * @return HasMany<UserInfo, Nationality>
     */
    public function user(): HasMany
    {
        return $this->hasMany(UserInfo::class);
    }
}
