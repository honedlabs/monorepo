<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns\Support;

trait CanMatch
{
    /**
     * Whether the search can select which columns are used to search on.
     *
     * @var bool|null
     */
    protected $matches;

    /**
     * Determine whether the user's preferences should be remembered.
     */
    public function canMatch(): bool
    {
        if (isset($this->matches)) {
            return $this->matches;
        }

        /** @var bool */
        return config('refine.matches', false);
    }
}
