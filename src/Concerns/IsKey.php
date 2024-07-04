<?php

namespace Conquest\Core\Concerns;

trait IsKey
{
    protected bool $key = false;

    /**
     * Check if the class is the key
     * 
     * @return bool
     */
    public function isKey(): bool
    {
        return $this->key;
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
    protected function setKey(bool $key): void
    {
        $this->key = $key;
    }
}