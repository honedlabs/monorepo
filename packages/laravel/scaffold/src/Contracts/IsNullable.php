<?php

declare(strict_types=1);

namespace Honed\Scaffold\Contracts;

interface IsNullable
{
    /**
     * Determine whether the property is nullable.
     */
    public function isNullable(): bool;

    /**
     * Prompt the user for whether the property is nullable.
     */
    public function promptForNullable(): void;
}
