<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasMeta
{
    /**
     * @var array<array-key, mixed>|\Closure(mixed...):array<array-key, mixed>
     */
    protected $meta = [];

    /**
     * Set the meta, chainable.
     *
     * @param  array<array-key, mixed>|\Closure(mixed...):array<array-key, mixed>  $meta
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
     * @param  array<array-key, mixed>|\Closure(mixed...):array<array-key, mixed>|null $meta
     */
    public function setMeta(array|\Closure|null $meta): void
    {
        if (is_null($meta)) {
            return;
        }
        $this->meta = $meta;
    }

    /**
     * Get the meta using the given closure dependencies.
     *
     * @param array<string, mixed> $named
     * @param array<string, mixed> $typed
     * @return array<array-key, mixed>
     */
    public function getMeta(array $named = [], array $typed = []): array
    {
        return $this->evaluate($this->meta, $named, $typed);
    }

    /**
     * Resolve the meta using the given closure dependencies.
     *
     * @param array<string, mixed> $named
     * @param array<string, mixed> $typed
     * @return array<array-key, mixed>
     */
    public function resolveMeta(array $named = [], array $typed = []): array
    {
        $this->setMeta($this->getMeta($named, $typed));

        return $this->meta;
    }

    /**
     * Determine if the class does not have metadata.
     *
     * @return bool
     */
    public function missingMeta(): bool
    {
        return empty($this->getMeta());
    }

    /**
     * Determine if the class has metadata.
     *
     * @return bool
     */
    public function hasMeta(): bool
    {
        return ! $this->missingMeta();
    }
}
