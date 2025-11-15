<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Scaffold\Support\ScaffoldContext;
use Honed\Scaffold\Contracts\Scaffolder as ScaffolderContract;
use Illuminate\Console\View\Components\Factory;

abstract class Scaffolder implements ScaffolderContract
{
    public function __construct(
        protected ScaffoldContext $context,
        protected Factory $components,
    ) { }

    /**
     * Get the context for scaffolding.
     */
    public function getContext(): ScaffoldContext
    {
        return $this->context;
    }
}