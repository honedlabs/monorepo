<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;

trait CanHaveExtra
{
    /**
     * Extra data.
     *
     * @var array<string,mixed>|(\Closure(...mixed):array<string,mixed>)|null
     */
    protected array|Closure|null $extra = null;

    /**
     * Set the extra data.
     *
     * @param  array<string,mixed>|(\Closure(...mixed):array<string,mixed>)|null  $extra
     * @return $this
     */
    public function extra(array|Closure|null $extra): static
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * Get the extra data.
     *
     * @return array<string,mixed>|null
     */
    public function getExtra(): ?array
    {
        return $this->evaluate($this->extra);
    }

    /**
     * Determine if extra data is set.
     */
    public function hasExtra(): bool
    {
        return isset($this->extra);
    }
}
