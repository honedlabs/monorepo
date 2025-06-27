<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait CanHaveExtra
{
    /**
     * Extra data.
     *
     * @var array<string,mixed>|(\Closure(...mixed):array<string,mixed>)|null
     */
    protected $extra;

    /**
     * Set the extra data.
     *
     * @param  array<string,mixed>|(\Closure(...mixed):array<string,mixed>)|null  $extra
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
        return $this->evaluate($this->extra);
    }

    /**
     * Determine if extra data is set.
     *
     * @return bool
     */
    public function hasExtra()
    {
        return isset($this->extra);
    }
}
