<?php

declare(strict_types=1);

namespace Honed\Data\Contracts;

interface Disableable
{
    /**
     * Determine if the instance is disabled.
     */
    public function isDisabled(): bool;
}
