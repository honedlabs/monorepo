<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

interface HasLabel
{
    /**
     * Get the label.
     */
    public function getLabel(): ?string;
}
