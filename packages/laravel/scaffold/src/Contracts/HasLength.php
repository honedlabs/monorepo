<?php

declare(strict_types=1);

namespace Honed\Scaffold\Contracts;

interface HasLength
{
    /**
     * Get the length of the property.
     */
    public function getLength(): int;

    /**
     * Prompt the user for the length of the property.
     */
    public function promptForLength(): void;
}
