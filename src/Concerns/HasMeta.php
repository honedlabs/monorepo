<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasMeta
{
    /**
     * @var array<array-key, mixed>|\Closure():array<array-key, mixed>
     */
    protected $meta = [];

    /**
     * Set the meta, chainable.
     *
     * @param  array<array-key, mixed>|\Closure():array<array-key, mixed>  $meta
     * @return $this
     */
    public function meta(array|\Closure $meta): static
    {
        $this->setMeta($meta);

        return $this;
    }

    /**
     * Set the meta quietly.
     *
     * @param  array<array-key, mixed>|\Closure():array<array-key, mixed>|null  $meta
     */
    public function setMeta(array|\Closure|null $meta): void
    {
        if (is_null($meta)) {
            return;
        }
        $this->meta = $meta;
    }

    /**
     * Get the meta.
     *
     * @return array<array-key, mixed>
     */
    public function getMeta()
    {
        return $this->evaluate($this->meta);
    }

    /**
     * Determine if the class does not have metadata.
     */
    public function missingMeta(): bool
    {
        return empty($this->getMeta());
    }

    /**
     * Determine if the class has metadata.
     */
    public function hasMeta(): bool
    {
        return ! $this->missingMeta();
    }
}
