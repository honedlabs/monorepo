<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

interface IsIcon
{
    /**
     * Get the icon as raw HTML.
     */
    public function icon(): string;
}
