<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasMeta
{
    /**
     * The meta data.
     *
     * @var array<string,mixed>|null
     */
    protected $meta;

    /**
     * Set the meta data.
     *
     * @param  array<string,mixed>|null  $meta
     * @return $this
     */
    public function meta($meta = null)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Define the meta data.
     *
     * @return array<string,mixed>
     */
    public function defineMeta()
    {
        return [];
    }

    /**
     * Get the meta.
     *
     * @return array<string,mixed>
     */
    public function getMeta()
    {
        return $this->meta ??= $this->defineMeta();
    }

    /**
     * Determine if meta is set.
     *
     * @return bool
     */
    public function hasMeta()
    {
        return isset($this->getMeta());
    }
}
