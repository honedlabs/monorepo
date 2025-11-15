<?php

declare(strict_types=1);

namespace Honed\Scaffold\Contracts;

interface Property extends Suggestible
{
    /**
     * Create a new property instance.
     */
    public static function make(): static;
}