<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Action\Commands\ActionMakeCommand;

class ActionScaffolder extends MultipleScaffolder
{
    /**
     * The command to be run.
     *
     * @return class-string<\Illuminate\Console\Command>
     */
    public function commandName(): string
    {
        return ActionMakeCommand::class;
    }

    /**
     * Get the suggestions for the user.
     *
     * @return array<string, string>
     */
    public function suggestions(): array
    {
        return [
            'store' => 'Store',
            'update' => 'Update',
            'delete' => 'Delete',
        ];
    }

    /**
     * Get the arguments for the command.
     *
     * @return array<string, mixed>
     */
    protected function getArguments(string $input): array
    {
        return [
            'name' => $this->getResolvedName($input),
            '--action' => $input,
            '--model' => $this->getName(),
            // '--body' => $this->getBody(),
        ];
    }
}
