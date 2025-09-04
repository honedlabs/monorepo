<?php

declare(strict_types=1);

namespace Honed\Disable\Concerns;

use Honed\Disable\Support\Disable;

/**
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model&\Honed\Disable\Contracts\Disableable>
 */
trait QueriesDisableable
{
    /**
     * Scope the query to only include disabled models.
     */
    public function disabled(bool $value = true): static
    {
        Disable::builder($this, $this->getModel(), $value);

        return $this;
    }

    /**
     * Scope the query to only include enabled models.
     */
    public function enabled(bool $value = true): static
    {
        return $this->disabled(! $value);
    }
}
