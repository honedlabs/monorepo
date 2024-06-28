<?php

namespace Conquest\Core\Table\Concerns;

use Conquest\Core\Exceptions\KeyDoesntExist;

/**
 * Set a required key property.
 */
trait RequiresKey
{
    /**
     * Retrieve the key property
     * 
     * @return string
     * @throws KeyDoesntExist
     */
    public function getKey(): string
    {
        if (isset($this->key)) {
            return $this->key;
        }

        if (method_exists($this, 'key')) {
            return $this->key();
        }
        
        throw new KeyDoesntExist();
    }
}