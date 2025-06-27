<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasMeta
{
    /**
     * The meta data.
     *
     * @var array<string,mixed>|(\Closure(...mixed):array<string,mixed>)
     */
    protected $meta = [];

    /**
     * Set the meta data.
     *
     * @param  array<string,mixed>|(\Closure(...mixed):array<string,mixed>)  $meta
     * @return $this
     */
    public function meta($meta)
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
