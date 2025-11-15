<?php

declare(strict_types=1);

namespace Honed\Scaffold\Support;

use Illuminate\Contracts\Config\Repository;
use Honed\Scaffold\Collections\ScaffolderCollection;
use Honed\Scaffold\Contracts\Property;
use Illuminate\Console\Command;

class ScaffoldContext
{
    /**
     * The properties to be added.
     * 
     * @var list<\Honed\Scaffold\Contracts\Property>
     */
    protected $properties = [];

    /**
     * The imports to be added.
     * 
     * @var list<string>
     */
    protected $imports = [];

    /**
     * The commands to be executed.
     * 
     * @var list<string|\Honed\Scaffold\Support\PendingCommand>
     */
    protected $commands = [];

    /**
     * The interfaces to be implemented.
     * 
     * @var list<string|\Honed\Scaffold\Support\PendingInterface>
     */
    protected $interfaces = [];

    /**
     * The methods to be added.
     * 
     * @var list<string|\Honed\Scaffold\Support\PendingMethod>
     */
    protected $methods = [];

    /**
     * The traits to be used.
     * 
     * @var list<string|\Honed\Scaffold\Support\PendingTrait>
     */
    protected $traits = [];

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
     * Add a property to the context.
     */
    public function addProperty(Property $property): void
    {
        $this->properties[] = $property;
    }

    /**
     * Add multiple properties to the context.
     * 
     * @param list<\Honed\Scaffold\Contracts\Property> $properties
     */
    public function addProperties(array $properties): void
    {
        $this->properties = array_merge($this->properties, $properties);
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
     * Add an import to the context.
     */
    public function addImport(string $import): void
    {
        $this->imports[] = $import;
    }

    /**
     * Add multiple imports to the context.
     * 
     * @param list<string> $imports
     */
    public function addImports(array $imports): void
    {
        $this->imports = array_merge($this->imports, $imports);
    }

    /**
     * Get the imports for the context.
     * 
     * @return list<string>
     */
    public function getImports(): array
    {
        return $this->imports;
    }

    /**
     * Add a command to the context.
     */
    public function addCommand(string|PendingCommand $command): void
    {
        $this->commands[] = $command;
    }

    /**
     * Add multiple commands to the context.
     * 
     * @param class-string<\Honed\Scaffold\Scaffolders\Scaffolder> $className
     * @param list<\Honed\Scaffold\Support\PendingCommand> $commands
     */
    public function addCommands(string $className, array $commands): void
    {
        $this->commands[$className] = array_merge($this->commands[$className], $commands);
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
     * Create a new pending command instance.
     */
    public function newCommand(): PendingCommand
    {
        return new PendingCommand();
    }

    /**
     * Add an interface to the context.
     */
    public function addInterface(string $interface): void
    {
        $this->interfaces[] = $interface;
    }

    /**
     * Add multiple interfaces to the context.
     * 
     * @param list<string> $interfaces
     */
    public function addInterfaces(array $interfaces): void
    {
        $this->interfaces = array_merge($this->interfaces, $interfaces);
    }

    /**
     * Get the interfaces for the context.
     * 
     * @return list<string>
     */
    public function getInterfaces(): array
    {
        return $this->interfaces;
    }

    public function newInterface(): PendingInterface
    {
        return new PendingInterface();
    }

    /**
     * Add a method to the context.
     */
    public function addMethod(string $method): void
    {
        $this->methods[] = $method;
    }

    /**
     * Add multiple methods to the context.
     * 
     * @param list<string> $methods
     */
    public function addMethods(array $methods): void
    {
        $this->methods = array_merge($this->methods, $methods);
    }

    /**
     * Get the methods for the context.
     * 
     * @return list<string>
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    public function newMethod(): PendingMethod
    {
        return new PendingMethod();
    }

    /**
     * Add a trait to the context.
     */
    public function addTrait(string $trait): void
    {
        $this->traits[] = $trait;
    }

    /**
     * Add multiple traits to the context.
     * 
     * @param list<string> $traits
     */
    public function addTraits(array $traits): void
    {
        $this->traits = array_merge($this->traits, $traits);
    }

    /**
     * Get the traits for the context.
     * 
     * @return list<string>
     */
    public function getTraits(): array
    {
        return $this->traits;
    }

    public function newTrait(): PendingTrait
    {
        return new PendingTrait();
    }

    /**
     * Get the scaffolders to be used.
     * 
     * @return list<\Honed\Scaffold\Contracts\Scaffolder>
     */
    public function getScaffolders(Command $command): array
    {
        /** @var list<\Honed\Scaffold\Contracts\Scaffolder> */
        return (new ScaffolderCollection($this->config->get('scaffold.scaffolders', [])))
            ->build($this, $command)
            ->toArray();
    }

    /**
     * Scaffold the context.
     */
    public function generate(): void
    {
        
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