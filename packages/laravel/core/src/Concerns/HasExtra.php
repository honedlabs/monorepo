<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasExtra
{
    /**
     * Extra data for the instance.
     *
     * @var array<string,mixed>|\Closure
     */
    protected $extra = [];

    /**
     * Set the extra for the instance.
     *
     * @param  array<string,mixed>|\Closure|null  $extra
     * @return $this
     */
    public function extra($extra)
    {
        if (! \is_null($extra)) {
            $this->extra = $extra;
        }

        return $this;
    }

    /**
     * Get the extra for the instance.
     *
     * @return array<string,mixed>
     */
    public function getExtra()
    {
        return $this->extra instanceof \Closure
            ? $this->resolveExtra()
            : $this->extra;
    }

    /**
     * Evaluate the extra parameters for the instance.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return array<string,mixed>
     */
    public function resolveExtra($parameters = [], $typed = [])
    {
        /** @var array<string,mixed>|null */
        $evaluated = $this->evaluate($this->extra, $parameters, $typed);

        return $evaluated;
    }

    /**
     * Determine if the instance has a extra set.
     *
     * @return bool
     */
    public function hasExtra()
    {
        return filled($this->extra);
    }
}
