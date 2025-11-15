<?php

declare(strict_types=1);

namespace Honed\Scaffold\Support;

use Illuminate\Contracts\Config\Repository;
use Honed\Scaffold\Collections\ScaffolderCollection;
use Honed\Scaffold\Contracts\Property;

class ScaffoldContext
{
    /**
     * The commands to be executed.
     * 
     * @var array<class-string<\Honed\Scaffold\Scaffolders\Scaffolder>, \Honed\Scaffold\Support\PendingCommand>
     */
    protected $commands = [];

    /**
     * The properties to be added.
     * 
     * @var list<\Honed\Scaffold\Contracts\Property>
     */
    protected $properties = [];

    public function __construct(
        protected string $name,
        protected Repository $config,
    ) { }

    /**
     * Create a new scaffold context instance.
     */
    public static function make(string $name): static
    {
        return app(static::class, ['name' => $name]);
    }

    /**
     * Determine if the context uses the given scaffolder.
     * 
     * @param class-string<\Honed\Scaffold\Scaffolders\Scaffolder> $className
     */
    public function isUsing(string $className): bool
    {
        return isset($this->commands[$className]);
    }

    /**
     * Add a command to the context.
     */
    public function addCommand(string $className, PendingCommand $command): void
    {
        $this->commands[$className] = $command;
    }

    /**
     * Get the commands for the context.
     * 
     * @return array<class-string<\Honed\Scaffold\Scaffolders\Scaffolder>, \Honed\Scaffold\Support\PendingCommand>
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * Add a property to the context.
     */
    public function addProperty(Property $property): void
    {
        $this->properties[] = $property;
    }

    /**
     * Get the properties for the context.
     * 
     * @return list<\Honed\Scaffold\Contracts\Property>
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * Get the scaffolders to be used.
     * 
     * @return list<\Honed\Scaffold\Contracts\Scaffolder>
     */
    public function getScaffolders(): array
    {
        /** @var list<\Honed\Scaffold\Contracts\Scaffolder> */
        return (new ScaffolderCollection($this->getScaffolderClassNames()))
            ->build($this)
            ->toArray();
    }

    /**
     * Scaffold the context.
     */
    public function generate(): void
    {
        foreach ($this->commands as $className => $command) {
            $command->call($this);
        }
    }

    /**
     * Get the scaffolders to be used.
     * 
     * @return list<class-string<\Honed\Scaffold\Contracts\Scaffolder>>
     */
    protected function getScaffolderClassNames(): array
    {
        /** @var list<class-string<\Honed\Scaffold\Contracts\Scaffolder>> */
        return $this->config->get('scaffold.scaffolders', []);
    }
}