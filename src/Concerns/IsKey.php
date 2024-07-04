<?php

namespace Conquest\Core\Concerns;

use Closure;

trait IsKey
{
    protected bool|Closure $key = false;

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
     * Set the column as the key, chainable
     * 
     * @return static
     */
    public function key(): static
    {
        $this->setKey(true);
        return $this;
    }

    /**
     * Alias for key
     * 
     * @return static
     */
    public function asKey(): static
    {
        return $this->key();
    }

    /**
     * Set the column as not the key, chainable
     * 
     * @return static
     */
    public function notKey(): static
    {
        $this->setKey(false);
        return $this;
    }


    /**
     * Alias for notKey
     * 
     * @return static
     */
    public function notAsKey(): static
    {
        return $this->notKey();
    }

    /**
     * Set the key value quietly
     * 
     * @param bool $key
     * @return void
     */
    public function setKey(bool $key): void
    {
        $this->key = $key;
    }
}