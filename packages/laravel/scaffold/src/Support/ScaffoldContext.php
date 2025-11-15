<?php

declare(strict_types=1);

namespace Honed\Scaffold\Support;

use Honed\Scaffold\Collections\ScaffolderCollection;
use Honed\Scaffold\Contracts\Property;
use Honed\Scaffold\Contracts\ScaffoldContext as ScaffoldContextContract;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;

class ScaffoldContext implements ScaffoldContextContract
{
    /**
     * The imports to be added.
     *
     * @var list<string>
     */
    protected $imports = [];

    /**
     * The properties to be added.
     *
     * @var list<Property>
     */
    protected $properties = [];

    /**
     * The commands to be executed.
     *
     * @var list<PendingCommand>
     */
    protected $commands = [];

    /**
     * The interfaces to be implemented.
     *
     * @var list<PendingInterface>
     */
    protected $interfaces = [];

    /**
     * The methods to be added.
     *
     * @var list<PendingMethod>
     */
    protected $methods = [];

    /**
     * The traits to be used.
     *
     * @var list<PendingTrait>
     */
    protected $traits = [];

    public function __construct(
        protected string $name,
        protected Repository $config,
    ) {}

    /**
     * Create a new scaffold context instance.
     */
    public static function make(string $name): static
    {
        return app(static::class, ['name' => $name]);
    }

    /**
     * Get the name of the model being scaffolded.
     */
    public function getName(): string
    {
        return $this->name;
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
     * @param  list<string>  $imports
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
     * Add a property to the context.
     */
    public function addProperty(Property $property): void
    {
        $this->properties[] = $property;
    }

    /**
     * Add multiple properties to the context.
     *
     * @param  list<Property>  $properties
     */
    public function addProperties(array $properties): void
    {
        $this->properties = array_merge($this->properties, $properties);
    }

    /**
     * Get the properties for the context.
     *
     * @return list<Property>
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * Add a command to the context.
     */
    public function addCommand(PendingCommand $command): void
    {
        $this->commands[] = $command;
    }

    /**
     * Add multiple commands to the context.
     *
     * @param  list<PendingCommand>  $commands
     */
    public function addCommands(array $commands): void
    {
        $this->commands = array_merge($this->commands, $commands);
    }

    /**
     * Get the commands for the context.
     *
     * @return list<PendingCommand>
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
    public function addInterface(PendingInterface $interface): void
    {
        $this->interfaces[] = $interface;
    }

    /**
     * Add multiple interfaces to the context.
     *
     * @param  list<PendingInterface>  $interfaces
     */
    public function addInterfaces(array $interfaces): void
    {
        $this->interfaces = array_merge($this->interfaces, $interfaces);
    }

    /**
     * Get the interfaces for the context.
     *
     * @return list<PendingInterface>
     */
    public function getInterfaces(): array
    {
        return $this->interfaces;
    }

    /**
     * Create a new pending interface instance.
     */
    public function newInterface(): PendingInterface
    {
        return new PendingInterface();
    }

    /**
     * Add a method to the context.
     */
    public function addMethod(PendingMethod $method): void
    {
        $this->methods[] = $method;
    }

    /**
     * Add multiple methods to the context.
     *
     * @param  list<PendingMethod>  $methods
     */
    public function addMethods(array $methods): void
    {
        $this->methods = array_merge($this->methods, $methods);
    }

    /**
     * Get the methods for the context.
     *
     * @return list<PendingMethod>
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * Create a new pending method instance.
     */
    public function newMethod(): PendingMethod
    {
        return new PendingMethod();
    }

    /**
     * Add a trait to the context.
     */
    public function addTrait(string|PendingTrait $trait): void
    {
        $this->traits[] = $trait;
    }

    /**
     * Add multiple traits to the context.
     *
     * @param  list<string|PendingTrait>  $traits
     */
    public function addTraits(array $traits): void
    {
        $this->traits = array_merge($this->traits, $traits);
    }

    /**
     * Get the traits for the context.
     *
     * @return list<string|PendingTrait>
     */
    public function getTraits(): array
    {
        return $this->traits;
    }

    /**
     * Create a new pending trait instance.
     */
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
    public function generate(): void {}
}
