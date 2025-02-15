<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

interface Iconable
{
    /**
     * Get the icon.
     */
    public function icon(): string;
}
