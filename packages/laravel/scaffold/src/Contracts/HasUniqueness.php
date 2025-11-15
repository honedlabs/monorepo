<?php

declare(strict_types=1);

namespace Honed\Scaffold\Contracts;

interface HasUniqueness
{
    /**
     * Determine whether the property is unique.
     */
    public function isUnique(): bool;

    /**
     * Prompt the user for whether the property is unique.
     */
    public function promptForUniqueness(): void;
}
