<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Illuminate\Foundation\Console\PolicyMakeCommand;

class PolicyScaffolder extends SingleScaffolder
{
    /**
     * The command to be run.
     *
     * @return class-string<\Illuminate\Console\Command>
     */
    public function commandName(): string
    {
        return PolicyMakeCommand::class;
    }

    /**
     * Get the arguments for the command.
     *
     * @return array<string, mixed>
     */
    protected function getArguments(): array
    {
        return [
            ...parent::getArguments(),
            '--model' => $this->getName(),
        ];
    }
}
