<?php

declare(strict_types=1);

namespace Honed\Scaffold\Support;

use Honed\Core\Concerns\HasName;
use Honed\Scaffold\Support\Utility\Writer;
use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use ReflectionClass;
use ReflectionMethod;

class PendingCommand
{
    use HasName;

    /**
     * The command to be run.
     * 
     * @var \Illuminate\Console\Command
     */
    protected $command;

    /**
     * The arguments to be passed to the command.
     *
     * @var array<string, mixed>
     */
    protected $arguments = [];

    /**
     * Create a new pending command instance.
     */
    public static function make(string|Command $command, string $name): static
    {
        return app(static::class)
            ->command($command)
            ->name($name);
    }

    /**
     * Set the command to be run.
     *
     * @param  class-string<Command>|Command  $command
     * @return $this
     */
    public function command(string|Command $command): static
    {
        $command = is_string($command) ? app($command) : $command;

        $command->setLaravel(app());

        $this->command = $command;

        return $this;
    }

    /**
     * Get the command to be run.
     */
    public function getCommand(): Command
    {
        return $this->command;
    }

    /**
     * Set an argument to be passed to the command.
     *
     * @return $this
     */
    public function argument(string $name, mixed $value): static
    {
        $this->arguments[$name] = $value;

        return $this;
    }

    /**
     * Set the arguments to be passed to the command.
     *
     * @param  array<string, mixed>  $arguments
     * @return $this
     */
    public function arguments(array $arguments): static
    {
        $this->arguments = array_merge($this->arguments, $arguments);

        return $this;
    }

    /**
     * Get the arguments to be passed to the command.
     *
     * @return array<string, mixed>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Get the path of the generated class if applicable.
     */
    public function getPath(): ?string
    {
        if (! $this->command instanceof GeneratorCommand) {
            return null;
        }

        $method = new ReflectionMethod($this->command, 'getPath');

        $method->setAccessible(true);

        /** @var string */
        return $method->invoke($this->command, $this->name);
    }
}
