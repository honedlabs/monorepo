<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Scaffold\Support\ScaffoldContext;
use Honed\Scaffold\Contracts\Scaffolder as ScaffolderContract;

abstract class Scaffolder implements ScaffolderContract
{
    public function __construct(
        protected ScaffoldContext $context,
    ) { }

    /**
     * Get the context for scaffolding.
     */
    public function getContext(): ScaffoldContext
    {
        return $this->context;
    }
}