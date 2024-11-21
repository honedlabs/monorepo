<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use ReflectionClass;

/**
 * Check if the class is anonymous
 *
 * @property class-string $anonymous
 */
trait IsAnonymous
{
    /**
     * Check if the class is anonymous
     */
    public function isAnonymous(): bool
    {
        $reflection = new ReflectionClass($this);

        return $reflection->getName() === $this->anonymous;
    }

    public function isNotAnonymous(): bool
    {
        return ! $this->isAnonymous();
    }
}
