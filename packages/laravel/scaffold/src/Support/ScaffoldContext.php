<?php

declare(strict_types=1);

namespace Honed\Scaffold\Support;

class ScaffoldContext
{
    /**
     * The commands to be executed.
     * 
     * @var array<class-string<\Honed\Scaffold\Scaffolders\Scaffolder>, \Honed\Scaffold\Support\PendingCommand>
     */
    protected $commands = [];

    public function __construct(
        protected string $name
    ) { }

    /**
     * Determine if the context has
     * 
     * @param class-string<\Honed\Scaffold\Scaffolders\Scaffolder> $className
     */
    public function hasScaffolder(string $className): bool
    {
        return isset($this->commands[$className]);
    }

    public function generate(): void
    {

    }
}