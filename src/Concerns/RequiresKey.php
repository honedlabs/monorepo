<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Exceptions\MissingRequiredAttributeException;

trait RequiresKey
{
    /**
     * Retrieve the key property
     *
     * @return string
     * @throws MissingRequiredAttributeException
     */
    public function getKey(): string
    {
        if (method_exists($this, 'key')) {
            return $this->key();
        }

        if (property_exists($this, 'key') && isset($this->key)) {
            return $this->key;
        }

        throw new MissingRequiredAttributeException('key', $this);
    }
}
