<?php

declare(strict_types=1);

namespace Honed\Form\Contracts;

interface DefaultComponent
{
    /**
     * Get the component to use from the config.
     */
    public function getConfigComponent(): string;
}