<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasMeta
{
    /**
     * @var array<string,mixed>
     */
    protected array $meta = [];

    /**
     * Get or set the meta for the instance.
     *
     * @param  array<string,mixed>|null  $meta
     * @return $this
     */
    public function meta($meta = null)
    {
        if (! \is_null($meta)) {
            $this->meta = $meta;
        }

        return $this;
    }

    /**
     * Get the meta for the instance.
     *
     * @return array<string,mixed>
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Determine if the instance has meta set.
     *
     * @return bool
     */
    public function hasMeta()
    {
        return filled($this->meta);
    }
}
