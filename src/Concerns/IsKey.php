<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;

trait IsKey
{
    protected bool|Closure $key = false;

    /**
     * Set the column as the key, chainable
     */
    public function key(bool|Closure $key = true): static
    {
        $this->setKey($key);

        return $this;
    }

    /**
     * Set the key value quietly
     *
     * @param  bool  $key
     */
    public function setKey(bool|Closure|null $key): void
    {
        if (is_null($key)) {
            return;
        }
        $this->key = $key;
    }

    /**
     * Check if the class is the key
     */
    public function isKey(): bool
    {
        return (bool) $this->evaluate($this->key);
    }

    /**
     * Check if the class is not the key
     */
    public function isNotKey(): bool
    {
        return ! $this->isKey();
    }
}
