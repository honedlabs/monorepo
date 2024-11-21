<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait IsKey
{
    /**
     * @var bool|(\Closure():bool)
     */
    protected $key = false;

    /**
     * Set the column as the key, chainable
     * 
     * @param bool|(\Closure():bool) $key
     * @return $this
     */
    public function key(bool|\Closure $key = true): static
    {
        $this->setKey($key);

        return $this;
    }

    /**
     * Set the key value quietly
     * 
     * @param bool|(\Closure():bool)|null $key
     */
    public function setKey(bool|\Closure|null $key): void
    {
        if (is_null($key)) {
            return;
        }
        $this->key = $key;
    }

    /**
     * Determine if the class is the key.
     */
    public function isKey(): bool
    {
        return (bool) $this->evaluate($this->key);
    }

    /**
     * Determine if the class is not the key.
     */
    public function isNotKey(): bool
    {
        return ! $this->isKey();
    }
}
