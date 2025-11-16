<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Scaffold\Concerns\InteractsWithSystem;
use Honed\Scaffold\Contracts\Property;
use Honed\Scaffold\Contracts\Scaffolder as ScaffolderContract;
use Honed\Scaffold\Support\PendingCommand;
use Honed\Scaffold\Support\PendingInterface;
use Honed\Scaffold\Support\PendingMethod;
use Honed\Scaffold\Support\PendingTrait;
use Honed\Scaffold\Support\ScaffoldContext;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Console\View\Components\Factory;
use Illuminate\Support\Str;
use ReflectionMethod;

abstract class Scaffolder implements ScaffolderContract
{
    use InteractsWithSystem;

    public function __construct(
        protected ScaffoldContext $context,
        protected Factory $components,
    ) {}

    /**
     * Get the context for scaffolding.
     */
    public function getContext(): ScaffoldContext
    {
        return $this->context;
    }

    /**
     * Get the name of the model being scaffolded.
     */
    public function getName(): string
    {
        return $this->getContext()->getName();
    }

    /**
     * Suffix the name of the model being scaffolded.
     */
    public function suffixName(string $suffix, ?string $name = null): string
    {
        $name = $name ?? $this->getContext()->getName();

        if (Str::endsWith($name, $suffix)) {
            return $name;
        }

        return $name.$suffix;
    }

    /**
     * Prefix the name of the model being scaffolded.
     */
    public function prefixName(string $prefix, ?string $name = null): string
    {
        $name = $name ?? $this->getContext()->getName();

        if (Str::startsWith($name, $prefix)) {
            return $name;
        }

        return $prefix.$name;
    }

    /**
     * Qualify the name against a generator.
     *
     * @param  class-string<GeneratorCommand>|GeneratorCommand  $generator
     * @return class-string
     */
    public function qualifyGenerator(string $name, string|GeneratorCommand $generator): string
    {
        $generator = is_string($generator) ? app($generator) : $generator;

        $generator->setLaravel(app());

        $method = new ReflectionMethod($generator, 'qualifyClass');

        $method->setAccessible(true);

        /** @var class-string */
        return $method->invoke($generator, $name);
    }

    /**
     * Add an import to the context.
     */
    public function addImport(string $import): void
    {
        $this->getContext()->addImport($import);
    }

    /**
     * Add a property to the context.
     */
    public function addProperty(Property $property): void
    {
        $this->getContext()->addProperty($property);
    }

    /**
     * Add a command to the context.
     */
    public function addCommand(PendingCommand $command): void
    {
        $this->getContext()->addCommand($command);
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
     * Add a method to the context.
     */
    public function addMethod(PendingMethod $method): void
    {
        $this->getContext()->addMethod($method);
    }

    /**
     * Create a new pending interface instance.
     */
    public function newInterface(): PendingInterface
    {
        return $this->getContext()->newInterface();
    }

    /**
     * Add an interface to the context.
     */
    public function addInterface(PendingInterface $interface): void
    {
        $this->getContext()->addInterface($interface);
    }

    /**
     * Create a new pending trait instance.
     */
    public function newTrait(): PendingTrait
    {
        return $this->getContext()->newTrait();
    }

    /**
     * Add a trait to the context.
     */
    public function addTrait(PendingTrait $trait): void
    {
        $this->getContext()->addTrait($trait);
    }
}
