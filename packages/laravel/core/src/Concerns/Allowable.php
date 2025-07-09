<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;

trait Allowable
{
    /**
     * The allow condition.
     *
     * @var (Closure():bool)|bool
     */
    protected $allow = true;

    /**
     * Set the allow condition.
     *
     * @param  (Closure():bool)|bool  $value
     * @return $this
     */
    public function allow(Closure|bool $value): static
    {
        $this->allow = $value;

        return $this;
    }

    /**
     * Get the allow condition callback.
     *
     * @return (Closure():bool)|bool
     *
     * @internal
     */
    public function allowCallback(): Closure|bool
    {
        return $this->allow;
    }

    /**
     * Determine if the parameters pass the allow condition.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     */
    public function isAllowed(array $parameters = [], array $typed = []): bool
    {
        return (bool) $this->evaluate($this->allowCallback(), $parameters, $typed);
    }
}
