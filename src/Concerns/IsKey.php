<?php

namespace Conquest\Core\Concerns;

use Closure;

trait IsKey
{
    protected bool|Closure $key = false;

    /**
     * Set the column as the key, chainable
     * 
     * @return static
     */
    public function key(bool|Closure $key = true): static
    {
        $this->setKey($key);
        return $this;
    }

    /**
     * Set the key value quietly
     * 
     * @param bool $key
     * @return void
     */
    public function setKey(bool|Closure $key): void
    {
        $this->key = $key;
    }

    /**
     * Check if the class is the key
     * 
     * @return bool
     */
    public function isKey(): bool
    {
        return $this->evaluate($this->key);
    }

    /**
     * Check if the class is not the key
     * 
     * @return bool
     */
    public function isNotKey(): bool
    {
        return !$this->isKey();
    }
}