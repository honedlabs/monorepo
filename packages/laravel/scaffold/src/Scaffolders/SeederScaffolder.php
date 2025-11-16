<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Illuminate\Database\Console\Seeds\SeederMakeCommand;

use function Laravel\Prompts\confirm;

class SeederScaffolder extends SingleScaffolder
{
    /**
     * The command to be run.
     *
     * @return class-string<\Illuminate\Console\Command>
     */
    public function commandName(): string
    {
        return SeederMakeCommand::class;
    }

    /**
     * Prompt the user for input.
     */
    public function prompt(): void
    {
        if (confirm(label: $this->label(), default: false)) {
            $this->addCommand($this->withMakeCommand());
        }
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
