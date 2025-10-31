<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

interface HasDescription
{
    /**
     * Get the description.
     */
    public function getDescription(): ?string;
}
