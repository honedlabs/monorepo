<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Exceptions\MissingRequiredAttributeException;

trait RequiresKey
{
    /**
     * Retrieve the key property
     *
     * @throws MissingRequiredAttributeException
     */
    public function getKey(): string
    {
        return match (true) {
            \method_exists($this, 'key') => $this->key(),
            \property_exists($this, 'key') && isset($this->key) => $this->key,
            default => throw new MissingRequiredAttributeException('key', $this),
        };
    }
}
