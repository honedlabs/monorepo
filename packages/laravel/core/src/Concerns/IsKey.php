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
     * Set the column as the key, chainable
     *
     * @return $this
     */
    public function key(bool $key = true): static
    {
        $this->setKey($key);

        return $this;
    }

    /**
     * Set the key value quietly
     */
    public function setKey(bool $key): void
    {
        $this->key = $key;
    }

    /**
     * Determine if the class is the key.
     */
    public function isKey(): bool
    {
        return $this->key;
    }
}
