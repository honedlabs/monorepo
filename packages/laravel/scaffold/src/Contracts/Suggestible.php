<?php

declare(strict_types=1);

namespace Honed\Scaffold\Contracts;

interface Suggestible
{
    /**
     * Prompt the user for input.
     */
    public function suggest(): void;
}