<?php

declare(strict_types=1);

namespace Honed\Scaffold\Support;

use Honed\Core\Concerns\HasName;
use Illuminate\Console\Command;

class PendingCommand extends PendingHelper
{
    use HasName;

    /**
     * The arguments to be passed to the command.
     *
     * @var array<string, mixed>
     */
    protected $arguments = [];

    /**
     * Get the command to be run from the class.
     *
     * @param  class-string<Command>|Command  $command
     * @return $this
     */
    public function command(string|Command $command): static
    {
        $command = is_string($command) ? app($command) : $command;

        return $this->name($command->getName());
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
}
