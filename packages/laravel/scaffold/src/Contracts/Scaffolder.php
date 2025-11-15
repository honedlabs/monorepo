<?php

declare(strict_types=1);

namespace Honed\Scaffold\Contracts;

use Honed\Scaffold\Support\ScaffoldContext;

interface Scaffolder extends Promptable
{
    /**
     * Determine if the scaffolder is applicable to the context and should be executed.
     */
    public function isApplicable(): bool;

    /**
     * Get the context for scaffolding.
     */
    public function getContext(): ScaffoldContext;
}
