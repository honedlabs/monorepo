<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

interface HasIcon
{
    /**
     * Get the icon.
     */
    public function getIcon(): ?string;
}
