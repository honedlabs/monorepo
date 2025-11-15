<?php

declare(strict_types=1);

namespace Honed\Scaffold\Contracts;

interface Promptable
{
    /**
     * Prompt the user for input.
     */
    public function prompt(): void;
}
