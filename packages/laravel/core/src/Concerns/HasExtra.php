<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasExtra
{
    /**
     * @var array<string,mixed>|\Closure
     */
    protected $extra = [];

    /**
     * Set the extra for the instance.
     *
     * @return $this
     */
    public function extra(array|\Closure|null $extra): static
    {
        if (! \is_null($extra)) {
            $this->extra = $extra;
        }

        return $this;
    }

    /**
     * Get the extra for the instance.
     */
    public function getExtra(): array
    {
        return $this->extra instanceof \Closure
            ? $this->resolveExtra()
            : $this->extra;
    }

    /**
     * Evaluate the extra parameters for the instance.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<string,mixed>  $typed
     * @return array<string,mixed>
     */
    public function resolveExtra(array $parameters = [], array $typed = []): array
    {
        /** @var array<string,mixed>|null */
        $evaluated = $this->evaluate($this->extra, $parameters, $typed);

        $this->extra = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has a extra set.
     */
    public function hasExtra(): bool
    {
        return $this->extra instanceof \Closure || \count($this->extra) > 0;
    }
}
