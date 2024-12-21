<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @property class-string $anonymous
 */
trait IsAnonymous
{
    /**
     * Determine if the class is anonymous.
     */
    public function isAnonymous(): bool
    {
        $reflection = new \ReflectionClass($this);

        return $reflection->getName() === $this->anonymous;
    }

    /**
     * Determine if the class is not anonymous.
     */
    public function isNotAnonymous(): bool
    {
        return ! $this->isAnonymous();
    }
}
