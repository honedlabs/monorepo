<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait IsKey
{
    /**
     * @var bool
     */
    protected $key = false;

    /**
     * Set the instance as the key.
     *
     * @return $this
     */
    public function key(bool $key = true): static
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Determine if the instance is the key.
     */
    public function isKey(): bool
    {
        return $this->key;
    }
}
