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
     * @param bool $key The key state to set.
     * @return $this
     */
    public function key($key = true)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Determine if the instance is the key.
     * 
     * @return bool True if the instance is the key, false otherwise.
     */
    public function isKey()
    {
        return $this->key;
    }
}
