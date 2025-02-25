<?php

declare(strict_types=1);

namespace Honed\Modal\Tests\Stubs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $username
 */
class User extends Model
{
    protected $guarded = [];

    public function tweets(): HasMany
    {
        return $this->hasMany(Tweet::class);
    }
}
