<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasMeta
{
    /**
     * The meta data.
     *
     * @var array<string,mixed>|(\Closure(...mixed):array<string,mixed>)|null
     */
    protected $meta = [];

    /**
     * Set the meta data.
     *
     * @param  array<string,mixed>|(\Closure(...mixed):array<string,mixed>)|null  $meta
     * @return $this
     */
    public function meta($meta = null)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Get the meta.
     *
     * @return array<string,mixed>
     */
    public function getMeta()
    {
        return $this->evaluate($this->meta);
    }
}
