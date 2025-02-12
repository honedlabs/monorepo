<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Allowable
{
    /**
     * @var \Closure|bool
     */
    protected $allow = true;

    /**
     * Set the allow condition for the instance.
     *
     * @return $this
     */
    public function allow(\Closure|bool $allow): static
    {
        $this->allow = $allow;

        return $this;
    }

    /**
     * Determine if the instance allows the given parameters.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<string,mixed>  $typed
     */
    public function isAllowed($parameters = [], $typed = []): bool
    {
        $evaluated = $this->evaluate($this->allow, $parameters, $typed);

        $this->allow = $evaluated;

        return $evaluated;
    }
}
