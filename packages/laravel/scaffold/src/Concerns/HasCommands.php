<?php

declare(strict_types=1);

namespace Honed\Scaffold\Concerns;

use Honed\Scaffold\Support\PendingCommand;
use Illuminate\Support\Collection;

trait HasCommands
{
    /**
     * The commands to be executed.
     *
     * @var Collection<int, PendingCommand>
     */
    protected $commands;

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

    /**
     * Initialize the commands.
     */
    protected function initializeCommands(): void
    {
        $this->commands = new Collection();
    }
}
