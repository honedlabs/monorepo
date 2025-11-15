<?php

declare(strict_types=1);

namespace Honed\Scaffold\Contracts;

interface Scaffolder extends Suggestible
{
    /**
     * Determine if the scaffolder is applicable to the context and should be executed.
     */
    public function isApplicable(): bool;
}