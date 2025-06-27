<?php

namespace Honed\Honed\Concerns;

use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Auth\User;

/**
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
trait HasUser
{
    /**
     * Get the user that owns the model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\Illuminate\Foundation\Auth\User, $this>
     */
    public function user()
    {
        /** @var class-string<\Illuminate\Foundation\Auth\User> */
        $user = Config::get('auth.providers.users.model', User::class);

        return $this->belongsTo(
            $user,
            $this->getUserIdColumn(),
            (new $user())->getKeyName(),
        );
    }
}