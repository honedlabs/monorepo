<?php

declare(strict_types=1);

namespace Honed\Scaffold\Support;

use Honed\Scaffold\Collections\ScaffolderCollection;
use Honed\Scaffold\Contracts\Property;
use Honed\Scaffold\Contracts\ScaffoldContext as ScaffoldContextContract;
use Honed\Scaffold\Contracts\Scaffolder;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;

class ScaffoldContext implements ScaffoldContextContract
{
    /**
     * The imports to be added.
     *
     * @var \Illuminate\Support\Collection<int, string>
     */
    protected $imports;

    /**
     * The properties to be added.
     *
     * @var \Illuminate\Support\Collection<int, Property>
     */
    protected $properties;

    /**
     * The commands to be executed.
     *
     * @var \Illuminate\Support\Collection<int, PendingCommand>
     */
    protected $commands;

    /**
     * The interfaces to be implemented.
     *
     * @var \Illuminate\Support\Collection<int, PendingInterface>
     */
    protected $interfaces;

    /**
     * The methods to be added.
     *
     * @var \Illuminate\Support\Collection<int, PendingMethod>
     */
    protected $methods;

    /**
     * The traits to be used.
     *
     * @var \Illuminate\Support\Collection<int, PendingTrait>
     */
    protected $traits;

    public function __construct(
        protected string $name,
    ) {
        $this->imports = new Collection();
        $this->properties = new Collection();
        $this->commands = new Collection();
        $this->interfaces = new Collection();
        $this->methods = new Collection();
        $this->traits = new Collection();
    }

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
        $this->imports->push($import);
    }

    /**
     * Add multiple imports to the context.
     *
     * @param  list<string>  $imports
     */
    public function addImports(array $imports): void
    {
        $this->imports->push(...$imports);
    }

    /**
     * Get the imports for the context.
     *
     * @return \Illuminate\Support\Collection<int, string>
     */
    public function getImports(): Collection
    {
        return $this->imports;
    }

    /**
     * Add a property to the context.
     */
    public function addProperty(Property $property): void
    {
        $this->properties->push($property);
    }

    /**
     * Add multiple properties to the context.
     *
     * @param  list<Property>  $properties
     */
    public function addProperties(array $properties): void
    {
        $this->properties->push(...$properties);
    }

    /**
     * Get the properties for the context.
     *
     * @return \Illuminate\Support\Collection<int, Property>
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    /**
     * Add a command to the context.
     */
    public function addCommand(PendingCommand $command): void
    {
        $this->commands->push($command);
    }

    /**
     * Add multiple commands to the context.
     *
     * @param  list<PendingCommand>  $commands
     */
    public function addCommands(array $commands): void
    {
        $this->commands->push(...$commands);
    }

    /**
     * Get the commands for the context.
     *
     * @return \Illuminate\Support\Collection<int, PendingCommand>
     */
    public function getCommands(): Collection
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
        $this->interfaces->push($interface);
    }

    /**
     * Add multiple interfaces to the context.
     *
     * @param  list<PendingInterface>  $interfaces
     */
    public function addInterfaces(array $interfaces): void
    {
        $this->interfaces->push(...$interfaces);
    }

    /**
     * Get the interfaces for the context.
     *
     * @return \Illuminate\Support\Collection<int, PendingInterface>
     */
    public function getInterfaces(): Collection
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
        $this->methods->push($method);
    }

    /**
     * Get the methods for the context.
     *
     * @return \Illuminate\Support\Collection<int, PendingMethod>
     */
    public function getMethods(): Collection
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
    public function addTrait(PendingTrait $trait): void
    {
        $this->traits->push($trait);
    }

    /**
     * Add multiple traits to the context.
     *
     * @param  list<PendingTrait>  $traits
     */
    public function addTraits(array $traits): void
    {
        $this->traits->push(...$traits);
    }

    /**
     * Get the traits for the context.
     *
     * @return \Illuminate\Support\Collection<int, PendingTrait>
     */
    public function getTraits(): Collection
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
        return (new ScaffolderCollection(config()->array('scaffold.scaffolders', [])))
            ->build($this, $command)
            ->toArray();
    }

    /**
     * Scaffold the context.
     */
    public function generate(): void
    {
        $this->callCommands();

        $this->implementInterfaces();

        // $this->getMethods()->each->handle($this);

        // $this->getTraits()->each->handle($this);
    }

    /**
     * Call the commands.
     */
    protected function callCommands(): void
    {
        // $this->getCommands()->each(function (PendingCommand $command) {
        //     Artisan::call($command->getName(), $command->getArguments());
        // });
    }

    /**
     * Implement the interfaces.
     */
    protected function implementInterfaces(): void
    {
        //
    }

    /**
     * Use the traits.
     */
    protected function useTraits(): void
    {
        //
    }

    /**
     * Add the methods.
     */
    protected function addMethods(): void
    {
        //
    }
}
