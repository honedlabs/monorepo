<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Scaffold\Support\PendingTrait;
use Honed\Scaffold\Support\PendingMethod;
use Honed\Scaffold\Support\PendingCommand;
use Honed\Scaffold\Support\ScaffoldContext;
use Honed\Scaffold\Support\PendingInterface;
use Illuminate\Console\View\Components\Factory;
use Honed\Scaffold\Contracts\Scaffolder as ScaffolderContract;

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

    /**
     * Create a new pending command instance.
     */
    public function newCommand(): PendingCommand
    {
        return $this->getContext()->newCommand();
    }

    /**
     * Create a new pending method instance.
     */
    public function newMethod(): PendingMethod
    {
        return $this->getContext()->newMethod();
    }

    /**
     * Create a new pending interface instance.
     */
    public function newInterface(): PendingInterface
    {
        return $this->getContext()->newInterface();
    }

    /**
     * Create a new pending trait instance.
     */
    public function newTrait(): PendingTrait
    {
        return $this->getContext()->newTrait();
    }
}