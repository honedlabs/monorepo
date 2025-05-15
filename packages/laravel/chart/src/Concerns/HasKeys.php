<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Illuminate\Support\Arr;

trait HasKeys
{
    /**
     * The keys to use.
     * 
     * @var array<string, mixed>|null
     */
    protected $keys;

    /**
     * Set the keys to use.
     * 
     * @param iterable<string, mixed> $keys
     * @return $this
     */
    public function keys(...$keys)
    {
        $keys = Arr::flatten($keys);

        $this->keys = $keys;

        return $this;
    }

    /**
     * Get the keys to use.
     * 
     * @return array<string, mixed>|null
     */
    public function getKeys()
    {
        return $this->keys;
    }
    
}