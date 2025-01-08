<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Exceptions\MissingRequiredAttributeException;

trait RequiresKey
{
    /**
     * Retrieve the key property.
     *
     * @throws MissingRequiredAttributeException
     */
    public function requiredKey(): string
    {
        return match (true) {
            \property_exists($this, 'key') && isset($this->key) => $this->key,
            \method_exists($this, 'key') => $this->key(),
            default => throw new MissingRequiredAttributeException('key', static::class),
        };
    }
}
