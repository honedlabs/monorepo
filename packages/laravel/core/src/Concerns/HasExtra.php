<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasExtra
{
    /**
     * Extra data.
     *
     * @var array<string,mixed>|\Closure(...mixed):array<string,mixed>|null
     */
    protected $extra;

    /**
     * Set the extra data.
     *
     * @param  array<string,mixed>|\Closure(...mixed):array<string,mixed>  $extra
     * @return $this
     */
    public function extra($extra)
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * Define the extra data.
     *
     * @return \Closure(...mixed):array<string,mixed>
     */
    public function defineExtra()
    {
        return [];
    }

    /**
     * Get the extra data.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return array<string,mixed>
     */
    public function getExtra($parameters = [], $typed = [])
    {
        $extra = $this->extra ??= $this->defineExtra();

        return $this->evaluate($extra, $parameters, $typed);
    }

    /**
     * Determine if extra data is set.
     *
     * @return bool
     */
    public function hasExtra()
    {
        return filled($this->getExtra());
    }
}
