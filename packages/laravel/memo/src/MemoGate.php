<?php

declare(strict_types=1);

namespace Honed\Memo;

use Honed\Memo\Concerns\Memoizable;
use Illuminate\Auth\Access\Gate as AccessGate;

class MemoGate extends AccessGate
{
    use Memoizable;

    /**
     * Get the memoized, raw result from the authorization callback.
     *
     * @param  string  $ability
     * @param  mixed  $arguments
     * @return mixed
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function raw($ability, $arguments = [])
    {
        $hash = $this->getHash($ability, $arguments);

        if ($this->isNotMemoized($hash)) {
            $result = $this->memoize($hash, parent::raw($ability, $arguments));

            return $result;
        }

        return $this->memoized($hash);
    }

    /**
     * Get a cached gate instance for the given user.
     */
    public function forUser($user): static
    {
        // @phpstan-ignore-next-line
        $key = (string) $user->getAuthIdentifier();

        if ($this->isNotMemoized($key)) {
            /** @var static $gate */
            $gate = $this->memoize($key, parent::forUser($user));

            return $gate;
        }

        /** @var static */
        return $this->memoized($key);
    }
}
