<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;

trait HasExtra
{
    /**
     * Extra data.
     *
     * @var array<string,mixed>|Closure():array<string,mixed>|null
     */
    protected $extra;

    /**
     * Set the extra data.
     *
     * @param  array<string,mixed>|Closure():array<string,mixed>|null  $extra
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
     * @return ?array<string,mixed>
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
