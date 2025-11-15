<?php

declare(strict_types=1);

namespace Honed\Scaffold\Contracts;

interface Property extends Promptable
{
    /**
     * Create a new property instance.
     */
    public static function make(): static;

    /**
     * Get the name of the property.
     */
    public function getName(): string;

    /**
     * Get the column type of the property.
     */
    public function getColumn(): string;
}
