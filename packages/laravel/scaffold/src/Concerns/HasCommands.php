<?php

declare(strict_types=1);

namespace Honed\Scaffold\Concerns;

use Illuminate\Support\Collection;
use Honed\Scaffold\Support\PendingCommand;

trait HasCommands
{
    /**
     * The commands to be executed.
     *
     * @var Collection<int, PendingCommand>
     */
    protected $commands;

    /**
     * Initialize the commands.
     */
    protected function initializeCommands(): void
    {
        $this->commands = new Collection();
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
     * @return Collection<int, PendingCommand>
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
}