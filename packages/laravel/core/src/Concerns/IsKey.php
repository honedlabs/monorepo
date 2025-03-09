<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait IsKey
{
    /**
     * Whether the instance is the key.
     *
     * @var bool
     */
    protected $key = false;

    /**
     * Set the instance as the key.
     *
     * @param  bool  $key
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
     * @return bool
     */
    public function isKey()
    {
        return $this->key;
    }
}
