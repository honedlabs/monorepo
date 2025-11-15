<?php

declare(strict_types=1);

namespace Honed\Scaffold\Contracts;

interface ScaffoldContext
{
    /**
     * Create a new scaffold context instance.
     */
    public static function make(string $name): static;

    /**
     * Get the name of the model being scaffolded.
     */
    public function getName(): string;
}
