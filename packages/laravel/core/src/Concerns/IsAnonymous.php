<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @property-read class-string $anonymous
 */
trait IsAnonymous
{
    /**
     * Determine if the instance is anonymous.
     */
    public function isAnonymous(): bool
    {
        if (! \property_exists($this, 'anonymous')) {
            return false;
        }

        $reflection = new \ReflectionClass($this);

        return $reflection->getName() === $this->anonymous;
    }
}
