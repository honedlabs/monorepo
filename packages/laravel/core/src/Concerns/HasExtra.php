<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Contracts\DefinesExtra;

trait HasExtra
{
    /**
     * Extra data.
     *
     * @var array<string,mixed>|\Closure(mixed...):array<string,mixed>
     */
    protected $extra = [];

    /**
     * Set the extra data.
     *
     * @param  array<string,mixed>|\Closure(mixed...):array<string,mixed>  $extra
     * @return $this
     */
    public function extra($extra)
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * Get the extra data.
     *
     * @return array<string,mixed>
     */
    public function getExtra()
    {
        $extra = $this instanceof DefinesExtra
            ? \Closure::fromCallable([$this, 'defineExtra'])
            : $this->extra;

        return $this->evaluate($extra);
    }

    /**
     * Evaluate the extra parameters.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return array<string,mixed>
     */
    public function resolveExtra($parameters = [], $typed = [])
    {
        $extra = $this instanceof DefinesExtra
            ? \Closure::fromCallable([$this, 'defineExtra'])
            : $this->extra;

        /** @var array<string,mixed>|null */
        $evaluated = $this->evaluate($extra, $parameters, $typed);

        return $evaluated;
    }

    /**
     * Determine if extra data is set.
     *
     * @return bool
     */
    public function hasExtra()
    {
        return filled($this->extra);
    }
}
