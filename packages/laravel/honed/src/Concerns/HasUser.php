<?php

declare(strict_types=1);

namespace Honed\Honed\Concerns;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Config;

/**
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
trait HasUser
{
    /**
     * Get the user that owns the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, $this>
     */
    public function user()
    {
        /** @var class-string<User> */
        $user = Config::get('auth.providers.users.model', User::class);

        return $this->belongsTo(
            $user,
            $this->getUserIdColumn(),
            (new $user())->getKeyName(),
        );
    }
}
